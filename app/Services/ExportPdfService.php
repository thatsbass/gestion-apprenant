<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class ExportPdfService {

    public function export($data, $blade, $name)
    {
        // Générer le PDF avec la vue 
        $pdf = Pdf::loadView($blade, $data);

        // Nettoyer le nom de fichier pour éviter les caractères invalides
        $pdfFileName = Str::slug($name) . '.pdf';
        $pdfPath = storage_path('app/public/' . $pdfFileName);

        // Sauvegarder le PDF dans le répertoire de stockage
        $pdf->save($pdfPath);

        // Retourner le chemin du fichier
        return $pdfPath;
    }
    
}