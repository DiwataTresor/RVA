<?php
	@session_start();
	$dt=$_GET["dt"];
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../manager/bd/cnx.php');
	
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
	$pdf->SetTopMargin(15);
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
	
			$s_rda="select * from rda,client where rda.Client_rda=client.Id_cl and rda.Date_rda='$dt' order by Nom_cli";
			$e_rda=mysqli_query($bdd,$s_rda);
			$n_rda=mysqli_num_rows($e_rda);
			$t_rda=mysqli_fetch_array($e_rda);
			$user=user($t_rda['Id_us'],$bdd);	

			$pdf->Cell(183,20, utf8_decode(''),'','','C'); 
			$pdf->Ln(8);
			//$mouv=str_replace("'","",$num_mouv);
			$pdf->SetFont('Arial','B',10);
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
	$s_acces="select * from acces where Date_perc='$dt'";
	$e_acces=mysqli_query($bdd,$s_acces);
	$n_acces=mysqli_num_rows($e_acces);
	$t_acces=mysqli_fetch_array($e_acces);
	
	$s_rda="select * from rda,client where rda.Client_rda=client.Id_cl and rda.Date_rda='$dt' order by Nom_cli";
	$e_rda=mysqli_query($bdd,$s_rda);
	$n_rda=mysqli_num_rows($e_rda);
	$t_rda=mysqli_fetch_array($e_rda);	
	
	$s_idf="select * from idf_paiement,client where idf_paiement.Date_idf='$dt' and idf_paiement.Client=client.Id_cl";
	$e_idf=mysqli_query($bdd,$s_idf);
	$n_idf=mysqli_num_rows($e_idf);
	$t_idf=mysqli_fetch_array($e_idf);		
//================================ ENTETE DU TABLEAU==================================
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(50,7, utf8_decode("EXPLOITANT + FACT. "),'TRBL','','C');
			//$pdf->Cell(50,7, ($bord['acc']),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT.HT US"),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT. HT CD"),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT. TVA US"),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT.TVA CD"),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT.TTC US"),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT. TTC CD"),'TRBL','','C'); 
			$pdf->Cell(27,7, utf8_decode("QUITTANCE"),'TRBL','','C'); 
			$pdf->Cell(30,7, utf8_decode("OBSERV"),'TRBL','','C'); 
//=============================== CONTENU DU TABLEAU=================================
			$pdf->Ln();
			$pdf->SetFont('Arial','B',9);
			// ========= VARIABLE ===========
			$st_acc_us=0; $st_acc_tva_us=0; $st_acc_tt_us=0; $st_acc_cd=0; $st_acc_tva_cd=0; $st_acc_tt_cd=0;
			$t_tt_us=0;
			if(($n_acces)==0)
			{
				//$pdf->Cell(50,7,$acces[$a]["num_acc"],'','','R');
			}else
			{	
				$pdf->Cell(50,5,"     LES ACCES",'B','','L');
				$pdf->Cell(20,5,"",'B','','R');
				$pdf->Cell(20,5,"",'B','','R');
				$pdf->Cell(20,5,"",'B','','R');
				$pdf->Cell(20,5,"",'B','','R');
				$pdf->Cell(20,5,"",'B','','R');
				$pdf->Cell(20,5,"",'B','','C');
				$pdf->Cell(27,5,"",'B','','C');
				$pdf->Cell(30,5,"",'B','','R');
				$pdf->Ln();
				$pdf->SetFont('Arial','',9);	
				do
				{
						if($t_acces['Monn_acc']=='USD')
						{
							$tva_us=($t_acces['Mt_acc']*16)/100;
							if($t_acces['Tva']=="N"){$tva_us=0;}
							$mht=$t_acces['Mt_acc'];
							$mtt=ceil($tva_us+$mht);
							$st_acc_us=$st_acc_us+$mht;
							$st_acc_tva_us=$st_acc_tva_us+$tva_us;							
							$st_acc_tt_us=$st_acc_tt_us+$mtt;
							
							$pdf->Cell(50,5,$t_acces["Num_long"],'L','','C');
							$pdf->Cell(20,5,arrondie($mht),'LR','','R');
							$pdf->Cell(20,5,arrondie(0),'R','','R');
							$pdf->Cell(20,5,arrondie($tva_us),'R','','R');
							$pdf->Cell(20,5,arrondie(0),'R','','R');
							$pdf->Cell(20,5,arrondie($mtt),'R','','R');
							$pdf->Cell(20,5,arrondie(0),'R','','R');
							$pdf->Cell(27,5,$t_acces["Quittance"],'R','','R');
							$pdf->Cell(30,5,"PERCUS",'R','','C');
							$pdf->Ln();
						}else
						{
							$tva_cd=($t_acces['Mt_acc']*16)/100;
							if($t_acces['Tva']=="N"){$tva_cd=0;}
							$mht=$t_acces['Mt_acc'];
							$mtt=$tva_cd+$mht;
							$st_acc_cd=$st_acc_cd+$mht;
							$st_acc_tva_cd=$st_acc_tva_cd+$tva_cd;
							$st_acc_tt_cd=$st_acc_tt_cd+$mht+$tva_cd;
							
							$pdf->Cell(50,5,$t_acces["Num_long"],'L','','C');
							$pdf->Cell(20,5,arrondie(0),'LR','','R');
							$pdf->Cell(20,5,arrondie($mht),'R','','R');
							$pdf->Cell(20,5,arrondie(0),'R','','R');
							$pdf->Cell(20,5,arrondie($tva_cd),'R','','R');
							$pdf->Cell(20,5,arrondie(0),'R','','R');
							$pdf->Cell(20,5,arrondie($mtt),'R','','R');
							$pdf->Cell(27,5,$t_acces["Quittance"],'R','','R');
							$pdf->Cell(30,5,"PERCUS",'R','','C');
							$pdf->Ln();
						}
				}while($t_acces=mysqli_fetch_array($e_acces));
				$pdf->SetFont('Arial','B',9);				
				$pdf->Cell(50,5,"Sous total",'LTB','','R');
				$pdf->Cell(20,5,arrondie($st_acc_us),'LRTB','','R');
				$pdf->Cell(20,5,arrondie($st_acc_cd),'RTB','','R');
				$pdf->Cell(20,5,arrondie($st_acc_tva_us),'RTB','','R');
				$pdf->Cell(20,5,arrondie($st_acc_tva_cd),'RTB','','R');
				$pdf->Cell(20,5,(arrondie($st_acc_tt_us)),'RTB','','R');
				$pdf->Cell(20,5,arrondie(ceil($st_acc_tt_cd)),'RTB','','R');
				$pdf->Cell(27,5,"",'RTB','','C');
				$pdf->Cell(30,5,"",'RTB','','C');
				$t_tt_us=$t_tt_us+$st_acc_tt_us;
			}		
//================ HANDLING=================================================================
	$s_hand="select * from handling_paiement where Date_paie='$dt'";
	$e_hand=mysqli_query($bdd,$s_hand);
	$n_hand=mysqli_num_rows($e_hand);
	$t_hand=mysqli_fetch_array($e_hand);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);	
	$pdf->Cell(50,5,"     HANDLING",'B','','L');
	$pdf->Cell(20,5,"",'B','','R');
	$pdf->Cell(20,5,"",'B','','R');
	$pdf->Cell(20,5,"",'B','','R');
	$pdf->Cell(20,5,"",'B','','R');
	$pdf->Cell(20,5,"",'B','','R');
	$pdf->Cell(20,5,"",'B','','C');
	$pdf->Cell(27,5,"",'B','','C');
	$pdf->Cell(30,5,"",'B','','R');
	$pdf->Ln();	
	$st_hand_us=0; $st_hand_tva_us=0; $st_hand_tt_us=0; $st_hand_cd=0; $st_hand_tva_cd=0; $st_hand_tt_cd=0;
	if($n_hand==0)
	{
		$pdf->Cell(50,5,"",'LB','','C');
		$pdf->Cell(20,5,arrondie(0),'LRB','','R');
		$pdf->Cell(20,5,arrondie(0),'RB','','R');
		$pdf->Cell(20,5,arrondie(0),'RB','','R');
		$pdf->Cell(20,5,arrondie(0),'RB','','R');
		$pdf->Cell(20,5,arrondie(0),'RB','','R');
		$pdf->Cell(20,5,arrondie(0),'RB','','R');
		$pdf->Cell(27,5,"",'RB','','R');
		$pdf->Cell(30,5,"",'RB','','C');
		$pdf->Ln();
	}else
	{
		do
		{
			$pdf->SetFont('Arial','',9);
			$detail=paie_handling_detail($t_hand['Fact_paie'],$bdd);
			
			$pdf->Cell(50,5,$detail['detail']['client'],'L','','L');
			$pdf->Cell(20,5,"",'LR','','R');
			$pdf->Cell(20,5,"",'R','','R');
			$pdf->Cell(20,5,"",'R','','R');
			$pdf->Cell(20,5,"",'R','','R');
			$pdf->Cell(20,5,"",'R','','R');
			$pdf->Cell(20,5,"",'R','','R');
			$pdf->Cell(27,5,"",'R','','R');
			$pdf->Cell(30,5,"",'R','','C');
			$pdf->Ln();
			$pdf->Cell(50,5,$detail['num_fact'],'L','','C');
			$pdf->Cell(20,5,arrondie($detail['mht']),'LR','','R');
			$pdf->Cell(20,5,arrondie(0),'R','','R');
			$pdf->Cell(20,5,arrondie($detail["tva"]),'R','','R');
			$pdf->Cell(20,5,arrondie(0),'R','','R');
			$pdf->Cell(20,5,arrondie($detail["mttc"]),'R','','R');
			$pdf->Cell(20,5,arrondie(0),'R','','R');
			$pdf->Cell(27,5,$detail["quittance"],'R','','R');
			$pdf->Cell(30,5,"PERCUS",'R','','C');
			$pdf->Ln();

			//============= CALCUL SOUS TOTAL ====================
				$st_hand_us=$st_hand_us+$detail["mht"]; 
				$st_hand_tva_us=$st_hand_tva_us+$detail["tva"]; 
				$st_hand_tt_us=$st_hand_tt_us+$detail["mttc"]; 
				$st_hand_cd=0; 
				$st_hand_tva_cd=0; 
				$st_hand_tt_cd=0;

		}while($t_hand=mysqli_fetch_array($e_hand));
	}
		$pdf->SetFont('Arial','B',8);				
		$pdf->Cell(50,5,"Sous total",'LTB','','R');
		$pdf->Cell(20,5,arrondie($st_hand_us),'LRTB','','R');
		$pdf->Cell(20,5,arrondie($st_hand_cd),'RTB','','R');
		$pdf->Cell(20,5,arrondie($st_hand_tva_us),'RTB','','R');
		$pdf->Cell(20,5,arrondie($st_hand_tva_cd),'RTB','','R');
		$pdf->Cell(20,5,arrondie($st_hand_tt_us),'RTB','','R');
		$pdf->Cell(20,5,arrondie($st_hand_tt_cd),'RTB','','R');
		$pdf->Cell(27,5,"",'RTB','','C');
		$pdf->Cell(30,5,"",'RTB','','C');
//================ REDEVANCES AER===========================================================	
			$pdf->Ln();
			$pdf->SetFont('Arial','B',9);	
			$pdf->Cell(50,5,"     RDA",'B','','L');
				$pdf->Cell(20,5,"",'B','','R');
				$pdf->Cell(20,5,"",'B','','R');
				$pdf->Cell(20,5,"",'B','','R');
				$pdf->Cell(20,5,"",'B','','R');
				$pdf->Cell(20,5,"",'B','','R');
				$pdf->Cell(20,5,"",'B','','C');
				$pdf->Cell(27,5,"",'B','','C');
				$pdf->Cell(30,5,"",'B','','R');
				$pdf->Ln();
				$inc=1;
				$pdf->SetFont('Arial','',9);	
				//$nom=$rda['Nom_cli'];
				$stcli=0;
								
				$pdf->Cell(50,5,truncate($t_rda["Nom_cli"],22),'L','','L');
				$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','R');
				$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','R');
				$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(27,5,"",'LR','','R');$pdf->Cell(30,5,"",'LR','','R');
				
				$pdf->Ln();
				$st_rda_us=0; $st_rda_tva_us=0; $st_rda_tt_us=0; $st_rda_cd=0; $st_rda_tva_cd=0; $st_rda_tt_cd=0;
				$mtt=0; $mht=0; $tva_us=0; $tva_cd=0;
				$nomcli=$t_rda["Nom_cli"];
				do
				{
						$fact=$t_rda['Num_long'];
						$s2="select * from facture_imprime where Num_facture='$fact'"; 
						$e2=mysqli_query($bdd,$s2); $t2=mysqli_fetch_array($e2);
						$mouv2=mouv($t2['Mouv'],$bdd);
						$rda=$t_rda;
						
						if($t_rda["Nom_cli"]==$nomcli)
						{
							//$pdf->Cell(50,5,$t_rda["Nom_cli"],'L','','L');
							
						}else
						{
							$pdf->Cell(50,5,truncate($t_rda['Nom_cli'],22),'L','','L');
							$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','R');
							$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','R');
							$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(27,5,"",'LR','','R');$pdf->Cell(30,5,"",'LR','','R');
							$pdf->Ln();
							$nomcli=$t_rda["Nom_cli"];
						}
						
						if($t_rda['Monn_rda']=='USD')
						{
							if($mouv2['ta']['Code_nat']=="E" || $mouv2['ta']['Categ_vol']=="H")
							{
								$tva_us=0;
								$mht=$mouv2['tot_sans_tva'];
								$mtt=$mouv2['tot_avec_tva'];
							//if($mouv2['ta']['Code_nat']==
							}else
							{
								$tva_us=$mouv2['tva'];
								$mht=$mouv2['tot_sans_tva'];
								$mtt=$mouv2['tot_avec_tva'];
							}
							
							$st_rda_us=$st_rda_us+$mht;
							$st_rda_tva_us=$st_rda_tva_us+$tva_us;
							$st_rda_tt_us=$st_rda_tt_us+($mtt);
							
							$pdf->Cell(50,5,$rda["Num_long"],'L','','C');
							$pdf->Cell(20,5,arrondie($mht),'LR','','R');
							$pdf->Cell(20,5,arrondie(0),'R','','R');
							$pdf->Cell(20,5,arrondie($tva_us),'R','','R');
							$pdf->Cell(20,5,arrondie(0),'R','','R');
							$pdf->Cell(20,5,arrondie($mtt),'R','','R');
							$pdf->Cell(20,5,arrondie(0),'R','','R');
							$pdf->Cell(27,5,$rda["Quittance"],'R','','R');
							$pdf->Cell(30,5,"TOTALITE",'R','','C');
							$pdf->Ln();
							
							
						}else
						{
							if($mouv2['ta']['Code_nat']=="E" || $mouv2['ta']['Categ_vol']=="H")
							{
								$tva_cd=0;
								$mht=$t_rda['Mt_rda']-$tva_cd;
								$mtt=$mht+$tva_cd;
							}else
							{
								$tva_cd=tva($t_rda['Mt_rda']);
								$mht=$t_rda['Mt_rda']-$tva_cd;
								$mtt=$mht+$tva_cd;
							}
							
							
							$st_rda_cd=$st_rda_cd+$mht;
							$st_rda_tva_cd=$st_rda_tva_cd+$tva_cd;
							$st_rda_tt_cd=$st_rda_tt_cd+($mtt);
							
							$pdf->Cell(50,5,$rda["Num_long"],'L','','C');
							$pdf->Cell(20,5,arrondie(0),'LR','','R');
							$pdf->Cell(20,5,arrondie($mht),'R','','R');
							$pdf->Cell(20,5,arrondie(0),'R','','R');
							$pdf->Cell(20,5,arrondie($tva_cd),'R','','R');
							$pdf->Cell(20,5,arrondie(0),'R','','R');
							$pdf->Cell(20,5,arrondie($mtt),'R','','R');
							$pdf->Cell(27,5,$rda["Quittance"],'R','','R');
							$pdf->Cell(30,5,"TOTALITE",'R','','C');
							$pdf->Ln();
						}														
				}while($t_rda=mysqli_fetch_array($e_rda));
				$pdf->SetFont('Arial','B',8);				
				$pdf->Cell(50,5,"Sous total",'LTB','','R');
				$pdf->Cell(20,5,arrondie($st_rda_us),'LRTB','','R');
				$pdf->Cell(20,5,arrondie($st_rda_cd),'RTB','','R');
				$pdf->Cell(20,5,arrondie($st_rda_tva_us),'RTB','','R');
				$pdf->Cell(20,5,arrondie($st_rda_tva_cd),'RTB','','R');
				$pdf->Cell(20,5,arrondie($st_rda_tt_us),'RTB','','R');
				$pdf->Cell(20,5,arrondie($st_rda_tt_cd),'RTB','','R');
				$pdf->Cell(27,5,"",'RTB','','C');
				$pdf->Cell(30,5,"",'RTB','','C');
				$pdf->Ln();
				
				$pdf->Cell(50,5,"TOTAL HANDLING + ACCES + RDA",'LTB','','R');
				$pdf->Cell(20,5,arrondie(($st_rda_us)+($st_acc_us)+($st_hand_us)),'LRTB','','R');
				$pdf->Cell(20,5,arrondie(($st_rda_cd)+($st_acc_cd)+($st_hand_cd)),'RTB','','R');
				$pdf->Cell(20,5,arrondie(($st_rda_tva_us)+($st_acc_tva_us)+($st_hand_tva_us)),'RTB','','R');
				$pdf->Cell(20,5,arrondie(($st_rda_tva_cd)+($st_acc_tva_cd)+($st_hand_tva_cd)),'RTB','','R');
				$pdf->Cell(20,5,arrondie(($st_rda_tt_us)+($st_acc_tt_us)+($st_hand_tt_us)),'RTB','','R');
				$pdf->Cell(20,5,arrondie(($st_rda_tt_cd)+($st_acc_tt_cd)+($st_hand_tt_cd)),'RTB','','R');
				$pdf->Cell(27,5,"",'RTB','','C');
				$pdf->Cell(30,5,"",'RTB','','C');
				$pdf->Ln();				
				//$t_tt_us=$t_tt_us+$st_acc_tt_us;
				$t_tt_us=($st_rda_tt_us+$st_acc_tt_us)+$t_tt_us;

//============================ IDF ========================================================================
			$pdf->SetFont('Arial','B',9);				
			$st_idf_us=0; $st_idf_tva_us=0; $st_idf_tt_us=0; $st_idf_cd=0; $st_idf_tva_cd=0; $st_idf_tt_cd=0;
							
				$pdf->Cell(50,5,"     IDF FRET",'TB','','L');
				$pdf->Cell(20,5,"",'','','R');
				$pdf->Cell(20,5,"",'','','R');
				$pdf->Cell(20,5,"",'','','R');
				$pdf->Cell(20,5,"",'','','R');
				$pdf->Cell(20,5,"",'','','R');
				$pdf->Cell(20,5,"",'','','R');
				$pdf->Cell(27,5,"",'','','C');
				$pdf->Cell(30,5,"",'','','C');
				$pdf->Ln();
				$pdf->SetFont('Arial','',10);	
			if($n_idf==0)
			{
				$idf_tva_us=0;
				$idf_mht_us=0;
				$idf_mtt_us=0;
				$idf_tva_cd=0;
				$idf_mht_cd=0;
				$idf_mtt_cd=0;
			}else
			{
				
				do
				{
					$idf_tva_us=0;$idf_tva_cd=0;$idf_mht=0;$idf_mtt=0;
					if($t_idf["Monn"]=='USD')
					{
						$idf_tva_us=0;
						$idf_mht=$t_idf['Mt']-$idf_tva_us;
						$idf_mtt=$t_idf['Mt'];
						
						$st_idf_us=$st_idf_us+$idf_mht;
						$st_idf_tva_us=$st_idf_tva_us+$idf_tva_us;
						$st_idf_tt_us=$st_idf_tt_us+$idf_mtt;
						
						$pdf->Cell(50,5,$t_idf['Nom_cli'],'LTB','','L');
						$pdf->Cell(20,5,arrondie($idf_mht),'LRTB','','R');
						$pdf->Cell(20,5,arrondie(0),'RTB','','R');
						$pdf->Cell(20,5,arrondie($idf_tva_us),'RTB','','R');
						$pdf->Cell(20,5,arrondie(0),'RTB','','R');
						$pdf->Cell(20,5,arrondie($idf_mtt),'RTB','','R');
						$pdf->Cell(20,5,arrondie(0),'RTB','','R');
						$pdf->Cell(27,5,$t_idf['Quittance'],'RTB','','R');
						$pdf->Cell(30,5,"",'RTB','','C');
						$pdf->Ln();
					}else
					{
						$idf_tva_cd=0;
						$idf_mht=$t_idf['Mt']-$idf_tva_cd;
						$idf_mtt=$t_idf['Mt'];
						
						$st_idf_cd=$st_idf_cd+$idf_mht;
						$st_idf_tva_cd=$st_idf_tva_cd+$idf_tva_cd;
						$st_idf_tt_cd=$st_idf_tt_cd+$idf_mtt;
						
						$pdf->Cell(50,5,$t_idf['Nom_cli'],'LTB','','L');
						$pdf->Cell(20,5,arrondie(0),'RTB','','R');
						$pdf->Cell(20,5,arrondie($idf_mht),'LRTB','','R');
						$pdf->Cell(20,5,arrondie(0),'RTB','','R');
						$pdf->Cell(20,5,arrondie($idf_tva_cd),'RTB','','R');
						$pdf->Cell(20,5,arrondie(0),'RTB','','R');
						$pdf->Cell(20,5,arrondie($idf_mtt),'RTB','','R');
						$pdf->Cell(27,5,$t_idf['Quittance'],'RTB','','R');
						$pdf->Cell(30,5,"",'RTB','','C');
						$pdf->Ln();
					}
				
				}while($t_idf=mysqli_fetch_array($e_idf));
					$pdf->SetFont('Arial','B',10);	
						$pdf->Cell(50,5,"Sous total",'LTB','','R');
						$pdf->Cell(20,5,arrondie($st_idf_us),'LRTB','','R');
						$pdf->Cell(20,5,arrondie($st_idf_cd),'RTB','','R');
						$pdf->Cell(20,5,arrondie($st_idf_tva_us),'RTB','','R');
						$pdf->Cell(20,5,arrondie($st_idf_tva_cd),'RTB','','R');
						$pdf->Cell(20,5,arrondie($st_idf_tt_us),'RTB','','R');
						$pdf->Cell(20,5,arrondie($st_idf_tt_cd),'RTB','','R');
						$pdf->Cell(27,5,"",'RTB','','R');
						$pdf->Cell(30,5,"",'RTB','','C');
						$pdf->Ln();
			}
			
//==================================== TOTALITE DU BORDEREAU===============================================	
			$t_us=$st_acc_us+$st_hand_us+$st_rda_us+$st_idf_us;
			$t_cd=$st_acc_cd+$st_hand_cd+$st_rda_cd+$st_idf_cd;
			$t_tva_cd=$st_acc_tva_cd+$st_hand_tva_cd+$st_rda_tva_cd+$st_idf_tva_cd;
			$t_tva_us=$st_acc_tva_us+$st_hand_tva_us+$st_rda_tva_us+$st_idf_tva_us;
			//$t_tt_us=$t_tva_us+$t_us;
			$t_tt_cd=$t_cd+$t_tva_cd;
			$t_tt_us=($st_rda_tt_us+$st_acc_tt_us+$st_hand_tt_us)+$st_idf_tt_us;
			

			$pdf->Ln();$pdf->Ln();
			$pdf->SetFont('Arial','',8);				
			$pdf->Cell(50,5,"TOTAL BORDEREAU JOURN.",'LTB','','C');
			$pdf->Cell(20,5,arrondie($t_us),'LRTB','','R');
			$pdf->Cell(20,5,arrondie($t_cd),'RTB','','R');
			$pdf->Cell(20,5,arrondie($t_tva_us),'RTB','','R');
			$pdf->Cell(20,5,arrondie($t_tva_cd),'RTB','','R');
			$pdf->Cell(20,5,arrondie($t_tt_us),'RTB','','R');
			$pdf->Cell(20,5,arrondie($t_tt_cd),'RTB','','R');	
			
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
