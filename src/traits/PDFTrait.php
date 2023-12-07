<?php

namespace App\traits;

use App\emuns\OrientationTypes;
use App\emuns\PaperTypes;
use Exception;

use mikehaertl\wkhtmlto\Pdf;
use mikehaertl\tmp\File;

trait PDFTrait
{
    public function generatePDF(string $html, PaperTypes $paper, OrientationTypes $orientation, string $fileName)
    {
        try {
            $config = array(
                'orientation' => $orientation->value,
                'page-size' => $paper->value,
                'margin-top'    => '70px',
                'margin-right'  => '40px',
                'margin-bottom' => '140px',
                'margin-left'   => '40px',
            );
            $pdf = new Pdf($config);
            $pdf->addPage($html);   
            if (!$pdf->send())
                var_dump($pdf->getError());
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
