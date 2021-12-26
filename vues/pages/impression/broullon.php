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
	$pdf->SetTopMargin(1);
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
				group by Num_mouv";
			$e=mysqli_query($bdd,$s); $t=mysqli_fetch_array($e); $n=mysqli_num_rows($e);
	//=============================== CONTENU DU TABLEAU=================================
			$pdf->Ln();
			
			if($n!==0)
			{
				$m=mouv($t['Num_mouv'],$bdd);
				$libelle_typ=$m['ta']['Libelle_typ'];
				$pdf->Cell(5,1, utf8_decode("IMMATRICULATION : ".$m['ta']['Code_imm']),'','','C'); 
				$pdf->Cell(9,1, utf8_decode("TYPE D'AVION : ".$m['ta']['Libelle_typ']),'','','C'); 
				$pdf->Cell(9,1, utf8_decode("POIDS MAX. AU DECOLLAGE : ".$m['ta']['Mtow']),'','','C'); 
				$pdf->Ln();

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
				//=========================================================
				do
				{
					$mouvement=mouv($t['Num_mouv'],$bdd);
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
					//================================================
						//$pdf->Cell(3,1, utf8_decode("jjj"),'','','C'); 
					if($libelle_typ!==$mouvement['ta']['Libelle_typ'])
					{
						continue;
						$pdf->Ln();
						$pdf->Cell(90,1, utf8_decode("IMMATRICULATION : ".$mouvement['ta']['Code_imm']),'','','C'); 
						$pdf->Cell(90,1, utf8_decode("TYPE D'AVION : ".$mouvement['ta']['Libelle_typ']),'','','C'); 
						$pdf->Cell(90,1, utf8_decode("POIDS MAX. AU DECOLLAGE : ".$mouvement['ta']['Mtow']),'','','C'); 
						$libelle_typ=$mouvement['ta']['Libelle_typ'];
						$pdf->Ln();
						$pdf->Cell(2.8,1, utf8_decode(Datemysqltofr($mouvement['ta']['Date_mouv'])),'TRBL','','C'); 
						$pdf->Cell(2,1, utf8_decode(($mouvement['ta']['Heure_mouv'])),'TRBL','','C');
						$pdf->Cell(2,1, utf8_decode($ta['Code_pt']),'TRBL','','C');
						$pdf->Cell(2,1, utf8_decode("FZQA"),'TRBL','','C');
						$pdf->Cell(1.25,1, utf8_decode($tescale_a['Ad']),'TRBL','','C');
						$pdf->Cell(1.25,1, utf8_decode($tescale_a['Ch']),'TRBL','','C');
						$pdf->Cell(1.25,1, utf8_decode($tescale_a['Inf']),'TRBL','','C');
						$pdf->Cell(1.25,1, utf8_decode($tescale_a['Pec']),'TRBL','','C');
						$pdf->Cell(2,1, utf8_decode($tescale_a['Loc']),'TRBL','','C');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['red_route_a'])),'TRBL','','C');
						$pdf->Cell(1.6,1, utf8_decode(""),'TRBL','','C');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_bal'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_fret'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_pass'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_stat'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_surete'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_securite'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_formu'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_compt'])),'TRBL','','R');
						$pdf->Cell(1.61,1, utf8_decode(arrondie($mouvement['tot_red_assantinc'])),'TRBL','','R');
				
						$pdf->Cell(2.7,1, utf8_decode(arrondie($mouvement['tot_sans_tva'])),'TRBL','','R');
						$pdf->Ln();	
						$pdf->Cell(2.8,1, utf8_decode(Datemysqltofr($mouvement['td']['Date_mouv'])),'TRBL','','C'); 
						$pdf->Cell(2,1, utf8_decode(($mouvement['td']['Heure_mouv'])),'TRBL','','C');
						$pdf->Cell(2,1, utf8_decode("FZQA"),'TRBL','','C');
						$pdf->Cell(2,1, utf8_decode($td['Code_pt']),'TRBL','','C');
						$pdf->Cell(1.25,1, utf8_decode($tescale_d['Ad']),'TRBL','','R');
						$pdf->Cell(1.25,1, utf8_decode($tescale_d['Ch']),'TRBL','','R');
						$pdf->Cell(1.25,1, utf8_decode($tescale_d['Inf']),'TRBL','','R');
						$pdf->Cell(1.25,1, utf8_decode($tescale_d['Pec']),'TRBL','','R');
						$pdf->Cell(2,1, utf8_decode($tescale_d['Loc']),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['red_route_d'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['red_att'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_bal'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_fret'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_pass'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_stat'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_surete'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_securite'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_formu'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_compt'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_assantinc'])),'TRBL','','R');
						
						$pdf->Cell(2.7,1, utf8_decode(arrondie($mouvement['tot_sans_tva'])),'TRBL','','R');
						$pdf->Ln();	
					}else
					{
						$pdf->Cell(2.8,1, utf8_decode(Datemysqltofr($mouvement['ta']['Date_mouv'])),'TRBL','','C'); 
						$pdf->Cell(2,1, utf8_decode(($mouvement['ta']['Heure_mouv'])),'TRBL','','C');
						$pdf->Cell(2,1, utf8_decode($ta['Code_pt']),'TRBL','','C');
						$pdf->Cell(2,1, utf8_decode("FZQA"),'TRBL','','C');
						$pdf->Cell(1.25,1, utf8_decode($tescale_a['Ad']),'TRBL','','R');
						$pdf->Cell(1.25,1, utf8_decode($tescale_a['Ch']),'TRBL','','R');
						$pdf->Cell(1.25,1, utf8_decode($tescale_a['Inf']),'TRBL','','R');
						$pdf->Cell(1.25,1, utf8_decode($tescale_a['Pec']),'TRBL','','R');
						$pdf->Cell(2,1, utf8_decode($tescale_a['Loc']),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['red_route_a'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_att'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_bal'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_fret'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie(0)),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_stat'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_surete'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_securite'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_formu'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['tot_red_compt'])),'TRBL','','R');
						$pdf->Cell(1.61,1, utf8_decode(arrondie($mouvement['tot_red_assantinc'])),'TRBL','','R');
						$total_ligne=$mouvement['red_route_a']+$mouvement['tot_red_att']+$mouvement['red_bal_a']+$mouvement['red_fret_a']+$mouvement['red_pass_a']+$mouvement['red_stat']+$mouvement['red_surete']+$mouvement['red_securite']+$mouvement['red_formu']+$mouvement['red_compt']+$mouvement['red_assantinc'];
						
						$pdf->Cell(2.7,1, utf8_decode(arrondie($total_ligne)),'TRBL','','R');
						$pdf->Ln();	
						$pdf->Cell(2.8,1, utf8_decode(Datemysqltofr($mouvement['td']['Date_mouv'])),'TRBL','','C'); 
						$pdf->Cell(2,1, utf8_decode(($mouvement['td']['Heure_mouv'])),'TRBL','','C');
						$pdf->Cell(2,1, utf8_decode("FZQA"),'TRBL','','C');
						$pdf->Cell(2,1, utf8_decode($ta['Code_pt']),'TRBL','','C');
						$pdf->Cell(1.25,1, utf8_decode($tescale_d['Ad']),'TRBL','','R');
						$pdf->Cell(1.25,1, utf8_decode($tescale_d['Ch']),'TRBL','','R');
						$pdf->Cell(1.25,1, utf8_decode($tescale_d['Inf']),'TRBL','','R');
						$pdf->Cell(1.25,1, utf8_decode($tescale_d['Pec']),'TRBL','','R');
						$pdf->Cell(2,1, utf8_decode($tescale_d['Loc']),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['red_route_d'])),'TRBL','','R');
						$pdf->Cell(1.6,1, "",'TRBL','','C');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['red_bal_d'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['red_fret_d'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['red_pass_d'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie(0)),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['red_surete'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['red_securite'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['red_formu'])),'TRBL','','R');
						$pdf->Cell(1.6,1, utf8_decode(arrondie($mouvement['red_compt'])),'TRBL','','R');
						$pdf->Cell(1.61,1, utf8_decode(arrondie($mouvement['red_assantinc'])),'TRBL','','R');
						$total_ligne=$mouvement['red_route_d']+$mouvement['red_bal_d']+$mouvement['red_fret_d']+$mouvement['red_pass_d']+$mouvement['red_stat']+$mouvement['red_surete']+$mouvement['red_securite']+$mouvement['red_formu']+$mouvement['red_compt']+$mouvement['red_assantinc'];
						$pdf->Cell(2.7,1, utf8_decode(arrondie($total_ligne)),'TRBL','','R');
						$pdf->Ln();	
					}
						$route=$route+$mouvement['tot_red_rout'];
						$atterrissage=$atterrissage+$mouvement['tot_red_att'];
						$bal=$bal+$mouvement['tot_red_bal'];
						$fret=$fret+$mouvement['tot_red_fret'];
						$pax=$pax+$mouvement['tot_red_pass'];
						$pec=$pec+$mouvement['tot_red_pec'];
						$stat=$stat+$mouvement['tot_red_stat'];
						$surete=$surete+$mouvement['tot_red_surete'];
						$securite=$securite+$mouvement['tot_red_securite'];
						$formu=$formu+$mouvement['tot_red_formu'];;
						$compt=$compt+$mouvement['tot_red_compt'];;
						$ass=$ass+$mouvement['tot_red_assantinc'];;
						$tot_l=$tot_l+($route+$atterrissage+$bal+$fret+$pax+$pec+$stat+$surete+$securite+$formu+$compt+$ass);
						
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
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(10.05,1.2, "",'','','C');
				$pdf->Cell(5.75,1.2, "TOT.RES INTER. US $",'TRBL','','L');
				$pdf->Cell(1.6,1.2, arrondie($route),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($atterrissage),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($bal),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($fret),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($pax),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($stat),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($surete),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($securite),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($formu),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($compt),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($ass),'RBL','','R');
				$pdf->Cell(2.7,1.2, arrondie($tot_l),'RBL','','R');
				$pdf->Ln();		
				$pdf->Cell(10.05,1.2, "",'','','C');
				$pdf->Cell(5.75,1.2, "TOT.RES NAT. US $",'TRBL','','L');
				$pdf->Cell(1.6,1.2, "",'RBL','','R');
				$pdf->Cell(1.6,1.2, "",'RBL','','R');
				$pdf->Cell(1.6,1.2, "",'RBL','','R');
				$pdf->Cell(1.6,1.2, "",'RBL','','R');
				$pdf->Cell(1.6,1.2, "",'RBL','','R');
				$pdf->Cell(1.6,1.2, "",'RBL','','R');
				$pdf->Cell(1.6,1.2, "",'RBL','','R');
				$pdf->Cell(1.6,1.2, "",'RBL','','R');
				$pdf->Cell(1.6,1.2, "",'RBL','','R');
				$pdf->Cell(1.6,1.2, "",'RBL','','R');
				$pdf->Cell(1.6,1.2, "",'RBL','','R');
				$pdf->Cell(2.7,1.2, "",'RBL','','R');
				$pdf->Ln();
				$pdf->Cell(10.05,1.2, "",'','','C');
				$pdf->Cell(5.75,1.2, "TOTAL TVA $",'TRBL','','L');
				$pdf->Cell(1.6,1.2, "",'RBL','','R');
				$pdf->Cell(1.6,1.2, "",'RBL','','L');
				$pdf->Cell(1.6,1.2, "",'RBL','','L');
				$pdf->Cell(1.6,1.2, "",'RBL','','L');
				$pdf->Cell(1.6,1.2, "",'RBL','','L');
				$pdf->Cell(1.6,1.2, "",'RBL','','L');
				$pdf->Cell(1.6,1.2, "",'RBL','','L');
				$pdf->Cell(1.6,1.2, "",'RBL','','L');
				$pdf->Cell(1.6,1.2, "",'RBL','','L');
				$pdf->Cell(1.6,1.2, "",'RBL','','L');
				$pdf->Cell(1.6,1.2, "",'RBL','','C');
				$pdf->Cell(2.7,1.2, "",'RBL','','C');
				$pdf->Ln();
				$pdf->Cell(10.05,1.2, "",'','','C');
				$pdf->Cell(5.75,1.2, "TOTAL CLIENT US $",'TRBL','','L');
				$pdf->Cell(1.6,1.2, arrondie($route),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($atterrissage),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($bal),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($fret),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($pax),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($stat),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($surete),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($securite),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($formu),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($compt),'RBL','','R');
				$pdf->Cell(1.6,1.2, arrondie($ass),'RBL','','R');
				$pdf->Cell(2.7,1.2, arrondie(ceil($tot_l)),'RBL','','R');
				
				$pdf->Ln(2);
				$pdf->Cell(10,1.2, "LE CHEF DE SERVICE FACTURATION",'','','C');
				$pdf->Cell(10,1.2, "",'','','C');
				$pdf->Cell(10,1.2, "LE CHEF DE DIVISION COMMERCIALE",'','','C');
				$pdf->Ln(1);
				$pdf->Cell(10,1.2, "BABY BAMBA MAKABI",'','','C');
				$pdf->Cell(10,1.2, "",'','','C');
				$pdf->Cell(10,1.2, "JEAN CLAUDE KASONGO MUTOMBO",'','','C');
			}else
			{
			
				$pdf->Cell(80,1.2, ($client),'TRBL','','C'); 
			}
			
//================ REDEVANCES AER===========================================================	
			
//==================================== TOTALITE DU BORDEREAU===============================================	
			
			
			
			
$pdf->Output();



?>
