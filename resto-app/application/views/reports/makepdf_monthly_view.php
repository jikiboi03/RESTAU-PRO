<?php


// $pdf = new New_pdf('P', 'mm', 'A4', true, 'UTF-8', false);
// $pdf->SetTitle('My Title');
// $pdf->SetHeaderMargin(30);
// $pdf->SetTopMargin(20);
// $pdf->setFooterMargin(20);
// $pdf->SetAutoPageBreak(true);
// $pdf->SetAuthor('Author');
// $pdf->SetDisplayMode('real', 'default');

// $pdf->AddPage();

// $pdf->Write(5, 'Some sample text');
// $pdf->Output('My-File-Name.pdf', 'I');

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
$pdf->SetSubject('ANC Report');
$pdf->SetKeywords('child');

// set default header data
$pdf->SetHeaderData('anc.jpg', 45, $title, "\r\n" . 'Archdiocesan Nourishment Center - Data Profiling System' . "\r\n" . 'Prepared by: ' . $user_fullname . "\r\n" . 'Date: ' . $current_date . "\r\n" . "\r\n" . 'Total Records: ' . count($data));



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
$pdf->SetFont('helvetica', '', 9);

// add a page
$pdf->AddPage();

// data loading
// $data = $pdf->LoadData();

$text = 'This is a <b color="#003366">Monthly Monitoring Records</b> document for active or ongoing treatment children beneficiaries of the selected month. The records show the fullname of a child, <b color="#FF0000">INITIAL</b> height and weight status upon entering ANC, <b color="#FF0000">CURRENT</b> age in months as well as their corresponding height and weight status for the selected month.<p align="center"><b>I.H.Stats - Initial Height Status</b> | <b>I.W.Stats - Initial Weight Status</b> | <b>C.Age - Current Age in Months</b><br /><br /><b>C.Height - Current Height</b> | <b color="#FF0000">Sst - Severly Stunted</b> | <b color="#993300">St - Stunted</b> | <b color="#006600">N - Normal</b> | <b color="#990066">T - Tall</b><br /><br /><b>C.Weight - Current Weight</b> | <b color="#FF0000">SU - Severly Underweight</b> | <b color="#993300">U - Underweight</b> | <b color="#006600">N - Normal</b> | <b color="#990066">O - Obese</p><hr />';
$pdf->writeHTML($text, true, 0, true, 0);

// print colored table
$pdf->ColoredTable_monthly($header, $data);




$pdf->Cell(0, 30, '_____________________________________', 0, false, 'R', 0, '', 0, false, 'T', 'M' );
$pdf->Cell(0, 40, 'Signature over printed name              ', 0, false, 'R', 0, '', 0, false, 'T', 'M' );


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
$pdf->Output('cis.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
