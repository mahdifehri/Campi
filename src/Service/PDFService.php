<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFService
{
    private $domPdf;


    public function __construct()
    {
        $this->domPdf = new Dompdf();

        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Garamond');

        $this->domPdf->setOptions($pdfOptions);

    }
    Public function showPdfFile($html){
       $this->domPdf->loadHtml($html);
       $this->domPdf->render();
       $this->domPdf->stream("details.pdf",['Attachment'=>false]);
    }

}
