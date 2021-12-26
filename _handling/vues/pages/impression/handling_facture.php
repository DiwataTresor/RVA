<?php
	@session_start();
	$id_us=$_SESSION['Idd'];
	$id_fact=$_REQUEST["fact"];
	
	$dt=date("Y-m-d");
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../../manager/bd/cnx.php');
	class m extends main{}
	$m=new m();
	$handling_facture=$m->handling_facture($id_fact);
	@session_start();
	$nom_user=$m->user($_SESSION['Idd']);

	
	
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
	
	$pdf->Text(10, 20, utf8_decode("REPUBLIQUE DEMOCRATIQUE DU CONGO"));
	$pdf->Text(10, 23, utf8_decode("REGIE DES VOIES AERIENNES SA"));
	$pdf->Text(10, 26, utf8_decode("AEROPORT INTERNATIONAL DE LA LUANO"));
	$pdf->Text(10, 29, utf8_decode("N° TVA : A0700324 L"));
	$pdf->Text(10, 32, utf8_decode("----------------------------------------------------------------------"));
			//=========================== CREATION N° FACTURE===============================
				$s="select * from rva_facturation2.handling_num_fact where Id_fact='$id_fact'";
				$e=$m->cnx->query($s);
				$t=($e->fetchAll());
				//$num_facture=$t['Num_fact_long'];
				$num_facture=$t[0]["Num_fact_long"];
			//===============================================================================

			$pdf->Cell(183,20, utf8_decode(''),'','','C'); 
			$pdf->Ln(5);
			//$mouv=str_replace("'","",$num_mouv);
			$pdf->Cell(199,7, utf8_decode("LUBUMBASHI ".date('d/m/Y H:i:s')),'','','R'); 
			$pdf->Ln(21);
			$pdf->SetFont('Arial','BU',11);
			$pdf->Cell(183,7, utf8_decode("FACTURE CASH N° ".$num_facture),'','','C'); 
			
			$pdf->SetFont('Arial','B',9);
			$pdf->Ln(10);
			$pdf->Cell(153,7, utf8_decode("NOM    : ".$handling_facture['handleur']."     CODE : ".$handling_facture['handleur_code']),'','','L'); 
			$pdf->Ln();
			$pdf->Cell(153,7, utf8_decode("ADRESSE : ".$handling_facture['adresse_handleur']."       VILLE :".$handling_facture['ville_handleur']),'','','L');  
			
			$pdf->SetFont('Arial','B',8);
			$pdf->Ln(9);
			$pdf->Cell(201,5,utf8_decode("I.TOUCHEE(S) EFFECTUEE(S) SUR  IMMAT : ".$handling_facture['imm']."   TYPE  : ".$handling_facture['type_av']."   MTOW : ".$handling_facture['poids']),'','LRT','C');
			
			$pdf->Ln();
			$pdf->Cell(201,5,"SUR AEROPORT INTERNATIONAL DE LA LUANO",'','','C');
				
			$pdf->Ln(13);	
			$pdf->SetFont('Arial','B',9);			
			$pdf->Cell(40,6, "",'','','C');  
			$pdf->Cell(14,6, "SENS",'TLB','','C');  
			$pdf->Cell(47,6, "DATE",'TLB','','C');
			$pdf->Cell(45,6, "HEURE",'TLBR','','C');
			
			$pdf->Ln();
			$pdf->Cell(40,6, "",'','','C');  
			$pdf->Cell(14,6, "A",'LB','','C');  
			$pdf->Cell(47,6, $handling_facture['dt_arr'],'LB','','C');
			$pdf->Cell(45,6, $m->Heureformat($handling_facture['heure_arr']),'LBR','','C');
			
			$pdf->Ln();
			$pdf->Cell(40,6, "",'','','C');  
			$pdf->Cell(14,6, "D",'LB','','C');  
			$pdf->Cell(47,6, $handling_facture['dt_dep'],'LB','','C');
			$pdf->Cell(45,6, $m->Heureformat($handling_facture['heure_dep']),'LBR','','C');
						
	//=================== 2e Tableau====================================
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);	
			$pdf->Cell(190,8, "II.REDEVANCES A PAYER",'','','C');
			$pdf->Ln();	
			$pdf->SetFont('Arial','B',9);	
			$pdf->Cell(40,6, "",'','','C');  		
			$pdf->Cell(61,6, "NATURE DE TOUCHEE",'TLB','','C');  
			$pdf->Cell(45,6, "MONTANT",'TLBR','','C');
			
			if($handling_facture["aa"]!="N")
			{
				$pdf->Ln();	
				$pdf->SetFont('Arial','',9);	
				$pdf->Cell(40,6, "",'','','C');  		
				$pdf->Cell(61,6, strtoupper($m->handling_detail_ass($handling_facture['aa'])),'L','','C');  
				$pdf->Cell(45,6, $m->arrondie($handling_facture['aa_prix']),'LR','','R');		
			}
			
			if($handling_facture["ta"]=="O")
			{
				$pdf->Ln();	
				$pdf->SetFont('Arial','',9);	
				$pdf->Cell(40,6, "",'','','C');  		
				$pdf->Cell(61,6, "TOUCHEE ADMINISTRATIVE",'L','','C');  
				$pdf->Cell(45,6, $m->arrondie($handling_facture['ta_prix']),'LR','','R');		
			}
			if($handling_facture["fa"]=="O")
			{
				$pdf->Ln();	
				$pdf->SetFont('Arial','',9);		
				$pdf->Cell(40,6, "",'','','C');  	
				$pdf->Cell(61,6, "FULL ASSISTANCE",'L','','C');  
				$pdf->Cell(45,6, $m->arrondie($handling_facture['fa_prix']),'LR','','R');		
			}
			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(40,6, "",'','','C');  
			$pdf->Cell(66,7,"Montant hors taxe en $ US : ",'LTB','','C');	
			$pdf->Cell(40,7,$m->arrondie($handling_facture['mht']),'RTB','','R');	
			
			$pdf->Ln();
			$pdf->Ln();
			$pdf->Cell(40,6, "",'','','C');  
			$pdf->Cell(40,7,"TVA : ",'LTB','','C');	
			$pdf->Cell(66,7,$m->arrondie($handling_facture['tva']),'RTB','','R');	
			
			$pdf->Ln();
			$pdf->Ln();
			
			$pdf->Cell(40,6, "",'','','C');  
			$pdf->Cell(66,7,"Total toutes taxes comprises : ",'LTB','','C');	
			$pdf->Cell(40,7,$m->arrondie($handling_facture['mttc']),'RTB','','R');	
			
			$pdf->Ln();
			$pdf->Ln();
						
			$pdf->SetFont('Arial','B',11);
			$pdf->Cell(25,6, "",'','','C');  
			$pdf->Cell(20,7,utf8_decode("           EN TOUTE LETTRE"),'','','C');
				
			$pdf->Ln();
			$lettre=new ChiffreEnLettre();
			//$tot_avec_tva=explode(",",arrondie($tot_avec_tva));
			
			//$tot_avec_tva=$tot_avec_tva[0]+1;
 			$v=$lettre->Conversion(($handling_facture['mttc']));
			str_replace("deux","deux ",$v);
			$pdf->Cell(25,6, "",'','','C');  
			$pdf->Cell(180,7,'Dollars americains, '.str_replace("deux","deux ",$v),'','','L');	
				
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
			//$pdf->Text(120, 255, utf8_decode("QUITTANCE"));
			
			$pdf->Text(20, 260, utf8_decode($nom_user['nom']));
			$pdf->Text(50, 260, utf8_decode($nom_user['matr']));
			$pdf->Text(70, 260,"  ".$m->arrondie($handling_facture['mttc']));
			$pdf->Text(100, 260, date('d/m/Y'));
			
 	
	$pdf->Text(20, 270, utf8_decode("Copyright Division commerciale"));

$pdf->Output();



?>
