<?php
	@session_start();
	$id_us=$_SESSION['Idd'];
	//$id_mouv=$_REQUEST["id_mouv"];
	$num_mouv=$_REQUEST["num_mouv"];
	$dt=date("Y-m-d");
	$heure=date("H:i:s");	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../manager/bd/cnx.php');
	class m extends main{};
	$m =new main();
$s="select * from  rva_facturation2.facture_imprime where Mouv='$num_mouv' and Statut='R'"; 
$e=$m->cnx->query($s); 
$t=$e->fetch();
$n=count($t); 
if($n==0)
{	
	//include('../../../manager/parametre/parametre.php');
	echo(utf8_decode("<center><div align='center' style='text-align:center; font-weight:bold; font-size:25px; background-color:red; width:65%; border-radius:20px; padding:20px; color:white'>Désolé, cette facture n'existe pas ou n'a pas encore été imprimée</div></center>"));
}else
{
	$m->journal_insert($id_us,'impression_facture',$num_mouv);
	$mouvement=$m->mouv($num_mouv);
	$s="select * from rva_facturation2.facture_imprime where Mouv='$num_mouv' and Statut='R' order by Id_fact desc"; 
	$e=$m->cnx->query($s); 
	$t=($e->fetchAll());
		$num=$t[0]['N_ordre']+1;
		$num_facture=$t[0]['Num_facture'];
	//====================================== DONNEES DE LA TABLE ========================
			
				$sa="select *,format(Date_mouv,'%d/%m/%Y') as dt_mouv from rva_facturation2.mouvement2,rva_facturation2.pt_emplacement,rva_facturation2.immatriculation,rva_facturation2.client,rva_facturation2.type_avion 
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
				$ta=$ea->fetchAll();
				$escale_a="select * from rva_facturation2.escale where Id_mouv=$num_mouv and Sens='A'"; 
				$e_escale_a=$m->cnx->query($escale_a); $tescale_a=$e_escale_a->fetchAll();
				
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
				$td=$ed->fetchAll();;
				$escale_d="select * from rva_facturation2.escale where Id_mouv=$num_mouv and Sens='D'"; 
				$e_escale_d=$m->cnx->query($escale_d); $tescale_d=$e_escale_d->fetchAll();
			
			//===== TOTAL PASSAGER =======================
				$tot_pax_d=0;
				foreach($tescale_d as $row)
				{
					$tot_pax_d=$tot_pax_d+($row['Ad']+$row['Ch']+$row['Inf']);
				}
				
				
				if($td[0]['Temps']=="B")
				{
					$balisage_d="N";
				}else
				{
					$balisage_d="O";
				}
				
				if($ta[0]['Temps']=="B")
				{
					$balisage_a="N";
				}else
				{
					$balisage_a="O";
				}
				
				$s_taux="select * from rva_facturation2.taux order by Id_taux desc"; 
				$e_taux=$m->cnx->query($s_taux); 
				$taux=($e_taux->fetchAll());
			//============== STATIONNEMENT =================
			$stationement=$td[0]['Stat'];
			
			// =============== CALCUL REDEVANCES ========================
			$tarif="select * from rva_facturation2.tarif_red"; 
			$etarif=$m->cnx->query($tarif); 
			$ttarif=($etarif->fetchAll());
			// RED ROUTE A
			if($ta[0]['Type_mouv']=="N")
			{
				if($ta[0]['Nv_vol']<245)
				{
					$route_d=0;
					$route_a=(($ttarif[0]['Redrou_esp_inf_245'])*($ta[0]['Distance']/100)*(sqrt($ta[0]['Poids']/50)));
				}else
				{
					$route_a=0;
					$route_d=(($ttarif[0]['Redrou_esp_sup_245'])*($ta[0]['Distance']/100)*(sqrt($ta[0]['Poids']/50)));
				}
			}else
			{
				$route_a=(($ttarif[0]['Redrou_vol_int'])*($ta[0]['Distance']/100)*(sqrt($ta[0]['Poids']/50)));
				$route_d=(($ttarif[0]['Redrou_vol_int'])*($td[0]['Distance']/100)*(sqrt($ta[0]['Poids']/50)));	
			}
			
			//===BALISAGE 
			if($balisage_a=="O")
			{
				if($ta[0]['Ex_bal']=='N')
				{
					$red_bal_a=$ttarif[0]['Redbal'];
				}else
				{
					$red_bal_a=0;
				}
			}else{
				$red_bal_a=0;
			}
			
			if($balisage_d=="O")
			{
				if($td[0]['Ex_bal']=='N')
				{
					$red_bal_d=$ttarif[0]['Redbal'];
				}else
				{
					$red_bal_d=0;
				}
			}else{
				$red_bal_d=0;
			}
			
			//=== RED ATTERISSAGE
			if($ta[0]['Type_mouv']=='N')
			{
				if($ta[0]['Poids']<4)
				{
					$red_att_a=5;
					$red_att_d=0;
				}else if($ta[0]['Poids']>4 && $ta[0]['Poids']<26)
				{
					$red_att_a=$ta[0]['Poids']*$ttarif[0]['Redatt_1_25_nat'];
					$red_att_d=0;
				}else if($ta[0]['Poids']>25 && $ta[0]['Poids']<76)
				{
					$red_att_a=40+($ta[0]['Poids']-25)*$ttarif[0]['Redatt_26_75_nat'];
					$red_att_d=0;
				}else if($ta[0]['Poids']>75)
				{
					$red_att_a=200+($ta[0]['Poids']-75)*$ttarif[0]['Redatt_sur_75_nat'];
					$red_att_d=0;
				}
			}else
			{
				if($ta[0]['Poids']<4)
				{
					$red_att_a=12.5;
					$red_att_d=0;
				}else if($ta[0]['Poids']>4 && $ta[0]['Poids']<26)
				{
					$red_att_a=$ta[0]['Poids']*$ttarif[0]['Redatt_1_25_inter'];
					$red_att_d=0;
				}else if($ta[0]['Poids']>25 && $ta[0]['Poids']<76)
				{
					$red_att_a=100+($ta[0]['Poids']-25)*$ttarif[0]['Redatt_26_75_inter'];
					$red_att_d=0;
				}else if($ta[0]['Poids']>75)
				{
					$red_att_a=500+($ta[0]['Poids']-75)*$ttarif[0]['Redatt_sup_75_inter'];
					$red_att_d=0;
				}
			}
			//== RED FRET
			if($ta[0]['Type_mouv']=='N')
			{
				$red_fret_a=0;
				$red_fret_d=($ttarif[0]['Redfr_res_nat']*($tescale_d[0]['Loc']+$tescale_d[0]['Trat']+$tescale_d[0]['Ptt']));	
			}else
			{
				$red_fret_a=($ttarif[0]['Redfr_res_nat_idf_deb']*($tescale_a[0]['Loc']+$tescale_a[0]['Trat']+$tescale_a[0]['Ptt']));
				$red_fret_d=($ttarif[0]['Redfr_res_nat_idf_emb']*($tescale_d[0]['Loc']+$tescale_d[0]['Trat']+$tescale_d[0]['Ptt']));
			}
			//==RED PASSGER 
			if($ta[0]['Type_mouv']=='N')
			{
				$red_pass_a=0;
				$red_pass_d=$tot_pax_d*$ttarif[0]['Redpass_res_nat'];
			}else
			{
				//$spassager="select * from escale 
				$red_pass_a=0;
				$red_pass_d=$ttarif[0]['Redpass_res_int']*$tot_pax_d;
			}
			//==PEC
			if($ta[0]['Type_mouv']=='N')
			{
				$red_pec=($tescale_d[0]['Pec']*(($ttarif[0]['Redpass_res_nat']*10)/100));
			}else
			{
				$red_pec=($tescale_d[0]['Pec']*(($ttarif[0]['Redpass_res_int']*10)/100));
			}
			//==RED COMPT ENREG
			$red_compt_a=$ta[0]['Compt_enr']*$ttarif[0]['Cptenreg'];
			$red_compt_d=$td[0]['Compt_enr']*$ttarif[0]['Cptenreg'];
			//== RED FORM
			$red_formu_a=$ta[0]['Formu'];
			$red_formu_d=$td[0]['Formu'];
			//==ANTI INC
			if($td[0]['Anti_inc']=="N")
			{
				$red_assantinc_a=0;
				$red_assantinc_d=0;
			}else
			{
				$red_assantinc_a=0;
				$red_assantinc_d=$ttarif[0]['Assantinc'];
			}
			$red_assantinc=$ttarif[0]["Assantinc"];
			//== RED SURETE
			if($ta[0]['Type_mouv']=='N')
			{
				$red_sur_a=0;
				$red_sur_d=($ttarif[0]['Redsur_nat']*($tot_pax_d));
			}else
			{
				$red_sur_a=0;
				$red_sur_d=($ttarif[0]['Redsur_inter']*($tot_pax_d));
			}
			//== RED SECURITE
			if($ta[0]['Type_mouv']=='N')
			{
				$red_sec_a=0;
				if($tot_pax_d<20)
				{
					$red_sec_d=0;
				}else
				{
					$red_sec_d=($ttarif[0]['Redsecurite']*($tot_pax_d));
				}
				
			}else
			{
				$red_sec_a=0;
				$red_sec_d=0;
			}
			//== RED STATIONNMENT 
				$dt_arr=$ta[0]['Date_mouv'];
				$heure_arr=$ta[0]['Heure_mouv'];
				$dt_dep=$td[0]['Date_mouv'];
				$heure_dep=$td[0]['Heure_mouv'];
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
			if($ta[0]['Type_mouv']=='N')
			{
				$heure=$heure-2;
				if($heure=1)
				{
					$red_stat=$ta[0]['Poids']*$ttarif[0]['Redstat_tarmac'];;
				}else if($heure>3)
				{
					$red_stat=$ta[0]['Poids']*$ttarif[0]['Redstat_tarmac'];
				}else
				{
					if($td[0]['Stat']=='T')
					{
						$red_stat=$ta[0]['Poids']*$ttarif[0]['Redstat_tarmac']*$heure;
					}else if($td[0]['Stat']=='G')
					{
						$red_stat=$ta[0]['Poids']*$ttarif['Redstat_garage']*$heure;
					}else
					{
						$red_stat=0;
					}
				}
				
			}else
			{
				if($td[0]['Stat']=='T')
				{
					$red_stat=$ta[0]['Poids']*$ttarif[0]['Redstat_tarmac']*$heure;
				}else if($td[0]['Stat']=='G')
				{
					$red_stat=$ta[0]['Poids']*$ttarif[0]['Redstat_garage']*$heure;
				}else
				{
					$red_stat=0;
				}
			}
	//===================================================================================
	
	class PDF extends FPDF
	{
	
	}
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetLeftMargin(5);
	$pdf->SetTopMargin(35);
	$pdf->SetFont('Arial','B',11);
	$pdf->Image('../../../images/entete_pdf.png',73,15,60,20);
	
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
			$pdf->Ln(28);
			//$mouv=str_replace("'","",$num_mouv);
			//$num_facture=$num_mouv."/RDA.FZQA/".date('n.Y');
			$pdf->Cell(169,7, utf8_decode("LUBUMBASHI ".date('d/m/Y H:i:s')),'','','R'); 
			$pdf->Ln();
			$pdf->SetFont('Arial','BU',11);
						
			//=========================================INSERTION DU N° DE LA FACTURE
			
				$reqfact="select * from rva_facturation2.facture_imprime order by Id_fact desc"; 
				$efact=$m->cnx->query($reqfact); 
				$tfact=$efact->fetchAll();
				$nfact=count($tfact);
				$num_long_act=0;
				if($nfact==0)
				{
					$num=1;
				}else
				{
					$num=$tfact[0]['N_ordre']+1;
				}
				
					$num=$m->format_nbre($num);
					
				//$num_facture=$num."/RDA.FZQA/".date('n.Y');
				$_mouv=$mouvement['ta'][0]['Num_mouv'];
				$verif="select * from rva_facturation2.num_facture where Mouv='$_mouv'"; 
				$everif=$m->cnx->query($verif); 
				$tverif=$everif->fetchAll();
				$n=count($tverif);
			//=============================================================
			$pdf->Cell(183,7, utf8_decode(str_replace("'","",("FACTURE CASH N° ".$num_facture))),'','','C'); 
			
			$pdf->SetFont('Arial','B',8);
			$pdf->Ln(15);
			$pdf->Cell(153,7, utf8_decode("NOM    : ".$mouvement['nom_cli']."       CODE : ".$ta[0]['Code_cl']),'','','L'); 
			$pdf->Ln();
			$pdf->Cell(153,7, utf8_decode("ADRESSE : ".$ta[0]['Adresse_cl']),'','','L');  
			
			$pdf->SetFont('Arial','',8);
			$pdf->Ln();
			$pdf->Cell(203,5,utf8_decode("I.MOUVEMENTS EFFECTUES PAR  IMMAT : ".$ta[0]['Code_imm']."   TYPE  : ".$ta[0]['Libelle_typ']."   N° FORMULAIRE : ".$mouvement['num_form']),'LRT','LRT','C');
			
			$pdf->Ln();
			$pdf->Cell(203,5,"POIDS : ".$ta[0]['Poids']."T  SUR AEROPORT INTERNATIONAL DE LA LUANO",'l+LBR','','C');
				
			$pdf->Ln();	
			$pdf->SetFont('Arial','B',7);			
			$pdf->Cell(9,6, "SENS",'LB','','C');  
			$pdf->Cell(14,6, "DATE",'LB','','C');
			$pdf->Cell(11,6, "HEURE",'LB','','C');
			$pdf->Cell(12,6, "ESCALE",'LB','','C');
			$pdf->Cell(12,6, "ADULTE",'LB','','C');
			$pdf->Cell(12,6, "ENFANT",'LB','','C');
			$pdf->Cell(12,6, "BEBE",'LB','','C');
			$pdf->Cell(12,6, "PEC",'LB','','C');
			$pdf->Cell(20,6, "PAX TRANS",'LB','','C');
			$pdf->Cell(17,6, "FRET LOC",'LB','','C');
			$pdf->Cell(17,6, "FRET TRA",'LB','','C');
			$pdf->Cell(17,6, "FRET PTT",'LB','','C');
			$pdf->Cell(18,6, "BALISAGE",'LB','','C');
			$pdf->Cell(20,6, "STATIONN",'LRB','','C');
			
			$s="select * from rva_facturation2.escale,rva_facturation2.pt_emplacement where escale.Prov_dest=Pt_emplacement.Id_pt and Sens='A' and Id_mouv='$num_mouv'"; 
			$e=$m->cnx->query($s); $t=($e->fetchAll());
			foreach($t as $row)
			{
						
				$pdf->Ln();	
				$pdf->SetFont('Arial','',7);			
				$pdf->Cell(9,6, "A",'L','','C');  
				$pdf->Cell(14,6, $m->Datemysqltofr($mouvement['ta'][0]['Date_mouv']),'L','','L');
				$pdf->Cell(11,6, $m->Heureformat($mouvement['ta'][0]['Heure_mouv']),'L','','R');
				$pdf->Cell(12,6, $row['Code_pt'],'L','','C');
				$pdf->Cell(12,6, $row['Ad'],'L','','R');
				$pdf->Cell(12,6, $row['Ch'],'L','','R');
				$pdf->Cell(12,6, $row['Inf'],'L','','R');
				$pdf->Cell(12,6, $row['Pec'],'L','','R');
				$pdf->Cell(20,6, $row['Tra'],'L','','R');
				$pdf->Cell(17,6, $row['Loc'],'L','','R');
				$pdf->Cell(17,6, $row['Trat'],'L','','R');
				$pdf->Cell(17,6, $row['Ptt'],'L','','R');
				$pdf->Cell(18,6, $mouvement['balisage_a'],'L','','C');
				$pdf->Cell(20,6, "",'LR','','L');
			}
			
			if($mouvement['td'][0]['Type_mouv']=='I')
			{
				$s="select * from rva_facturation2.escale,rva_facturation2.pt_emplacement where escale.Prov_dest=Pt_emplacement.Id_pt and Sens='D' and Id_mouv='$num_mouv'"; 
			}else
			{
				$s="select * from rva_facturation2.escale,rva_facturation2.pt_emplacement where escale.Pt_ent=Pt_emplacement.Id_pt and Sens='D' and Id_mouv='$num_mouv'"; 
			}
			$e=$m->cnx->query($s); $t=$e->fetchAll();
			foreach($t as $row)
			{
				$pdf->Ln();	
				$pdf->SetFont('Arial','',7);			
				$pdf->Cell(9,6, "D",'L','','C');  
				$pdf->Cell(14,6, $m->Datemysqltofr($mouvement['td'][0]['Date_mouv']),'L','','L');
				$pdf->Cell(11,6, $m->Heureformat($mouvement['td'][0]['Heure_mouv']),'L','','R');
				$pdf->Cell(12,6, $row['Code_pt'],'L','','C');
				$pdf->Cell(12,6, $row['Ad'],'L','','R');
				$pdf->Cell(12,6, $row['Ch'],'L','','R');
				$pdf->Cell(12,6, $row['Inf'],'L','','R');
				$pdf->Cell(12,6, $row['Pec'],'L','','R');
				$pdf->Cell(20,6, $row['Tra'],'L','','R');
				$pdf->Cell(17,6, $row['Loc'],'L','','R');
				$pdf->Cell(17,6, $row['Trat'],'L','','R');
				$pdf->Cell(17,6, $row['Ptt'],'L','','R');
				$pdf->Cell(18,6, $mouvement['balisage_d'],'L','','C');
				$pdf->Cell(20,6, $mouvement['stat_d'],'LR','','C');
			}
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
				$pdf->Cell(38,0, "",'RB','','C');
	//=================== 2e Tableau====================================
			$pdf->Ln();
			$pdf->SetFont('Arial','B',8);	
			$pdf->Cell(190,7, "II.REDEVANCES A PAYER",'','','C');
			$pdf->Ln();	
			$pdf->SetFont('Arial','B',7);			
			$pdf->Cell(10,6, "SENS",'TLB','','C');  
			$pdf->Cell(12,6, "ROUTE",'TLB','','C');
			$pdf->Cell(16,6, "ATTERISS.",'TLB','','C');
			$pdf->Cell(16,6, "BALISAGE",'TLB','','C');
			$pdf->Cell(12,6, "FRET",'TLB','','C');
			$pdf->Cell(15,6, "PASSAGER",'TLB','','C');
			$pdf->Cell(15,6, "PEC",'TLB','','C');
			$pdf->Cell(15,6, "STATIONN.",'TLB','','C');
			$pdf->Cell(21,6, "COMPT ENREG",'TLB','','C');
			$pdf->Cell(15,6, "FORM",'TLB','','C');
			$pdf->Cell(19,6, "ASS. ANTI-INC",'TLB','','C');
			$pdf->Cell(17,6, "SURETE",'TLB','','C');
			$pdf->Cell(14,6, "SECURITE",'TLBR','','C');
			
			$pdf->Ln();	
			$pdf->SetFont('Arial','',7);			
			$pdf->Cell(10,6, "A",'L','','C');  
			$pdf->Cell(12,6, $m->arrondie($mouvement['red_route_a']),'L','','R');
			$pdf->Cell(16,6, $m->arrondie($mouvement['red_att']),'L','','C');
			$pdf->Cell(16,6, $m->arrondie($mouvement['red_bal_a']),'L','','R');
			$pdf->Cell(12,6, $m->arrondie($mouvement['red_fret_a']),'L','','R');
			$pdf->Cell(15,6, $m->arrondie($mouvement['red_pass_a']),'L','','R');
			$pdf->Cell(15,6, "",'L','','C');
			$pdf->Cell(15,6, "",'L','','C');
			$pdf->Cell(21,6, "",'L','','C');
			$pdf->Cell(15,6, "",'L','','C');
			$pdf->Cell(19,6, "",'L','','C');
			$pdf->Cell(17,6, "",'L','','C');
			$pdf->Cell(14,6, "",'LR','','C');
			
			$pdf->Ln();	
			$pdf->SetFont('Arial','',7);			
			$pdf->Cell(10,6, "D",'LB','','C');  
			$pdf->Cell(12,6, $m->arrondie($mouvement['red_route_d']),'LB','','R');
			$pdf->Cell(16,6, '','LB','','R');
			$pdf->Cell(16,6, $m->arrondie($mouvement['red_bal_d']),'LB','','R');
			$pdf->Cell(12,6, $m->arrondie($mouvement['red_fret_d']),'LB','','R');
			$pdf->Cell(15,6, $m->arrondie($mouvement['red_pass_d']),'LB','','R');
			$pdf->Cell(15,6, $m->arrondie($mouvement['red_pec']),'LB','','R');
			$pdf->Cell(15,6, $m->arrondie($mouvement['red_stat']),'LB','','R');
			$pdf->Cell(21,6, $m->arrondie($mouvement['red_compt']),'LB','','R');
			$pdf->Cell(15,6, $m->arrondie($mouvement['red_formu']),'LB','','R');
			$pdf->Cell(19,6, $m->arrondie($mouvement['red_assantinc']),'LB','','R');
			$pdf->Cell(17,6, $m->arrondie($mouvement['red_surete']),'LB','','R');
			$pdf->Cell(14,6, $m->arrondie($mouvement['red_securite']),'LBR','','R');
			
			$pdf->Ln();	
			$pdf->SetFont('Arial','B',7);			
			$pdf->Cell(10,7, "",'','','C'); 
				
			$pdf->Cell(12,6, $m->arrondie($mouvement['tot_red_rout']),'','','R');
			$pdf->Cell(16,6, $m->arrondie($mouvement['tot_red_att']),'','','R');
			$pdf->Cell(16,6, $m->arrondie($mouvement['tot_red_bal']),'','','R');
			$pdf->Cell(12,6, $m->arrondie($mouvement['tot_red_fret']),'','','R');
			$pdf->Cell(15,6, $m->arrondie($mouvement['tot_red_pass']),'','','R');
			$pdf->Cell(15,6, $m->arrondie($mouvement['tot_red_pec']),'','','R');
			$pdf->Cell(15,6, $m->arrondie($mouvement['tot_red_stat']),'','','R');
			$pdf->Cell(21,6, $m->arrondie($mouvement['tot_red_compt']),'','','R');
			$pdf->Cell(15,6, $m->arrondie($mouvement['tot_red_formu']),'','','R');
			$pdf->Cell(19,6, $m->arrondie($mouvement['tot_red_assantinc']),'','','R');
			$pdf->Cell(17,6, $m->arrondie($mouvement['tot_red_surete']),'','','R');
			$pdf->Cell(14,6, $m->arrondie($mouvement['tot_red_securite']),'','','R');
			
			
			$pdf->Ln();$pdf->Ln();
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(25,7, "Au Taux de : ".$mouvement['taux'][0]['Usd_fc'],'','','C');
			
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);
			
			$pdf->Cell(40,7,"Montant hors taxe en $ US : ",'LTB','','C');	
			$pdf->Cell(20,7, $m->arrondie($mouvement['tot_sans_tva']),'RTB','','R');	
			$pdf->Cell(30,7,utf8_decode("Equivalent à : "),'','','C');
			//$pdf->Cell(70,7,$m->arrondie(($mouvement['tot_sans_tva'])*$taux[0]['Usd_fc']).' FC','LTBR','','C');
			$pdf->Cell(70,7,($mouvement["tot_sans_tva_fc"]).' FC','LTBR','','C');
			$pdf->Ln();
			$pdf->Ln();
			
			$pdf->Cell(40,7,"TVA : ",'LTB','','C');	
			$pdf->Cell(20,7, $m->arrondie($mouvement['tva']),'RTB','','R');	
			$pdf->Cell(30,7,utf8_decode("Equivalent à : "),'','','C');
			$pdf->Cell(70,7, $m->arrondie($mouvement['tva_fc']).' FC','LTBR','','C');
			
			$pdf->Ln();
			$pdf->Ln();
			
			$pdf->Cell(40,7,"Total toutes taxes comprises : ",'LTB','','C');	
			$pdf->Cell(20,7, $m->arrondie($mouvement['tot_avec_tva']),'RTB','','R');	
			$pdf->Cell(30,7,utf8_decode("Equivalent à : "),'','','C');
			$pdf->Cell(70,7, $m->arrondie(ceil($mouvement['tot_avec_tva_fc']))." FC",'LTBR','','C');
			
			$pdf->Ln();
			$pdf->Ln();
			
			//********************************   CALCUL IDF   **********************
			if($mouvement['ta'][0]['Type_mouv']=="I")
			{
				//$fret_a=$mouvement['red_fret_a']*$mouvement['ttarif']['Redfr_res_int'];
				$fret_a=$mouvement['red_fret_a'];
				$fret_a=0;
			}else
			{
				//$fret_a=$mouvement['red_fret_a']*$mouvement['ttarif']['Redfr_res_nat'];
				$fret_a=$mouvement['red_fret_a'];
			}
			
			if($mouvement['td'][0]['Type_mouv']=="I")
			{
				//$fret_d=$mouvement['red_fret_d']*$mouvement['ttarif']['Redfr_res_int'];
				$fret_d=$mouvement['red_fret_d'];
				$fret_d=0;
			}else
			{
				//$fret_d=$mouvement['red_fret_d']*$mouvement['ttarif']['Redfr_res_nat'];
				$fret_d=$mouvement['red_fret_d'];
			}
			
			$fret_d=$mouvement['red_fret_d'];
			$fret_total=$fret_a+$fret_d;
			$fret_total_fc=$fret_total*$mouvement['taux'][0]['Usd_fc'];
			$idf=(ceil($fret_total));
			$idf_fc=$idf*$mouvement['taux'][0]['Usd_fc'];
			//******************************************************
			
			$pdf->Ln();
			$pdf->Ln();
			
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(20,7,utf8_decode("       EN TOUTE LETTRE"),'','','C');
				
			$pdf->Ln();
			$lettre=new ChiffreEnLettre();
			//$tot_avec_tva=explode(",", $m->arrondie($tot_avec_tva));
			
			//$tot_avec_tva=$tot_avec_tva[0]+1;
 			$v=$lettre->Conversion(($mouvement['tot_avec_tva']));
			str_replace("deux","deux ",$v);
			$pdf->Cell(180,7,'Dollars americains, '.str_replace("deux","deux ",$v),'','','L');	
			
			$pdf->Ln();	
			//$v=$lettre->Conversion(($mouvement['tot_avec_tva_fc']));
			$v=$lettre->Conversion(ceil($mouvement['tot_avec_tva_fc']));
			$pdf->Cell(180,7,'Francs congolais, '.$v,'','','L');				
	//************************ FIN FACTURE
			$pdf->Ln(10);
			$pdf->SetFont('Arial','BI',7);
			$pdf->Cell(50,7,'','','','L');
			$pdf->Cell(100,7,'FACTURE PAYABLE CASH A LA PERCEPTION CENTRALE','','','L');	
			
			$pdf->Ln();
			$pdf->Cell(50,7,'','','','L');
			$pdf->Cell(100,7,"DE L'AEROPORT INTERNATIONAL DE LA LUANO",'','','L');	

			$pdf->Ln(15);	
			$pdf->SetFont('Arial','B',7);
			@session_start();
			$id_us=$_SESSION['Idd'];
			$user=$m->user($mouvement['ta'][0]['Us']);
			$pdf->Cell(180,7,'TAXATEUR : '.$user['nom']."  ".$user['matr'],'','','R');
	
 	
	$pdf->Text(20, 265, utf8_decode("Copyright Division commerciale"));
	
	//==================== INSERT DANS LA TABLE DES FACTURES IMPRIMEES==================
		$taux=$mouvement['taux'][0]['Usd_fc'];
		$montant=$mouvement['tot_sans_tva'];
		$tva=$mouvement['tva'];
		$heure=date("H:i:s");
		
		/*$s="insert into facture_imprime values ('','$dt','$heure','$num','$num_mouv','$num_facture','$montant','$tva','$taux','R','O','$id_us')";
		$m->cnx->query($s);*/
	//==================================================================================
//=========================================== FACTURE IDF =================================================
if($mouvement['tot_red_fret']>0)
{
	$pdf->AddPage();
	$pdf->SetLeftMargin(5);
	$pdf->SetTopMargin(20);
	$pdf->SetFont('Arial','B',11);
	$pdf->Image('../../../images/entete_pdf.png',73,15,60,20);
	
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
			//$num_facture=$num_mouv."/RDA.FZQA/".date('n.Y');
			$pdf->Cell(169,7, utf8_decode("LUBUMBASHI ".date('d/m/Y H:i:s')),'','','R'); 
			$pdf->Ln();
			$pdf->SetFont('Arial','BU',11);
						
			//=========================================INSERTION DU N° DE LA FACTURE
			
				$reqfact="select * from rva_facturation2.facture_imprime order by Id_fact desc"; 
				$efact=$m->cnx->query($reqfact); 
				$tfact=$efact->fetchAll();
				$nfact=count($tfact); 
				$num_long_act=0;
				if($nfact==0)
				{
					$num=1;
				}else
				{
					$num=$tfact[0]['N_ordre']+2;
				}
				
					$num=$m->format_nbre($num);
					
				$s="select * from rva_facturation2.facture_imprime where Mouv='$num_mouv' and Statut='I' order by Id_fact desc"; 
				$e=$m->cnx->query($s); $t=$e->fetchAll();
				$num=$t[0]['N_ordre']+1;
				$num_facture=$t[0]['Num_facture'];				
			
			//=============================================================
			$pdf->Cell(183,7, utf8_decode(str_replace("'","",("FACTURE CASH N° ".$num_facture))),'','','C'); 
			
			$pdf->SetFont('Arial','B',8);
			$pdf->Ln(15);
			$pdf->Cell(153,7, utf8_decode("NOM    : ".$mouvement['nom_cli']."       CODE : ".$ta[0]['Code_cl']),'','','L'); 
			$pdf->Ln();
			$pdf->Cell(153,7, utf8_decode("ADRESSE : ".$ta[0]['Adresse_cl']),'','','L');  
			
			$pdf->SetFont('Arial','',8);
			$pdf->Ln();
			$pdf->Cell(203,5,utf8_decode("I.MOUVEMENTS EFFECTUES PAR  IMMAT : ".$ta[0]['Code_imm']."   TYPE  : ".$ta[0]['Libelle_typ']."   N° FORMULAIRE : ".$mouvement['num_form']),'LRT','LRT','C');
			
			$pdf->Ln();
			$pdf->Cell(203,5,"POIDS : ".$ta[0]['Poids']."T  SUR AEROPORT INTERNATIONAL DE LA LUANO",'l+LBR','','C');
				
			$pdf->Ln();	
			$pdf->SetFont('Arial','B',7);			
			$pdf->Cell(9,6, "SENS",'LB','','C');  
			$pdf->Cell(14,6, "DATE",'LB','','C');
			$pdf->Cell(11,6, "HEURE",'LB','','C');
			$pdf->Cell(12,6, "ESCALE",'LB','','C');
			$pdf->Cell(12,6, "ADULTE",'LB','','C');
			$pdf->Cell(12,6, "ENFANT",'LB','','C');
			$pdf->Cell(12,6, "BEBE",'LB','','C');
			$pdf->Cell(12,6, "PEC",'LB','','C');
			$pdf->Cell(20,6, "PAX TRANS",'LB','','C');
			$pdf->Cell(17,6, "FRET LOC",'LB','','C');
			$pdf->Cell(17,6, "FRET TRA",'LB','','C');
			$pdf->Cell(17,6, "FRET PTT",'LB','','C');
			$pdf->Cell(18,6, "BALISAGE",'LB','','C');
			$pdf->Cell(20,6, "STATIONN",'LRB','','C');
			
			$s="select * from rva_facturation2.escale,rva_facturation2.pt_emplacement where escale.Prov_dest=Pt_emplacement.Id_pt and Sens='A' and Id_mouv='$num_mouv'"; 
			$e=$m->cnx->query($s); 
			$t=($e->fetchAll());
			$total_fret_arr=0;
			foreach($t as $row)
			{
				$total_fret_arr=$total_fret_arr+$row['Loc'];		
				$pdf->Ln();	
				$pdf->SetFont('Arial','',7);			
				$pdf->Cell(9,6, "A",'L','','C');  
				$pdf->Cell(14,6, $m->Datemysqltofr($mouvement['ta'][0]['Date_mouv']),'L','','L');
				$pdf->Cell(11,6, $m->Heureformat($mouvement['ta'][0]['Heure_mouv']),'L','','R');
				$pdf->Cell(12,6, $row['Code_pt'],'L','','C');
				$pdf->Cell(12,6, $row['Ad'],'L','','R');
				$pdf->Cell(12,6, $row['Ch'],'L','','R');
				$pdf->Cell(12,6, $row['Inf'],'L','','R');
				$pdf->Cell(12,6, $row['Pec'],'L','','R');
				$pdf->Cell(20,6, $row['Tra'],'L','','R');
				$pdf->Cell(17,6, $row['Loc'],'L','','R');
				$pdf->Cell(17,6, $row['Trat'],'L','','R');
				$pdf->Cell(17,6, $row['Ptt'],'L','','R');
				$pdf->Cell(18,6, $mouvement['balisage_a'],'L','','C');
				$pdf->Cell(20,6, "",'LR','','L');
			}
			
			if($mouvement['td'][0]['Type_mouv']=='I')
			{
				$s="select * from rva_facturation2.escale,rva_facturation2.pt_emplacement where escale.Prov_dest=Pt_emplacement.Id_pt and Sens='D' and Id_mouv='$num_mouv'"; 
			}else
			{
				$s="select * from rva_facturation2.escale,rva_facturation2.pt_emplacement where escale.Pt_ent=Pt_emplacement.Id_pt and Sens='D' and Id_mouv='$num_mouv'"; 
			}
			$e=$m->cnx->query($s); $t=($e->fetchAll());
			$total_fret_dep=0;
			foreach($t as $row)
			{
				$total_fret_dep=$total_fret_dep+$row['Loc'];
				$pdf->Ln();	
				$pdf->SetFont('Arial','',7);			
				$pdf->Cell(9,6, "D",'L','','C');  
				$pdf->Cell(14,6, $m->Datemysqltofr($mouvement['td'][0]['Date_mouv']),'L','','L');
				$pdf->Cell(11,6, $m->Heureformat($mouvement['td'][0]['Heure_mouv']),'L','','R');
				$pdf->Cell(12,6, $row['Code_pt'],'L','','C');
				$pdf->Cell(12,6, $row['Ad'],'L','','R');
				$pdf->Cell(12,6, $row['Ch'],'L','','R');
				$pdf->Cell(12,6, $row['Inf'],'L','','R');
				$pdf->Cell(12,6, $row['Pec'],'L','','R');
				$pdf->Cell(20,6, $row['Tra'],'L','','R');
				$pdf->Cell(17,6, $row['Loc'],'L','','R');
				$pdf->Cell(17,6, $row['Trat'],'L','','R');
				$pdf->Cell(17,6, $row['Ptt'],'L','','R');
				$pdf->Cell(18,6, $mouvement['balisage_d'],'L','','C');
				$pdf->Cell(20,6, $mouvement['stat_d'],'LR','','C');
			}
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
				$pdf->Cell(38,0, "",'RB','','C');
	//=================== 2e Tableau====================================
			if($mouvement['ta'][0]['Type_mouv']=='I')
			{
				$tarif_arr=$ttarif[0]['Redfr_res_int_idf_deb'];
			}else
			{
				$tarif_arr=0;
			}
			
			if($mouvement['td'][0]['Type_mouv']=='I')
			{
				$tarif_dep=$ttarif[0]['Redfr_res_int_idf_emb'];
			}else{
				$tarif_dep=$ttarif[0]['Redfr_res_nat_idf_emb'];
			}
			
			$idf_fret_arr=$total_fret_arr*$tarif_arr;
			$idf_fret_dep=$total_fret_dep*$tarif_dep;
			$pdf->Ln();
			$pdf->SetFont('Arial','B',8);	
			$pdf->Cell(190,7, "II.REDEVANCES A PAYER",'','','C');
			$pdf->Ln();	
			$pdf->SetFont('Arial','B',7);			
			$pdf->Cell(10,6, "SENS",'TLB','','C');  
			$pdf->Cell(35,6, "REDEVANCE IDF FRET",'TLBR','','C');
			$pdf->Ln();
			$pdf->Cell(10,6, "A",'LR','','C');
			$pdf->Cell(35,6, $m->arrondie($idf_fret_arr),'LR','','C');
			$pdf->Ln();
			$pdf->Cell(10,6, "D",'LB','','C');
			$pdf->Cell(35,6, $m->arrondie($idf_fret_dep),'LBR','','C');
			$pdf->Ln();
			$total_idf_fret=$idf_fret_arr+$idf_fret_dep;
			
			$pdf->Cell(10,6, "",'','','C');
			$pdf->Cell(35,6, $m->arrondie(ceil($total_idf_fret)),'','','C');
			
			
			$pdf->Ln();	
			$pdf->SetFont('Arial','B',7);			
			$pdf->Cell(10,7, "",'','','C'); 
				
						
			$pdf->Ln();$pdf->Ln();
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(25,7, "Au Taux de : ".$mouvement['taux'][0]['Usd_fc'],'','','C');
			
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);
			
			$pdf->Cell(40,7,"Montant hors taxe en $ US : ",'LTB','','C');	
			$pdf->Cell(20,7, $m->arrondie(0),'RTB','','R');	
			$pdf->Cell(30,7,utf8_decode("Equivalent à : "),'','','C');
			$pdf->Cell(70,7, $m->arrondie(0).' FC','LTBR','','C');
			
			$pdf->Ln();
			$pdf->Ln();
			
			$pdf->Cell(40,7,"TVA : ",'LTB','','C');	
			$pdf->Cell(20,7, $m->arrondie(0),'RTB','','R');	
			$pdf->Cell(30,7,utf8_decode("Equivalent à : "),'','','C');
			$pdf->Cell(70,7, $m->arrondie(0).' FC','LTBR','','C');
			
			$pdf->Ln();
			$pdf->Ln();
			
			$pdf->Cell(40,7,"Total toutes taxes comprises : ",'LTB','','C');	
			$pdf->Cell(20,7, $m->arrondie(ceil($total_idf_fret)),'RTB','','R');	
			$pdf->Cell(30,7,utf8_decode("Equivalent à : "),'','','C');
			$pdf->Cell(70,7, $m->arrondie(ceil($total_idf_fret)*$mouvement['taux'][0]['Usd_fc'])." FC",'LTBR','','C');
			
			$pdf->Ln();
			$pdf->Ln();
			
			//********************************   CALCUL IDF   **********************
			if($mouvement['ta'][0]['Type_mouv']=="I")
			{
				//$fret_a=$mouvement['red_fret_a']*$mouvement['ttarif']['Redfr_res_int'];
				$fret_a=$mouvement['red_fret_a'];
				$fret_a=0;
			}else
			{
				//$fret_a=$mouvement['red_fret_a']*$mouvement['ttarif']['Redfr_res_nat'];
				$fret_a=$mouvement['red_fret_a'];
			}
			
			if($mouvement['td'][0]['Type_mouv']=="I")
			{
				//$fret_d=$mouvement['red_fret_d']*$mouvement['ttarif']['Redfr_res_int'];
				$fret_d=$mouvement['red_fret_d'];
				$fret_d=0;
			}else
			{
				//$fret_d=$mouvement['red_fret_d']*$mouvement['ttarif']['Redfr_res_nat'];
				$fret_d=$mouvement['red_fret_d'];
			}
			
			$fret_d=$mouvement['red_fret_d'];
			$fret_total=$fret_a+$fret_d;
			$fret_total_fc=$fret_total*$mouvement['taux'][0]['Usd_fc'];
			$idf=(ceil($fret_total));
			$idf_fc=$idf*$mouvement['taux'][0]['Usd_fc'];
			//******************************************************
			
			$pdf->Ln();
			$pdf->Ln();
			
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(20,7,utf8_decode("       EN TOUTE LETTRE"),'','','C');
				
			$pdf->Ln();
			$lettre=new ChiffreEnLettre();
			//$tot_avec_tva=explode(",", $m->arrondie($tot_avec_tva));
			
			//$tot_avec_tva=$tot_avec_tva[0]+1;
			
 			$v=$lettre->Conversion(ceil($total_idf_fret));
			str_replace("deux","deux ",$v);
			$pdf->Cell(180,7,'Dollars americains, '.utf8_decode(str_replace("deux","deux ",$v)),'','','L');	
			
			$pdf->Ln();	
			//$v=$lettre->Conversion(($mouvement['tot_avec_tva_fc']));
			$v=$lettre->Conversion(ceil($total_idf_fret)*$mouvement['taux'][0]['Usd_fc']);
			$pdf->Cell(180,7,'Francs congolais, '.$v,'','','L');				
	//************************ FIN FACTURE
			$pdf->Ln(10);
			$pdf->SetFont('Arial','BI',7);
			$pdf->Cell(50,7,'','','','L');
			$pdf->Cell(100,7,'FACTURE PAYABLE CASH A LA PERCEPTION CENTRALE','','','L');	
			
			$pdf->Ln();
			$pdf->Cell(50,7,'','','','L');
			$pdf->Cell(100,7,"DE L'AEROPORT INTERNATIONAL DE LA LUANO",'','','L');	

			$pdf->Ln(15);	
			$pdf->SetFont('Arial','B',7);
			@session_start();
			$id_us=$_SESSION['Idd'];
			$user=$m->user($mouvement['ta'][0]['Us']);
			$pdf->Cell(180,7,'TAXATEUR : '.$user['nom']."  ".$user['matr'],'','','R');
	
 	
	$pdf->Text(20, 265, utf8_decode("Copyright Division commerciale"));	
	
	
	//============== insertion dans sql=========================
	//$m->cnx->query("insert into facture_imprime values('','$dt','$heure','$num','$num_mouv','$num_facture','$fret_total',0,'$taux','I','O','$id_us')");
}
//=========================================================================================================


	$pdf->Output();
}
?>
