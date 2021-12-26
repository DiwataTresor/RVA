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
			$client=client($cl,$bdd);
			$pdf->Cell(36,1, utf8_decode("POUR ".$client['nom_cl']." AU ".Datemysqltofr($dt2)),'','','C'); 
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

					$pdf->SetFont('Arial','B',11);
					$m=mouv($t2['Num_mouv'],$bdd);
					$libelle_typ=$m['ta']['Libelle_typ'];
					$pdf->Cell(9,1.3, utf8_decode("IMMATRICULATION : ".$m['ta']['Code_imm']),'TBL','','C'); 
					$pdf->Cell(6,1.3, utf8_decode("TYPE D'AVION : ".$m['ta']['Libelle_typ']),'TB','','L'); 
					$pdf->Cell(21.1,1.3, utf8_decode("POIDS MAX. AU DECOLLAGE : ".$m['ta']['Poids']),'TBR','','L'); 
					$pdf->SetFont('Arial','',11);
					do
					{
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
						$pdf->Ln();
							$pdf->Cell(2.8,1, utf8_decode(Datemysqltofr($mouvement2['ta']['Date_mouv'])),'RL','','C'); 
							$pdf->Cell(2,1, utf8_decode(($mouvement2['ta']['Heure_mouv'])),'RL','','C');
							$pdf->Cell(2,1, utf8_decode($mouvement2['ville_arr']),'RL','','C');
							$pdf->Cell(2,1, utf8_decode("FZQA"),'RL','','C');
							$pdf->Cell(1.25,1, utf8_decode($t_e_a['ad']),'RL','','R');
							$pdf->Cell(1.25,1, utf8_decode($t_e_a['ch']),'RL','','R');
							$pdf->Cell(1.25,1, utf8_decode($t_e_a['inf']),'RL','','R');
							$pdf->Cell(1.25,1, utf8_decode($t_e_a['pec']),'RL','','R');
							$pdf->Cell(2,1, utf8_decode($t_e_a['loc']),'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement2['red_route_a'])),'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement2['red_att'])),'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement2['red_bal_a'])),'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement2['red_fret_a'])),'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement2['red_pass_a'])),'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement2['red_stat'])),'RL','','R');
							$pdf->Cell(1.6,1, "",'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(""),'RL','','R');
							$pdf->Cell(1.6,1, "",'RL','','R');
							$pdf->Cell(1.6,1, "",'RL','','R');
							$pdf->Cell(1.61,1, "",'RL','','R');
						$total_ligne_a=$mouvement2['red_route_a']+
										$mouvement2['tot_red_att']+
										$mouvement2['red_bal_a']+
										$mouvement2['red_fret_a']+
										$mouvement2['red_stat'];			
						$pdf->Cell(2.7,1, utf8_decode(arrondie(	$total_ligne_a)),'RL','','R');

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

							$pdf->Cell(2.8,1, utf8_decode(Datemysqltofr($mouvement2['td']['Date_mouv'])),'RL','','C'); 
							$pdf->Cell(2,1, utf8_decode(($mouvement2['td']['Heure_mouv'])),'RL','','C');
							$pdf->Cell(2,1, utf8_decode("FZQA"),'RL','','C');
							$pdf->Cell(2,1, utf8_decode($mouvement2['ville_dep']),'RL','','C');
							$pdf->Cell(1.25,1, utf8_decode($t_e_d['ad']),'RL','','R');
							$pdf->Cell(1.25,1, utf8_decode($t_e_d['ch']),'RL','','R');
							$pdf->Cell(1.25,1, utf8_decode($t_e_d['inf']),'RL','','R');
							$pdf->Cell(1.25,1, utf8_decode($t_e_d['pec']),'RL','','R');
							$pdf->Cell(2,1, utf8_decode($t_e_d['loc']),'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement2['red_route_d'])),'RL','','R');
							$pdf->Cell(1.6,1, "",'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement2['red_bal_d'])),'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement2['red_fret_d'])),'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement2['red_pass_d'])),'RL','','R');
							$pdf->Cell(1.6,1, "",'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement2['red_surete'])),'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement2['red_securite'])),'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement2['red_formu'])),'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement2['red_compt'])),'RL','','R');
							$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement2['red_assantinc'])),'RL','','R');
						$total_ligne_d=$mouvement2['red_route_d']+
										$mouvement2['red_bal_d']+
										$mouvement2['red_fret_d']+
										$mouvement2['red_pass_d']+
										$mouvement2['red_pec']+
										$mouvement2['red_surete']+
										$mouvement2['red_securite']+
										$mouvement2['red_assantinc']+
										$mouvement2['red_compt']+
										$mouvement2['red_formu'];
						
						$pdf->Cell(2.7,1, utf8_decode(arrondie($total_ligne_d)),'RL','','R');
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
					}while($t2=mysqli_fetch_array($e2));
					$pdf->Ln();						
						
				}while($t=mysqli_fetch_array($e));
					/*//$pdf->Ln();
						$pdf->Cell(1.25,1.2, utf8_decode(Datemysqltofr($mouvement['ta']['Date_mouv'])),'TRBL','','C'); 
						$pdf->Cell(20,1.2, utf8_decode(($mouvement['ta']['Heure_mouv'])),'TRBL','','C');
						$pdf->Cell(20,1.2, utf8_decode($ta['Code_pt']),'TRBL','','C');
						$pdf->Cell(20,1.2, utf8_decode("FZQA"),'TRBL','','C');
						$pdf->Cell(12,1.2, utf8_decode($tescale_a['Ad']),'TRBL','','C');
						$pdf->Cell(12,1.2, utf8_decode($tescale_a['Ch']),'TRBL','','C');
						$pdf->Cell(12,1.2, utf8_decode($tescale_a['Inf']),'TRBL','','C');
						$pdf->Cell(12,1.2, utf8_decode($tescale_a['Pec']),'TRBL','','C');
						$pdf->Cell(19,1.2, utf8_decode($tescale_a['Loc']),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_rout'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_att'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_bal'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_fret'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_pass'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_stat'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_surete'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_securite'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_formu'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_compt'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_assantinc'])),'TRBL','','C');
						$pdf->Cell(20,1.2, utf8_decode(""),'TRBL','','C');
						$pdf->Cell(1.25,1.2, utf8_decode(arrondie($mouvement['tot_sans_tva'])),'TRBL','','C');
						$pdf->Ln();	
						$pdf->Cell(1.25,1.2, utf8_decode(Datemysqltofr($mouvement['td']['Date_mouv'])),'TRBL','','C'); 
						$pdf->Cell(20,1.2, utf8_decode(($mouvement['td']['Heure_mouv'])),'TRBL','','C');
						$pdf->Cell(20,1.2, utf8_decode("FZQA"),'TRBL','','C');
						$pdf->Cell(20,1.2, utf8_decode($ta['Code_pt']),'TRBL','','C');
						$pdf->Cell(12,1.2, utf8_decode($tescale_d['Ad']),'TRBL','','C');
						$pdf->Cell(12,1.2, utf8_decode($tescale_d['Ch']),'TRBL','','C');
						$pdf->Cell(12,1.2, utf8_decode($tescale_d['Inf']),'TRBL','','C');
						$pdf->Cell(12,1.2, utf8_decode($tescale_d['Pec']),'TRBL','','C');
						$pdf->Cell(19,1.2, utf8_decode($tescale_d['Loc']),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_rout'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_att'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_bal'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_fret'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_pass'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_stat'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_surete'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_securite'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_formu'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_compt'])),'TRBL','','C');
						$pdf->Cell(15,1.2, utf8_decode(arrondie($mouvement['tot_red_assantinc'])),'TRBL','','C');
						$pdf->Cell(20,1.2, utf8_decode(""),'TRBL','','C');
						$pdf->Cell(1.25,1.2, utf8_decode(arrondie($mouvement['tot_sans_tva'])),'TRBL','','C');
						$pdf->Ln();	
					*/
				//============= JUSTE POUR LE SOULIGNEMENT DE LA DERNIERE LIGNE ===================
					$pdf->Cell(36.1,0.1, "",'T','','C'); 
				//=================================================================================
				$pdf->Ln();
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(10.05,1.2, "",'','','C');
				$pdf->Cell(5.75,1.2, "TOT.RES INTER. US $",'TRL','','L');
				$pdf->Cell(1.6,1.2, arrondie($route),'TRL','','R');
				$pdf->Cell(1.6,1.2, arrondie($atterrissage),'TRL','','R');
				$pdf->Cell(1.6,1.2, arrondie($bal),'TRL','','R');
				$pdf->Cell(1.6,1.2, arrondie($fret),'TRL','','R');
				$pdf->Cell(1.6,1.2, arrondie($pax),'TRL','','R');
				$pdf->Cell(1.6,1.2, arrondie($stat),'TRL','','R');
				$pdf->Cell(1.6,1.2, arrondie($surete),'TRL','','R');
				$pdf->Cell(1.6,1.2, arrondie($securite),'TRL','','R');
				$pdf->Cell(1.6,1.2, arrondie($formu),'TRL','','R');
				$pdf->Cell(1.6,1.2, arrondie($compt),'TRL','','R');
				$pdf->Cell(1.6,1.2, arrondie($ass),'TRL','','R');
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(2.7,1.2, arrondie(ceil($tot_l)),'TRL','','R');
				$pdf->Ln();		
				/*$pdf->Cell(10.05,1.2, "",'','','C');
				$pdf->Cell(5.75,1.2, "TOT.RES NAT. US $",'RL','','L');
				$pdf->Cell(1.6,1.2, "",'RL','','R');
				$pdf->Cell(1.6,1.2, "",'RL','','R');
				$pdf->Cell(1.6,1.2, "",'RL','','R');
				$pdf->Cell(1.6,1.2, "",'RL','','R');
				$pdf->Cell(1.6,1.2, "",'RL','','R');
				$pdf->Cell(1.6,1.2, "",'RL','','R');
				$pdf->Cell(1.6,1.2, "",'RL','','R');
				$pdf->Cell(1.6,1.2, "",'RL','','R');
				$pdf->Cell(1.6,1.2, "",'RL','','R');
				$pdf->Cell(1.6,1.2, "",'RL','','R');
				$pdf->Cell(1.6,1.2, "",'RL','','R');
				$pdf->Cell(2.7,1.2, "",'RL','','R');
				$pdf->Ln();*/
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(10.05,1.2, "",'','','C');
				$pdf->Cell(5.75,1.2, "TOTAL TVA $",'RL','','L');
				$pdf->Cell(1.6,1.2, "",'RL','','R');
				$pdf->Cell(1.6,1.2, "",'RL','','L');
				$pdf->Cell(1.6,1.2, "",'RL','','L');
				$pdf->Cell(1.6,1.2, "",'RL','','L');
				$pdf->Cell(1.6,1.2, "",'RL','','L');
				$pdf->Cell(1.6,1.2, "",'RL','','L');
				$pdf->Cell(1.6,1.2, "",'RL','','L');
				$pdf->Cell(1.6,1.2, "",'RL','','L');
				$pdf->Cell(1.6,1.2, "",'RL','','L');
				$pdf->Cell(1.6,1.2, "",'RL','','L');
				$pdf->Cell(1.6,1.2, "",'RL','','C');
				$pdf->Cell(2.7,1.2, "",'RL','','C');
				$pdf->Ln();
				$pdf->Cell(10.05,1.2, "",'','','C');
				$pdf->Cell(5.75,1.2, "TOTAL CLIENT US $",'RLB','','L');
				$pdf->Cell(1.6,1.2, arrondie($route),'RLB','','R');
				$pdf->Cell(1.6,1.2, arrondie($atterrissage),'RLB','','R');
				$pdf->Cell(1.6,1.2, arrondie($bal),'RLB','','R');
				$pdf->Cell(1.6,1.2, arrondie($fret),'RLB','','R');
				$pdf->Cell(1.6,1.2, arrondie($pax),'RLB','','R');
				$pdf->Cell(1.6,1.2, arrondie($stat),'RLB','','R');
				$pdf->Cell(1.6,1.2, arrondie($surete),'RLB','','R');
				$pdf->Cell(1.6,1.2, arrondie($securite),'RLB','','R');
				$pdf->Cell(1.6,1.2, arrondie($formu),'RLB','','R');
				$pdf->Cell(1.6,1.2, arrondie($compt),'RLB','','R');
				$pdf->Cell(1.6,1.2, arrondie($ass),'RLB','','R');
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(2.7,1.2, arrondie(ceil($tot_l)),'RLB','','R');
				
				$pdf->Ln(2);
				$signataire=signataire($bdd);
				$pdf->Cell(10,1.2, "LE CHEF DE SERVICE FACTURATION",'','','C');
				$pdf->Cell(10,1.2, "",'','','C');
				$pdf->Cell(10,1.2, "LE CHEF DE DIVISION COMMERCIALE",'','','C');
				$pdf->Ln(1);
				$pdf->Cell(10,1.2, $signataire['facturation'],'','','C');
				$pdf->Cell(10,1.2, "",'','','C');
				$pdf->Cell(10,1.2, $signataire['division'],'','','C');
			}else
			{
			
				$pdf->Cell(80,1.2, ($client),'TRBL','','C'); 
			}
			
//================ REDEVANCES AER===========================================================	
			
//==================================== TOTALITE DU BORDEREAU===============================================	
			
			
			
			
$pdf->Output();



?>
