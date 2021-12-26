<?php
	@session_start();
	$cl=$_REQUEST["client"];
	$dt=$_REQUEST["dt"];
	$dt2=$_REQUEST["dt2"];
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../manager/bd/cnx.php');
	$bord=bordereau($dt,$bdd);
	$id_us=$_SESSION["Idd"];
	$user=user($id_us,$bdd);

	class PDF extends FPDF
	{
	
	}
	$taille=array(39,39);
	$pdf = new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetLeftMargin(5);
	$pdf->SetTopMargin(10);
	$pdf->SetFont('Arial','B',10);
	$pdf->Image('../../../images/entete_pdf.png',123,10,60,20);
	$npage=$pdf->PageNo();
	
	//$pdf->Line(15, 260, 190, 260);
	//$pdf->Line(15, 70, 190, 70);
	
	$pdf->SetFont('Arial','',11);
	/*$pdf->Text(20, 270, utf8_decode("N° TVA : 664 / 2012"));
	$pdf->Text(20, 275, utf8_decode("N° IMPOT : A1201438C"));*/
	
	//$pdf->Text(2.7, 1.2, utf8_decode("REPUBLIQUE DEMOCRATIQUE DU CONGO"));
	$pdf->Text(20, 10, utf8_decode("REGIE DES VOIES AERIENNES SA"));
	$pdf->Text(20, 20, utf8_decode("AEROPORT INTERNATIONAL DE LA LUANO"));
	$pdf->Text(20, 25, utf8_decode("N° TVA : A0700324 L"));
	$pdf->Text(20, 30, utf8_decode("----------------------------------------------------------------------"));

			$pdf->Cell(34,5, utf8_decode(''),'','','C'); 
			$pdf->Ln();
			//$mouv=str_replace("'","",$num_mouv);
			$pdf->SetFont('Arial','B',11);
			$pdf->Cell(260,2, utf8_decode("EDITE LE : ".date('d/m/Y')),'','','R'); 
			$pdf->Ln();
			//$pdf->Cell(109,7, "",'','','R'); 
			//$pdf->Cell(60,7, "PAGE : ".$npage,'','','R');  
			$pdf->Ln(20);
			$pdf->Cell(270,6, utf8_decode("RELEVE DES FACTURES PAYEES"),'','','C'); 
			$pdf->Ln();
			$pdf->SetFont('Arial','BU',11);
			$client=client($cl,$bdd);
			$pdf->Cell(270,6, utf8_decode("POUR ".$client['nom_cl']." AU ".Datemysqltofr($dt2)),'','','C'); 
			$pdf->Ln();
			$pdf->SetFont('Arial','',7);
			
			$pdf->Ln(); $pdf->Ln();
	//================================= FACTURE==================
			
			$pdf->Cell(18,5, utf8_decode("DATE"),'TRBL','','C'); 
			$pdf->Cell(18,5, utf8_decode("DATE"),'TRBL','','C');
			$pdf->Cell(20,5, utf8_decode("ROUTE"),'TRBL','','C');
			$pdf->Cell(20,5, utf8_decode("ATTER"),'TRBL','','C');
			$pdf->Cell(10,5, utf8_decode("BALIS"),'TRBL','','C');
			$pdf->Cell(10,5, utf8_decode("FRET"),'TRBL','','C');
			$pdf->Cell(15,5, utf8_decode("PAX"),'TRBL','','C');
			$pdf->Cell(20,5, utf8_decode("STAT"),'TRBL','','C');
			$pdf->Cell(14,5, utf8_decode("SURETE"),'TRBL','','C');
			$pdf->Cell(10,5, utf8_decode("FORM"),'TRBL','','C');
			$pdf->Cell(10,5, utf8_decode("COMP"),'TRBL','','C');
			$pdf->Cell(17,5, utf8_decode("SECUR"),'TRBL','','C');
			$pdf->Cell(12,5, utf8_decode("ASS ANTI"),'TRBL','','C');
			$pdf->Cell(17,5, utf8_decode("MTHT"),'TRBL','','C');
			$pdf->Cell(15,5, utf8_decode("TVA"),'TRBL','','C');
			$pdf->Cell(10,5, utf8_decode("ARR"),'TRBL','','C');
			$pdf->Cell(20,5, utf8_decode("MTTTC"),'TRBL','','C');
			$pdf->Cell(15,5, utf8_decode("N° FACT"),'TRBL','','C');
			$pdf->Cell(15,5, utf8_decode("QUITT"),'TRBL','','C');
			
	//================================ SQL==================================
			/*$s="select * from 
					mouvement2,immatriculation,client 
				where 
					mouvement2.Immatr=immatriculation.Id_imm
				and
					immatriculation.Code_pr=client.Id_cl
				and
					client.Id_cl='$client'
				and
					Date_mouv between '$dt' and '$dt2' order by Code_imm";*/
			$s="select * from 
					mouvement2,immatriculation,client
				where 
					mouvement2.Immatr=immatriculation.Id_imm 
				and 
					immatriculation.Code_pr=client.Id_cl 
				and 
					client.Id_cl=$cl 
				and
					Date_mouv between '$dt' and '$dt2'
				group by 
					Code_imm
				order by 
					Code_imm";
			$e=mysqli_query($bdd,$s); $t=mysqli_fetch_array($e); $n=mysqli_num_rows($e);
	//=============================== CONTENU DU TABLEAU=================================
			$pdf->Ln();
			
			if($n!==0)
			{
				
				//$pdf->Cell(5,5, utf8_decode($n),'','','C'); 

				//============== VARIABLES DE CALCUL=======================
					
					$ad=0; $ch=0; $inf=0; $pec=0;
					$route=0;
					$atterrissage=0;
					$bal=0;
					$fret=0;
					$fret_kg=0;
					$pax=0;
					$pec=0;
					$stat=0;
					$surete=0;
					$securite=0;
					$formu=0;
					$compt=0;
					$ass=0;
					$tot_l=0;
					$tot_mht=0;
					$tot_tva=0;
					$tot_mttc=0;
					$general=0;
					$arrondie_ligne=0;
					$tot_arrondie=0;
				//=========================================================
				do
				{
					$mouvement=mouv($t['Num_mouv'],$bdd);
					$code_imm=$mouvement['code_imm'];
					//================ TABLE ESCALEQ==================	
						$num_mouv=$t['Num_mouv'];		
						$sa="select *,date_format(Date_mouv,'%d/%m/%Y') as dt_mouv from mouvement2,pt_emplacement,immatriculation,client,type_avion 
							where 
								mouvement2.Pt=pt_emplacement.Id_pt 
							and 
								mouvement2.Immatr=immatriculation.Id_imm
							and
								immatriculation.Type_av=type_avion.Id_typ
							and
								immatriculation.Code_pr=client.Id_cl
							and
								Sens='A' 
							and 
								Num_mouv=$num_mouv";
						$ea=mysqli_query($bdd,$sa);
						$ta=mysqli_fetch_array($ea);
						$escale_a="select * from escale where Id_mouv=$num_mouv and Sens='A'"; 
						$e_escale_a=mysqli_query($bdd,$escale_a); $tescale_a=mysqli_fetch_array($e_escale_a);
						
						$tot_pax_a=$tescale_a['Ad']+$tescale_a['Ch']+$tescale_a['Inf'];
						
						if($ta['Temps']=="B")
						{
							$balisage_a="O";
						}else
						{
							$balisage_a="N";
						}
							
						
						$sd="select *,date_format(Date_mouv,'%d/%m/%Y') as dt_mouv from mouvement2,pt_emplacement where mouvement2.Pt=pt_emplacement.Id_pt and Sens='D' and Num_mouv=$num_mouv";
						$ed=mysqli_query($bdd,$sd);
						$td=mysqli_fetch_array($ed);
						$escale_d="select * from escale where Id_mouv=$num_mouv and Sens='D'"; 
						$e_escale_d=mysqli_query($bdd,$escale_d); $tescale_d=mysqli_fetch_array($e_escale_d);
					//=================  TRAIEMENT DE GROUPE IMMATRICULATION=========================
						$s2="select * from 
								mouvement2,immatriculation,client
							where 
								mouvement2.Immatr=immatriculation.Id_imm 
							and 
								immatriculation.Code_pr=client.Id_cl 
							and 
								Code_imm='$code_imm' 
							and
								Date_mouv between '$dt' and '$dt2'
							group by
								Num_mouv
							order by 
								Date_mouv";	
					//===================
					$e2=mysqli_query($bdd,$s2);
					$t2=mysqli_fetch_array($e2);
					$num_mouv2=$t2['Num_mouv'];

					$pdf->SetFont('Arial','B',8);
					$m=mouv($t2['Num_mouv'],$bdd);
					$libelle_typ=$m['ta']['Libelle_typ'];
					$pdf->Cell(70,8, utf8_decode("IMMATRICULATION : ".$m['ta']['Code_imm']),'TBL','','C'); 
					$pdf->Cell(70,8, utf8_decode("TYPE D'AVION : ".$m['ta']['Libelle_typ']),'TB','','L'); 
					$pdf->Cell(146,8, utf8_decode("POIDS MAX. AU DECOLLAGE : ".$m['ta']['Poids']),'TBR','','L'); 
					$pdf->SetFont('Arial','',7);

					/*======================== LIGNE ====================================*/
						$ad_ligne=0; $ch_ligne=0; $inf_ligne=0; $pec_ligne=0;
						$route_ligne=0;
						$atterrissage_ligne=0;
						$bal_ligne=0;
						$fret_ligne=0;
						$fret_kg_ligne=0;
						$pax_ligne=0;
						$stat_ligne=0;
						$surete_ligne=0;
						$securite_ligne=0;
						$formu_ligne=0;
						$compt_ligne=0;
						$ass_ligne=0;
						$tot_l_ligne=0;
						$tot_mht_ligne=0;
						$tot_tva_ligne=0;
						$tot_mttc_ligne=0;
						$general_ligne=0;
						$arrondie_ligne=0;
					/* ==================================================================*/
					do
					{
						/************* check dans la table de paiement **********************/
							$mvt=$t2['Num_mouv'];
							$check="select * from paiement_facture where Mouv='$mvt'";
							$echeck=mysqli_query($bdd,$check); $ncheck=mysqli_num_rows($echeck);
							if($ncheck==0){
								
							}else
							{

								//====================================================================
								$mouvement2=mouv($t2['Num_mouv'],$bdd);
								$num_mouv2=$t2['Num_mouv'];
								$general=$general+$mouvement2['tot_avec_tva'];
								/*=========== 	escale arrive ===========*/
									$s_e_a="select *,
										sum(Ad) as ad,
										sum(Ch) as ch,
										sum(Inf) as inf,
										sum(Pec) as pec,
										sum(Tra) as tra,
										sum(Loc) as loc,
										sum(Trat) as trat,
										sum(Ptt) as ptt     
											from escale where Sens='A' and Id_mouv='$num_mouv2'";
									$e_e_a=mysqli_query($bdd,$s_e_a);
									$t_e_a=mysqli_fetch_array($e_e_a);	
								/*=========== escale depart =============*/
									$s_e_d="select *,
										sum(Ad) as ad,
										sum(Ch) as ch,
										sum(Inf) as inf,
										sum(Pec) as pec,
										sum(Tra) as tra,
										sum(Loc) as loc,
										sum(Trat) as trat,
										sum(Ptt) as ptt     
											from escale where Sens='D' and Id_mouv='$num_mouv2'";
									$e_e_d=mysqli_query($bdd,$s_e_d);
									$t_e_d=mysqli_fetch_array($e_e_d);
								/*=====================================*/

									$ad=$ad+$t_e_a['ad'];
									$ch=$ch+$t_e_a['ch'];
									$inf=$inf+$t_e_a['inf'];
									$pec=$pec+$t_e_a['pec'];

								//
									$route=$route+$mouvement2['red_route_a'];
									$atterrissage=$atterrissage+$mouvement2['tot_red_att'];
									$bal=$bal+$mouvement2['red_bal_a'];
									$fret=$fret+$mouvement2['red_fret_a'];
									$fret_kg=$fret_kg+$t_e_a['loc'];
									$pax=$pax+$mouvement2['red_pass_a'];
									$stat=$stat+$mouvement2['red_stat'];
									$securite=$securite+$mouvement2['red_securite'];
									$ass=$ass;
								//
								/*================ SOUS TOTAL ARRIVEE=============================*/
										$ad_ligne=$ad_ligne+$t_e_a['ad']; 
										$ch_ligne=$ch_ligne+$t_e_a['ch']; 
										$inf_ligne=$inf_ligne+$t_e_a['inf']; 
										$pec_ligne=$pec_ligne+$t_e_a['pec'];
										$fret_kg_ligne=$fret_kg_ligne+$t_e_a['loc'];
										$route_ligne=$route_ligne+$mouvement2['red_route_a'];
										$atterrissage_ligne=$atterrissage_ligne+$mouvement2['red_att'];
										$bal_ligne=$bal_ligne+$mouvement2['red_bal_a'];
										$fret_ligne=$fret_ligne+$mouvement2['red_fret_a'];
										$pax_ligne=$pax_ligne+$mouvement2['red_pass_a'];

										$stat_ligne=$stat_ligne+$mouvement2['red_stat'];
										$surete_ligne=$surete_ligne;
										$securite_ligne=$securite_ligne;
										$formu_ligne=$formu_ligne;
										$compt_ligne=$compt_ligne;
										$ass_ligne=$ass_ligne;
										$tot_l_ligne=$mouvement2['red_route_a']+$mouvement2['tot_red_att']+$mouvement2['red_bal_a']+$mouvement2['red_fret_a']+$mouvement2['red_stat'];
										$tot_mht_ligne=$tot_mht_ligne+$tot_l_ligne;
										$tot_tva_ligne=$tot_tva_ligne;
										//$tot_mttc_ligne=$tot_mttc_ligne;
										$general_ligne=$general_ligne;
								/*========================================================*/

									$pdf->Ln();	

									$pdf->Cell(18,5, utf8_decode(Datemysqltofr($mouvement2['td']['Date_mouv'])),'RL','','C'); 
									$pdf->Cell(18,5, "",'RL','','C');
									$pdf->Cell(20,5, arrondie($mouvement2['tot_red_rout']),'RL','','R');
									$pdf->Cell(20,5, arrondie($mouvement2['tot_red_att']),'RL','','R');
									$pdf->Cell(10,5, arrondie($mouvement2['tot_red_bal']),'RL','','R');
									$pdf->Cell(10,5, arrondie($mouvement2['tot_red_fret']),'RL','','R');
									$pdf->Cell(15,5, arrondie($mouvement2['tot_red_pass']+$mouvement2['tot_red_pec']),'RL','','R');
									$pdf->Cell(20,5, arrondie($mouvement2['tot_red_stat']),'RL','','R');
									$pdf->Cell(14,5, arrondie($mouvement2['tot_red_surete']),'RL','','R');
									$pdf->Cell(10,5, arrondie($mouvement2['tot_red_formu']),'RL','','R');
									$pdf->Cell(10,5, arrondie($mouvement2['tot_red_compt']),'RL','','R');
									$pdf->Cell(17,5, arrondie($mouvement2['tot_red_securite']),'RL','','R');
									$pdf->Cell(12,5, arrondie($mouvement2['tot_red_assantinc']),'RL','','R');
									$pdf->Cell(17,5, arrondie($mouvement2['tot_sans_tva']),'RL','','R');
									$pdf->Cell(15,5, arrondie($mouvement2['tva']),'RL','','R');
									$arrondie=($mouvement2['tot_avec_tva'])-($mouvement2['tva'])-($mouvement2['tot_sans_tva']);
									$pdf->Cell(10,5, arrondie($arrondie),'RL','','R');
									$pdf->Cell(20,5, arrondie($mouvement2['tot_avec_tva']),'RL','','R');
									$num_fact=num_fact($t2['Num_mouv'],$bdd);
									$facture=explode("/",$num_fact);
									$quittance=num_quittance($t2['Num_mouv'],$bdd);
									$pdf->Cell(15,5, ($facture[0]),'RL','','R');
									$pdf->Cell(15,5, ($quittance),'RL','','R');
									
									$mht2=$mouvement2['red_route_d']+
												$mouvement2['red_bal_d']+
												$mouvement2['red_fret_d']+
												$mouvement2['red_pass_d']+
												$mouvement2['red_pec']+
												$mouvement2['red_surete']+
												$mouvement2['red_securite']+
												$mouvement2['red_assantinc']+
												$mouvement2['red_compt']+
												$mouvement2['red_formu'];
								$tva2=$mouvement2['tva'];
								
								$tot_tva=$tot_tva+$tva2;
								
								$total_ligne_d=ceil(0);
								$tot_mttc=$tot_mttc+$total_ligne_d;

								/*================ SOUS TOTAL DEPART=============================*/
										$ad_ligne=$ad_ligne+$t_e_d['ad']; 
										$ch_ligne=$ch_ligne+$t_e_d['ch']; 
										$inf_ligne=$inf_ligne+$t_e_d['inf']; 
										$pec_ligne=$pec_ligne+$t_e_d['pec'];
										$fret_kg_ligne=$fret_kg_ligne+$t_e_d['loc'];
										$route_ligne=$route_ligne+$mouvement2['red_route_d'];
										$atterrissage_ligne=$atterrissage_ligne;
										$bal_ligne=$bal_ligne+$mouvement2['red_bal_d'];
										$fret_ligne=$fret_ligne+$mouvement2['red_fret_d'];
										$pax_ligne=$pax_ligne+$mouvement2['red_pass_d'];

										$stat_ligne=$stat_ligne;
										$surete_ligne=$surete_ligne+$mouvement2['red_surete'];
										$securite_ligne=$securite_ligne+$mouvement2['red_securite'];
										$formu_ligne=$formu_ligne+$mouvement2['red_formu'];
										$compt_ligne=$compt_ligne+$mouvement2['red_compt'];
										$ass_ligne=$ass_ligne+$mouvement2['red_assantinc'];

										
										$tot_mht_ligne=$tot_mht_ligne+$mht2;
										$tot_tva_ligne=$tot_tva_ligne+$tva2;
										$tot_mttc_ligne=$tot_mttc_ligne+($mouvement2['tot_avec_tva']);
										$arrondie_ligne=$arrondie_ligne+$arrondie;
										//$tot_mttc_ligne=52;
										$general_ligne=$general_ligne;
								/*========================================================*/
								
								$pdf->Cell(20,5, utf8_decode(arrondie($mht2)),'RL','','R');
								$pdf->Cell(20,5, utf8_decode(arrondie($tva2)),'RL','','R');
								$pdf->Cell(20,5, utf8_decode(arrondie($total_ligne_d)),'RL','','R');
								$ad=$ad+$t_e_d['ad'];
								$ch=$ch+$t_e_d['ch'];
								$inf=$inf+$t_e_d['inf'];
								$pec=$pec+$t_e_d['pec'];
								$route=$route+$mouvement2['red_route_d'];
								$atterrissage=$atterrissage;
								$bal=$bal+$mouvement2['red_bal_d'];
								$fret=$fret+$mouvement2['red_fret_d'];
								$fret_kg=$fret_kg+$t_e_d['loc'];
								$pax=$pax+$mouvement2['red_pass_d'];
								$stat=$stat;
								$surete=$surete+$mouvement2['red_surete'];
								$securite=$securite;
								$formu=$formu+$mouvement2['red_formu'];
								$compt=$compt+$mouvement2['red_compt'];
								$ass=$ass+$mouvement2['red_assantinc'];
								$tot_l=$tot_l+(0+$total_ligne_d);
							}
					}while($t2=mysqli_fetch_array($e2));
					$pdf->Ln();
					$pdf->SetFont('Arial','',6);
					$pdf->Cell(36,5, "SOUS TOTAL",'LTRB','','R'); 
					$pdf->Cell(20,5, arrondie($route_ligne),'LTRB','','R'); 
					$pdf->Cell(20,5, arrondie($atterrissage_ligne),'LTRB','','R'); 
					$pdf->Cell(10,5, arrondie($bal_ligne),'LTRB','','R'); 
					$pdf->Cell(10,5, arrondie($fret_ligne),'LTRB','','R'); 
					$pdf->Cell(15,5, arrondie($pax_ligne),'LTRB','','R'); 
					$pdf->Cell(20,5, arrondie($stat_ligne),'LTRB','','R'); 
					$pdf->Cell(14,5, arrondie($surete_ligne),'LTRB','','R'); 
					$pdf->Cell(10,5, arrondie($formu_ligne),'RLT','','R');
					$pdf->Cell(10,5, arrondie($compt_ligne),'RLT','','R');
					$pdf->Cell(17,5, arrondie($securite_ligne),'RLT','','R');
					$pdf->Cell(12,5, arrondie($ass_ligne),'RLRT','','R');
					$pdf->Cell(17,5, arrondie($tot_mht_ligne),'RLT','','R');
					$pdf->Cell(15,5, arrondie($tot_tva_ligne),'RLT','','R');
					$pdf->Cell(10,5, arrondie($arrondie_ligne),'RLT','','R');
					$pdf->Cell(20,5, arrondie($tot_mttc_ligne),'RLT','','R');
					$pdf->Cell(15,5, (''),'RLT','','R');
					$pdf->Cell(15,5, (''),'RLT','','R');

					$tot_mht=$tot_mht+$tot_mht_ligne;
					$tot_arrondie=$tot_arrondie+$arrondie_ligne;
					$tot_mttc=$tot_mttc+$tot_mttc_ligne;
					
					$pdf->Ln();						
				}while($t=mysqli_fetch_array($e));
					
				//============= JUSTE POUR LE SOULIGNEMENT DE LA DERNIERE LIGNE ===================
					$pdf->Cell(36.1,0.1, "",'T','','C'); 
				//=================================================================================
				$pdf->Ln();
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(36,6, "TOT.RES INTER. US $",'TRLB','','L');
				$pdf->Cell(20,6, arrondie($route),'TRLB','','R');
				$pdf->Cell(20,6, arrondie($atterrissage),'TRLB','','R');
				$pdf->Cell(10,6, arrondie($bal),'TRLB','','R');
				$pdf->Cell(10,6, arrondie($fret),'TRLB','','R');
				$pdf->Cell(15,6, arrondie($pax),'TRLB','','R');
				$pdf->Cell(20,6, arrondie($stat),'TRLB','','R');
				$pdf->Cell(14,6, arrondie($surete),'TRLB','','R');
				$pdf->Cell(10,6, arrondie($formu),'TRLB','','R');
				$pdf->Cell(10,6, arrondie($compt),'TRLB','','R');
				$pdf->Cell(17,6, arrondie($securite),'TRLB','','R');
				$pdf->Cell(12,6, arrondie($ass),'TRLB','','R');
				$pdf->Cell(17,6, arrondie($tot_mht),'TRLB','','R');
				$pdf->Cell(15,6, arrondie($tot_tva),'TRLB','','R');
				$pdf->Cell(10,6, arrondie($tot_arrondie),'TRLB','','R');
				$pdf->Cell(20,6, arrondie($tot_mttc),'TRLB','','R');
				$pdf->Cell(15,6, "",'TRLB','','R');
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(15,6, (''),'TRLB','','R');
				
				
				$pdf->Ln();		
				
				
				$pdf->Ln(8);
				$signataire=signataire($bdd);
				$pdf->Cell(70,6, "LE CHEF DE SERVICE FACTURATION",'','','C');
				$pdf->Cell(70,6, "",'','','C');
				$pdf->Cell(70,6, "LE CHEF DE DIVISION COMMERCIALE",'','','C');
				$pdf->Ln();
				$pdf->Cell(70,6, $signataire['facturation'],'','','C');
				$pdf->Cell(70,6, "",'','','C');
				$pdf->Cell(70,6, $signataire['division'],'','','C');
			}else
			{
			
				$pdf->Cell(80,6, ($client),'TRBL','','C'); 
			}
			
//================ REDEVANCES AER===========================================================	
			
//==================================== TOTALITE DU BORDEREAU===============================================	
			
			
			
			
$pdf->Output();



?>
