<?php
	@session_start();
	$du=$_GET["du"];
	$handleur=$_GET["handleur"];
	$p_handleur=$_GET['handleur'];
	$au=$_GET["au"];
	$fact=$_GET['fact'];
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../../manager/bd/cnx.php');
	class m extends main{}
	$m=new m();
	//$client=client($cl,$bdd);

	class PDF extends FPDF
	{
	
	}
	$taille=array(290,300);
	$pdf = new PDF('P','mm',"A4");
	$pdf->AliasNbPages();
	
	$pdf->SetLeftMargin(15);
	$pdf->SetTopMargin(10);
	/*$pdf->Text(20, 275, utf8_decode("N° IMPOT : A1201438C"));*/
			//======================== TRAITEMENT DONNEES====================		
				$s="select * from rva_facturation2.handling_facturation where Handleur='$handleur' and Date_dep between '$du' and '$au'"; 
				$e=$m->cnx->query($s); 
				$t=($e->fetchAll());	
				@$handleur=$m->handling_facture($t[0]['Id_fact']);
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
				$pdf->Cell(180,7, utf8_decode("FACTURE N°RVA 111.7/"."RDHM.FZQA/".$fact."/".$m->mois_chiffre($du).".".$m->annee($au)),'','','C'); 
				$pdf->Ln(7);
				$pdf->SetFont('Arial','U',10);
				$pdf->Cell(180,7, "REDEVANCE ASSISTANCE AU SOL",'','','C'); 
				
				$pdf->Ln();
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(180,4, utf8_decode("LA SOCIETE : ".ucwords($handleur['handleur'])."                    CODE : ".$handleur['handleur_code']),'','','L'); 
				$pdf->Ln();$pdf->Ln();
				$pdf->Cell(180,4, utf8_decode("SISE : ".$handleur['adresse_handleur']."            B.P : 0"),'','','L'); 
				$pdf->Ln();$pdf->Ln();
				$pdf->MultiCell(210,4, utf8_decode("DOIT A LA REGIE DES VOIES AERIENNES POUR LA REDEVANCE D'ASSISTANCE AU SOL DES AERONEFS A L'AEROPORT INTERNATIONAL DE LUANO LE MONTANT CI-DESSOUS POUR LE MOIS DE : ".strtoupper(ucwords($m->mois_long($au)))),'','',''); 
				$pdf->Ln();
				$pdf->Ln();
			//================================================================
				$mt=0;
				foreach($t as $row)
				{
					$facture=$m->handling_facture($row['Id_fact']);
					$mt=$mt+$facture['mht'];
				}	
				$tva=$m->tva($mt);
				$mttc=$tva+$mt;
				
				$pdf->Ln();
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(100,5, "DESIGNATION DE REDEVANCE",'LTRB','','C'); 
				$pdf->Cell(60,5, "MONTANT EN DOLLARS USD",'LTRB','','C'); 
				$pdf->Ln();
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(100,8, "REDEVANCE HANDLING",'LRB','','L'); 
				$pdf->Cell(60,8, $m->arrondie($mt),'LRB','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,8, "MONTANT TVA 16%",'LRB','','L'); 
				$pdf->Cell(60,8, $m->arrondie($tva),'LRB','','R'); 
				$pdf->Ln();
				$pdf->Cell(100,8, "TOTAL MENSUEL",'LRB','','L'); 
				$pdf->Cell(60,8, $m->arrondie(ceil($mttc)),'LRB','','R'); 
				$pdf->Ln();
				
				$lettre=new ChiffreEnLettre();
				//$tot_avec_tva=explode(",",arrondie($tot_avec_tva));
				
				//$tot_avec_tva=$tot_avec_tva[0]+1;
				$pdf->SetFont('Arial','',9);
				$pdf->Ln(10);
				$pdf->Cell(180,7,'Nous disons','','','L');	
				$pdf->Ln();
				$v=$lettre->Conversion(ceil($mttc));
				str_replace("deux","deux ",$v);
				$pdf->Cell(180,7,'Dollars americains, '.str_replace("deux","deux ",$v),'','','L');	
				$pdf->Ln(10);
				$pdf->SetFont('Arial','I',7);
				$pdf->Cell(100,4, utf8_decode("  FACTURE A REGLER INTEGRALEMENT ENDEANS 10 JOURS DE LA RECEPTION DE CELLE-CI AUX CONDITIONS SUIVANTES : "),'','','L'); 
				
				$pdf->Ln();
				$pdf->MultiCell(200,4, utf8_decode("- LE TOTAL EB DOLLARS US EST PAYABLE EN FRANCS CONGOLAIS CONVERTIS AU TAUX VENDEUR DU JOUR DE PAIEMENT A LA CAISSE RECETTES DE L'AEROPORT DE LUANO EN ESPECES OU PAR VIREMENT BANCAIRE AU COMPTE DE LA REGIE NUMERO 00016-05130-01000050366-54 USD"),'','',''); 
				$pdf->Ln();
				$pdf->MultiCell(200,4, utf8_decode("- LE NON PAIEMENT DANS LE DELAI REGLEMENTAIRE ENTRAINE L'APPLICATION DES PENALITES PREVUES AU CHAPITRE VI DE L'ARRETE DEPARTEMENTAL N°85/001 DU 02 JANVIER 1985"),'','',''); 
				$pdf->Ln();
				$pdf->MultiCell(200,4, utf8_decode("- TOUT PAIEMENT EFFECTUE SERA D'ABORD AFFECTE AU REGLEMENT DES PENALITES ET EN SUITE A CELLE OU CELLES DES PLUS ANCIENNES FACTURES"),'','',''); 
				$pdf->Ln();
				$pdf->Cell(100,4, utf8_decode("TOUTE RECLAMATION EST RECEVABLE ENDEANS 20 JOURS DE SA RECEPTION"),'','','L'); 
				
				
					$signataire=$m->signataire();
				$pdf->Ln(10);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(160,4, ("FAIT A LUBUMBASHI, LE ".date('d/m/Y')),'','','R'); 
				$pdf->Ln(10);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(120,4, utf8_decode("LE CHEF DE DIVISION COMMERCIALE"),'','','L'); 
				$pdf->Cell(80,4, utf8_decode("  LE COMMANDANT DE L'AEROPORT"),'','','L'); 
				
				$pdf->Ln(7);
				$pdf->Cell(120,4, utf8_decode($signataire['division']),'','','L'); 
				$pdf->Cell(80,4, utf8_decode("        ".$signataire['cmd']),'','','L'); 
//========================================== RELEVE ================================================================================
	$pdf->AddPage('L');
	$pdf->SetFont('Arial','',7);
	$pdf->Text(220, 20, "LUBUMBASHI, LE ".Date('d/m/Y'));
	$pdf->Image('../../../images/entete_pdf.png',120,15,60,20);

	$pdf->Cell(10,5, utf8_decode("REPUBLIQUE DEMOCRATIQUE DU CONGO")); $pdf->Ln();
	$pdf->Cell(10,5, utf8_decode("REGIE DES VOIES AERIENNES SA")); $pdf->Ln();
	$pdf->Cell(10,5, utf8_decode("AEROPORT INTERNATIONAL DE LA LUANO"));$pdf->Ln();
	$pdf->Cell(10,5, utf8_decode("N° TVA : A0700324 L")); $pdf->Ln();
	$pdf->Cell(10,5, utf8_decode("----------------------------------------------------------------------"));

	$pdf->Cell(183,8, utf8_decode(''),'','','C'); 
	$pdf->Ln();
	//$mouv=str_replace("'","",$num_mouv);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(270,7, utf8_decode("RELEVE PERIODIQUE DES MOUVEMENTS VALORISES HANDLING"),'','','C'); 
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(270,7, utf8_decode("Période du : ".$m->Datemysqltofr($du)." au ".$m->Datemysqltofr($au)),'','','C'); 
	$pdf->Ln(7);
	$pdf->SetFont('Arial','B',9);
	$pdf->Ln(6);
	
	$pdf->Cell(270,7, utf8_decode("HANDLEUR : ".$handleur['handleur']."        CODE : ".$handleur['handleur_code']),'','','L'); 	
	$pdf->Ln(10);
	$pdf->Cell(25,7, utf8_decode("DATE VOL"),'TBRL','','C');	
	$pdf->Cell(35,7, utf8_decode("HEURE VOL"),'TBR','','C');	
	$pdf->Cell(40,7, utf8_decode("EXPLOITANT"),'TBR','','C');
	$pdf->Cell(30,7, utf8_decode("IMMATR"),'TBR','','C');	
	$pdf->Cell(22,7, utf8_decode("AA,AE,TT"),'TBR','','C');	
	$pdf->Cell(22,7, utf8_decode("MONT TA"),'TBR','','C');	
	$pdf->Cell(22,7, utf8_decode("MONT FA"),'TBR','','C');	
	$pdf->Cell(22,7, utf8_decode("MONT HT"),'TBR','','C');	
	$pdf->Cell(20,7, utf8_decode("TVA"),'TBR','','C');	
	$pdf->Cell(35,7, utf8_decode("MONTANT TTC"),'TBR','','C');	
				$s2="select * from rva_facturation2.handling_facturation where Handleur='$p_handleur' and Date_dep between '$du' and '$au'"; 
				$e2=$m->cnx->query($s2); 
				$row=($e2->fetchAll());
				$n2=count($row);
			$t_aa=0; $t_ta=0; $t_fa=0; $t_mht=0; $t_tva=0; $t_mttc=0;
	foreach($row as $t2)
	{
		$pdf->SetFont('Arial','',9);
		$pdf->Ln();
		$ligne=$m->handling_facture($t2['Id_fact']);
		$pdf->Cell(25,7, (($ligne['dt_dep'])),'LR','','L');	
		$pdf->Cell(35,7, ($m->Heureformat($ligne['heure_dep'])),'R','','C');	
		$pdf->Cell(40,7, utf8_decode($ligne['client']),'R','','C');
		$pdf->Cell(30,7, utf8_decode($ligne['imm']),'R','','C');	
		$pdf->Cell(22,7, $ligne['aa']." : ".$m->arrondie($ligne['aa_prix']),'R','','R');	
		$pdf->Cell(22,7, $m->arrondie($ligne['ta_prix']),'R','','R');	
		$pdf->Cell(22,7, $m->arrondie($ligne['fa_prix']),'R','','R');	
		$pdf->Cell(22,7, $m->arrondie($ligne['mht']),'R','','R');	
		$pdf->Cell(20,7, $m->arrondie($ligne['tva']),'R','','R');	
		$pdf->Cell(35,7, $m->arrondie($ligne['mttc']),'R','','R');
		$t_aa=$t_aa+$ligne['aa_prix'];
		$t_ta=$t_ta+$ligne['ta_prix'];
		$t_fa=$t_fa+$ligne['fa_prix'];
		$t_mht=$t_mht+$ligne['mht'];
		$t_tva=$t_tva+$ligne['tva'];
		$t_mttc=$t_mttc+$ligne['mttc'];
	}	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	@$ligne=$m->handling_facture($t2['Id_fact']);
	$pdf->Cell(130,9, utf8_decode("MONTANT TOTAL          "),'T','','R');	
	$pdf->Cell(22,9, $m->arrondie($t_aa),'TRBL','','R');	
	$pdf->Cell(22,9, $m->arrondie($t_ta),'TRB','','R');	
	$pdf->Cell(22,9, $m->arrondie($t_fa),'TRB','','R');	
	$pdf->Cell(22,9, $m->arrondie($t_mht),'TRB','','R');	
	$pdf->Cell(20,9, $m->arrondie($t_tva),'TRB','','R');	
	$pdf->Cell(35,9, $m->arrondie(ceil($mttc)),'TRB','','R');
	
	$pdf->Ln(20);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(200,4, utf8_decode("CHEF DE SERVICE FACTURATION"),'','','L'); 
	$pdf->Cell(80,4, utf8_decode("  CHEF DE DIVISION COMMERCIALE"),'','','L'); 
	
	$pdf->Ln(7);
	$pdf->Cell(200,4, utf8_decode($signataire['facturation']),'','','L'); 
	$pdf->Cell(80,4, utf8_decode($signataire['division']),'','','L'); 
//=========================================== FIN ================================================================================
				
	$pdf->Output();
?>
