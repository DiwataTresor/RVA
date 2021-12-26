<?php
	@session_start();
	$dt1=$_GET["dt"];
	$cl=$_GET["client"];
	$dt2=$_GET["dt2"];
	
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../manager/bd/cnx.php');
	$client=client($cl,$bdd);

	class PDF extends FPDF
	{
	
	}
	$taille=array(290,300);
	$pdf = new PDF('P','mm',"A4");
	$pdf->AliasNbPages();
	
	$pdf->SetLeftMargin(15);
	$pdf->SetTopMargin(20);
	/*$pdf->Text(20, 275, utf8_decode("N° IMPOT : A1201438C"));*/
			//======================== TRAITEMENT DONNEES====================		
				$snum_fact="select * from num_facture_agree"; 
				$enum_fact=mysqli_query($bdd,$snum_fact); 
				$tnum_fact=mysqli_fetch_array($enum_fact);
				$num_fact=$tnum_fact['Num'];		
				$s="select * from mouvement2,client,immatriculation 
					where 
						mouvement2.Immatr=immatriculation.Id_imm
					and
						immatriculation.Code_pr=client.Id_cl
					and
						client.Id_cl='$cl'
					and	
						Date_mouv between '$dt1' and '$dt2'
					group by Num_mouv";
				$e=mysqli_query($bdd,$s); $n=mysqli_num_rows($e);
				$t=mysqli_fetch_array($e);
				$r=array();
				//============================================================
					$route=0;
					$atterissage=0;
					$bal=0;
					$stationnement=0;
					$fret=0;
					$passager=0;
					$pec=0;
					$surete=0;
					$securite=0;
					$ass=0;
					$formu=0;
					$compt=0;
				//==================
				if($n==0){$r[]=array("n"=>0);}
				else
				{
					$nb=array("n"=>1);
					do
					{
						$mouvement=mouv($t['Num_mouv'],$bdd);
						$route=$route+$mouvement['tot_red_rout'];
						$bal=$bal+$mouvement['tot_red_bal'];
						$atterissage=$atterissage+$mouvement['tot_red_att'];
						$stationnement=$stationnement+$mouvement['tot_red_stat'];
						$fret=$fret+$mouvement['tot_red_fret'];
						$passager=$passager+$mouvement['tot_red_pass'];
						$pec=$pec+$mouvement['tot_red_pec'];
						$surete=$surete+$mouvement['tot_red_surete'];
						$securite=$securite+$mouvement['tot_red_securite'];
						$ass=$ass+$mouvement['tot_red_assantinc'];
						$formu=$formu+$mouvement['red_formu'];
						$compt=$compt+$mouvement['red_compt'];
					}while($t=mysqli_fetch_array($e));
					$ligne=array("route"=>arrondie($route),
							"bal"=>arrondie($bal),
							"atterissage"=>	arrondie($atterissage),
							"stationnement"=>arrondie($stationnement),
							"fret"=>arrondie($fret),
							"passager"=>arrondie($passager),
							"pec"=>arrondie($pec),
							"surete"=>arrondie($surete),
							"securite"=>arrondie($securite),
							"ass"=>arrondie($ass),
							"formu"=>arrondie($formu),
							"compt"=>arrondie($compt),
							"tot"=>($route+$bal+$atterissage+$stationnement+$fret+$passager+$pec+$surete+$securite+$ass+$formu+$compt));
					$r=array_merge_recursive($nb,$ligne);
							//$r=array("n"=>1);
				}
	
			//==================== ENTETE ====================================
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',9);
				//$pdf->Image('../../../images/entete_pdf.png',86,15,60,20);
				$npage=$pdf->PageNo();
				
				//$pdf->Line(15, 260, 190, 260);
				//$pdf->Line(15, 70, 190, 70);
				
				$pdf->SetFont('Arial','',7);
				$pdf->Text(150, 20, "LUBUMBASHI, LE ".Date('d/m/Y'));
				$pdf->Image('../../../images/entete_pdf.png',73,15,60,20);

				$pdf->Cell(10,5, utf8_decode("REPUBLIQUE DEMOCRATIQUE DU CONGO")); $pdf->Ln();
				$pdf->Cell(10,5, utf8_decode("REGIE DES VOIES AERIENNES SA")); $pdf->Ln();
				$pdf->Cell(10,5, utf8_decode("AEROPORT INTERNATIONAL DE LA LUANO"));$pdf->Ln();
				$pdf->Cell(10,5, utf8_decode("N° TVA : A0700324 L")); $pdf->Ln();
				$pdf->Cell(10,5, utf8_decode("----------------------------------------------------------------------"));

				$pdf->Cell(183,8, utf8_decode(''),'','','C'); 
				$pdf->Ln();
				//$mouv=str_replace("'","",$num_mouv);
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(180,7, utf8_decode("FACTURE N°RVA 111.7/".$_SESSION['num_fact_agr']." /RAI/".mois_chiffre($dt2).".".annee($dt2)),'','','C'); 
				$pdf->Ln();
				$pdf->SetFont('Arial','U',10);
				$pdf->Cell(180,7, "RESEAU INTERNATIONAL",'','','C'); 
				
				$pdf->Ln();
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(180,4, utf8_decode("LA SOCIETE : ".$client['nom_cl']." NUMERO : 10212"),'','','L'); 
				$pdf->Ln();
				$pdf->Cell(180,4, utf8_decode("SISE : ".$client['adresse']." B.P : 0"),'','','L'); 
				$pdf->Ln();$pdf->Ln();
				$pdf->Cell(180,4, utf8_decode("DOIT A LA REGIE DES VOIES AERIENNES POUR L'UTILISATION DES INSTALLATIONS AEROPORTUAIRES DE LA LUANO,"),'','','L'); 
				$pdf->Ln();
				$pdf->Cell(180,4, utf8_decode("LE MONTANT DES REDEVANCES DETAILLEES COMME SUITE POUR LE MOIS DE : ".strtoupper(mois_long($dt2))." ".annee($dt1)),'','','L'); $pdf->Ln();
				$pdf->Ln(5);
			//================================================================
				$pdf->Ln();
				$pdf->Cell(100,5, "DESIGNATION",'LTRB','','C'); 
				$pdf->Cell(60,5, "MONTANT EN $ US",'LTRB','','C'); 
				$pdf->Ln();
				$pdf->Cell(100,5, "ROUTE",'LR','','L'); 
				$pdf->Cell(60,5, $r['route'],'LR','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,5, "ATTERRISSAGE",'LR','','L'); 
				$pdf->Cell(60,5, $r['atterissage'],'LR','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,5, "BALISAGE",'LR','','L'); 
				$pdf->Cell(60,5, $r['bal'],'LR','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,5, "STATIONNEMENT TARMAC",'LR','','L'); 
				$pdf->Cell(60,5, $r['stationnement'],'LR','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,5, "FRET",'LR','LR','L'); 
				$pdf->Cell(60,5, $r['fret'],'LR','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,5, "PASSAGERS",'LR','','L'); 
				$pdf->Cell(60,5, $r['passager'],'LR','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,5, "PEC",'LR','','L'); 
				$pdf->Cell(60,5, $r['pec'],'LR','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,5, "SURETE",'LR','','L'); 
				$pdf->Cell(60,5, $r['surete'],'LR','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,5, "SECURITE",'LR','','L'); 
				$pdf->Cell(60,5, $r['securite'],'LR','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,5, "ASSIS.ANTI INCENDIE",'LR','','L'); 
				$pdf->Cell(60,5, $r['ass'],'LR','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,5, "FORMULAIRE DE TRAFIC",'LR','','L'); 
				$pdf->Cell(60,5, $r['formu'],'LR','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,5, "COMPTOIRE ENREGISTREMENT",'LRB','','L'); 
				$pdf->Cell(60,5, $r['compt'],'LBR','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,5, "TOTAL FACTURE HORS TAXE",'LRB','','L'); 
				$pdf->Cell(60,5, arrondie($r['tot']),'LBR','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,5, "MONTANT TVA 16 %",'LRB','','L'); 
				$pdf->Cell(60,5, "",'LBR','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,5, "TOTAL TOUTE TAXE COMPRISE",'LRB','','L'); 
				$pdf->Cell(60,5,arrondie(ceil($r['tot'])),'LBR','','R'); 
				
				$lettre=new ChiffreEnLettre();
				//$tot_avec_tva=explode(",",arrondie($tot_avec_tva));
				
				//$tot_avec_tva=$tot_avec_tva[0]+1;
				$pdf->SetFont('Arial','',9);
				$pdf->Ln(10);
				$pdf->Cell(180,7,'Nous disons','','','L');	
				$pdf->Ln();
				$v=$lettre->Conversion(ceil($r['tot']));
				str_replace("deux","deux ",$v);
				$pdf->Cell(180,7,'Dollars americains, '.str_replace("deux","deux ",$v),'','','L');	
				$pdf->Ln(10);
				$pdf->SetFont('Arial','I',7);
				$pdf->Cell(100,4, utf8_decode("  FACTURE A REGLER INTEGRALEMENT ENDEANS 7 JOURS DE LA RECEPTION DE CELLE-CI AUX CONDITIONS SUIVANTES : "),'','','L'); 
				
				$pdf->Ln();
				$pdf->Cell(100,4, utf8_decode("- LE MONTANT DE LA FACTURE EST PAYABLE PAR VIREMENT BANCAIRE AU COMPTE NUMERO 00016-05130-01000050366-54 USD"),'','','L'); 
				$pdf->Ln();
				$pdf->Cell(100,4, utf8_decode("  AUPRES DE LA RAWBANK "),'','L'); 
				$pdf->Ln();
				$pdf->Cell(100,4, utf8_decode("- LE NON PAIEMENT DANS LE DELAI REGLEMENTAIRE ENTRAINE L'APPLICATION DES PENALITES"),'','','L'); 
				$pdf->Ln();
				$pdf->Cell(100,4, utf8_decode("  PREVUES AU CHAPITRE VI DE L'ARRETE DEPARTEMENTAL N° 85/001 DU 02/01/1985."),'','','L'); 
				$pdf->Ln();
				$pdf->Cell(100,4, utf8_decode("- TOUT PAIEMENT EFFECTUE SERA D'ABORD AFFECTE AU REGLEMENT DES PENALITES ET EN SUITE"),'','','L'); 
				$pdf->Ln();
				$pdf->Cell(100,4, utf8_decode("  LE NON PAIEMENT DANS LE DELAI REGLEMENTAIRE ENTRAINE L'APPLICATION DES PENALITES A CELLE OU CELLES "),'','','L');
				$pdf->Ln();
				$pdf->Cell(100,4, utf8_decode("  DE PLUS ANCIENNES FACTURES IMPAYES"),'','','L'); 
				$pdf->Ln();
				$pdf->Cell(100,4, utf8_decode("TOUTE RECLAMATION EST RECEVABLE ENDEANS 20 JOURS DE SA RECEPTION"),'','','L'); 
				
					$signataire=signataire($bdd);
				$pdf->Ln(20);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(120,4, utf8_decode("LE CHEF DE DIVISION COMMERCIALE"),'','','L'); 
				$pdf->Cell(80,4, utf8_decode("  LE COMMANDANT DE L'AEROPORT"),'','','L'); 
				
				$pdf->Ln(7);
				$pdf->Cell(120,4, utf8_decode($signataire['division']),'','','L'); 
				$pdf->Cell(80,4, utf8_decode("        ".$signataire['cmd']),'','','L'); 
				
				
				
				
	$pdf->Output();
?>
