<?php

namespace App\Services;
use App\Repositories\Interfaces\PromotionFirebaseRepositoryInterface;
use App\Services\Firebase\FirebaseStorageService;
use App\Services\Interfaces\PromotionServiceInterface;
use App\Facade\PromotionFacade as Promotion;
use App\Facade\ReferentielFacade as Referentiel;
use DateTime;

class PromotionService implements PromotionServiceInterface
{
    protected $storageService;
    protected $promotionRepository;

    public function __construct(
        PromotionFirebaseRepositoryInterface $promotionFirebaseRepository,
        FirebaseStorageService $storageService
    ) {
        $this->promotionRepository = $promotionFirebaseRepository;
        $this->storageService = $storageService;
    }

    public function create(array $data)
    {
       
        $existingPromotion = Promotion::where("libelle", $data["libelle"]);

        if ($existingPromotion) {
            return [
                "status" => "error",
                "message" => "Libellé déjà utilisé",
            ];
        }

        if (isset($data["date_debut"]) && isset($data["date_fin"])) {
            $startDate = new DateTime($data["date_debut"]);
            $endDate = new DateTime($data["date_fin"]);
            $interval = $startDate->diff($endDate);
            $totalMonths = $interval->y * 12 + $interval->m;
            if ($interval->d > 0) {
                $totalMonths += 1;
            }
            $data["duree"] = $totalMonths;
        } elseif (isset($data["date_debut"]) && isset($data["duree"])) {
            $startDate = new DateTime($data["date_debut"]);
            $data["date_fin"] = $startDate
                ->modify("+{$data["duree"]} months")
                ->format("Y-m-d");
        }

        if (isset($data["photo"])) {
            $data["photo"] = $this->uploadPhoto($data);
        }
        $data["etat"] = "inactif";

        // Création de la promotion
        $promotion = $this->promotionRepository->create([
            "libelle" => $data["libelle"],
            "date_debut" => $data["date_debut"],
            "date_fin" => $data["date_fin"],
            "duree" => $data["duree"],
            "etat" => $data["etat"],
            "photo" => $data["photo"],
        ]);

        $referentielArray = $data["referentiels"] ?? [];
        if (!empty($referentielArray)) {
            foreach ($referentielArray as $ref) {
                $referentiel = array_values(
                    Referentiel::where("libelle", $ref)
                )[0];
                if ($referentiel && $referentiel["statut"] == "actif") {
                    $this->addReferentielToPromotion(
                        $promotion["uid"],
                        $referentiel
                    );
                }
            }
        }
        return $promotion;
    }
    public function addReferentielToPromotion(
        $promotionId,
        array $referentielData
    ) {
        $referentiel = $this->promotionRepository->addReferentielToPromotion(
            $promotionId,
            $referentielData
        );
        return $referentiel;
    }

    public function update($id, array $data)
    {
    }
    public function delete($id)
    {
    }
    public function all()
    {
        return $this->promotionRepository->all();
    }

    public function removeReferentiel($idPromotion, $libelleReferentiel)
    {
        $this->promotionRepository->removeReferentiel(
            $idPromotion,
            $libelleReferentiel
        );
        return true;
    }

    public function closePromotion($id)
    {
        $this->promotionRepository->closePromotion($id);
        return true;
    }
    public function getReferentielActivePromotion($id)
    {
    }
    public function getStaticPromotion($id)
    {
    }

    public function uploadPhoto($data)
    {
        $firebaseFolder = "promotions/photos";
        $fileName = $data["libelle"] . "png";
        $url = $this->storageService->uploadFile(
            storage_path("app/public/" . $data["photo"]),
            $firebaseFolder,
            $fileName
        );
        return $url;
    }

    public function generatePromoIndex(array $promotions)
    {
        $nextIndexPromo = 1;

        if (!empty($promotions)) {
            $lastIndices = array_map(function ($promo) {
                return (int) filter_var(
                    $promo["libelle"],
                    FILTER_SANITIZE_NUMBER_INT
                );
            }, $promotions);

            $nextIndexPromo = max($lastIndices) + 1;
        }

        return $nextIndexPromo;
    }
}
