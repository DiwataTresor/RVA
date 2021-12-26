<?php
	@session_start();
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../manager/bd/cnx.php');
	class m extends main{}
	$m=new m();
	
	$id_us=$_SESSION["Idd"];
	
	class PDF extends FPDF
	{
		
	}
	
	
	$taille=array(250,300);
	$pdf = new PDF('P','mm',"A4");
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetLeftMargin(15);
	$pdf->SetTopMargin(20);
	$pdf->SetFont('Arial','B',11);
	//$pdf->Image('../../../images/entete_pdf.png',86,15,60,20);
	$npage=$pdf->PageNo();
	//Header();
	
	//$pdf->Line(15, 260, 190, 260);
	//$pdf->Line(15, 70, 190, 70);
	
	$pdf->SetFont('Arial','U',8);
	/*$pdf->Text(20, 270, utf8_decode("N° TVA : 664 / 2012"));
	$pdf->Text(20, 275, utf8_decode("N° IMPOT : A1201438C"));*/
	
	
			$pdf->SetFont('Arial','U',8);
			$pdf->Cell(190,7, utf8_decode("DIVISION COMMERCIALE"),'','','C'); 
			$pdf->Ln();
			$pdf->Cell(190,7, "LISTE DES POINTS D'ENTREE",'','','C'); 
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(30,7, "",'','','C');
			$pdf->Cell(30,7, "CODE",'LRBT','','C');
			$pdf->Cell(75,7, "LIBELLE",'LRBT','','C');
			$pdf->Cell(25,7, "DISTANCE",'LRBT','','C');

			$type=$_GET['t'];
			$s="select * from rva_facturation2.pt_emplacement where Type='$type' order by Lib_pt";
			$e=$m->cnx->query($s);
			$t=($e->fetchALl());
			$pdf->Ln();
			foreach($t as $row)
			{
				$pdf->Cell(30,7, "",'','','C');
				$pdf->Cell(30,7, $row['Code_pt'],'LRBT','','L');
				$pdf->Cell(75,7, $row['Lib_pt'],'LRBT','','L');
				$pdf->Cell(25,7, $row['Distance']." km",'RBT','','R');
				
				$pdf->Ln();
			}
			$pdf->SetFont('Arial','BI',8);
			$pdf->Cell(180,7, utf8_decode("Fait à Lubumbashi, le ".date("d/m/Y")),'','','R');
									
$pdf->Output();



?>
