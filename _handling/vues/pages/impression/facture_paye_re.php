<?php
	@session_start();
	$id_us=$_SESSION['Idd'];
	//$id_mouv=$_REQUEST["id_mouv"];
	$num_mouv=$_REQUEST["num_mouv"];
	$dt=date("Y-m-d");
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../manager/bd/cnx.php');
	$mouvement=mouv($num_mouv,$bdd);
	@session_start();
	$nom_user=user($_SESSION['Idd'],$bdd);

	//====================================== DONNEES DE LA TABLE ========================
			
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
			
			//===== TOTAL PASSAGER =======================
				$tot_pax_d=0;
				do
				{
					$tot_pax_d=$tot_pax_d+($tescale_d['Ad']+$tescale_d['Ch']+$tescale_d['Inf']);
				}while($tescale_d=mysqli_fetch_array($e_escale_d));
				
				
				if($td['Temps']=="B")
				{
					$balisage_d="N";
				}else
				{
					$balisage_d="O";
				}
				
				if($ta['Temps']=="B")
				{
					$balisage_a="N";
				}else
				{
					$balisage_a="O";
				}
				
				$s_taux="select * from taux order by Id_taux desc"; $e_taux=mysqli_query($bdd,$s_taux); $taux=mysqli_fetch_array($e_taux);
			//============== STATIONNEMENT =================
			$stationement=$td['Stat'];
			
			// =============== CALCUL REDEVANCES ========================
			$tarif="select * from tarif_red"; $etarif=mysqli_query($bdd,$tarif); $ttarif=mysqli_fetch_array($etarif);
			// RED ROUTE A
			if($ta['Type_mouv']=="N")
			{
				if($ta['Nv_vol']<245)
				{
					$route_d=0;
					$route_a=(($ttarif['Redrou_esp_inf_245'])*($ta['Distance']/100)*(sqrt($ta['Poids']/50)));
				}else
				{
					$route_a=0;
					$route_d=(($ttarif['Redrou_esp_sup_245'])*($ta['Distance']/100)*(sqrt($ta['Poids']/50)));
				}
			}else
			{
				$route_a=(($ttarif['Redrou_vol_int'])*($ta['Distance']/100)*(sqrt($ta['Poids']/50)));
				$route_d=(($ttarif['Redrou_vol_int'])*($td['Distance']/100)*(sqrt($ta['Poids']/50)));	
			}
			
			//===BALISAGE 
			if($balisage_a=="O")
			{
				if($ta['Ex_bal']=='N')
				{
					$red_bal_a=$ttarif['Redbal'];
				}else
				{
					$red_bal_a=0;
				}
			}else{
				$red_bal_a=0;
			}
			
			if($balisage_d=="O")
			{
				if($td['Ex_bal']=='N')
				{
					$red_bal_d=$ttarif['Redbal'];
				}else
				{
					$red_bal_d=0;
				}
			}else{
				$red_bal_d=0;
			}
			
			//=== RED ATTERISSAGE
			if($ta['Type_mouv']=='N')
			{
				if($ta['Poids']<4)
				{
					$red_att_a=5;
					$red_att_d=0;
				}else if($ta['Poids']>4 && $ta['Poids']<26)
				{
					$red_att_a=$ta['Poids']*$ttarif['Redatt_1_25_nat'];
					$red_att_d=0;
				}else if($ta['Poids']>25 && $ta['Poids']<76)
				{
					$red_att_a=40+($ta['Poids']-25)*$ttarif['Redatt_26_75_nat'];
					$red_att_d=0;
				}else if($ta['Poids']>75)
				{
					$red_att_a=200+($ta['Poids']-75)*$ttarif['Redatt_sur_75_nat'];
					$red_att_d=0;
				}
			}else
			{
				if($ta['Poids']<4)
				{
					$red_att_a=12.5;
					$red_att_d=0;
				}else if($ta['Poids']>4 && $ta['Poids']<26)
				{
					$red_att_a=$ta['Poids']*$ttarif['Redatt_1_25_inter'];
					$red_att_d=0;
				}else if($ta['Poids']>25 && $ta['Poids']<76)
				{
					$red_att_a=100+($ta['Poids']-25)*$ttarif['Redatt_26_75_inter'];
					$red_att_d=0;
				}else if($ta['Poids']>75)
				{
					$red_att_a=500+($ta['Poids']-75)*$ttarif['Redatt_sup_75_inter'];
					$red_att_d=0;
				}
			}
			//== RED FRET
			if($ta['Type_mouv']=='N')
			{
				$red_fret_a=0;
				$red_fret_d=($ttarif['Redfr_res_nat']*($tescale_d['Loc']+$tescale_d['Trat']+$tescale_d['Ptt']));	
			}else
			{
				$red_fret_a=($ttarif['Redfr_res_nat_idf_deb']*($tescale_a['Loc']+$tescale_a['Trat']+$tescale_a['Ptt']));
				$red_fret_d=($ttarif['Redfr_res_nat_idf_emb']*($tescale_d['Loc']+$tescale_d['Trat']+$tescale_d['Ptt']));
			}
			//==RED PASSGER 
			if($ta['Type_mouv']=='N')
			{
				$red_pass_a=0;
				$red_pass_d=$tot_pax_d*$ttarif['Redpass_res_nat'];
			}else
			{
				//$spassager="select * from escale 
				$red_pass_a=0;
				$red_pass_d=$ttarif['Redpass_res_int']*$tot_pax_d;
			}
			//==PEC
			if($ta['Type_mouv']=='N')
			{
				$red_pec=($tescale_d['Pec']*(($ttarif['Redpass_res_nat']*10)/100));
			}else
			{
				$red_pec=($tescale_d['Pec']*(($ttarif['Redpass_res_int']*10)/100));
			}
			//==RED COMPT ENREG
			$red_compt_a=$ta['Compt_enr']*$ttarif['Cptenreg'];
			$red_compt_d=$td['Compt_enr']*$ttarif['Cptenreg'];
			//== RED FORM
			$red_formu_a=$ta['Formu'];
			$red_formu_d=$td['Formu'];
			//==ANTI INC
			if($td['Anti_inc']=="N")
			{
				$red_assantinc_a=0;
				$red_assantinc_d=0;
			}else
			{
				$red_assantinc_a=0;
				$red_assantinc_d=$ttarif['Assantinc'];
			}
			$red_assantinc=$ttarif["Assantinc"];
			//== RED SURETE
			if($ta['Type_mouv']=='N')
			{
				$red_sur_a=0;
				$red_sur_d=($ttarif['Redsur_nat']*($tot_pax_d));
			}else
			{
				$red_sur_a=0;
				$red_sur_d=($ttarif['Redsur_inter']*($tot_pax_d));
			}
			//== RED SECURITE
			if($ta['Type_mouv']=='N')
			{
				$red_sec_a=0;
				if($tot_pax_d<20)
				{
					$red_sec_d=0;
				}else
				{
					$red_sec_d=($ttarif['Redsecurite']*($tot_pax_d));
				}
				
			}else
			{
				$red_sec_a=0;
				$red_sec_d=0;
			}
			//== RED STATIONNMENT 
				$dt_arr=$ta['Date_mouv'];
				$heure_arr=$ta['Heure_mouv'];
				$dt_dep=$td['Date_mouv'];
				$heure_dep=$td['Heure_mouv'];
				$tps_arr=strtotime($dt_arr." ".$heure_arr);	
				$tps_dep=strtotime($dt_dep." ".$heure_dep);
				$heure=((($tps_dep-$tps_arr)/60)/60);
				$tabl_heure=explode('.',$heure);
				if(isset($tabl_heure[1]))
				{
					$heure=$tabl_heure[0]+1;
				}else
				{
					$heure=$heure;
				}
			if($ta['Type_mouv']=='N')
			{
				$heure=$heure-2;
				if($heure=1)
				{
					$red_stat=$ta['Poids']*$ttarif['Redstat_tarmac'];;
				}else if($heure>3)
				{
					$red_stat=$ta['Poids']*$ttarif['Redstat_tarmac'];
				}else
				{
					if($td['Stat']=='T')
					{
						$red_stat=$ta['Poids']*$ttarif['Redstat_tarmac']*$heure;
					}else if($td['Stat']=='G')
					{
						$red_stat=$ta['Poids']*$ttarif['Redstat_garage']*$heure;
					}else
					{
						$red_stat=0;
					}
				}
				
			}else
			{
				if($td['Stat']=='T')
				{
					$red_stat=$ta['Poids']*$ttarif['Redstat_tarmac']*$heure;
				}else if($td['Stat']=='G')
				{
					$red_stat=$ta['Poids']*$ttarif['Redstat_garage']*$heure;
				}else
				{
					$red_stat=0;
				}
			}
	//===================================================================================	
	//============ RECUPERATION N° FACTURE===============================================
	$s="select * from facture_imprime where Mouv='$num_mouv'"; $e=mysqli_query($bdd,$s); $t=mysqli_fetch_array($e);
	$num_facture=$t['Num_facture'];
	
	class PDF extends FPDF
	{
	
	}
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetLeftMargin(5);
	$pdf->SetTopMargin(105);
	$pdf->SetFont('Arial','B',11);
	$pdf->Image('../../../images/entete_pdf.png',73,15,60,20);
	$pdf->Image('../../../images/sceau_paye.png',13,205,60,20);
	//$pdf->Line(15, 260, 190, 260);
	//$pdf->Line(15, 70, 190, 70);
	
	$pdf->SetFont('Arial','',8);
	/*$pdf->Text(20, 270, utf8_decode("N° TVA : 664 / 2012"));
	$pdf->Text(20, 275, utf8_decode("N° IMPOT : A1201438C"));*/
	
	//=== RECUPERATION DU N° QUITTANCE ================
		$s="select * from  paiement_facture where Mouv='$num_mouv'";
		$t=mysqli_fetch_array(mysqli_query($bdd,$s));
		$quittance=$t['Quittance'];
		$pdf->Text(120, 260, utf8_decode($quittance));
		$dt_paie=Datemysqltofr($t['Date_paie'])." ".Date("H:i:s");
	//=================================================
	
		
	$pdf->Text(10, 20, utf8_decode("REPUBLIQUE DEMOCRATIQUE DU CONGO"));
	$pdf->Text(10, 23, utf8_decode("REGIE DES VOIES AERIENNES SA"));
	$pdf->Text(10, 26, utf8_decode("AEROPORT INTERNATIONAL DE LA LUANO"));
	$pdf->Text(10, 29, utf8_decode("N° TVA : A0700324 L"));
	$pdf->Text(10, 32, utf8_decode("----------------------------------------------------------------------"));

			$pdf->Cell(183,20, utf8_decode(''),'','','C'); 
			$pdf->Ln(5);
			//$mouv=str_replace("'","",$num_mouv);
			$pdf->Cell(199,7, utf8_decode("LUBUMBASHI ".$dt_paie),'','','R'); 
			$pdf->Ln(21);
			$pdf->SetFont('Arial','BU',11);
			$pdf->Cell(183,7, utf8_decode("FACTURE CASH N° ".$num_facture),'','','C'); 
			
			$pdf->SetFont('Arial','B',8);
			$pdf->Ln(10);
			$pdf->Cell(153,7, utf8_decode("NOM    : ".$mouvement['nom_cli']."       CODE : ".$ta['Code_cl']),'','','L'); 
			$pdf->Ln();
			$pdf->Cell(153,7, utf8_decode("ADRESSE : ".$ta['Adresse_cl']),'','','L');  
			
			$pdf->SetFont('Arial','',8);
			$pdf->Ln();
			$pdf->Cell(201,5,utf8_decode("I.MOUVEMENTS EFFECTUES PAR  IMMAT : ".$ta['Code_imm']."   TYPE  : ".$ta['Libelle_typ']."   N° FORMULAIRE : ".$mouvement['num_form']),'LRT','LRT','C');
			
			$pdf->Ln();
			$pdf->Cell(201,5,"POIDS : ".$ta['Poids']."T  SUR AEROPORT INTERNATIONAL DE LA LUANO",'l+LBR','','C');
				
			$pdf->Ln();	
			$pdf->SetFont('Arial','B',7);			
			$pdf->Cell(9,4, "SENS",'LB','','C');  
			$pdf->Cell(14,4, "DATE",'LB','','C');
			$pdf->Cell(11,4, "HEURE",'LB','','C');
			$pdf->Cell(12,4, "ESCALE",'LB','','C');
			$pdf->Cell(12,4, "ADULTE",'LB','','C');
			$pdf->Cell(12,4, "ENFANT",'LB','','C');
			$pdf->Cell(12,4, "BEBE",'LB','','C');
			$pdf->Cell(12,4, "PEC",'LB','','C');
			$pdf->Cell(21,4, "PAX TRANS",'LB','','C');
			$pdf->Cell(15,4, "FRET LOC",'LB','','C');
			$pdf->Cell(15,4, "FRET TRA",'LB','','C');
			$pdf->Cell(15,4, "FRET PTT",'LB','','C');
			$pdf->Cell(16,4, "BALISAGE",'LB','','C');
			$pdf->Cell(25,4, "STATIONNEMENT",'LRB','','C');
			
			$s="select * from escale,pt_emplacement where escale.Prov_dest=Pt_emplacement.Id_pt and Sens='A' and Id_mouv='$num_mouv'"; $e=mysqli_query($bdd,$s); $t=mysqli_fetch_array($e);
			do
			{
						
				$pdf->Ln();	
				$pdf->SetFont('Arial','',7);			
				$pdf->Cell(9,4, "A",'L','','C');  
				$pdf->Cell(14,4, Datemysqltofr($mouvement['ta']['Date_mouv']),'L','','L');
				$pdf->Cell(11,4, $mouvement['ta']['Heure_mouv'],'L','','R');
				$pdf->Cell(12,4, $t['Code_pt'],'L','','C');
				$pdf->Cell(12,4, $t['Ad'],'L','','R');
				$pdf->Cell(12,4, $t['Ch'],'L','','R');
				$pdf->Cell(12,4, $t['Inf'],'L','','R');
				$pdf->Cell(12,4, $t['Pec'],'L','','R');
				$pdf->Cell(21,4, $t['Tra'],'L','','R');
				$pdf->Cell(15,4, $t['Loc'],'L','','R');
				$pdf->Cell(15,4, $t['Trat'],'L','','R');
				$pdf->Cell(15,4, $t['Ptt'],'L','','R');
				$pdf->Cell(16,4, $mouvement['balisage_a'],'L','','C');
				$pdf->Cell(25,4, "",'LR','','L');
			}while($t=mysqli_fetch_array($e));
			
			$s="select * from escale,pt_emplacement where escale.Pt_ent=Pt_emplacement.Id_pt and Sens='D' and Id_mouv='$num_mouv'"; 
			$e=mysqli_query($bdd,$s); $t=mysqli_fetch_array($e);
			do
			{
				$pdf->Ln();	
				$pdf->SetFont('Arial','',7);			
				$pdf->Cell(9,4, "D",'L','','C');  
				$pdf->Cell(14,4, Datemysqltofr($mouvement['td']['Date_mouv']),'L','','L');
				$pdf->Cell(11,4, $mouvement['td']['Heure_mouv'],'L','','R');
				$pdf->Cell(12,4, $t['Code_pt'],'L','','C');
				$pdf->Cell(12,4, $t['Ad'],'L','','R');
				$pdf->Cell(12,4, $t['Ch'],'L','','R');
				$pdf->Cell(12,4, $t['Inf'],'L','','R');
				$pdf->Cell(12,4, $t['Pec'],'L','','R');
				$pdf->Cell(21,4, $t['Tra'],'L','','R');
				$pdf->Cell(15,4, $t['Loc'],'L','','R');
				$pdf->Cell(15,4, $t['Trat'],'L','','R');
				$pdf->Cell(15,4, $t['Ptt'],'L','','R');
				$pdf->Cell(16,4, $mouvement['balisage_d'],'L','','C');
				$pdf->Cell(25,4, $mouvement['stat_d'],'LR','','C');
			}while($t=mysqli_fetch_array($e));
				$pdf->Ln();	
				$pdf->SetFont('Arial','',6);			
				$pdf->Cell(10,0, "",'B','','C');  
				$pdf->Cell(14,0, "",'B','','L');
				$pdf->Cell(10,0, "",'B','','R');
				$pdf->Cell(12,0, "",'B','','C');
				$pdf->Cell(10,0, "",'B','','R');
				$pdf->Cell(10,0, "",'B','','R');
				$pdf->Cell(10,0, "",'B','','R');
				$pdf->Cell(10,0, "",'B','','R');
				$pdf->Cell(18,0, "",'B','','R');
				$pdf->Cell(15,0, "",'B','','R');
				$pdf->Cell(15,0, "",'B','','R');
				$pdf->Cell(15,0, "",'B','','R');
				$pdf->Cell(16,0, "",'B','','C');
				$pdf->Cell(36,0, "",'RB','','C');
	//=================== 2e Tableau====================================
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);	
			$pdf->Cell(190,8, "II.REDEVANCES A PAYER",'','','C');
			$pdf->Ln();	
			$pdf->SetFont('Arial','B',7);			
			$pdf->Cell(10,4, "SENS",'TLB','','C');  
			$pdf->Cell(12,4, "ROUTE",'TLB','','C');
			$pdf->Cell(16,4, "ATTERISS.",'TLB','','C');
			$pdf->Cell(15,4, "BALISAGE",'TLB','','C');
			$pdf->Cell(12,4, "FRET",'TLB','','C');
			$pdf->Cell(18,4, "PASSAGER",'TLB','','C');
			$pdf->Cell(15,4, "PEC",'TLB','','C');
			$pdf->Cell(15,4, "STATIONN.",'TLB','','C');
			$pdf->Cell(20,4, "COMPT ENREG",'TLB','','C');
			$pdf->Cell(15,4, "FORM",'TLB','','C');
			$pdf->Cell(19,4, "ASS. ANTI-INC",'TLB','','C');
			$pdf->Cell(17,4, "SURETE",'TLB','','C');
			$pdf->Cell(14,4, "SECURITE",'TLBR','','C');
			
			$pdf->Ln();	
			$pdf->SetFont('Arial','',7);			
			$pdf->Cell(10,4, "A",'L','','C');  
			$pdf->Cell(12,4, arrondie($mouvement['red_route_a']),'L','','R');
			$pdf->Cell(16,4, '','L','','C');
			$pdf->Cell(15,4, arrondie($mouvement['red_bal_a']),'L','','R');
			$pdf->Cell(12,4, arrondie($mouvement['red_fret_a']),'L','','R');
			$pdf->Cell(18,4, arrondie($mouvement['red_pass_a']),'L','','R');
			$pdf->Cell(15,4, "",'L','','C');
			$pdf->Cell(15,4, "",'L','','C');
			$pdf->Cell(20,4, "",'L','','C');
			$pdf->Cell(15,4, "",'L','','C');
			$pdf->Cell(19,4, "",'L','','C');
			$pdf->Cell(17,4, "",'L','','C');
			$pdf->Cell(14,4, "",'LR','','C');
			
			$pdf->Ln();	
			$pdf->SetFont('Arial','',7);			
			$pdf->Cell(10,4, "D",'LB','','C');  
			$pdf->Cell(12,4, arrondie($mouvement['red_route_d']),'LB','','R');
			$pdf->Cell(16,4, arrondie($mouvement['red_att']),'LB','','R');
			$pdf->Cell(15,4, arrondie($mouvement['red_bal_d']),'LB','','R');
			$pdf->Cell(12,4, arrondie($mouvement['red_fret_d']),'LB','','R');
			$pdf->Cell(18,4, arrondie($mouvement['red_pass_d']),'LB','','R');
			$pdf->Cell(15,4, arrondie($mouvement['red_pec']),'LB','','R');
			$pdf->Cell(15,4, arrondie($mouvement['red_stat']),'LB','','R');
			$pdf->Cell(20,4, arrondie($mouvement['red_compt']),'LB','','R');
			$pdf->Cell(15,4, arrondie($mouvement['red_formu']),'LB','','R');
			$pdf->Cell(19,4, arrondie($mouvement['red_assantinc']),'LB','','R');
			$pdf->Cell(17,4, arrondie($mouvement['red_surete']),'LB','','R');
			$pdf->Cell(14,4, arrondie($mouvement['red_securite']),'LBR','','R');
			
			$pdf->Ln();	
			$pdf->SetFont('Arial','',7);			
			$pdf->Cell(10,4, "",'','','C'); 
				
			$pdf->Cell(12,4, arrondie($mouvement['tot_red_rout']),'','','R');
			$pdf->Cell(16,4, arrondie($mouvement['tot_red_att']),'','','R');
			$pdf->Cell(15,4, arrondie($mouvement['tot_red_bal']),'','','R');
			$pdf->Cell(12,4, arrondie($mouvement['tot_red_fret']),'','','R');
			$pdf->Cell(18,4, arrondie($mouvement['tot_red_pass']),'','','R');
			$pdf->Cell(15,4, arrondie($mouvement['tot_red_pec']),'','','R');
			$pdf->Cell(15,4, arrondie($mouvement['tot_red_stat']),'','','R');
			$pdf->Cell(20,4, arrondie($mouvement['tot_red_compt']),'','','R');
			$pdf->Cell(15,4, arrondie($mouvement['tot_red_formu']),'','','R');
			$pdf->Cell(19,4, arrondie($mouvement['tot_red_assantinc']),'','','R');
			$pdf->Cell(17,4, arrondie($mouvement['tot_red_surete']),'','','R');
			$pdf->Cell(14,4, arrondie($mouvement['tot_red_securite']),'','','R');
		
			
			$pdf->Ln();$pdf->Ln();
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(25,7, "           Au Taux de : ".$mouvement['taux']['Usd_fc'],'','','C');
			
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);
			
			$pdf->Cell(40,7,"Montant hors taxe en $ US : ",'LTB','','C');	
			$pdf->Cell(20,7,arrondie($mouvement['tot_sans_tva']),'RTB','','R');	
			$pdf->Cell(24,7,utf8_decode("Equivalent à : "),'','','C');
			$pdf->Cell(70,7,arrondie($mouvement['tot_sans_tva_fc'])." FC",'LTBR','','C');
			
			$pdf->Ln();
			$pdf->Ln();
			
			$pdf->Cell(40,7,"TVA : ",'LTB','','C');	
			$pdf->Cell(20,7,arrondie($mouvement['tva']),'RTB','','R');	
			$pdf->Cell(24,7,utf8_decode("Equivalent à : "),'','','C');
			$pdf->Cell(70,7,arrondie($mouvement['tva_fc'])." FC",'LTBR','','C');
			
			$pdf->Ln();
			$pdf->Ln();
			
			$pdf->Cell(40,7,"Total toutes taxes comprises : ",'LTB','','C');	
			$pdf->Cell(20,7,arrondie($mouvement['tot_avec_tva']),'RTB','','R');	
			$pdf->Cell(24,7,utf8_decode("Equivalent à : "),'','','C');
			$pdf->Cell(70,7,arrondie(ceil($mouvement['tot_avec_tva_fc']))." FC",'LTBR','','C');
			
			$pdf->Ln();
			$pdf->Ln();
						
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(20,7,utf8_decode("        EN TOUTE LETTRE"),'','','C');
				
			$pdf->Ln();
			$lettre=new ChiffreEnLettre();
			//$tot_avec_tva=explode(",",arrondie($tot_avec_tva));
			
			//$tot_avec_tva=$tot_avec_tva[0]+1;
 			$v=$lettre->Conversion(($mouvement['tot_avec_tva']));
			str_replace("deux","deux ",$v);
			$pdf->Cell(180,7,'Dollars americains, '.str_replace("deux","deux ",$v),'','','L');	
			
			$pdf->Ln();	
			//$v=$lettre->Conversion(($mouvement['tot_avec_tva_fc']));
			$v=$lettre->Conversion(ceil($mouvement['tot_avec_tva_fc']));
			$pdf->Cell(180,7,'Francs congolais, '.$v,'','','L');				
	//************************Fin Bon de sortie
			$pdf->Ln(10);
			$pdf->SetFont('Arial','BI',8);
			$pdf->Cell(50,7,'','','','L');
			$pdf->Cell(100,7,'FACTURE PAYABLE CASH A LA PERCEPTION CENTRALE','','','L');	
			$pdf->Ln(3);	
			
			$pdf->Cell(50,7,'','','','L');
			$pdf->Cell(100,7,"DE L'AEROPORT INTERNATIONAL DE LA LUANO",'','','L');	
			
			$pdf->SetFont('Arial','',7);
			$pdf->Text(20, 255, utf8_decode("PERCEPTEUR(TRICE)"));
			$pdf->Text(50, 255, utf8_decode("MATRICULE"));
			$pdf->Text(70, 255, utf8_decode("MONTANT PAYE"));
			$pdf->Text(100, 255, utf8_decode("DATE"));
			$pdf->Text(120, 255, utf8_decode("QUITTANCE"));
			
			$pdf->Text(20, 260, utf8_decode($nom_user['nom']));
			$pdf->Text(50, 260, utf8_decode($nom_user['matr']));
			$pdf->Text(70, 260,"  ".arrondie($mouvement['tot_avec_tva']));
			$pdf->Text(100, 260, $dt_paie);
			
			
 	
	$pdf->Text(20, 270, utf8_decode("Copyright Division commerciale"));
	
	//==================== INSERT DANS LA TABLE DES FACTURES IMPRIMEES==================
		$taux=$mouvement['taux']['Usd_fc'];
		$montant=$mouvement['tot_sans_tva'];
		$tva=$mouvement['tva'];
		$heure=date("H:i:s");
		
		journal_insert($id_us,'impression_facture',$num_mouv,$bdd);
		
		/*$s="insert into facture_paye_imprime values ('','$dt','$heure','$quittance','$num_mouv','$num_facture','$montant','$tva','$taux','V','$id_us')";
		mysqli_query($bdd,$s);*/
	//==================================================================================

$pdf->Output();



?>
