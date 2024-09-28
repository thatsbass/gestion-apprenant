<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ApprenantsImport;
use App\Services\Firebase\FirebaseStorageService;
use App\Services\Firebase\FirebaseService;
use App\Services\ApprenantService;

class ApprenantController extends Controller
{
    protected $firebaseStorage;
    protected $firestoreService;
    protected $imageUploadService;
    protected ApprenantService $apprenantService;

    public function __construct(FirebaseStorageService $firebaseStorage, FirebaseService $firestoreService, ApprenantService $apprenantService)
    {
        $this->firebaseStorage = $firebaseStorage;
        $this->firestoreService = $firestoreService;
        $this->apprenantService = $apprenantService;
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new ApprenantsImport($this->firebaseStorage, $this->apprenantService), $request->file('file'));

        return response()->json(['message' => 'Importation réussie'], 200);
    }
}
