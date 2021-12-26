<?php
	@session_start();
	$id_us=$_SESSION['Idd'];
	$client=$_REQUEST["client"];
	$dt1=$_REQUEST["dt1"];
	$dt2=$_REQUEST["dt2"];
	
	$dt=date("Y-m-d");
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../manager/bd/cnx.php');
	@session_start();
	$nom_user=user($_SESSION['Idd'],$bdd);

	
	
	class PDF extends FPDF
	{
	
	}
	$pdf = new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetLeftMargin(5);
	$pdf->SetTopMargin(105);
	$pdf->SetFont('Arial','B',11);
	$pdf->Image('../../../images/entete_pdf.png',113,15,60,20);
	//$pdf->Line(15, 260, 190, 260);
	//$pdf->Line(15, 70, 190, 70);
	
	$pdf->SetFont('Arial','',8);
	/*$pdf->Text(20, 270, utf8_decode("N° TVA : 664 / 2012"));
	$pdf->Text(20, 275, utf8_decode("N° IMPOT : A1201438C"));*/
	
	$pdf->Text(10, 20, utf8_decode("REPUBLIQUE DEMOCRATIQUE DU CONGO"));
	$pdf->Text(10, 23, utf8_decode("REGIE DES VOIES AERIENNES SA"));
	$pdf->Text(10, 26, utf8_decode("AEROPORT INTERNATIONAL DE LA LUANO"));
	$pdf->Text(10, 29, utf8_decode("N° TVA : A0700324 L"));
	$pdf->Text(10, 32, utf8_decode("----------------------------------------------------------------------"));
			//=========================== CREATION N° FACTURE===============================
				if($client!=="T")
				{
					$s="select * from handling_facturation where Date_dep between '$dt1' and '$dt2' and Handleur='$client'";
				}else
				{
					$s="select * from handling_facturation where Date_dep between '$dt1' and '$dt2'";
				}
			$e=mysqli_query($bdd,$s);
			$n=mysqli_num_rows($e);
			$t=mysqli_fetch_array($e);
			//===============================================================================

			$pdf->Cell(183,20, utf8_decode(''),'','','C'); 
			$pdf->Ln(5);
			//$mouv=str_replace("'","",$num_mouv);
			$pdf->Cell(280,7, utf8_decode("LUBUMBASHI ".date('d/m/Y H:i:s')),'','','R'); 
			$pdf->Ln(21);
			$pdf->SetFont('Arial','BU',11);
			$pdf->Cell(280,7, utf8_decode("RAPPORT DES FACTURES PAYEES "),'','','C'); 
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(280,7, ("DU ".datemysqltofr($dt1)." AU ".datemysqltofr($dt2)),'','','C'); 
			if($client=="T")
			{
				
			}
			
			$pdf->SetFont('Arial','B',8);
			if($n==0)
			{
				$pdf->Ln();
				$pdf->Cell(280,7, utf8_decode("AUCUNE FACTURE SAISIE A CETTE DATE"),'','','C'); 
			}else
			{
				$pdf->Ln();
				$pdf->Cell(20,7, utf8_decode(""),'','','C'); 
				$pdf->Cell(14,7, utf8_decode("DATE"),'TB','','C'); 
				$pdf->Cell(23,7, utf8_decode("TAXATEUR"),'TB','','C');
				$pdf->Cell(26,7, utf8_decode("IMMATR."),'TB','','C'); 
				$pdf->Cell(35,7, utf8_decode("EXPLOITANT"),'TB','','C'); 
				$pdf->Cell(26,7, utf8_decode("HANDLEUR"),'TB','','C'); 
				$pdf->Cell(30,7, utf8_decode("DATE MOUV"),'TB','','C'); 
				$pdf->Cell(10,7, utf8_decode("AA"),'TB','','C'); 
				$pdf->Cell(10,7, utf8_decode("TA"),'TB','','C');
				$pdf->Cell(10,7, utf8_decode("FA"),'TB','','C'); 
				$pdf->Cell(20,7, utf8_decode("MHT"),'TB','','C'); 
				$pdf->Cell(15,7, utf8_decode("TVA"),'TB','','C');
				$pdf->Cell(30,7, utf8_decode("MTTC"),'TB','','C');   
				$aa=0;$ta=0;$fa=0;$mht=0;$tva=0;$mttc=0;
				$pdf->SetFont('Arial','',8);
				do
				{
					//============== VERIFICATION DANS LA TABLE DE PAIEMENT===================
						$id_fact=$t['Id_fact'];
						$s2="select * from handling_paiement where Fact_paie='$id_fact'";
						$e2=mysqli_query($bdd,$s2);
						$n2=mysqli_num_rows($e2);
						if($n2==0)
						{
							continue;
						}else
						{						
					//========================================================================
							$fact=handling_facture($t['Id_fact'],$bdd);
							$pdf->Ln();
							$pdf->Cell(20,7, utf8_decode(""),'','','C'); 
							$pdf->Cell(14,7, utf8_decode($fact['dt_fact']),'','','C'); 
							$pdf->Cell(23,7, utf8_decode($fact["user"]['nom']),'','','C'); 
							$pdf->Cell(26,7, utf8_decode($fact['imm']),'','','C'); 
							$pdf->Cell(35,7, utf8_decode($fact['client']),'','','C'); 
							$pdf->Cell(26,7, utf8_decode($fact['handleur']),'','','C'); 
							$pdf->Cell(30,7, utf8_decode($fact['dt_arr']." - ".$fact['dt_dep']),'','','C'); 
							$pdf->Cell(10,7, arrondie($fact['aa_prix']),'','','C'); 
							$pdf->Cell(10,7, arrondie($fact['ta_prix']),'','','C');
							$pdf->Cell(10,7, arrondie($fact['fa_prix']),'','','C'); 
							$pdf->Cell(20,7, arrondie($fact['mht']),'','','C'); 
							$pdf->Cell(15,7, arrondie($fact['tva']),'','','C');
							$pdf->Cell(30,7, arrondie($fact['mttc']),'','','C'); 
							$aa=$aa+$fact['aa_prix'];
							$ta=$ta+$fact['ta_prix'];
							$fa=$fa+$fact['fa_prix'];
							$mht=$mht+$fact['mht'];
							$tva=$tva+$fact['tva'];
							$mttc=$mttc+$fact['mttc'];
						}
				}while($t=mysqli_fetch_array($e));
			}
				$pdf->SetFont('Arial','B',8);
				$pdf->Ln();
				$pdf->Cell(20,7, utf8_decode(""),'','','C'); 
				$pdf->Cell(154,7, utf8_decode("TOTAL   "),'TB','','C'); 
				$pdf->Cell(10,7, arrondie($aa),'TB','','C'); 
				$pdf->Cell(10,7, arrondie($fa),'TB','','C');
				$pdf->Cell(10,7, arrondie($ta),'TB','','C'); 
				$pdf->Cell(20,7, arrondie($mht),'TB','','C'); 
				$pdf->Cell(15,7, arrondie($tva),'TB','','C');
				$pdf->Cell(30,7, arrondie($mttc)." USD",'TB','','C'); 
			
			$pdf->SetFont('Arial','B',9);
			
			
			
			$pdf->Text(100, 260, date('d/m/Y'));
			
 	
	$pdf->Text(20, 200, utf8_decode("Copyright Division commerciale"));

$pdf->Output();



?>
