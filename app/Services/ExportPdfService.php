<?php

namespace App\Services;

use App\Facade\UploadPhotoFacade as Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class ExportPdfService {

    public function export($data, $blade, $name)
    {
        $pdf = Pdf::loadView($blade, $data);

        $pdfFileName = Str::slug($name) . '.pdf';
        $pdfPath = storage_path('app/public/pdfListe/' . $pdfFileName);

        $pdf->save($pdfPath);
        $urlUpload = Storage::uploadFile($pdfPath, 'PDFListe', $pdfFileName);

        return "Le fichier PDF a été exporté avec succès dans le dossier: " . dirname($pdfPath)." et \n".$urlUpload;
    }
}