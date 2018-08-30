<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf.php';

class MYPDF extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }

    // Colored table
    public function ColoredTable($header,$data) {
    	// Colors, line width and bold font
    	$this->SetFillColor(70, 130, 180);
    	$this->SetTextColor(255);
    	$this->SetDrawColor(0);
    	$this->SetLineWidth(0.3);
    	$this->SetFont('', 'B');
    	// Header
    	$w = array(15, 50, 20, 18, 12, 18, 12, 35);
    	$num_headers = count($header);
    	for($i = 0; $i < $num_headers; ++$i) {
    		$this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
    	}
    	$this->Ln();
    	// Color and font restoration
    	$this->SetFillColor(224, 235, 255);
    	$this->SetTextColor(0);
    	$this->SetFont('');
    	// Data
    	$fill = 0;
    	foreach($data as $row) {

    		$this->Cell($w[0], 6, $row[0], 'LR', 0, 'C', $fill);
    		$this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
    		$this->Cell($w[2], 6, $row[2], 'LR', 0, 'R', $fill);
    		
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'R', $fill);

            if ($row[4] == 'N')
            {
                $this->SetTextColor(255);
                $this->SetFillColor(0,128,0);
            }
            else if ($row[4] == 'SSt')
            {
                $this->SetTextColor(255);
                $this->SetFillColor(255,0,0);   
            }
            else if ($row[4] == 'St')
            {
                $this->SetTextColor(255);
                $this->SetFillColor(139,69,19);   
            }
            else
            {
                $this->SetTextColor(255);
                $this->SetFillColor(128,0,128);   
            }


            $this->Cell($w[4], 6, $row[4], 'LR', 0, 'C', 1);

            $this->SetTextColor(0);
            $this->SetFillColor(224, 235, 255);

    		$this->Cell($w[5], 6, $row[5], 'LR', 0, 'R', $fill);

            if ($row[6] == 'N')
            {
                $this->SetTextColor(255);
                $this->SetFillColor(0,128,0);
            }
            else if ($row[6] == 'SU')
            {
                $this->SetTextColor(255);
                $this->SetFillColor(255,0,0);   
            }
            else if ($row[6] == 'U')
            {
                $this->SetTextColor(255);
                $this->SetFillColor(139,69,19);   
            }
            else
            {
                $this->SetTextColor(255);
                $this->SetFillColor(128,0,128);   
            }

            $this->Cell($w[6], 6, $row[6], 'LR', 0, 'C', 1);

            $this->SetTextColor(0);
            $this->SetFillColor(224, 235, 255);

    		$this->Cell($w[7], 6, $row[7], 'LR', 0, 'C', $fill);


    		// $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
    		// $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
    		$this->Ln();
    		$fill=!$fill;
    	}
    	$this->Cell(array_sum($w), 0, '', 'T');
    }

    // Colored table
    public function ColoredTable_monthly($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(70, 130, 180);
        $this->SetTextColor(255);
        $this->SetDrawColor(0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(15, 50, 17.5, 17.5, 20, 18, 12, 18, 12);
        // $w = array(15, 50, 20, 18, 12, 18, 12, 35);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {

            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            
            if ($row[2] == 'N')
            {
                $this->SetTextColor(0,128,0);
                
            }
            else if ($row[2] == 'SSt')
            {
                $this->SetTextColor(255,0,0);
                  
            }
            else if ($row[2] == 'St')
            {
                $this->SetTextColor(139,69,19);
                
            }
            else
            {
                $this->SetTextColor(128,0,128);
                
            }

            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'C', $fill);

            if ($row[3] == 'N')
            {
                $this->SetTextColor(0,128,0);
                
            }
            else if ($row[3] == 'SU')
            {
                $this->SetTextColor(255,0,0);

            }
            else if ($row[3] == 'U')
            {
                $this->SetTextColor(139,69,19);

            }
            else
            {
                $this->SetTextColor(128,0,128);
  
            }

            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'C', $fill);

            $this->SetTextColor(0);
            

            $this->Cell($w[4], 6, $row[4], 'LR', 0, 'R', $fill);

            $this->Cell($w[5], 6, $row[5], 'LR', 0, 'R', $fill);


            if ($row[6] == 'N')
            {
                $this->SetTextColor(255);
                $this->SetFillColor(0,128,0);
            }
            else if ($row[6] == 'SSt')
            {
                $this->SetTextColor(255);
                $this->SetFillColor(255,0,0);   
            }
            else if ($row[6] == 'St')
            {
                $this->SetTextColor(255);
                $this->SetFillColor(139,69,19);   
            }
            else if ($row[6] == 'T')
            {
                $this->SetTextColor(255);
                $this->SetFillColor(128,0,128);   
            }
            else
            {
                $this->SetTextColor(255);
                $this->SetFillColor(105,105,105);
            }

            $this->Cell($w[6], 6, $row[6], 'LR', 0, 'C', 1);

            $this->SetTextColor(0);
            $this->SetFillColor(224, 235, 255);

            $this->Cell($w[7], 6, $row[7], 'LR', 0, 'R', $fill);

            if ($row[8] == 'N')
            {
                $this->SetTextColor(255);
                $this->SetFillColor(0,128,0);
            }
            else if ($row[8] == 'SU')
            {
                $this->SetTextColor(255);
                $this->SetFillColor(255,0,0);   
            }
            else if ($row[8] == 'U')
            {
                $this->SetTextColor(255);
                $this->SetFillColor(139,69,19);   
            }
            else if ($row[8] == 'O')
            {
                $this->SetTextColor(255);
                $this->SetFillColor(128,0,128);   
            }
            else
            {
                $this->SetTextColor(255);
                $this->SetFillColor(105,105,105);
            }

            $this->Cell($w[8], 6, $row[8], 'LR', 0, 'C', 1);

            $this->SetTextColor(0);
            $this->SetFillColor(224, 235, 255);

            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    // Colored table
    public function ColoredTable_dashboard($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(70, 130, 180);
        $this->SetTextColor(255);
        $this->SetDrawColor(0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(20, 50, 30, 30, 20, 30);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {

            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'R', $fill);
            $this->Cell($w[4], 6, $row[4], 'LR', 0, 'R', $fill);
            $this->Cell($w[5], 6, $row[5], 'LR', 0, 'R', $fill);

            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    // Colored table
    public function ColoredTable_transactions ($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(70, 130, 180);
        $this->SetTextColor(255);
        $this->SetDrawColor(0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(18, 24, 20, 20, 20, 18, 20, 20, 20);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {

            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'C', $fill);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'C', $fill);
            $this->Cell($w[4], 6, $row[4], 'LR', 0, 'R', $fill);
            $this->Cell($w[5], 6, $row[5], 'LR', 0, 'R', $fill);
            $this->Cell($w[6], 6, $row[6], 'LR', 0, 'R', $fill);
            $this->Cell($w[7], 6, $row[7], 'LR', 0, 'C', $fill);
            $this->Cell($w[8], 6, $row[8], 'LR', 0, 'C', $fill);

            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    // Colored table
    public function ColoredTable_users ($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(70, 130, 180);
        $this->SetTextColor(255);
        $this->SetDrawColor(0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(15, 25, 20, 10, 10, 10, 15, 15, 15, 15, 15, 15);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {

            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'C', $fill);
            $this->Cell($w[4], 6, $row[4], 'LR', 0, 'C', $fill);
            $this->Cell($w[5], 6, $row[5], 'LR', 0, 'C', $fill);
            $this->Cell($w[6], 6, $row[6], 'LR', 0, 'R', $fill);
            $this->Cell($w[7], 6, $row[7], 'LR', 0, 'R', $fill);
            $this->Cell($w[8], 6, $row[8], 'LR', 0, 'R', $fill);
            $this->Cell($w[9], 6, $row[9], 'LR', 0, 'R', $fill);
            $this->Cell($w[10], 6, $row[10], 'LR', 0, 'R', $fill);
            $this->Cell($w[11], 6, $row[11], 'LR', 0, 'R', $fill);

            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    // Colored table
    public function ColoredTable_products($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(70, 130, 180);
        $this->SetTextColor(255);
        $this->SetDrawColor(0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(20, 50, 30, 30, 25, 25);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {

            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'C', $fill);
            $this->Cell($w[4], 6, $row[4], 'LR', 0, 'R', $fill);
            $this->Cell($w[5], 6, $row[5], 'LR', 0, 'R', $fill);

            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    // Colored table
    public function ColoredTable_packages($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(70, 130, 180);
        $this->SetTextColor(255);
        $this->SetDrawColor(0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(15, 35, 30, 60, 20, 20);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {

            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'L', $fill);
            $this->Cell($w[4], 6, $row[4], 'LR', 0, 'R', $fill);
            $this->Cell($w[5], 6, $row[5], 'LR', 0, 'R', $fill);

            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}