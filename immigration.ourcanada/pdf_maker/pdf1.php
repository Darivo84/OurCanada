<?php
include( 'config.php' );
require_once('tcpdf_include.php');

if($_GET['h']=='pdf')
{

$id=$_GET['id'];
$select=mysqli_query($conn,"select * from info where id=$id");
$row=mysqli_fetch_assoc($select);


    $factory = $row['factory_name'];
    $address = 'Street No: '.$row['street'].'<br>Postal Code: '.$row['postal'].'<br>City: '.$row['city'].'<br>Country: '.$row['country'];
    $uname = $row['user_name'];
    $email = $row['user_email'];
    $phone = $row['user_phone'];
    $focus = $row['export_focus'];
    $pgroup = $row['product_group'];
    $strategy = $row['strategy'];
    $certi = $row['certification'];
    $csr = $row['csr'];
//    $year1 = $row['year1'];
//    $year2 = $row['year2'];
//    $perc = $row['percentage'];
    $uploads_dir = "http://pdf.prowebsitedemos.com/uploads/";
    $uploads_dir2 = "http://pdf.prowebsitedemos.com/logos/";
    $logo=explode('-', $row["logo"]);
    if($logo[0]=='icon')
    {
        $image4 = $uploads_dir2.$row['logo'];

    }
    else
    {
        $image4 = ($row['logo']!='' ? $uploads_dir.$row['logo'] : '' );
    }


    $image1 = ($row['factory_image']!='' ? $uploads_dir.$row['factory_image'] : '' );
    $image2 = ($row['showroom_image']!='' ? $uploads_dir.$row['showroom_image'] : '' );
    $image3 = ($row['country_image']!='' ? $uploads_dir.$row['country_image'] : '' );
//    $image4 = $uploads_dir.$row['logo'];
    $image5 = ($row['product_image1']!='' ? $uploads_dir.$row['product_image1'] : '' );
    $image6 = ($row['product_image2']!='' ? $uploads_dir.$row['product_image2'] : '' );
    $image7 = ($row['product_image3']!='' ? $uploads_dir.$row['product_image3'] : '' );
    $image8 = ($row['product_image4']!='' ? $uploads_dir.$row['product_image4'] : '' );



// create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Etecmania');
    $pdf->SetTitle('PDF Development');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

// set default header data
//    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,0,0), array(0,0,0));
//    $pdf->setFooterData(array(0,0,0), array(0,0,0));

// set header and footer fonts
//    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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

// set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

// ---------------------------------------------------------

// set default font subsetting mode
    $pdf->setFontSubsetting(true);




// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
    $pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.


// set JPEG quality
    $pdf->setJPEGQuality(75);



// Set some content to print
    $html1 = <<<EOD
<table>
	<h1>Basic Information</h1><br><br>
	<p style="color: rgb(255, 216, 43)">Factory Name:</p><p style="font-size: 10pt">$factory</p><br>
	<p style="color: rgb(255, 216, 43)">Factory Address:</p><p style="font-size: 10pt">$address</p><br>
	<p style="color: rgb(255, 216, 43)">Full Name:</p><p style="font-size: 10pt">$uname</p><br>
	<p style="color: rgb(255, 216, 43)">E-Mail:</p><p style="font-size: 10pt">$email</p><br>
	<p style="color: rgb(255, 216, 43)">Phone No:</p><p style="font-size: 10pt">$phone</p>

</table>
EOD;

    $html2 = <<<EOD
<body>

<h1>Organizational Information</h1><br><br>

				<p style="color: rgb(255, 216, 43)">Export Market Focus </p><P style="font-size: 10pt">$focus</P><br><br><br>
	<table>
	
		<tr>
			<td>
				<br><p style="color: rgb(255, 216, 43)">Factory Image</p><br>
				<img src="$image1" alt="Factory Image" style="border: 1px solid black" height="150px" width="250px">

			</td>
			<td>
				<br>
<p style="color: rgb(255, 216, 43)">Showroom Image</p><br>
				<img src="$image2" style="border: 1px solid black" alt="Showroom Image" height="150px" width="250px">
			</td>
		</tr>
<br><br>
		<tr>
			<td>
				<p style="color: rgb(255, 216, 43)">Country Image</p><br>
				<img src="$image3" style="border: 1px solid black" alt="Contry Image" height="150px" width="250px">
			</td>
		</tr>
	</table>

</body>

EOD;

    $html3 = <<<EOD
<body>

	<h1>Product Information</h1><br><br><br><br><br><br>

		<p style="color: rgb(255, 216, 43)">Company Strategy</p><p style="font-size: 10pt">$strategy</p><br>
		<p style="color: rgb(255, 216, 43)">Product Groups</p><p style="font-size: 10pt">$pgroup</p><br>
		<p style="color: rgb(255, 216, 43)">Product Images</p>
		<table>
			<tr>
				<td>			

					<br><br>
					<img style="border: 1px solid black" src="$image5" alt="Factory Image" height="150px" width="200px">
				</td>
				<td>
					<br><br>
					<img style="border: 1px solid black" src="$image6" alt="Showroom Image" height="150px" width="200px">
				</td>
			</tr>

			<tr>
				<td>	

					<br><br><br><br>
					<img style="border: 1px solid black" src="$image7" alt="Contry Image" height="150px" width="200px">
				</td>
				<td>
					<br><br><br><br>
					<img style="border: 1px solid black" src="$image8" alt="Contry Image" height="150px" width="200px">
				</td>
			</tr>
		</table>

</body>
EOD;
    $html4 = <<<EOD
<body>
	<h1>Certification Information</h1><br><br><br><br>
	
	<p style="color: rgb(255, 216, 43)">Certifications </p><p style="font-size: 10pt">$certi</p><br>
	<p style="color: rgb(255, 216, 43)">CSR </p><p style="font-size: 10pt">$csr</p><br>
</body>

EOD;
    $html5 = <<<EOD
<body>
	<h1>Total Cultivation in Donation</h1><br><br><br><br>
	
	<p style="color: rgb(255, 216, 43)">What was your total giving in Year 1? </p><p style="font-size: 10pt">$year1</p><br>
	<p style="color: rgb(255, 216, 43)">What was your total giving in Year 2? </p><p style="font-size: 10pt">$year2</p><br>
	<p style="color: rgb(255, 216, 43)">Average Gift Size Percent Change </p><p style="font-size: 10pt">$perc</p><br>

</body>

EOD;

	$html = <<<EOD
	<body >
		<div style="position:relative !important;">
			<div style="position:absolute !important; top:50% !important">
				<br><br><br><br><br><br><span style=""><img src="$image4" style="width:200px; height:200px;"></span>
				<h1 style="color: black">$factory</h1>
			</div>
		</div>
	</body>
	
	EOD;

	$pdf->AddPage();
    $img_file1 = 'images/companyimg1.jpg';
    $img_file = 'images/comp.png';


    $pdf->Image($img_file1, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
//    $pdf->SetMargins(5, 0, 0);
//    $pdf->SetHeaderMargin(0);
//    $pdf->SetFooterMargin(0);
    $pdf->setPage(1, true);
    $pdf->SetY(0);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'C',true);

    //$pdf->SetLineStyle( array( 'width' => 2, 'color' => array(255, 216, 43)));
    //$pdf->Line(2, 2, $pdf->getPageWidth()-2, 2);
    //$pdf->Line($pdf->getPageWidth()-2, 2, $pdf->getPageWidth()-2,  $pdf->getPageHeight()-2);
    //$pdf->Line(2, $pdf->getPageHeight()-2, $pdf->getPageWidth()-2, $pdf->getPageHeight()-2);
    //$pdf->Line(2, 2, 2, $pdf->getPageHeight()-2);
	
    $pdf->AddPage();
    $pdf->setPage(2, true);
    $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
//    $pdf->SetMargins(5, 0, 0);
//    $pdf->SetHeaderMargin(0);
//    $pdf->SetFooterMargin(0);
    $pdf->SetY(0);
	$pdf->writeHTMLCell(0, 0, '', '', $html1, 0, 1, 0, true, '',true);
    $pdf->AddPage();
	
	$pdf->AddPage();
    $pdf->setPage(3, true);
    $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
//    $pdf->SetMargins(5, 0, 0);
//    $pdf->SetHeaderMargin(0);
//    $pdf->SetFooterMargin(0);
    $pdf->SetY(0);
	$pdf->writeHTMLCell(0, 0, '', '', $html2, 0, 1, 0, true, '',true);
    $pdf->AddPage();

	$pdf->AddPage();
    $pdf->setPage(4, true);
    $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
//    $pdf->SetMargins(5, 0, 0);
//    $pdf->SetHeaderMargin(0);
//    $pdf->SetFooterMargin(0);

    $pdf->SetY(0);
	$pdf->writeHTMLCell(0, 0, '', '', $html3, 0, 1, 0, true, '',true);

	$pdf->AddPage();
    $pdf->setPage(5, true);
    $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
//    $pdf->SetMargins(5, 0, 0);
//    $pdf->SetHeaderMargin(0);
//    $pdf->SetFooterMargin(0);
    $pdf->SetY(0);
	$pdf->writeHTMLCell(0, 0, '', '', $html4, 0, 1, 0, true, '',true);
//    $pdf->AddPage();
//
//    $pdf->setPage(6, true);
//    $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
//    $pdf->SetMargins(5, 0, 0);
//    $pdf->SetHeaderMargin(0);
//    $pdf->SetFooterMargin(0);
//
//    $pdf->SetY(0);
//	$pdf->writeHTMLCell(0, 0, '', '', $html5, 0, 1, 0, true, '',true);

    $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/pdf_maker/Info.pdf' , 'I');
}
else
{
    echo'no';
}

?>

