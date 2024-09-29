<?php

namespace App\Http\Controllers;
use App\Services\PromotionService;
use Illuminate\Http\Request;

class PromotionController
{
    protected $promotionService;
    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    public function index(Request $request){
        $promotions = $this->promotionService->all();
        return response()->json($promotions, 200);
    }
    public function store(Request $request){
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos/promotions', 'public');
        }
        $promotion = $this->promotionService->create($data);
        return response()->json($promotion, 201);
    }
    public function addReferentielToPromotion(Request $request, $id){
        $data = $request->all();
        $action = $data['action'];
        if ($action == 'add') {
            $this->promotionService->addReferentielToPromotion($id, $data['libelle']);
        } else if ($action == 'remove') {
            $this->promotionService->removeReferentiel($id, $data['libelle']);
        }
    }
}