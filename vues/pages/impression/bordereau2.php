<?php
	@session_start();
	$dt=$_GET["dt"];
	
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
	$pdf->SetTopMargin(105);
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
			$pdf->Cell(169,7, utf8_decode("NOM PERCEPTEUR(TRICE) : ".$user['nom']."      ".$user['matr']),'','','L'); 
			$pdf->Ln(9);
			$pdf->SetFont('Arial','BU',11);
			$pdf->Cell(210,7, utf8_decode("BORDEREAU DE VERSEMENT "),'','','C'); 
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);
			
			$pdf->Cell(210,7, utf8_decode("DU "." ". strtoupper(jrSemaine($dt))." ".Datemysqltofr($dt)),'','','C'); 
			$pdf->Ln();
//================================= DONNEES RETOURNEES DU BORDEREAU==================
			$acces=$bord["acc"];
			$rda=$bord["rda"];
			$idf=$bord["idf"];
			$st_acc_usd=$bord["st_acc_usd"];
			$st_acc_tva_usd=$bord["st_acc_tva_usd"];
			$st_acc_tt_usd=$bord["st_acc_tt_usd"];
			$st_acc_cdf=$bord["st_acc_cdf"];
			$st_acc_tva_cdf=$bord["st_acc_tva_cdf"];
			$st_acc_tt_cdf=$bord["st_acc_tt_cdf"];

			$st_rda_usd=$bord["st_rda_usd"];
			$st_rda_tva_usd=$bord["st_rda_tva_usd"];
			$st_rda_tt_usd=$bord["st_rda_tt_usd"];
			$st_rda_cdf=$bord["st_rda_cdf"];
			$st_rda_tva_cdf=$bord["st_rda_tva_cdf"];
			$st_rda_tt_cdf=$bord["st_rda_tt_cdf"];

			$t_usd=$bord["t_usd"];
			$t_tva_usd=$bord["t_tva_usd"];
			$t_tt_usd=$bord["t_tt_usd"];
			$t_cdf=$bord["t_cdf"];
			$t_tva_cdf=$bord["t_tva_cdf"];
			$t_tt_cdf=$bord["t_tt_cdf"];
//================================ ENTETE DU TABLEAU==================================
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(50,7, utf8_decode("EXPLOITANT + FACT. "),'TRBL','','C');
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
			$pdf->Ln();
			$pdf->SetFont('Arial','B',7);
			if(($acces[0]["n"])==0)
			{
				//$pdf->Cell(50,7,$acces[$a]["num_acc"],'','','R');
			}else
			{	
				$pdf->Cell(50,5,"LES ACCES PONCTUELS",'L','','L');
				$pdf->Cell(20,5,"",'LR','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','C');
				$pdf->Cell(27,5,"",'R','','C');
				$pdf->Cell(30,5,"",'R','','R');
				$pdf->Ln();
				for($a=0;$a<count($acces);$a++)
				{
						
						$pdf->Cell(50,5,$acces[$a]["num_acc"],'L','','L');
						$pdf->Cell(20,5,$acces[$a]["acc_mt_usd"],'LR','','R');
						$pdf->Cell(20,5,$acces[$a]["acc_mt_cdf"],'R','','R');
						$pdf->Cell(20,5,$acces[$a]["acc_mt_tva_usd"],'R','','R');
						$pdf->Cell(20,5,$acces[$a]["acc_mt_tva_cdf"],'R','','R');
						$pdf->Cell(20,5,$acces[$a]["acc_mt_tt_usd"],'R','','R');
						$pdf->Cell(20,5,$acces[$a]["acc_mt_tt_cdf"],'R','','R');
						$pdf->Cell(27,5,$acces[$a]["acc_quittance"],'R','','R');
						$pdf->Cell(30,5,"PERCUS",'R','','C');
						$pdf->Ln();
				}
				$pdf->SetFont('Arial','B',7);				
				$pdf->Cell(50,5,"Sous total",'LTB','','R');
				$pdf->Cell(20,5,$st_acc_usd,'LRTB','','R');
				$pdf->Cell(20,5,$st_acc_cdf,'RTB','','R');
				$pdf->Cell(20,5,$st_acc_tva_usd,'RTB','','R');
				$pdf->Cell(20,5,$st_acc_tva_cdf,'RTB','','R');
				$pdf->Cell(20,5,$st_acc_tt_usd,'RTB','','R');
				$pdf->Cell(20,5,$st_acc_tt_cdf,'RTB','','R');
				$pdf->Cell(27,5,"",'RTB','','C');
				$pdf->Cell(30,5,"",'RTB','','C');
			}		
			
//================ REDEVANCES AER===========================================================	
			$pdf->Ln();
			if(($rda[0]["n"])==0)
			{
				//$pdf->Cell(50,7,$rda[$a]["num_rda"],'','','R');
			}else
			{	
				$pdf->Cell(50,5,"RDA",'L','','L');
				$pdf->Cell(20,5,"",'LR','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','C');
				$pdf->Cell(27,5,"",'R','','C');
				$pdf->Cell(30,5,"",'R','','R');
				$pdf->Ln();
				$inc=1;
				$nom=$rda[0]['nom'];
				$stcli=0;
				$st_u=0; $st_c=0.00; $st_u_tva=0.00; $st_c_tva=0.00; $st_u_tt=0.00; $st_c_tt=0.00;
				
				$pdf->Cell(50,5,$rda[0]["nom"],'L','','L');
				$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','R');
				$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','R');
				$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(27,5,"",'LR','','R');$pdf->Cell(30,5,"",'LR','','R');
				$rupture="non";
				$pdf->Ln();
				for($a=0;$a<count($rda);$a++)
				{
						if($rda[$a]['nom']==$nom)
						{
							$st_u=$st_u+$rda[$a]['rda_mt_usd'];
							$st_u_tva=$st_u_tva+$rda[$a]['rda_mt_tva_usd'];
							$st_u_tt=($st_u+$st_u_tva);
							
							$rupture="non";
							$nom=$rda[$a]['nom'];	
							$pdf->Cell(50,5,$rda[$a]["num_rda"],'L','','L');
							$pdf->Cell(20,5,($rda[$a]["rda_mt_usd"]),'LR','','R');
							$pdf->Cell(20,5,$rda[$a]["rda_mt_cdf"],'R','','R');
							$pdf->Cell(20,5,$rda[$a]["rda_mt_tva_usd"],'R','','R');
							$pdf->Cell(20,5,$rda[$a]["rda_mt_tva_cdf"],'R','','R');
							$pdf->Cell(20,5,$rda[$a]["rda_mt_tt_usd"],'R','','R');
							$pdf->Cell(20,5,$rda[$a]["rda_mt_tt_cdf"],'R','','R');
							$pdf->Cell(27,5,$rda[$a]["rda_quittance"],'R','','R');
							$pdf->Cell(30,5,"TOTALITE",'R','','C');
							$pdf->Ln();
							
						}else
						{
							$nom=$rda[$a]['nom']; 
							$pdf->Cell(50,5,"Sous Total",'L','','R');
							$pdf->Cell(20,5,$st_u,'LR','','R');
							$pdf->Cell(20,5,$rda[$a-1]['st'][0]['mt_cdf'],'LR','','R');
							$pdf->Cell(20,5,$st_u_tva,'LR','','R');
							$pdf->Cell(20,5,$rda[$a-1]['st'][0]['mt_cdf_tva'],'LR','','R');
							$pdf->Cell(20,5,($st_u_tt),'LR','','R');
							$pdf->Cell(20,5,arrondie($rda[$a-1]['st'][0]['mt_cdf_tt']),'LR','','R');
							$pdf->Cell(27,5,"",'LR','','R');
							$pdf->Cell(30,5,"",'LR','','R');
							$rupture="non";
							$st_u=0; $st_c=0.00; $st_u_tva=0.00; $st_c_tva=0.00; $st_u_tt=0.00; $st_c_tt=0.00;
							$pdf->Ln();
						
							$rupture="oui";
							$pdf->Cell(50,5,$rda[$a]["nom"],'L','','L');
							$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','R');
							$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','R');
							$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(27,5,"",'LR','','R');$pdf->Cell(30,5,"",'LR','','R');
							
							$pdf->Ln();
							
							$nom=$rda[$a]['nom'];	
							$pdf->Cell(50,5,$rda[$a]["num_rda"],'L','','R');
							$pdf->Cell(20,5,$rda[$a]["rda_mt_usd"],'LR','','R');
							$pdf->Cell(20,5,$rda[$a]["rda_mt_cdf"],'R','','R');
							$pdf->Cell(20,5,$rda[$a]["rda_mt_tva_usd"],'R','','R');
							$pdf->Cell(20,5,$rda[$a]["rda_mt_tva_cdf"],'R','','R');
							$pdf->Cell(20,5,$rda[$a]["rda_mt_tt_usd"],'R','','R');
							$pdf->Cell(20,5,$rda[$a]["rda_mt_tt_cdf"],'R','','R');
							$pdf->Cell(27,5,$rda[$a]["rda_quittance"],'R','','R');
							$pdf->Cell(30,5,"TOTALITE",'R','','C');
							$pdf->Ln();
						}
							
							$st_u=(($rda[$a]["rda_mt_usd"]));
							//$st_usd=(($rda[$a]["rda_mt_usd"])); 
							$st_c=($st_c+$rda[$a]["rda_mt_cdf"]); 
							$st_u_tva=$st_u_tva+$rda[$a]["rda_mt_tva_usd"]; 
							$st_c_tva=$st_c_tva+$rda[$a]["rda_mt_tva_cdf"]; 
							$st_u_tt=$st_u_tt+$rda[$a]["rda_mt_tt_usd"]; 
							$st_c_tt=$st_c_tt+$rda[$a]["rda_mt_tt_cdf"];
							
				}
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
				
				$pdf->SetFont('Arial','B',9);				
				$pdf->Cell(50,5,"Sous total",'LTB','','C');
				$pdf->Cell(20,5,$st_rda_usd,'LRTB','','R');
				$pdf->Cell(20,5,$st_rda_cdf,'RTB','','R');
				$pdf->Cell(20,5,$st_rda_tva_usd,'RTB','','R');
				$pdf->Cell(20,5,$st_rda_tva_cdf,'RTB','','R');
				$pdf->Cell(20,5,$st_rda_tt_usd,'RTB','','R');
				$pdf->Cell(20,5,$st_rda_tt_cdf,'RTB','','R');
				$pdf->Cell(27,5,"",'RTB','','C');
				$pdf->Cell(30,5,"",'RTB','','C');
			}	
			
//============================ IDF ========================================================================
			$pdf->Ln();
			if(($idf[0]["n"])==0)
			{
				//$pdf->Cell(50,7,$rda[$a]["num_rda"],'','','R');
			}else
			{	
				$pdf->Cell(50,5,"IDF FRET",'L','','L');
				$pdf->Cell(20,5,"",'LR','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','C');
				$pdf->Cell(27,5,"",'R','','C');
				$pdf->Cell(30,5,"",'R','','R');
				$pdf->Ln();
				
				
				/*$pdf->Cell(50,5,$rda[0]["nom"],'L','','L');
				$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','R');
				$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','R');
				$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(27,5,"",'LR','','R');$pdf->Cell(30,5,"",'LR','','R');
				$rupture="non";
				$pdf->Ln();*/
				
							$pdf->Cell(50,5,"",'LRB','','R');
							$pdf->Cell(20,5,$idf[0]['mt'],'LRB','','R');
							$pdf->Cell(20,5,0,'LRB','','R');
							$pdf->Cell(20,5,0,'LRB','','R');
							$pdf->Cell(20,5,0,'LRB','','R');
							$pdf->Cell(20,5,$idf[0]['mt'],'LRB','','R');
							$pdf->Cell(20,5,0,'LRB','','R');
							$pdf->Cell(27,5,"",'LRB','','R');
							$pdf->Cell(30,5,"",'LRB','','R');
							
							$pdf->Ln();
							
			}				
//==================================== TOTALITE DU BORDEREAU===============================================	
			$pdf->Ln();$pdf->Ln();
			$pdf->SetFont('Arial','B',7);				
			$pdf->Cell(50,5,"TOTAL BORDEREAU JOURN.",'LTB','','C');
			$pdf->Cell(20,5,$t_usd,'LRTB','','R');
			$pdf->Cell(20,5,$t_cdf,'RTB','','R');
			$pdf->Cell(20,5,$t_tva_usd,'RTB','','R');
			$pdf->Cell(20,5,$t_tva_cdf,'RTB','','R');
			$pdf->Cell(20,5,(ceil($t_usd)+ceil($t_tva_usd)+1),'RTB','','R');
			$pdf->Cell(20,5,$t_tt_cdf,'RTB','','R');	
			
			$pdf->Ln();$pdf->Ln();
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(200,5,"Lubumbashi, Le ".Datemysqltofr(Date('Y-m-d')),'','','R'); $pdf->Ln(); $pdf->Ln(); $pdf->Ln();
			$pdf->Cell(40,5,"Pour la remise",'','','R');
			$pdf->Cell(140,5,utf8_decode("Pour la Réception"),'','','R');
			
			$pdf->Ln();$pdf->Ln();
			$pdf->Cell(40,5,"Le Percepteur(trice)",'','','R');
			$pdf->Cell(140,5,utf8_decode("Caisse Recettes"),'','','R');
			
			$pdf->Ln();$pdf->Ln();
			$pdf->Cell(200,5,"Visa du Coordonnateur",'','','C');
			
			
			
$pdf->Output();



?>
