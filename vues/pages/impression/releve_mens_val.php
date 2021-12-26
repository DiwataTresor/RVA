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
	@$bord=$m->bordereau($dt);
	$id_us=$_SESSION["Idd"];
	$user=$m->user($id_us);

	class PDF extends FPDF
	{
	
	}
	$taille=array(39,39);
	$pdf = new PDF('L','cm',$taille);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetLeftMargin(1);
	$pdf->SetTopMargin(0.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Image('../../../images/entete_pdf.png',15,1,8,4);
	$npage=$pdf->PageNo();
	
	//$pdf->Line(15, 260, 190, 260);
	//$pdf->Line(15, 70, 190, 70);
	
	$pdf->SetFont('Arial','',11);
	/*$pdf->Text(20, 270, utf8_decode("N° TVA : 664 / 2012"));
	$pdf->Text(20, 275, utf8_decode("N° IMPOT : A1201438C"));*/
	
	//$pdf->Text(2.7, 1.2, utf8_decode("REPUBLIQUE DEMOCRATIQUE DU CONGO"));
	$pdf->Text(2, 2, utf8_decode("REGIE DES VOIES AERIENNES SA"));
	$pdf->Text(2, 2.5, utf8_decode("AEROPORT INTERNATIONAL DE LA LUANO"));
	$pdf->Text(2, 3, utf8_decode("N° TVA : A0700324 L"));
	$pdf->Text(2, 3.5, utf8_decode("----------------------------------------------------------------------"));

			$pdf->Cell(34,1, utf8_decode(''),'','','C'); 
			$pdf->Ln();
			//$mouv=str_replace("'","",$num_mouv);
			$pdf->SetFont('Arial','B',11);
			$pdf->Cell(31,2, utf8_decode("EDITE LE : ".date('d/m/Y')),'','','R'); 
			$pdf->Ln();
			//$pdf->Cell(109,7, "",'','','R'); 
			//$pdf->Cell(60,7, "PAGE : ".$npage,'','','R');  
			$pdf->Ln(1);
			$pdf->Cell(36,1, utf8_decode("RELEVE MENSUEL DES MOUVEMENTS VALORISES"),'','','C'); 
			$pdf->Ln();
			$pdf->SetFont('Arial','BU',11);
			$client=$m->client($cl);
			$pdf->Cell(36,1, utf8_decode("POUR ".strval($client['nom_cl'])." AU ".$m->Datemysqltofr($dt2)),'','','C'); 
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);
			
			$pdf->Ln(); $pdf->Ln();
	//================================= FACTURE==================
			$pdf->Cell(2.8,1, utf8_decode("DATE MOUV"),'TRL','','C'); 
			$pdf->Cell(2,1, utf8_decode("HEURE"),'TRL','','C');
			$pdf->Cell(2,1, utf8_decode("PROV"),'TRL','','C');
			$pdf->Cell(2,1, utf8_decode("DEST"),'TRL','','C');
			$pdf->Cell(5,1, utf8_decode("NBRE PAX"),'TRL','','C');
			$pdf->Cell(2,1, utf8_decode("FRET/KG"),'TRL','','C');
			$pdf->Cell(17.6,1, utf8_decode("REDEVANCES"),'TRL','','C');
			
			$pdf->Cell(2.7,1, utf8_decode("TOTAL RED"),'TRL','','C');
			$pdf->Ln();
			$pdf->Cell(2.8,1, utf8_decode(""),'RBL','','C'); 
			$pdf->Cell(2,1, utf8_decode(""),'RBL','','C');
			$pdf->Cell(2,1, utf8_decode(""),'RBL','','C');
			$pdf->Cell(2,1, utf8_decode(""),'RBL','','C');
			$pdf->Cell(1.25,1, utf8_decode("AD"),'RBL','','C');
			$pdf->Cell(1.25,1, utf8_decode("CH"),'RBL','','C');
			$pdf->Cell(1.25,1, utf8_decode("INF"),'RBL','','C');
			$pdf->Cell(1.25,1, utf8_decode("PEC"),'RBL','','C');
			$pdf->Cell(2,1, utf8_decode(""),'RBL','','C');
			$pdf->Cell(1.6,1, utf8_decode("ROUTE"),'RBL','','C');
			$pdf->Cell(1.6,1, utf8_decode("ATT"),'RBL','','C');
			$pdf->Cell(1.6,1, utf8_decode("BAL"),'RBL','','C');
			$pdf->Cell(1.6,1, utf8_decode("FRET"),'RBL','','C');
			$pdf->Cell(1.6,1, utf8_decode("PAX"),'RBL','','C');
			$pdf->Cell(1.6,1, utf8_decode("STAT."),'RBL','','C');
			$pdf->Cell(1.6,1, utf8_decode("SURETE"),'RBL','','C');
			$pdf->Cell(1.6,1, utf8_decode("SECUR"),'RBL','','C');
			$pdf->Cell(1.6,1, utf8_decode("F/T"),'RBL','','C');
			$pdf->Cell(1.6,1, utf8_decode("COMP"),'RBL','','C');
			$pdf->Cell(1.6,1, utf8_decode("ASS.INT"),'RBL','','C');
			
			$pdf->Cell(2.7,1, utf8_decode(""),'RBL','','C');
	//================================ SQL==================================
			$s="select 
			distinct(Code_imm), 
			immatriculation.Id_imm,
			mouvement2.Immatr,
			immatriculation.Code_pr,
			client.Id_cl,
			mouvement2.Date_mouv,Num_mouv 				
				from 
					rva_facturation2.mouvement2,rva_facturation2.immatriculation,rva_facturation2.client
				where 
					mouvement2.Immatr=immatriculation.Id_imm 
				and 
					immatriculation.Code_pr=client.Id_cl 
				and 
					client.Id_cl=$cl 
				and
					Date_mouv between '$dt' and '$dt2'
				
				order by 
					Code_imm";
			
			$e=$m->cnx->query($s); $row=$e->fetchAll(); $n=count($row);
	//=============================== CONTENU DU TABLEAU=================================
			$pdf->Ln();
			
			if($n!==0)
			{
				
				//$pdf->Cell(5,1, utf8_decode($n),'','','C'); 

				//============== VARIABLES DE CALCUL=======================
					$route=0;
					$atterrissage=0;
					$bal=0;
					$fret=0;
					$pax=0;
					$pec=0;
					$stat=0;
					$surete=0;
					$securite=0;
					$formu=0;
					$compt=0;
					$ass=0;
					$tot_l=0;
					$general=0;
				//=========================================================
				@$imma=$row[0]["Code_imm"];
				$aaa=1;
				foreach($row as $t)
				{
					if($aaa==1)
					{
						$aaa=2;
					}else
					{

						if($imma==$t["Code_imm"])
						{
							continue;
						}else
						{
							$imma=$t["Code_imm"];
						}
					}
					@$mouvement=$m->mouv($t['Num_mouv']);
					@$code_imm=$mouvement['code_imm'];
					//================ TABLE ESCALEQ==================	
						@$num_mouv=$t['Num_mouv'];		
						$sa="select *,format(Date_mouv,'%d/%m/%Y') as dt_mouv 
							from 
								rva_facturation2.mouvement2,rva_facturation2.pt_emplacement,rva_facturation2.immatriculation,rva_facturation2.client,rva_facturation2.type_avion 
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
						$escale_a="select * from rva_facturation2.escale where Id_mouv=$num_mouv and Sens='A'"; 
						$e_escale_a=$m->cnx->query($escale_a); $tescale_a=($e_escale_a->fetchAll());
						
						$tot_pax_a=$tescale_a[0]['Ad']+$tescale_a[0]['Ch']+$tescale_a[0]['Inf'];
						
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
						$e_escale_d=$m->cnx->query($escale_d); $tescale_d=($e_escale_d->fetchAll());
					//=================  TRAIEMENT DE GROUPE IMMATRICULATION=========================
						$s2="select distinct(mouvement2.Num_mouv),
									mouvement2.Date_mouv,
									Immatriculation.Code_imm,
									immatriculation.Code_pr,
									client.Id_cl,
									mouvement2.Immatr,
									immatriculation.Id_imm
								from 
									rva_facturation2.mouvement2,rva_facturation2.immatriculation,rva_facturation2.client
								where 
									mouvement2.Immatr=immatriculation.Id_imm 
								and 
									immatriculation.Code_pr=client.Id_cl 
								and 
									Code_imm='$code_imm' 
								and
									Date_mouv between '$dt' and '$dt2'
								order by 
									Date_mouv";	
						//===================
					$e2=$m->cnx->query($s2);
					@$row2=($e2->fetchAll());
					@$num_mouv2=$row2[0]['Num_mouv'];

					$pdf->SetFont('Arial','B',11);
					@$_m=$m->mouv($row2[0]['Num_mouv']);
					@$libelle_typ=$_m['ta'][0]['Libelle_typ'];
					@$pdf->Cell(9,1.3, utf8_decode("IMMATRICULATION : ".$_m['ta'][0]['Code_imm']),'TBL','','C'); 
					@$pdf->Cell(6,1.3, utf8_decode("TYPE D'AVION : ".$_m['ta'][0]['Libelle_typ']),'TB','','L'); 
					@$pdf->Cell(21.1,1.3, utf8_decode("POIDS MAX. AU DECOLLAGE : ".$_m['ta'][0]['Poids']),'TBR','','L'); 
					@$pdf->SetFont('Arial','',11);
					$mouvA=$row2[0]["Num_mouv"];
					
					$aA=0;
					foreach($row2 as $t2)
					{
						if($aA!==0)
						{
							if($t2["Num_mouv"]==$mouvA)
							{
								$aA++;
								continue;
							}else
							{
								$aA++;
								$mouvA=$t2["Num_mouv"];
							}
						}else
						{
							$aA++;
						}
						
						@$mouvement2=$m->mouv($t2['Num_mouv']);	
						@$num_mouv2=$t2['Num_mouv'];
						$general=$general+$mouvement2['tot_avec_tva'];
						/*=========== 	escale arrive ===========*/
							/*$s_e_a="select *,
								sum(escale.Ad) as ad,
								sum(escale.Ch) as ch,
								sum(escale.Inf) as inf,
								sum(escale.Pec) as pec,
								sum(escale.Tra) as tra,
								sum(escale.Loc) as loc,
								sum(escale.Trat) as trat,
								sum(escale.Ptt) as ptt     
									from rva_facturation2.escale where Sens='A' and Id_mouv='$num_mouv2'";*/
							$s_e_a="select * from rva_facturation2.escale where Sens='A' and Id_mouv='$num_mouv2'";
							$e_e_a=$m->cnx->query($s_e_a);
							$t_e_a=($e_e_a->fetchAll());	
							$a_somme_ad=0; $a_somme_ch=0;$a_somme_inf=0;$a_somme_pec=0;$a_somme_tra=0; $a_somme_loc=0; $a_somme_trat=0;$a_somme_ptt=0; 
							foreach($t_e_a as $row)
							{
								$a_somme_ad+=$row['Ad'];
								$a_somme_ch+=$row['Ch'];
								$a_somme_inf+=$row['Inf'];
								$a_somme_pec+=$row['Pec'];
								$a_somme_tra+=$row['Tra'];
								$a_somme_loc+=$row['Loc'];
								$a_somme_trat+=$row['Trat'];
								$a_somme_ptt+=$row['Ptt'];
							}
						/*=========== escale depart =============*/
							$s_e_d="select * from rva_facturation2.escale where Sens='D' and Id_mouv='$num_mouv2'";
							$e_e_d=$m->cnx->query($s_e_d);
							$t_e_d=($e_e_d->fetchAll());
							$d_somme_ad=0; $d_somme_ch=0;$d_somme_inf=0;$d_somme_pec=0;$d_somme_tra=0; $d_somme_loc=0; $d_somme_trat=0;$d_somme_ptt=0; 
							foreach($t_e_d as $row)
							{
								$d_somme_ad+=$row['Ad'];
								$d_somme_ch+=$row['Ch'];
								$d_somme_inf+=$row['Inf'];
								$d_somme_pec+=$row['Pec'];
								$d_somme_tra+=$row['Tra'];
								$d_somme_loc+=$row['Loc'];
								$d_somme_trat+=$row['Trat'];
								$d_somme_ptt+=$row['Ptt'];
							}
						/*=====================================*/
						$pdf->Ln();
							@$pdf->Cell(2.8,1, utf8_decode($m->Datemysqltofr($mouvement2['ta'][0]['Date_mouv'])),'RL','','C'); 
							@$pdf->Cell(2,1, utf8_decode($m->heureformat($mouvement2['ta'][0]['Heure_mouv'])),'RL','','C');
							@$pdf->Cell(2,1, utf8_decode($mouvement2['ville_arr']),'RL','','C');
							@$pdf->Cell(2,1, utf8_decode("FZQA"),'RL','','C');
							//@$pdf->Cell(2,1, utf8_decode($t2["Num_form"]),'RL','','C');
							@$pdf->Cell(1.25,1, utf8_decode($a_somme_ad),'RL','','R');
							@$pdf->Cell(1.25,1, utf8_decode($a_somme_ch),'RL','','R');
							@$pdf->Cell(1.25,1, utf8_decode($a_somme_inf),'RL','','R');
							@$pdf->Cell(1.25,1, utf8_decode($a_somme_pec),'RL','','R');
							@$pdf->Cell(2,1, utf8_decode($a_somme_loc),'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode($m->arrondie($mouvement2['red_route_a'])),'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode($m->arrondie($mouvement2['red_att'])),'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode($m->arrondie($mouvement2['red_bal_a'])),'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode($m->arrondie($mouvement2['red_fret_a'])),'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode($m->arrondie($mouvement2['red_pass_a'])),'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode($m->arrondie($mouvement2['red_stat'])),'RL','','R');
							@$pdf->Cell(1.6,1, "",'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode(""),'RL','','R');
							@$pdf->Cell(1.6,1, "",'RL','','R');
							@$pdf->Cell(1.6,1, "",'RL','','R');
							$pdf->Cell(1.61,1, "",'RL','','R');
						$total_ligne_a=$mouvement2['red_route_a']+
										$mouvement2['tot_red_att']+
										$mouvement2['red_bal_a']+
										$mouvement2['red_fret_a']+
										$mouvement2['red_stat'];			
						@$pdf->Cell(2.7,1, utf8_decode($m->arrondie(	$total_ligne_a)),'RL','','R');

						//
							$route=$route+$mouvement2['red_route_a'];
							$atterrissage=$atterrissage+$mouvement2['tot_red_att'];
							$bal=$bal+$mouvement2['red_bal_a'];
							$fret=$fret+$mouvement2['red_fret_a'];
							$pax=$pax+$mouvement2['red_pass_a'];
							$pec=0;
							$stat=$stat+$mouvement2['red_stat'];
							$securite=$securite+$mouvement2['red_securite'];
							$ass=$ass;
						//

						$pdf->Ln();	

							@$pdf->Cell(2.8,1, utf8_decode($m->Datemysqltofr($mouvement2['td'][0]['Date_mouv'])),'RL','','C'); 
							@$pdf->Cell(2,1, utf8_decode($m->Heureformat($mouvement2['td'][0]['Heure_mouv'])),'RL','','C');
							@$pdf->Cell(2,1, utf8_decode("FZQA"),'RL','','C');
							@$pdf->Cell(2,1, utf8_decode($mouvement2['ville_dep']),'RL','','C');
							@$pdf->Cell(1.25,1, utf8_decode($d_somme_ad),'RL','','R');
							@$pdf->Cell(1.25,1, utf8_decode($d_somme_ch),'RL','','R');
							@$pdf->Cell(1.25,1, utf8_decode($d_somme_inf),'RL','','R');
							@$pdf->Cell(1.25,1, utf8_decode($d_somme_pec),'RL','','R');
							@$pdf->Cell(2,1, utf8_decode($d_somme_loc),'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode($m->arrondie($mouvement2['red_route_d'])),'RL','','R');
							@$pdf->Cell(1.6,1, "",'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode($m->arrondie($mouvement2['red_bal_d'])),'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode($m->arrondie($mouvement2['red_fret_d'])),'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode($m->arrondie($mouvement2['red_pass_d'])),'RL','','R');
							@$pdf->Cell(1.6,1, "",'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode($m->arrondie($mouvement2['red_surete'])),'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode($m->arrondie($mouvement2['red_securite'])),'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode($m->arrondie($mouvement2['red_formu'])),'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode($m->arrondie($mouvement2['red_compt'])),'RL','','R');
							@$pdf->Cell(1.6,1, utf8_decode($m->arrondie($mouvement2['red_assantinc'])),'RL','','R');
						@$total_ligne_d=$mouvement2['red_route_d']+
										$mouvement2['red_bal_d']+
										$mouvement2['red_fret_d']+
										$mouvement2['red_pass_d']+
										$mouvement2['red_pec']+
										$mouvement2['red_surete']+
										$mouvement2['red_securite']+
										$mouvement2['red_assantinc']+
										$mouvement2['red_compt']+
										$mouvement2['red_formu'];
						
						$pdf->Cell(2.7,1, utf8_decode($m->arrondie($total_ligne_d)),'RL','','R');
						$route=$route+$mouvement2['red_route_d'];
						$atterrissage=$atterrissage;
						$bal=$bal+$mouvement2['red_bal_d'];
						$fret=$fret+$mouvement2['red_fret_d'];
						$pax=$pax+$mouvement2['red_pass_d'];
						$pec=0;
						$stat=$stat;
						$surete=$surete+$mouvement2['red_surete'];
						$securite=$securite;
						$formu=$formu+$mouvement2['red_formu'];
						$compt=$compt+$mouvement2['red_compt'];
						$ass=$ass+$mouvement2['red_assantinc'];
						$tot_l=$tot_l+($total_ligne_a+$total_ligne_d);
					}
					$pdf->Ln();						
						
				}
					
				//============= JUSTE POUR LE SOULIGNEMENT DE LA DERNIERE LIGNE ===================
					$pdf->Cell(36.1,0.1, "",'T','','C'); 
				//=================================================================================
				$pdf->Ln();
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(10.05,1, "",'','','C');
				$pdf->Cell(5.75,1, "TOT.RES INTER. US $",'TRL','','L');
				@$pdf->Cell(1.6,1, $m->arrondie($route),'TRL','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($atterrissage),'TRL','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($bal),'TRL','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($fret),'TRL','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($pax),'TRL','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($stat),'TRL','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($surete),'TRL','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($securite),'TRL','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($formu),'TRL','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($compt),'TRL','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($ass),'TRL','','R');
				@$pdf->SetFont('Arial','',10);
				@$pdf->Cell(2.7,1, $m->arrondie($tot_l),'TRL','','R');
				$pdf->Ln();		
				$client_=$m->client($cl);
				$tvaRoute=0;
				$tvaAtter=0;
				$tvaBal=0;
				$tvaFret=0;
				$tvaPax=0;
				$tvaStat=0;
				$tvaSurete=0;
				$tvaSecurite=0;
				$tvaForm=0;
				$tvaCompt=0;
				$tvaAss=0;
				$totalTva=0;
				if(trim($client_["code_nat"])=="Z")
				{
					$tvaRoute=$m->tva($route);
					$tvaAtter=$m->tva($atterrissage);
					$tvaBal=$m->tva($bal);
					$tvaFret=$m->tva($fret);
					$tvaPax=$m->tva($pax);
					$tvaStat=$m->tva($stat);
					$tvaSurete=$m->tva($surete);
					$tvaSecurite=$m->tva($securite);
					$tvaForm=$m->tva($formu);
					$tvaCompt=$m->tva($compt);
					$tvaAss=$m->tva($ass);
					//$totalTva=$tvaRoute+$tvaAtter+$tvaBal+$tvaFret+$tvaPax+$tvaStat+$tvaSurete+$tvaSecurite+$tvaForm+$tvaCompt+$tvaAss;
					$totalTva=$m->tva($tot_l);
				}
				
				
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(10.05,1, "",'','','C');
				$pdf->Cell(5.75,1, "TOTAL TVA $",'RL','','L');
				$pdf->Cell(1.6,1, $m->arrondie($tvaRoute),'RL','','R');
				$pdf->Cell(1.6,1, $m->arrondie($tvaAtter),'RL','','R');
				$pdf->Cell(1.6,1, $m->arrondie($tvaBal),'RL','','R');
				$pdf->Cell(1.6,1, $m->arrondie($tvaFret),'RL','','R');
				$pdf->Cell(1.6,1, $m->arrondie($tvaPax),'RL','','R');
				$pdf->Cell(1.6,1, $m->arrondie($tvaStat),'RL','','R');
				$pdf->Cell(1.6,1, $m->arrondie($tvaSurete),'RL','','R');
				$pdf->Cell(1.6,1, $m->arrondie($tvaSecurite),'RL','','R');
				$pdf->Cell(1.6,1, $m->arrondie($tvaForm),'RL','','R');
				$pdf->Cell(1.6,1, $m->arrondie($tvaCompt),'RL','','R');
				$pdf->Cell(1.6,1, $m->arrondie($tvaAss),'RL','','R');
				@$pdf->Cell(2.7,1, $m->arrondie(($totalTva)),'RL','','R');
				$pdf->Ln();
				
				$pdf->Cell(10.05,1, "",'','','C');
				$pdf->Cell(5.75,1, "TOTAL CLIENT US $",'RLB','','L');
				@$pdf->Cell(1.6,1, $m->arrondie($route+$tvaRoute),'RLB','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($atterrissage+$tvaAtter),'RLB','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($bal+$tvaBal),'RLB','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($fret+$tvaFret),'RLB','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($pax+$tvaPax),'RLB','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($stat+$tvaStat),'RLB','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($surete+$tvaSurete),'RLB','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($securite+$tvaSecurite),'RLB','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($formu+$tvaForm),'RLB','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($compt+$tvaComp),'RLB','','R');
				@$pdf->Cell(1.6,1, $m->arrondie($ass+$tvaAss),'RLB','','R');
				$pdf->SetFont('Arial','',10);
				@$pdf->Cell(2.7,1, $m->arrondie(ceil($tot_l+$totalTva)),'RLB','','R');
				
				$pdf->Ln(1);
				$signataire=$m->signataire();
				$pdf->Cell(10,1, "LE CHEF DE SERVICE FACTURATION",'','','C');
				$pdf->Cell(10,1, "",'','','C');
				$pdf->Cell(10,1, "LE CHEF DE DIVISION COMMERCIALE",'','','C');
				$pdf->Ln(1);
				$pdf->Cell(10,1, $signataire['facturation'],'','','C');
				$pdf->Cell(10,1, "",'','','C');
				$pdf->Cell(10,1, $signataire['division'],'','','C');
			}else
			{
			
				$pdf->Cell(80,1, ($client),'TRBL','','C'); 
			}
			
//================ REDEVANCES AER===========================================================	
			
//==================================== TOTALITE DU BORDEREAU===============================================	
			
			
			
			
$pdf->Output();



?>
