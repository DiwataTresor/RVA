<?php
	@session_start();
	$dt=$_REQUEST["dt"];
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../manager/bd/cnx.php');
	
	$id_us=$_SESSION["Idd"];
	
	class PDF extends FPDF
	{
	
	}
	$taille=array(250,300);
	$pdf = new PDF('L','mm',"A4");
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetLeftMargin(15);
	$pdf->SetTopMargin(20);
	$pdf->SetFont('Arial','B',11);
	//$pdf->Image('../../../images/entete_pdf.png',86,15,60,20);
	$npage=$pdf->PageNo();
	
	//$pdf->Line(15, 260, 190, 260);
	//$pdf->Line(15, 70, 190, 70);
	
	$pdf->SetFont('Arial','U',8);
	/*$pdf->Text(20, 270, utf8_decode("N° TVA : 664 / 2012"));
	$pdf->Text(20, 275, utf8_decode("N° IMPOT : A1201438C"));*/
	
	
			$pdf->SetFont('Arial','U',8);
			$pdf->Cell(280,7, utf8_decode("DIVISION COMMERCIALE"),'','','C'); 
			$pdf->Ln();
			$pdf->Cell(280,7, "TOTAL RAPPORT SUCCINT DU ".strtoupper(jrSemaine($dt))." ".Datemysqltofr($dt),'','','C'); 
			$pdf->Ln();
			$pdf->Cell(280,7, "LA SITUATION DE LA PERCEPTION CASH",'','','C');
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(70,7, "",'LRBT','','C');
			$pdf->Cell(100,7, "USD",'LRBT','','C');
			$pdf->Cell(100,7, "CDF",'RBT','','C');
			
			$pdf->Ln();
			$pdf->Cell(70,7, "CLIENT",'LRB','','L');
			$pdf->Cell(25,7, "MHT",'LRB','','C');
			$pdf->Cell(25,7, "TVA",'LRB','','C');
			$pdf->Cell(25,7, "ARR",'LRB','','C');
			$pdf->Cell(25,7, "MTTC",'LRB','','C');
			$pdf->Cell(25,7, "MHT",'LRB','','C');
			$pdf->Cell(25,7, "TVA",'LRB','','C');
			$pdf->Cell(25,7, "ARR",'LRB','','C');
			$pdf->Cell(25,7, "MTTC",'LRB','','C');
			
			$pdf->Ln();
			$pdf->Cell(70,7, "AERONAUTIQUE",'LRB','','L');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			
			$pdf->Ln();
			$pdf->Cell(70,7, "ACCES PONCTUELS",'LRB','','L');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			
			$pdf->Ln();
			$pdf->Cell(70,7, "ACCES PARKING",'LRB','','L');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			
			$pdf->Ln();
			$pdf->Cell(70,7, "",'LRB','','C');
			$pdf->Cell(200,7, "DEPENSES",'LRB','','C');
			
			$pdf->Ln();
			$pdf->Cell(70,7, "",'LRB','','L');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			
			$pdf->Ln();
			$pdf->Cell(70,7, "",'LRB','','C');
			$pdf->Cell(200,7, "SOUS-TOTAL",'LRB','','C');
			
			$pdf->Ln();
			$pdf->Cell(70,7, "",'LRB','','L');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			$pdf->Cell(25,7, "",'LRB','','C');
			
			$pdf->Ln();
			$pdf->Cell(70,7, "",'LRB','','C');
			$pdf->Cell(200,7, "RECOUVREMENT EN BANQUE + CASH",'LRB','','C');
									
$pdf->Output();



?>
