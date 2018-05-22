<?php

	require('fpdf.php');
	
	class PDF extends FPDF
	{
		// Page header
		function Header()
		{
			// Logo
			$this->Image('http://i.imgur.com/HUcHHjX.png',10,6,30);
			// Arial bold 15
			$this->SetFont('Arial','B',15);
			// Move to the right
			$this->Cell(80);
			// Title
			$this->Cell(30,10,'Decorart LTDA',0,0,'C');
			// Line break
			$this->Ln(20);
		}
	
		// Page footer
		function Footer()
		{
			// Position at 1.5 cm from bottom
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// Page number
			$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
	
		function ColoredTitle($text)
		{
			$this->Ln();
			// Arial 12
			$this->SetFont('Arial','',12);
			// Background color
			$this->SetFillColor(152,214,235);
			// Title
			$this->Cell(0,6,"$text",0,1,'L',true);
			// Line break
			$this->Ln(4);
		}
		function TableProdutos($header, $products, $total)
		{
			// Header	
			$this->SetFont('Arial','B',12);
			for($h = 0; $h < count($header); $h++)
			{
				if($h == 0)
					$this->Cell(70,7,$header[$h],1);
				else
					$this->Cell(40,7,$header[$h],1);
			}
			$this->Ln();
			// Data
			$this->SetFont('Arial','',10);
			for($k = 0; $k < count($products); $k++)
			{
				$this->Cell(70,6,$products[$k]['name'],1);
				$this->Cell(40,6,$products[$k]['price_unit'],1);
				$this->Cell(40,6,$products[$k]['amount'],1);
				$this->Cell(40,6,$products[$k]['price_parc'],1);
				$this->Ln();
			}
			$this->Ln();
			$this->SetFont('Arial','',14);
			$this->Cell(60,8,'Preco total: '.$total,0,0,'L');
		}
		
		function TableCliente($header, $data)
		{
			$this->SetFont('Arial','B',12);
			for($i = 0; $i < count($header); $i++)
			{
				$this->Cell(130,7,$header[$i]." ".$data[$i]);
				$this->Ln();
			}
		}
	}
	
?>