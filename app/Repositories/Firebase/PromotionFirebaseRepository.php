<?php

namespace App\Repositories\Firebase;
use App\Repositories\Interfaces\PromotionFirebaseRepositoryInterface;
use App\Facade\PromotionFacade as Promotion;
use App\Facade\ReferentielFacade as Referentiel;

class PromotionFirebaseRepository implements
    PromotionFirebaseRepositoryInterface
{
    public function create(array $data)
    {
        return Promotion::create(null, $data, strtoupper($data["libelle"]));
    }
    public function update($id, array $data)
    {
    }
    public function delete($id)
    {
    }
    public function all()
    {
        return Promotion::all();
    }
    public function addReferentielToPromotion($id, array $data)
    {
        $promotion = Promotion::find($id);
        if (!$promotion) {
            return false;
        }
        return Promotion::create("{$id}/referentiels", $data, $data["libelle"]);
    }

    public function removeReferentiel($id)
    {
    }
    public function closePromotion($id)
    {
    }
    public function getReferentielActivePromotion($id)
    {
    }
    public function getStaticPromotion($id)
    {
    }
}
