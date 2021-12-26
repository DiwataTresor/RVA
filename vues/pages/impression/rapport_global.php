<?php
	@session_start();
	$cl=$_REQUEST["client"];
	$dt=$_REQUEST["dt"];
	$dt2=$_REQUEST["dt2"];
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../manager/bd/cnx.php');
	class m extends main{}
	$m=new m();
	//$bord=bordereau($dt,$bdd);
	$id_us=$_SESSION["Idd"];
	$user=$m->user($id_us);

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
			$pdf->Cell(270,6, utf8_decode("RELEVE DES FACTURES PAR REDEVANCES DETAILLE"),'','','C'); 
			$pdf->Ln();
			$pdf->SetFont('Arial','BU',11);
			if($cl!=="T")
			{
				$client=$m->client($cl);
				$pdf->Cell(270,6, utf8_decode("POUR ".$client['nom_cl']." AU ".$m->Datemysqltofr($dt2)),'','','C'); 
			}else
			{
				$pdf->Cell(270,6, utf8_decode("POUR TOUS LES EXPLOITANTS AU ".$m->Datemysqltofr($dt2)),'','','C'); 
			}
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
		if($cl!=="T")
		{
			$s="select  
					immatriculation.Code_imm,
					mouvement2.Immatr,
					immatriculation.Id_imm,
					immatriculation.Code_pr,
					client.Id_cl,
					client.Nom_cli,
					mouvement2.Date_mouv,
					immatriculation.Code_imm,
					Num_mouv,
					paiement_facture.Mouv,
					paiement_facture.Date_paie
				from 
					rva_facturation2.mouvement2,rva_facturation2.immatriculation,rva_facturation2.client,rva_facturation2.paiement_facture
				where 
					mouvement2.Immatr=immatriculation.Id_imm 
				and 
					immatriculation.Code_pr=client.Id_cl 
				and 
					mouvement2.Num_mouv=paiement_facture.Mouv
				and
					client.Id_cl='$cl' 
				
				and
					paiement_facture.Date_paie between '$dt' and '$dt2'
				order by 
					Nom_cli,immatriculation.Code_imm";
		}else
		{
			$s="select  
					immatriculation.Code_imm,
					mouvement2.Immatr,
					immatriculation.Id_imm,
					immatriculation.Code_pr,
					client.Id_cl,
					client.Nom_cli,
					mouvement2.Date_mouv,
					immatriculation.Code_imm,
					Num_mouv,
					paiement_facture.Mouv,
					paiement_facture.Date_paie
				from 
					rva_facturation2.mouvement2,rva_facturation2.immatriculation,rva_facturation2.client,rva_facturation2.paiement_facture
				where 
					mouvement2.Immatr=immatriculation.Id_imm 
				and 
					immatriculation.Code_pr=client.Id_cl 
				and 
					mouvement2.Num_mouv=paiement_facture.Mouv
				and
					paiement_facture.Date_paie between '$dt' and '$dt2'
				order by 
					Nom_cli,immatriculation.Code_imm";
		}
			$e=$m->cnx->query($s); 
			$t=$e->fetchAll(); 
			$n=count($t);
			//echo($n);
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
					$totalite=0;
					$tot_l=0;
					$tot_mht=0;
					$tot_tva=0;
					$tot_mttc=0;
					$general=0;
					$arrondie_ligne=0;
					$tot_arrondie=0;


					$ad_exp=0; $ch_exp=0; $inf_exp=0; $pec_exp=0;
					$route_exp=0;
					$atterrissage_exp=0;
					$bal_exp=0;
					$fret_exp=0;
					$fret_kg_exp=0;
					$pax_exp=0;
					$pec_exp=0;
					$stat_exp=0;
					$surete_exp=0;
					$securite_exp=0;
					$formu_exp=0;
					$compt_exp=0;
					$ass_exp=0;
					$totalite_exp=0;
					$tot_l_exp=0;
					$tot_mht_exp=0;
					$tot_tva_exp=0;
					$tot_mttc_exp=0;
					$general_exp=0;
					$arrondie_ligne_exp=0;
					$tot_arrondie_exp=0;
				//=========================================================
				$imma=$t[0]["Code_imm"];
				$aaa=1;
				$clientNom=$t[0]["Nom_cli"];
				$pdf->Ln();
				$pdf->SetFont('Arial','B',11);
				$pdf->Cell(140,8, $clientNom,'','','L'); 
				$pdf->Ln();
				foreach($t as $row)
				{
					$pdf->SetFont('Arial','',7);
					if($clientNom!==$row["Nom_cli"])
					{
						//================total pour Exploitant
							$pdf->Ln();
							$pdf->Cell(36,5, "TOTAL ".$clientNom,'LTRB','','R'); 
							$pdf->Cell(20,5, $m->arrondie($route_exp),'LTRB','','R'); 
							$pdf->Cell(20,5, $m->arrondie($atterrissage_exp),'LTRB','','R'); 
							$pdf->Cell(10,5, $m->arrondie($bal_exp),'LTRB','','R'); 
							$pdf->Cell(10,5, $m->arrondie($fret_exp),'LTRB','','R'); 
							$pdf->Cell(15,5, $m->arrondie($pax_exp),'LTRB','','R'); 
							$pdf->Cell(20,5, $m->arrondie($stat_exp),'LTRB','','R'); 
							$pdf->Cell(14,5, $m->arrondie($surete_exp),'LTRB','','R'); 
							$pdf->Cell(10,5, $m->arrondie($formu_exp),'RLBT','','R');
							$pdf->Cell(10,5, $m->arrondie($compt_exp),'RLBT','','R');
							$pdf->Cell(17,5, $m->arrondie($securite_exp),'BRLT','','R');
							$pdf->Cell(12,5, $m->arrondie($ass_exp),'RLBT','','R');
							$pdf->Cell(17,5, $m->arrondie($tot_mht_exp),'BRLT','','R');
							$pdf->Cell(15,5, $m->arrondie($tot_tva_exp),'BRLT','','R');
							$pdf->Cell(10,5, $m->arrondie($tot_arrondie_exp),'BRLT','','R');
							$pdf->Cell(20,5, $m->arrondie($tot_mttc_exp),'RLTB','','R');
							$pdf->Cell(15,5, (''),'RLTB','','R');
							$pdf->Cell(15,5, (''),'RLTB','','R');
							$pdf->Ln();

							$ad_exp=0; $ch_exp=0; $inf_exp=0; $pec_exp=0;
							$route_exp=0;
							$atterrissage_exp=0;
							$bal_exp=0;
							$fret_exp=0;
							$fret_kg_exp=0;
							$pax_exp=0;
							$pec_exp=0;
							$stat_exp=0;
							$surete_exp=0;
							$securite_exp=0;
							$formu_exp=0;
							$compt_exp=0;
							$ass_exp=0;
							$totalite_exp=0;
							$tot_l_exp=0;
							$tot_mht_exp=0;
							$tot_tva_exp=0;
							$tot_mttc_exp=0;
							$general_exp=0;
							$arrondie_ligne_exp=0;
							$tot_arrondie_exp=0;
						//=====================================
						$pdf->SetFont('Arial','B',11);
						$clientNom=$row["Nom_cli"];
						$pdf->Cell(140,8, $clientNom,'','','L'); 
						$pdf->Ln();
					}
					if($aaa==1)
					{
						$aaa=2;
					}else
					{

						if($imma==$row["Code_imm"])
						{
							continue;
						}else
						{
							$imma=$row["Code_imm"];
						}
					}
					$mouvement=$m->mouv($row['Num_mouv']);
					$code_imm=$mouvement['code_imm'];
					//================ TABLE ESCALEQ==================	
						$num_mouv=$row['Num_mouv'];		
						$sa="select *,format(Date_mouv,'%d/%m/%Y') as dt_mouv 
							from 
								rva_facturation2.mouvement2,
								rva_facturation2.pt_emplacement,
								rva_facturation2.immatriculation,
								rva_facturation2.client,rva_facturation2.type_avion 
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
						$ea=$m->cnx->query($sa);
						$ta=($ea->fetchAll());
						$escale_a="select * from rva_facturation2.escale where Id_mouv='$num_mouv' and Sens='A'"; 
						$e_escale_a=$m->cnx->query($escale_a); $tescale_a=($e_escale_a->fetchAll());
						$tot_pax_a=0;
						foreach($tescale_a as $r)
						{
							$tot_pax_a+=$r["Ad"]+$r["Ch"]+$r["Inf"];
						}
						//$tot_pax_a=$tescale_a[0]['Ad']+$tescale_a['Ch']+$tescale_a['Inf'];
						
						if($ta[0]['Temps']=="B")
						{
							$balisage_a="O";
						}else
						{
							$balisage_a="N";
						}
							
						
						$sd="select *,format(Date_mouv,'%d/%m/%Y') as dt_mouv from rva_facturation2.mouvement2,rva_facturation2.pt_emplacement where mouvement2.Pt=pt_emplacement.Id_pt and Sens='D' and Num_mouv=$num_mouv";
						$ed=$m->cnx->query($sd);
						$td=($ed->fetchAll());
						$escale_d="select * from rva_facturation2.escale where Id_mouv=$num_mouv and Sens='D'"; 
						$e_escale_d=$m->cnx->query($escale_d); 
						$tescale_d=($e_escale_d->fetchAll());
					//=================  TRAIEMENT DE GROUPE IMMATRICULATION=========================
						$s2="select 
								Distinct(Num_mouv),
								Dt,
								mouvement2.Immatr,
								immatriculation.Id_imm,
								immatriculation.Code_pr,
								client.Id_cl,
								Code_imm,
								Date_mouv,
								Num_mouv,
								Date_paie
							from 
								rva_facturation2.mouvement2,rva_facturation2.immatriculation,rva_facturation2.client,rva_facturation2.paiement_facture
							where 
								mouvement2.Immatr=immatriculation.Id_imm 
							and 
								mouvement2.Num_mouv=paiement_facture.Mouv
							and
								immatriculation.Code_pr=client.Id_cl 
							and 
								Code_imm='$code_imm' 
							and
								Date_paie between '$dt' and '$dt2'
							order by 
								Date_mouv";	
					//===================
					$e2=$m->cnx->query($s2);
					$row2=($e2->fetchAll());
					$num_mouv2=$row2[0]['Num_mouv'];
					

					$pdf->SetFont('Arial','B',8);
					$_m=$m->mouv($row2[0]['Num_mouv']);
					$libelle_typ=$_m['ta'][0]['Libelle_typ'];
					$pdf->Cell(70,8, utf8_decode("IMMATRICULATION : ".$_m['ta'][0]['Code_imm']),'TBL','','C'); 
					$pdf->Cell(70,8, utf8_decode("TYPE D'AVION : ".$_m['ta'][0]['Libelle_typ']),'TB','','L'); 
					$pdf->Cell(146,8, utf8_decode("POIDS MAX. AU DECOLLAGE : ".$_m['ta'][0]['Poids']),'TBR','','L'); 
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
					$mvn=$row2[0]["Num_mouv"];
					$aaa2=1;
					
					foreach($row2 as $t2)
					{
						//echo($row["Date_paie"]);
						if($aaa2==1)
						{
							$aaa2=2;
						}else
						{

							if($mvn==$t2["Num_mouv"])
							{
								continue;
							}else
							{
								$mvn=$t2["Num_mouv"];
							}
						}
						/************* check dans la table de paiement **********************/
							$mvt=$t2['Num_mouv'];
							$check="select * from rva_facturation2.paiement_facture where Mouv='$mvt'";
							$echeck=$m->cnx->query($check);
							$tcheck=$echeck->fetchAll(); 
							$ncheck=count($tcheck);
							
								//====================================================================
								$mouvement2=$m->mouv($t2['Num_mouv']);
								
								$num_mouv2=$t2['Num_mouv'];
								$general=$general+$mouvement2['tot_avec_tva'];
								$totalite+=$mouvement2["tot_avec_tva"];
								/*=========== 	escale arrive ===========*/
									$s_e_a="select *  
											from rva_facturation2.escale where Sens='A' and Id_mouv='$num_mouv2'";
									$e_e_a=$m->cnx->query($s_e_a);
									$t_e_a=($e_e_a->fetchAll());
									
									$a_somme_ad=0;
									$a_somme_ch=0;
									$a_somme_inf=0;
									$a_somme_pec=0;
									$a_somme_tra=0;
									$a_somme_loc=0;
									$a_somme_trat=0;
									$a_somme_ptt=0;
									foreach($t_e_a as $r)
									{
										$a_somme_ad+=$r["Ad"];
										$a_somme_ch+=$r["Ch"];
										$a_somme_inf+=$r["Inf"];
										$a_somme_pec+=$r["Pec"];
										$a_somme_tra+=$r["Tra"];
										$a_somme_loc+=$r["Loc"];
										$a_somme_trat+=$r["Trat"];
										$a_somme_ptt+=$r["Ptt"];	
									}	
								/*=========== escale depart =============*/
									$s_e_d="select *     
											from rva_facturation2.escale where Sens='D' and Id_mouv='$num_mouv2'";
									$e_e_d=$m->cnx->query($s_e_d);
									$t_e_d=($e_e_d->fetchAll());
									$d_somme_ad=0;
									$d_somme_ch=0;
									$d_somme_inf=0;
									$d_somme_pec=0;
									$d_somme_tra=0;
									$d_somme_loc=0;
									$d_somme_trat=0;
									$d_somme_ptt=0;
									foreach($t_e_d as $r)
									{
										$d_somme_ad+=$r["Ad"];
										$d_somme_ch+=$r["Ch"];
										$d_somme_inf+=$r["Inf"];
										$d_somme_pec+=$r["Pec"];
										$d_somme_tra+=$r["Tra"];
										$d_somme_loc+=$r["Loc"];
										$d_somme_trat+=$r["Trat"];
										$d_somme_ptt+=$r["Ptt"];	
									}
								/*=====================================*/

									$ad=$ad+$a_somme_ad;
									$ch=$ch+$a_somme_ch;
									$inf=$inf+$a_somme_inf;
									$pec=$pec+$a_somme_pec;

								//
									$route=$route+$mouvement2['red_route_a'];
									$atterrissage=$atterrissage+$mouvement2['tot_red_att'];
									$bal=$bal+$mouvement2['red_bal_a'];
									$fret=$fret+$mouvement2['red_fret_a'];
									$fret_kg=$fret_kg+$a_somme_loc;
									$pax=$pax+$mouvement2['red_pass_a'];
									$stat=$stat+$mouvement2['red_stat'];
									$securite=$securite+$mouvement2['red_securite'];
									$ass=$ass;
								//
								/*================ SOUS TOTAL ARRIVEE=============================*/
										$ad_ligne=$ad_ligne+$a_somme_ad; 
										$ch_ligne=$ch_ligne+$a_somme_ch; 
										$inf_ligne=$inf_ligne+$a_somme_inf; 
										$pec_ligne=$pec_ligne+$a_somme_pec;
										$fret_kg_ligne=$fret_kg_ligne+$a_somme_loc;
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

									$pdf->Cell(18,5, utf8_decode($m->Datemysqltofr($mouvement2['td'][0]['Date_mouv'])),'RL','','C'); 
									$pdf->Cell(18,5, $m->Datemysqltofr($t2["Date_paie"]),'RL','','C');
									$pdf->Cell(20,5, $m->arrondie($mouvement2['tot_red_rout']),'RL','','R');
									$pdf->Cell(20,5, $m->arrondie($mouvement2['tot_red_att']),'RL','','R');
									$pdf->Cell(10,5, $m->arrondie($mouvement2['tot_red_bal']),'RL','','R');
									$pdf->Cell(10,5, $m->arrondie($mouvement2['tot_red_fret']),'RL','','R');
									$pdf->Cell(15,5, $m->arrondie($mouvement2['tot_red_pass']+$mouvement2['tot_red_pec']),'RL','','R');
									$pdf->Cell(20,5, $m->arrondie($mouvement2['tot_red_stat']),'RL','','R');
									$pdf->Cell(14,5, $m->arrondie($mouvement2['tot_red_surete']),'RL','','R');
									$pdf->Cell(10,5, $m->arrondie($mouvement2['tot_red_formu']),'RL','','R');
									$pdf->Cell(10,5, $m->arrondie($mouvement2['tot_red_compt']),'RL','','R');
									$pdf->Cell(17,5, $m->arrondie($mouvement2['tot_red_securite']),'RL','','R');
									$pdf->Cell(12,5, $m->arrondie($mouvement2['tot_red_assantinc']),'RL','','R');
									$pdf->Cell(17,5, $m->arrondie($mouvement2['tot_sans_tva']),'RL','','R');
									$pdf->Cell(15,5, $m->arrondie($mouvement2['tva']),'RL','','R');
									$arrondie=($mouvement2['tot_avec_tva'])-($mouvement2['tva'])-($mouvement2['tot_sans_tva']);
									$pdf->Cell(10,5, $m->arrondie($arrondie),'RL','','R');
									$pdf->Cell(20,5, $m->arrondie($mouvement2['tot_avec_tva']),'RL','','R');
									$num_fact=$m->num_fact($t2['Num_mouv']);
									$facture=explode("/",$num_fact);
									$quittance=$m->num_quittance($t2['Num_mouv']);
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
										$ad_ligne=$ad_ligne+$d_somme_ad; 
										$ch_ligne=$ch_ligne+$d_somme_ch; 
										$inf_ligne=$inf_ligne+$d_somme_inf; 
										$pec_ligne=$pec_ligne+$d_somme_pec;
										$fret_kg_ligne=$fret_kg_ligne+$d_somme_loc;
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
								
								$pdf->Cell(20,5, utf8_decode($m->arrondie($mht2)),'RL','','R');
								$pdf->Cell(20,5, utf8_decode($m->arrondie($tva2)),'RL','','R');
								$pdf->Cell(20,5, utf8_decode($m->arrondie($total_ligne_d)),'RL','','R');
								$ad=$ad+$d_somme_ad;
								$ch=$ch+$d_somme_ch;
								$inf=$inf+$d_somme_inf;
								$pec=$pec+$d_somme_pec;
								$route=$route+$mouvement2['red_route_d'];
								$atterrissage=$atterrissage;
								$bal=$bal+$mouvement2['red_bal_d'];
								$fret=$fret+$mouvement2['red_fret_d'];
								$fret_kg=$fret_kg+$d_somme_loc;
								$pax=$pax+$mouvement2['red_pass_d'];
								$stat=$stat;
								$surete=$surete+$mouvement2['red_surete'];
								$securite=$securite;
								$formu=$formu+$mouvement2['red_formu'];
								$compt=$compt+$mouvement2['red_compt'];
								$ass=$ass+$mouvement2['red_assantinc'];
								$tot_l=$tot_l+(0+$total_ligne_d);
					}
					$pdf->Ln();
					$pdf->SetFont('Arial','',6);
					$pdf->Cell(36,5, "SOUS TOTAL",'LTRB','','R'); 
					$pdf->Cell(20,5, $m->arrondie($route_ligne),'LTRB','','R'); 
					$pdf->Cell(20,5, $m->arrondie($atterrissage_ligne),'LTRB','','R'); 
					$pdf->Cell(10,5, $m->arrondie($bal_ligne),'LTRB','','R'); 
					$pdf->Cell(10,5, $m->arrondie($fret_ligne),'LTRB','','R'); 
					$pdf->Cell(15,5, $m->arrondie($pax_ligne),'LTRB','','R'); 
					$pdf->Cell(20,5, $m->arrondie($stat_ligne),'LTRB','','R'); 
					$pdf->Cell(14,5, $m->arrondie($surete_ligne),'LTRB','','R'); 
					$pdf->Cell(10,5, $m->arrondie($formu_ligne),'RLBT','','R');
					$pdf->Cell(10,5, $m->arrondie($compt_ligne),'RLBT','','R');
					$pdf->Cell(17,5, $m->arrondie($securite_ligne),'BRLT','','R');
					$pdf->Cell(12,5, $m->arrondie($ass_ligne),'RLBT','','R');
					$pdf->Cell(17,5, $m->arrondie($tot_mht_ligne),'BRLT','','R');
					$pdf->Cell(15,5, $m->arrondie($tot_tva_ligne),'BRLT','','R');
					$pdf->Cell(10,5, $m->arrondie($arrondie_ligne),'BRLT','','R');
					$pdf->Cell(20,5, $m->arrondie($totalite),'RLTB','','R');
					$pdf->Cell(15,5, (''),'RLTB','','R');
					$pdf->Cell(15,5, (''),'RLTB','','R');


					//=======ATTENTION
					$ad_exp+=$ad; $ch_exp+=$ch; $inf_exp+=$inf_exp; $pec_exp+=$pec;
					$route_exp+=$route_ligne;
					$atterrissage_exp+=$atterrissage_ligne;
					$bal_exp+=$bal_ligne;
					$fret_exp+=$fret_ligne;
					$fret_kg_exp+=$fret_kg_ligne;
					$pax_exp+=$pax_ligne;
					$pec_exp+=$pec_ligne;
					$stat_exp+=$stat_ligne;
					$surete_exp+=$surete_ligne;
					$securite_exp+=$securite_ligne;
					$formu_exp+=$formu_ligne;
					$compt_exp+=$compt_ligne;
					$ass_exp+=$ass_ligne;
					$totalite_exp+=$totalite;
					$tot_l_exp+=$tot_l;
					$tot_mht_exp+=$tot_mht_ligne;
					$tot_tva_exp+=$tot_tva_ligne;
					$tot_mttc_exp+=$tot_mttc_ligne;
					$tot_arrondie_exp+=$arrondie_ligne;
					
					//================



					$tot_mht=$tot_mht+$tot_mht_ligne;
					$tot_arrondie=$tot_arrondie+$arrondie_ligne;
					//$tot_mttc=$tot_mttc+$tot_mttc_ligne;
					$tot_mttc=$tot_mttc+$tot_mttc_ligne;
					
					$pdf->Ln();						
				}
					
				//============= JUSTE POUR LE SOULIGNEMENT DE LA DERNIERE LIGNE ===================
					$pdf->Cell(36.1,0.1, "",'T','','C'); 
				//=================================================================================

				//============= DERNIERE RUPTURE=====================
				$pdf->Ln();
				$pdf->Cell(36,5, "TOTAL ".$clientNom,'LTRB','','R'); 
				$pdf->Cell(20,5, $m->arrondie($route_exp),'LTRB','','R'); 
				$pdf->Cell(20,5, $m->arrondie($atterrissage_exp),'LTRB','','R'); 
				$pdf->Cell(10,5, $m->arrondie($bal_exp),'LTRB','','R'); 
				$pdf->Cell(10,5, $m->arrondie($fret_exp),'LTRB','','R'); 
				$pdf->Cell(15,5, $m->arrondie($pax_exp),'LTRB','','R'); 
				$pdf->Cell(20,5, $m->arrondie($stat_exp),'LTRB','','R'); 
				$pdf->Cell(14,5, $m->arrondie($surete_exp),'LTRB','','R'); 
				$pdf->Cell(10,5, $m->arrondie($formu_exp),'RLBT','','R');
				$pdf->Cell(10,5, $m->arrondie($compt_exp),'RLBT','','R');
				$pdf->Cell(17,5, $m->arrondie($securite_exp),'BRLT','','R');
				$pdf->Cell(12,5, $m->arrondie($ass_exp),'RLBT','','R');
				$pdf->Cell(17,5, $m->arrondie($tot_mht_exp),'BRLT','','R');
				$pdf->Cell(15,5, $m->arrondie($tot_tva_exp),'BRLT','','R');
				$pdf->Cell(10,5, $m->arrondie($tot_arrondie_exp),'BRLT','','R');
				$pdf->Cell(20,5, $m->arrondie($tot_mttc_exp),'RLTB','','R');
				$pdf->Cell(15,5, (''),'RLTB','','R');
				$pdf->Cell(15,5, (''),'RLTB','','R');
				$pdf->Ln();
				//===================================================

				$pdf->Ln();
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(36,6, "TOTAL US $",'TRLB','','L');
				$pdf->Cell(20,6, $m->arrondie($route),'TRLB','','R');
				$pdf->Cell(20,6, $m->arrondie($atterrissage),'TRLB','','R');
				$pdf->Cell(10,6, $m->arrondie($bal),'TRLB','','R');
				$pdf->Cell(10,6, $m->arrondie($fret),'TRLB','','R');
				$pdf->Cell(15,6, $m->arrondie($pax),'TRLB','','R');
				$pdf->Cell(20,6, $m->arrondie($stat),'TRLB','','R');
				$pdf->Cell(14,6, $m->arrondie($surete),'TRLB','','R');
				$pdf->Cell(10,6, $m->arrondie($formu),'TRLB','','R');
				$pdf->Cell(10,6, $m->arrondie($compt),'TRLB','','R');
				$pdf->Cell(17,6, $m->arrondie($securite),'TRLB','','R');
				$pdf->Cell(12,6, $m->arrondie($ass),'TRLB','','R');
				$pdf->Cell(17,6, $m->arrondie($tot_mht),'TRLB','','R');
				$pdf->Cell(15,6, $m->arrondie($tot_tva),'TRLB','','R');
				$pdf->Cell(10,6, $m->arrondie($tot_arrondie),'TRLB','','R');
				$pdf->Cell(20,6, $m->arrondie($tot_mttc),'TRLB','','R');
				$pdf->Cell(15,6, "",'TRLB','','R');
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(15,6, (''),'TRLB','','R');
				
				
				$pdf->Ln();		
				
				
				$pdf->Ln(8);
				$signataire=$m->signataire();
				$pdf->Cell(70,6, "LE CHEF DE SERVICE FACTURATION",'','','C');
				$pdf->Cell(70,6, "",'','','C');
				$pdf->Cell(70,6, "LE CHEF DE DIVISION COMMERCIALE",'','','C');
				$pdf->Ln();
				$pdf->Cell(70,6, $signataire['facturation'],'','','C');
				$pdf->Cell(70,6, "",'','','C');
				$pdf->Cell(70,6, $signataire['division'],'','','C');
			}else
			{
			
				$pdf->Cell(286,6, ("Aucune donnée trouvé"),'TRBL','','C'); 
			}
			
//================ REDEVANCES AER===========================================================	
			
//==================================== TOTALITE DU BORDEREAU===============================================	
			
			
			
			
$pdf->Output();



?>
