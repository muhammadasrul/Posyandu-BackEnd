<?php
//============================================================+
// File name   : example_051.php
// Begin       : 2009-04-16
// Last Update : 2013-05-14
//
// Description : Example 051 for TCPDF class
//               Full page background
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Full page background
 * @author Nicola Asuni
 * @since 2009-04-16
 */

// Include the main TCPDF library (search for installation path).
// require_once('tcpdf_include.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = K_PATH_IMAGES.'sertifikat_bg.png';
        // $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        $this->Image($img_file, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Posyandu '.$posyandu);
$pdf->SetTitle('Sertifikat '.$nama);
$pdf->SetSubject('Sertifikat');
$pdf->SetKeywords('TCPDF, '.$posyandu.', sertifikat, posyandu, ASI');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 48);

// add a page
$pdf->AddPage('L');

// Print a text
$html = '
<span style="color:blue;text-align:center;font-weight:bold;font-size:42pt;font-family:helvetica;">SERTIFIKAT</span> <br>
<span style="color:blue;text-align:center;font-weight:bold;font-size:28pt;font-family:helvetica;">Lulus ASI Eksklusif 6 bulan</span> <br>
<span style="color:blue;text-align:center;font-weight:bold;font-size:20pt;font-family:helvetica;">Diberikan kepada</span> <br>
<span style="color:blue;text-align:center;font-weight:bold;font-size:32pt;font-family:helvetica;text-decoration:underline">'.$nama.'</span> <br>
<span style="color:blue;text-align:center;font-weight:bold;font-size:20pt;font-family:helvetica;">Dengan penuh cinta dan kasih sayang</span> <br>
<span style="color:blue;text-align:center;font-weight:bold;font-size:32pt;font-family:helvetica;">Ayah '.$ayah.' dan Ibu '.$ibu.'</span> <br>';
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Sertifikat '.$nama.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+