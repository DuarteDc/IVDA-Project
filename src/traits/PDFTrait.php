<?php

namespace App\traits;

use Dompdf\Dompdf;
use App\emuns\PaperTypes;
use Exception;

trait PDFTrait
{
    public function generatePDF(string $html, PaperTypes $paper, string $fileName)
    {
        try {
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper($paper->value, 'landscape');
            $dompdf->render();
            return $dompdf->stream();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
