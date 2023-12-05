<?php

namespace App\traits;

use App\emuns\OrientationTypes;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\emuns\PaperTypes;
use Exception;

use TCPDF;
trait PDFTrait
{
    public function generatePDF(string $html, PaperTypes $paper, OrientationTypes $orientation, string $fileName, bool $download = true)
    {
        try {
            // $options = new Options();
            // $options->set('isRemoteEnabled', true);

            // $dompdf = new Dompdf($options);
            // $dompdf->loadHtml($html);
            // $dompdf->setPaper($paper->value, $orientation->value);
            // $dompdf->render();
            // return $dompdf->stream("$fileName.pdf", ['Attachment' => $download]);
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->AddPage();
            $pdf->writeHTML($html);
            $pdf->Output("$fileName.pdf", 'I');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
