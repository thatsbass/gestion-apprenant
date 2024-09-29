<?php

namespace App\Services;

use App\Services\Firebase\FirebaseStorageService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class ExportPdfService {

    public function export($data, $blade, $name)
    {
        // Générer le PDF avec la vue 
        $pdf = Pdf::loadView($blade, $data);

        // Nettoyer le nom de fichier pour éviter les caractères invalides
        $pdfFileName = Str::slug($name) . '.pdf';
        $pdfPath = storage_path('app/public/pdfListe/' . $pdfFileName);

        // Sauvegarder le PDF dans le répertoire de stockage et dans Firebase Storage :
        $pdf->save($pdfPath);

        $urlUpload = app(FirebaseStorageService::class)->uploadFile($pdfPath, 'PDFListe', $pdfFileName);

        return "Le fichier PDF a été exporté avec succès dans le dossier: " . dirname($pdfPath)." et \n".$urlUpload;
    }

}