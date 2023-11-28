<?php

namespace App\traits;

use Dompdf\Dompdf;

trait PDFTrait
{
    public function pdf()
    {
        return new Dompdf();
    }
}
