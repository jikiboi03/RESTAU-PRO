<?php

//============================================================+
// File name   : example_011.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 011 for TCPDF class
//               Colored Table (very simple table)
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
 * @abstract TCPDF - Example: Colored Table
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($user_fullname);
$pdf->SetTitle($title);
$pdf->SetSubject('Products Report');
$pdf->SetKeywords('dashboard');


// set default header data
$pdf->SetHeaderData('../../assets/img/' . $logo_img, 35, $title, $comp_name . "\r\n" . 'Prepared by: ' . $user_fullname . "\r\n" . 'Date: ' . $current_date . "\r\n" . 'Time: ' . $current_time . "\r\n");



// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 48, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(12);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(8);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

// $pdf->Cell(20, 10, 'Total Net Sales Today', 0, false, 'L', 0, '', 0, false, 'T', 'M');   
// $pdf->Cell(130, 10, $today_net_sales_str . ' ( ' . $percent_net_sales_str . ' )', 0, false, 'R', 0, '', 0, false, 'T', 'M'); 

// $pdf->Cell(120, 20, '', 0, false, 'L', 0, '', 0, false, 'T', 'M');
if ($categories_str != null)
{
	$text = '<h3 align="center">Report Summary</h3>
	<p align="left">1. Total Products: <b color="#006600">' . $total_products . '</b></p>
	<p align="left">2. Categories List: <b color="#006600">' . $categories_str . '</b></p>
	<p align="left">3. Total Products Sold: <b color="#006600">' . $total_products_sold . '</b></p>
	<p align="left">4. Total Products Sold via Package: <b color="#006600">' . $total_pack_prod_sold . '</b></p>
	<p align="left">5. Total Product Sales: <b color="#006600">' . $total_menu_sales . '</b></p>
	<hr>'
	;	
}
else
{
	$text = '<h3 align="center">Report Summary</h3>
	<p align="left">1. Total Products: <b color="#006600">' . $total_products . '</b></p>
	<p align="left">2. Total Products Sold: <b color="#006600">' . $total_products_sold . '</b></p>
	<p align="left">3. Total Packages: <b color="#006600">' . $total_packages . '</b></p>
	<p align="left">4. Total Packages Sold: <b color="#006600">' . $total_packages_sold . '</b></p>
	<p align="left">5. Total Products Sold via Package: <b color="#006600">' . $total_pack_prod_sold . '</b></p>
	<hr>'
	;
}

$pdf->writeHTML($text, true, 0, true, 0);
// data loading
// $data = $pdf->LoadData();

// // to get age in mos.
// $birthday = new DateTime($child->dob);

// // current
// $diff = $birthday->diff(new DateTime());
// $months = $diff->format('%m') + 12 * $diff->format('%y') . ' mos';

// // registered
// $diff_reg = $birthday->diff(new DateTime($child->date_registered));
// $months_reg = $diff_reg->format('%m') + 12 * $diff_reg->format('%y') . ' mos';


// $text = '<p align="center">

// <img id="image1" src="' . $imglink . '" style="width:1000px; max-height: 900px; margin-left:20px;">

// <br />

// <h1>' . $child->lastname . ', ' . $child->firstname . ' ' . $child->middlename . '</h1>
// <hr />
// </p>


// <b>Date of Birth: ' . date("M j, Y", strtotime($child->dob)) . '</b> | <b>Place of Birth: ' . $child->pob . '</b>
// <br /><br />
// <b>Registered Age in Mos: ' . $months_reg . '</b> | <b>Sex: ' . $child->sex . '</b> | <b color="#006600">CURRENT Age in Mos: ' . $months . '</b>
// <br /><br />
// <b>INITIAL RECORD Height: ' . $child->height . ' cm | Weight: ' . $child->weight . ' kg</b> 
// | 
// <b color="#006600">LATEST RECORD Height: ' . $latest_height . ' cm | Weight: ' . $latest_weight . ' kg</b>
// <br /><br />
// <b>Religion: ' . $child->religion . '</b>
// <br />
// <b>Disability: ' . $child->disability . '</b>
// <br />
// <b>Contact: ' . $child->contact . '</b>
// <br />
// <b>School: ' . $child->school . '</b> | <b>Grade Level: ' . $child->grade_level . '</b>
// <br />
// <b>Home Address: ' . $child->address . '</b>
// <br /><br />
// <hr />
// <p align="center"><b color="#003366">FAMILY BACKGROUND</b></p><hr />';
// $pdf->writeHTML($text, true, 0, true, 0);

// print colored table
$pdf->ColoredTable_products($header, $data);




// $pdf->Cell(0, 30, '_____________________________________', 0, false, 'R', 0, '', 0, false, 'T', 'M' );
// $pdf->Cell(0, 40, 'Signature over printed name              ', 0, false, 'R', 0, '', 0, false, 'T', 'M' );


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// *** set signature appearance ***



// // define active area for signature appearance
// $pdf->setSignatureAppearance(180, 60, 15, 15);

// // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// // *** set an empty signature appearance ***
// $pdf->addEmptySignatureAppearance(180, 80, 15, 15);

// ---------------------------------------------------------

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('products.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
