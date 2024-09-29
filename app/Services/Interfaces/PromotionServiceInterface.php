<?php

namespace App\Services\Interfaces;

interface PromotionServiceInterface 
{
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function all();
    public function addReferentielToPromotion($id, array $data);
    public function removeReferentiel($id);
    public function closePromotion($id);
    public function getReferentielActivePromotion($id);
    public function getStaticPromotion($id);
    public function generatePromoIndex(array$dataPromo);
    public function uploadPhoto($data);
}
