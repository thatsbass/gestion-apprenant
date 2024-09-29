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

    public function store(Request $request){
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos/promotions', 'public');
        }
        // dd($data);
        $promotion = $this->promotionService->create($data);
        return response()->json($promotion, 201);
    }

}
