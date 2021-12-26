<?php
	@session_start();
	//$cl=$_REQUEST["client"];
	//$dt=$_REQUEST["dt"];
	//$dt2=$_REQUEST["dt2"];
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../manager/bd/cnx.php');
	//$bord=bordereau($dt,$bdd);

	class PDF extends FPDF
	{
	
	}
	$taille=array(36,36);
	$pdf = new PDF('P','cm',$taille);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetLeftMargin(1);
	$pdf->SetTopMargin(10);
	$pdf->SetFont('Arial','B',11);
	$pdf->Image('../../../images/entete_pdf.png',11,1,8,4);
	$npage=$pdf->PageNo();

	
	$pdf->SetFont('Arial','',9);

	$pdf->Text(3, 3, utf8_decode("REGIE DES VOIES AERIENNES SA"));
	$pdf->Text(3, 3.4, utf8_decode("AEROPORT INTERNATIONAL DE LA LUANO"));
	$pdf->Text(3, 3.8, utf8_decode("N° TVA : A0700324 L"));
	$pdf->Text(3, 4.1, utf8_decode("----------------------------------------------------------------------"));

			$pdf->Cell(183,20, utf8_decode(''),'','','C'); 
			$pdf->Ln(4);
			//$mouv=str_replace("'","",$num_mouv);
	$pdf->Ln(3);
	$pdf->Cell(34.7,1, utf8_decode("Test d'impression pour le long format 555 "),'TRLB','','R'); 
			
$pdf->Output();

?>
