<?php

namespace App\Repositories\Interfaces;

interface PromotionFirebaseRepositoryInterface
{
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function all();
    public function addReferentielToPromotion($id, array $data);
    public function removeReferentiel($idPromotion, $libelleReferentiel);
    public function closePromotion($id);
    public function getReferentielActivePromotion($id);
    public function getStaticPromotion($id);

}
