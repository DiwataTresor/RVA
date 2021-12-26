<?php
	@session_start();
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../manager/bd/cnx.php');
	
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
			$pdf->Cell(190,7, "LISTE DES IMMATRICULATIONS",'','','C'); 
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,7, "EXPLOITANT",'LRBT','','C');
			$pdf->Cell(25,7, "IMMATR",'LRBT','','C');
			$pdf->Cell(25,7, "TYPE AV",'LRBT','','C');
			$pdf->Cell(25,7, "TONNAGE",'LRBT','','C');
			$pdf->Cell(20,7, "STAT",'RBT','','C');
			$pdf->Cell(15,7, "COMPT",'RBT','','C');
			$pdf->Cell(15,7, "SEC",'RBT','','C');
			
			$s="select * from immatriculation,client,type_avion where immatriculation.Code_pr=client.Id_cl and immatriculation.Type_av=type_avion.Id_typ order by client.Nom_cli";
			$e=mysqli_query($bdd,$s);
			$t=mysqli_fetch_array($e);
			$pdf->Ln();
			do
			{
				$pdf->Cell(60,7, $t['Nom_cli'],'LRBT','','L');
				$pdf->Cell(25,7, $t['Code_imm'],'LRBT','','C');
				$pdf->Cell(25,7, $t['Libelle_typ'],'RBT','','C');
				$pdf->Cell(25,7, $t['Poids'],'LRBT','','C');
				$pdf->Cell(20,7, "",'RBT','','C');
				$pdf->Cell(15,7, "",'RBT','','C');
				$pdf->Cell(15,7, "",'RBT','','C');
				$pdf->Ln();
			}while($t=mysqli_fetch_array($e));
			$pdf->SetFont('Arial','BI',8);
			$pdf->Cell(180,7, utf8_decode("Fait à Lubumbashi, le ".date("d/m/Y")),'','','R');
									
$pdf->Output();



?>
