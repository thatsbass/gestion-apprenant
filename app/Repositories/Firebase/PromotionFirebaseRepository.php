<?php

namespace App\Repositories\Firebase;
use App\Repositories\Interfaces\PromotionFirebaseRepositoryInterface;

class PromotionFirebaseRepository implements PromotionFirebaseRepositoryInterface
{

    public function create(array $data){}
    public function update($id, array $data){}
    public function delete($id){}
    public function all(){}
    public function addReferentiel($id, array $data){}
    public function removeReferentiel($id, array $data){}
    public function closePromotion($id){}
    public function getReferentielActivePromotion($id){}
    public function getStaticPromotion($id){}
}
