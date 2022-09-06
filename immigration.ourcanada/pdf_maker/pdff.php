<?php

include('tcpdf_include.php');

//if($_GET['h']=='submitForm')
{
    ob_start();

    echo $_SERVER['DOCUMENT_ROOT'];
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Etecmania');
    $pdf->SetTitle('PDF Development');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);


// set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
    $pdf->SetAutoPageBreak(FALSE, 0);

// set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);




    $pdf->setFontSubsetting(true);
    $pdf->SetFont('dejavusans', '', 14, '', true);
    $pdf->setJPEGQuality(75);



// Set some content to print
    $form='';

//    for($i=0;$i<sizeof($questions);$i++)
//    {
//        $form.='<li>'.$questions[$i].'<br><b>'.$answers[$i].'</b></li>';
//    }
    $html = <<<EOD
<ul>
	<li>aaaa</li>
	<li>aaaa</li>
	<li>aaaa</li>

</ul>
EOD;
    $pdf->AddPage();

    $pdf->setPage(1, true);
    $pdf->SetY(0);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'C',true);
    ob_end_clean();

    $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/pdf_files/Info.pdf' , 'F');

}

?>