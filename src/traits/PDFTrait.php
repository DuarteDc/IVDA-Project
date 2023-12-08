<?php

namespace App\traits;

use App\emuns\OrientationTypes;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\emuns\PaperTypes;
use Exception;

trait PDFTrait
{
    public function generatePDF(string $html, PaperTypes $paper, OrientationTypes $orientation, string $fileName, bool $download = true)
    {
        try {
            $options = new Options();
            $options->set('isRemoteEnabled', true);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper($paper->value, $orientation->value);
            $dompdf->render();
            return $dompdf->stream("$fileName.pdf", ['Attachment' => $download]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
