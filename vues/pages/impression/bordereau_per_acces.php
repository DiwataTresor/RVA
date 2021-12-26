<?php
	@session_start();
	$dt=$_GET["dt"];
	$dt2=$_GET["dt2"];
	$type_acces=$_GET['type_acces'];
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../manager/bd/cnx.php');
	$bord=bordereau($dt,$bdd);
	$id_us=$_SESSION["Idd"];
	$user=user($id_us,$bdd);

	class PDF extends FPDF
	{
	
	}
	$taille=array(250,300);
	$pdf = new PDF('P','mm',$taille);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetLeftMargin(15);
	$pdf->SetTopMargin(10);
	$pdf->SetFont('Arial','B',11);
	$pdf->Image('../../../images/entete_pdf.png',86,15,60,20);
	$npage=$pdf->PageNo();
	
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

			$pdf->Cell(183,20, utf8_decode(''),'','','C'); 
			$pdf->Ln(8);
			//$mouv=str_replace("'","",$num_mouv);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(179,7, utf8_decode("EDITE LE : ".date('d/m/Y')),'','','R'); 
			$pdf->Ln();
			$pdf->Cell(109,7, "",'','','R'); 
			$pdf->Cell(60,7, "PAGE : ".$npage,'','','R');  
			$pdf->Ln(14);
			//$pdf->Cell(169,7, utf8_decode("NOM PERCEPTEUR(TRICE) : ".$user['nom']."      ".$user['matr']),'','','L'); 
			$s="select * from type_acces where Id_acc='$type_acces'"; $e=mysqli_query($bdd,$s); $t=mysqli_fetch_array($e);
			$pdf->Ln(9);
			$pdf->SetFont('Arial','BU',11);
			$pdf->Cell(210,7, utf8_decode("BORDEREAU ".$t['Designation_acc']."/PERIODE "),'','','C'); 
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);
			
			$pdf->Cell(210,7, utf8_decode("DU "." ".Datemysqltofr($dt))." Au ".(Datemysqltofr($dt2)),'','','C'); 
			$pdf->Ln();
//================================= DONNEES RETOURNEES DU BORDEREAU==================

			$s="select * from acces where Date_perc between '$dt' and '$dt2' and Type_acc='$type_acces'";
			$e=mysqli_query($bdd,$s); $t=mysqli_fetch_array($e); $n=mysqli_num_fields($e);
//================================ ENTETE DU TABLEAU==================================
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(50,7, utf8_decode("FACTURE "),'TRBL','','C');
			//$pdf->Cell(50,7, ($bord['acc']),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT.HT USD"),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT. HT CDF."),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT. TVA US"),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT.TVA CDF"),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT.TTC USD"),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT. TTC CDF"),'TRBL','','C'); 
			$pdf->Cell(27,7, utf8_decode("N° QUITTANCE"),'TRBL','','C'); 
			$pdf->Cell(30,7, utf8_decode("OBSERVATION"),'TRBL','','C'); 
//=============================== CONTENU DU TABLEAU=================================
//================ REDEVANCES AER===========================================================	
			$pdf->Ln();
		
			if($n==0)
			{
				//$pdf->Cell(50,7,$rda[$a]["num_rda"],'','','R');
			}else
			{	
				$inc=1;
				//$nom=$data['handleur'];
				$stcli=0;
				$st_u=0; $st_c=0.00; $st_u_tva=0.00; $st_c_tva=0.00; $st_u_tt=0.00; $st_c_tt=0.00;
				
				/*$pdf->Cell(50,5,$data["handleur"],'L','','C');
				$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','L');$pdf->Cell(20,5,"",'LR','','R');
				$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','L');
				$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(27,5,"",'LR','','L');$pdf->Cell(30,5,"",'LR','','R');
				$rupture="non";
				$pdf->Ln();*/
				do
				{
					//$data=handling_facture($t["Fact_paie"],$bdd);
					//$data_paie=paie_handling_detail($t["Fact_paie"],$bdd);
					if($t['Tva']=='O')
					{
						$tva=tva($t['Mt_acc']);
						$mt=($t['Mt_acc']);
						$mt_tva=tva($t['Mt_acc']);
						$mt_tt=$mt+$mt_tva;
						if($t['Monn_acc']=='CDF')
						{
							$st_u=$st_u+0;	
							$st_c=($st_c+$mt); 
							$st_u_tva=$st_u_tva+0; 
							$st_c_tva=$st_c_tva+$mt_tva; 
							$st_u_tt=$st_u_tt+0; 
							$st_c_tt=$st_c_tt+$mt_tt;
						}else
						{
							$st_u=$st_u+$mt;	
							$st_c=($st_c+0); 
							$st_u_tva=$st_u_tva+$mt_tva; 
							$st_c_tva=$st_c_tva+0; 
							$st_u_tt=$st_u_tt+$mt_tt; 
							$st_c_tt=$st_c_tt+0;
						}
					}else
					{
						$tva=0;
						$mt=($t['Mt_acc']);
						$mt_tva=0;
						$mt_tt=$mt+$mt_tva;
						if($t['Monn_acc']=='CDF')
						{
							$st_u=$st_u+0;	
							$st_c=($st_c+$mt); 
							$st_u_tva=$st_u_tva+0; 
							$st_c_tva=$st_c_tva+$mt_tva; 
							$st_u_tt=$st_u_tt+0; 
							$st_c_tt=$st_c_tt+$mt_tt;
						}else
						{
							$st_u=$st_u+$mt;	
							$st_c=($st_c+0); 
							$st_u_tva=$st_u_tva+$mt_tva; 
							$st_c_tva=$st_c_tva+0; 
							$st_u_tt=$st_u_tt+$mt_tt; 
							$st_c_tt=$st_c_tt+0;
						}
					}
					
					
						
							if($t['Monn_acc']=='CDF')
							{
								$pdf->Cell(50,5,$t["Num_long"],'L','','L');
								$pdf->Cell(20,5,arrondie(0),'LR','','R');
								$pdf->Cell(20,5,arrondie($mt),'R','','R');
								$pdf->Cell(20,5,arrondie(0),'R','','R');
								$pdf->Cell(20,5,arrondie($mt_tva),'R','','R');
								$pdf->Cell(20,5,arrondie(0),'R','','R');
								$pdf->Cell(20,5,arrondie($mt_tt),'R','','R');
								$pdf->Cell(27,5,$t["Quittance"],'R','','C');
								$pdf->Cell(30,5,"PERCUS",'R','','C');
								$pdf->Ln();
							}else
							{
								$pdf->Cell(50,5,$t["Num_long"],'L','','L');
								$pdf->Cell(20,5,arrondie($mt),'LR','','R');
								$pdf->Cell(20,5,arrondie(0),'R','','R');
								$pdf->Cell(20,5,arrondie($mt_tva),'R','','R');
								$pdf->Cell(20,5,arrondie(0),'R','','R');
								$pdf->Cell(20,5,arrondie($mt_tt),'R','','R');
								$pdf->Cell(20,5,arrondie(0),'R','','R');
								$pdf->Cell(27,5,$t["Quittance"],'R','','C');
								$pdf->Cell(30,5,"PERCUS",'R','','C');
								$pdf->Ln();

							}
							//$nom=$data['handleur'];							
				}while($t=mysqli_fetch_array($e));
				/*$pdf->Cell(50,5,"Sous total",'L','','R');
				$pdf->Cell(20,5,$rda[count($rda)-1]['st'][0]['mt_usd'],'LR','','R');
				$pdf->Cell(20,5,$rda[count($rda)-1]['st'][0]['mt_cdf'],'LR','','R');
				$pdf->Cell(20,5,$rda[count($rda)-1]['st'][0]['mt_usd_tva'],'LR','','R');
				$pdf->Cell(20,5,$rda[count($rda)-1]['st'][0]['mt_cdf_tva'],'LR','','R');
				$pdf->Cell(20,5,$rda[count($rda)-1]['st'][0]['mt_usd_tt'],'LR','','R');
				$pdf->Cell(20,5,$rda[count($rda)-1]['st'][0]['mt_cdf_tt'],'LR','','R');
				$pdf->Cell(27,5,"",'LR','','R');
				$pdf->Cell(30,5,"",'LR','','R');
				$rupture="non";
				$pdf->Ln();*/
				
				$pdf->SetFont('Arial','B',8);				
				$pdf->Cell(50,5,"Sous total",'LTB','','C');
				$pdf->Cell(20,5,arrondie($st_u),'LRTB','','R');
				$pdf->Cell(20,5,arrondie($st_c),'RTB','','R');
				$pdf->Cell(20,5,arrondie($st_u_tva),'RTB','','R');
				$pdf->Cell(20,5,arrondie($st_c_tva),'RTB','','R');
				$pdf->Cell(20,5,arrondie($st_u_tt),'RTB','','R');
				$pdf->Cell(20,5,arrondie($st_c_tt),'RTB','','R');
				$pdf->Cell(27,5,"",'RTB','','C');
				$pdf->Cell(30,5,"",'RTB','','C');
			}	
			
			
//==================================== TOTALITE DU BORDEREAU===============================================	
			/*$pdf->Ln();$pdf->Ln();
			$pdf->SetFont('Arial','B',7);				
			$pdf->Cell(50,5,"TOTAL BORDEREAU JOURN.",'LTB','','C');
			$pdf->Cell(20,5,$t_usd,'LRTB','','R');
			$pdf->Cell(20,5,$t_cdf,'RTB','','R');
			$pdf->Cell(20,5,$t_tva_usd,'RTB','','R');
			$pdf->Cell(20,5,$t_tva_cdf,'RTB','','R');
			$pdf->Cell(20,5,$t_tt_usd,'RTB','','R');
			$pdf->Cell(20,5,$t_tt_cdf,'RTB','','R');	*/
			
			$pdf->Ln();$pdf->Ln();
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(200,5,"Lubumbashi, Le ".Datemysqltofr(Date('Y-m-d')),'','','R'); $pdf->Ln(); $pdf->Ln(); $pdf->Ln();
			
			$pdf->Ln();$pdf->Ln();
			$pdf->Cell(200,5,"Visa du Coordonnateur",'','','C');
			
			
			
$pdf->Output();



?>
