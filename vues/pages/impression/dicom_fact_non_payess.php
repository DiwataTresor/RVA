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
	//$bord=$m->bordereau($dt);
	$id_us=$_SESSION["Idd"];
	$user=$m->user($id_us);

	class PDF extends FPDF
	{
	
	}
	$taille=array(39,39);
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetLeftMargin(5);
	$pdf->SetTopMargin(10);
	$pdf->SetFont('Arial','B',11);
	$pdf->Image('../../../images/entete_pdf.png',86,15,60,20);
	$npage=$pdf->PageNo();
	
	//$pdf->Line(15, 260, 190, 260);
	//$pdf->Line(15, 70, 190, 70);
	
	$pdf->SetFont('Arial','',8);
	/*$pdf->Text(20, 270, utf8_decode("N° TVA : 664 / 2012"));
	$pdf->Text(20, 275, utf8_decode("N° IMPOT : A1201438C"));*/
	
	//$pdf->Text(2.7, 1.2, utf8_decode("REPUBLIQUE DEMOCRATIQUE DU CONGO"));
	$pdf->Text(10, 20, utf8_decode("REPUBLIQUE DEMOCRATIQUE DU CONGO"));
	$pdf->Text(10, 23, utf8_decode("REGIE DES VOIES AERIENNES SA"));
	$pdf->Text(10, 26, utf8_decode("AEROPORT INTERNATIONAL DE LA LUANO"));
	$pdf->Text(10, 29, utf8_decode("N° TVA : A0700324 L"));
	$pdf->Text(10, 32, utf8_decode("----------------------------------------------------------------------"));

			$pdf->Cell(34,5, utf8_decode(''),'','','C'); 
			$pdf->Ln();
			//$mouv=str_replace("'","",$num_mouv);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(200,2, utf8_decode("EDITE LE : ".date('d/m/Y')),'','','R'); 
			$pdf->Ln();
			//$pdf->Cell(109,7, "",'','','R'); 
			//$pdf->Cell(60,7, "PAGE : ".$npage,'','','R');  
			$pdf->Ln(20);
			$pdf->Cell(210,6, utf8_decode("RELEVE DES FACTURES NON PAYEES"),'','','C'); 
			$pdf->Ln();
			$pdf->SetFont('Arial','BU',8);
			
			if($cl=="tous")
			{
				$pdf->Cell(210,6, utf8_decode(" DU ".$m->Datemysqltofr($dt)." AU ".$m->Datemysqltofr($dt2)),'','','C');
			}else
			{
				$client=$m->client($cl);
				$pdf->Cell(210,6, utf8_decode("POUR ".$client['nom_cl']." DU ".$m->Datemysqltofr($dt)." AU ".$m->Datemysqltofr($dt2)),'','','C'); 
			}
			$pdf->Ln();
			$pdf->SetFont('Arial','B',8);
			
			$pdf->Ln(); $pdf->Ln();
	//================================= FACTURE==================
			$pdf->Cell(10,5, "",'','','C'); 
			$pdf->Cell(30,5, utf8_decode("DATE MOUV"),'TRL','','C'); 
			$pdf->Cell(20,5, utf8_decode("FORMUL."),'TRL','','C'); 
			$pdf->Cell(45,5, utf8_decode("EXPLOITANT"),'TRL','','C');
			$pdf->Cell(40,5, utf8_decode("FACTURE"),'TRL','','C');
			$pdf->Cell(25,5, utf8_decode("MOUVEM."),'TRL','','C');
			$pdf->Cell(25,5, utf8_decode("MONTANT"),'TRL','','C');
			
	//================================ SQL==================================
			/*$s="select * from 
					rva_facturation2.mouvement2,rva_facturation2.immatriculation,rva_facturation2.client
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
					Code_imm";*/
			if($cl=="tous")
			{
				$s="select * from 
						rva_facturation2.facture_imprime, rva_facturation2.mouvement2,rva_facturation2.immatriculation,rva_facturation2.client 
					where
						facture_imprime.Mouv=mouvement2.Num_mouv
					and
						mouvement2.Immatr=immatriculation.Id_imm
					and
						immatriculation.Code_pr=client.Id_cl
					and
						client.Type_cl='C'
					and
						facture_imprime.Statut='R'
					and
						Date_mouv between '$dt' and '$dt2'
					and
						Sens='A'
				";
			}else
			{
				$s="select * from 
						rva_facturation2.facture_imprime, rva_facturation2.mouvement2,rva_facturation2.immatriculation,rva_facturation2.client 
					where
						facture_imprime.Mouv=mouvement2.Num_mouv
					and
						mouvement2.Immatr=immatriculation.Id_imm
					and
						immatriculation.Code_pr=client.Id_cl
					and
						client.Id_cl='$cl'
					and
						client.Type_cl='C'
					and
						facture_imprime.Statut='R'
					and
						Date_mouv between '$dt' and '$dt2'
					and
						Sens='A'
				";
			}
			$e=$m->cnx->query($s); $t=($e->fetchAll()); $n=count($t);
	//=============================== CONTENU DU TABLEAU=================================
			$pdf->Ln();
			$pdf->SetFont('Arial','',7);
			if($e->rowCount()==0)
			{
				$pdf->Cell(10,5, "",'','','C'); 
				$pdf->Cell(20,5, utf8_decode(""),'T','','C'); 
				$pdf->Cell(30,5, utf8_decode(""),'T','','C'); 
				$pdf->Cell(45,5, utf8_decode(""),'T','','C');
				$pdf->Cell(40,5, utf8_decode(""),'T','','C');
				$pdf->Cell(25,5, utf8_decode(""),'T','','C');
				$pdf->Cell(25,5, utf8_decode(""),'T','','C');
				$pdf->Ln(20);
				$pdf->Cell(210,5, utf8_decode("AUCUNE DONNEE TROUVEE"),'','','C'); 
				
			}else
			{
				$total=0;
				foreach($t as $row)
				{
					$num_mouv=$row['Mouv'];
					$s="select * from rva_facturation2.paiement_facture where Mouv='$num_mouv'"; $e=$m->cnx->query($s); $n=$e->rowCount();
					if($n!==0)
					{
						continue;
					}
					
					$mouv=$m->mouv($row["Mouv"]);
					
					$pdf->Cell(10,5, "",'','','C'); 
					$pdf->Cell(30,5, $m->Datemysqltofr($mouv["ta"][0]["Dt"])." - ".$m->Datemysqltofr($mouv["td"][0]["Dt"]),'TRL','','C'); 
					$pdf->Cell(20,5, utf8_decode($mouv["num_form"]),'TRL','','C');
					$pdf->Cell(45,5, utf8_decode($mouv["nom_cli"]),'TRL','','C');
					$pdf->Cell(40,5, utf8_decode($row["Num_facture"]),'TRL','','C');
					$pdf->Cell(25,5, utf8_decode($mouv["ville_arr"]." - ".$mouv["ville_dep"]),'TRL','','C');
					$pdf->Cell(25,5, $m->arrondie($mouv["tot_avec_tva"])." USD",'TRL','','C');
					$pdf->Ln();
					$total+=$mouv['tot_avec_tva'];
				}
					$pdf->Cell(10,5, "",'','','C'); 
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(160,5, utf8_decode("TOTAL"),'TRLB','','C');
					$pdf->Cell(25,5, $m->arrondie($total)." USD",'TRLB','','C');
			}			
			
$pdf->Output();



?>
