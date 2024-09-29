<?php

namespace App\Services;

use App\Services\Firebase\FirebaseStorageService;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ModelExport;

class ExcelService
{

    public static function extractExcelImages($filePath)
    {
        // Charger le fichier Excel
        $spreadsheet = IOFactory::load(storage_path('app/public/'.$filePath));

        // Obtenir les images de la première feuille
        $sheet = $spreadsheet->getActiveSheet();
        $drawings = $sheet->getDrawingCollection();

        // Chemin du dossier de destination pour les images
        $destinationPath = storage_path('app/temp');

        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Obtenir les valeurs des colonnes spécifiques
        $columns = [
            'telephone' => 'E',
            'photo' => 'G',
            'cni' => 'M',
            'extrait_de_naissance' => 'N',
            'casier_judiciaire' => 'O',
            'diplome' => 'P',
            'visite_medicale' => 'Q'
        ];
        $values = [];
        foreach ($sheet->getRowIterator() as $row) {
            $rowIndex = $row->getRowIndex();
            foreach ($columns as $key => $column) {
                $cell = $sheet->getCell($column . $rowIndex);
                $values[$key][$rowIndex] = $cell->getValue();
            }
        }
        
        foreach ($drawings as $index => $drawing) {

            $telephone = $values['telephone'][$index] ?? 'unknown';

            if ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing) {
                // Obtenir l'image depuis Excel
                ob_start();
                call_user_func($drawing->getRenderingFunction(), $drawing->getImageResource());
                $imageContents = ob_get_contents();
                ob_end_clean();

                // Déterminer le type d'image et son extension
                $extension = match ($drawing->getMimeType()) {
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/gif' => 'gif',
                    default => 'jpg',
                };

                $imageName = $telephone . '.' . $extension;
                $imagePath = $destinationPath . '/' . $imageName;

                file_put_contents($imagePath, $imageContents);
            } elseif ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\Drawing) {
               
                $imageName = $telephone . '.' . pathinfo($drawing->getPath(), PATHINFO_EXTENSION);
                $imagePath = $destinationPath . '/' . $imageName;
                copy($drawing->getPath(), $imagePath);
            }
        }

        foreach ($values as $key => $columnValues) {
            echo "Les URLs pour $key:\n";
            foreach ($columnValues as $rowIndex => $value) {
                echo "Row $rowIndex: $value\n";
            }
        }

        echo "Les images ont été extraites et enregistrées avec succès dans le dossier: " . $destinationPath;
    }

    public function exportExcelFile(array $data, $headers, $name) 
    {
        $filePath = storage_path('app/public/excelListe/' . $name . '.xlsx');

        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }
        Excel::store(new ModelExport($data, $headers), 'public/excelListe/' . $name . '.xlsx', 'local');

        $urlUpload = app(FirebaseStorageService::class)->uploadFile($filePath, 'excelListe', $name . '.xlsx');

        return "Le fichier Excel a été exporté avec succès dans le dossier: " . dirname($filePath)." et \n".$urlUpload;
    }
}