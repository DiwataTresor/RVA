<?php
	$dt=$_GET["dt"];
	$dt2=$_GET["dt2"];
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../manager/bd/cnx.php');

	class PDF extends FPDF
	{
	
	}
	class m extends main{
		function client_date($client,$dt,$dt2)
		{
			$s="select * from 
					rva_facturation2.facture_imprime,rva_facturation2.mouvement2,rva_facturation2.immatriculation,rva_facturation2.client 
				where 
					facture_imprime.Mouv=mouvement2.Num_mouv 
				and
					mouvement2.Immatr=immatriculation.Id_imm
				and
					immatriculation.Code_pr=client.Id_cl
				and 
					facture_imprime.Date_impr between '$dt' and '$dt2'
				and
					client.Id_cl='$client'
				group by
					facture_imprime.Mouv
				";
			$e=$this->cnx->query($s); $t=$e->fetchAll(); $n=count($t);
			$r=array();
			$dt=$t[0]['Date_impr'];
			foreach($t as $row)
			{	
				@$mouvement=$this->mouv($row['Mouv']);
				$mt_usd=$mouvement['tot_sans_tva'];
				$tva=$mouvement['tva'];
				$tot_avec_tva=$mouvement['tot_avec_tva'];
				@$r[]=array("dt"=>($row['Date_impr']),"fact"=>$row['Num_long'],"mt_usd"=>$mt_usd,"tva"=>$tva,"tot_avec_tva"=>$tot_avec_tva);
				//$r[]=array("dt"=>($t['Date_impr']),"fact"=>$t['Num_long'],"mt_usd"=>"055","tva"=>"52","tot_avec_tva"=>"99");
			}
			return $r;
		}
	}
	$m=new m();
	$taille=array(290,300);
	$pdf = new PDF('P','mm',$taille);
	$pdf->AliasNbPages();
	
	$pdf->SetLeftMargin(15);
	$pdf->SetTopMargin(20);
	
	/*$pdf->Text(20, 270, utf8_decode("N° TVA : 664 / 2012"));
	$pdf->Text(20, 275, utf8_decode("N° IMPOT : A1201438C"));*/
//======================= RECUPERATION DE LA LISTE PAR DATE =======================
	
	
//============================================ SQL ===================================
	$s="select * from rva_facturation2.facture_imprime where Date_impr between '$dt' and '$dt2'";
	$e=$m->cnx->query($s); $t=$e->fetchall();
	$n=count($t);
	if($n==0)
	{
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',20);
		$pdf->Cell(270,5,utf8_decode("AUCUNE DONNEE TROUVEE"),'','','C');
	}else
	{
		//==================== ENTETE ====================================
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',11);
				$pdf->Image('../../../images/entete_pdf.png',106,15,85,35);
				$npage=$pdf->PageNo();
				
				//$pdf->Line(15, 260, 190, 260);
				//$pdf->Line(15, 70, 190, 70);
				
				$pdf->SetFont('Arial','',8);
			
				$pdf->Cell(10,5, utf8_decode("REPUBLIQUE DEMOCRATIQUE DU CONGO")); $pdf->Ln();
				$pdf->Cell(10,5, utf8_decode("REGIE DES VOIES AERIENNES SA")); $pdf->Ln();
				$pdf->Cell(10,5, utf8_decode("AEROPORT INTERNATIONAL DE LA LUANO"));$pdf->Ln();
				$pdf->Cell(10,5, utf8_decode("N° TVA : A0700324 L")); $pdf->Ln();
				$pdf->Cell(10,5, utf8_decode("----------------------------------------------------------------------"));

				$pdf->Cell(183,2, utf8_decode(''),'','','C'); 
				$pdf->Ln();
				//$mouv=str_replace("'","",$num_mouv);
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(239,4, utf8_decode("EDITE LE : ".date('d/m/Y')),'','','R'); 
				$pdf->Ln();
				$pdf->Cell(169,7, "",'','','R'); 
				$pdf->Cell(60,7, "PAGE : "."0",'','','R'); 
				$pdf->Ln(14);
				//$pdf->Cell(169,7, utf8_decode("VENTILLATION : "),'','','L'); 
				$pdf->Ln(5);
				$pdf->SetFont('Arial','BU',11);
				$pdf->Cell(260,7, utf8_decode("VENTILLATION JOURNALIERE "),'','','C'); $pdf->Ln();
				$pdf->SetFont('Arial','',11);
				
				$pdf->Cell(260,7, utf8_decode("DU ".$m->Datemysqltofr($dt)." AU ".$m->Datemysqltofr($dt2)),'','','C'); $pdf->Ln();
				$pdf->Ln(4);
			//================================================================
			
			$pdf->Ln();
			
			$pdf->SetFont('Arial','',11);
			$pdf->Cell(10,7,utf8_decode("N°"),'TRBL','','C');
			
			$pdf->Cell(65,7,utf8_decode("N° FACTURE"),'TRBL','','C');
			$pdf->Cell(65,7,utf8_decode("NOM CLIENT"),'TRBL','','C');
			$pdf->Cell(30,7,utf8_decode("MT.HORS TAXE"),'TRBL','','C');
			$pdf->Cell(30,7,utf8_decode("MT.TVA 16%"),'TRBL','','C');
			$pdf->Cell(30,7,utf8_decode("MT. FACTURE"),'TRBL','','C');
			//$pdf->Cell(40,7,utf8_decode("OBSERVATION"),'TRBL','','C');
			$pdf->Ln();
			$a=1;
			$total=0;
			foreach($t as $row)
			{
				if($row['Statut']=='R')
				{
					@$mouv=$m->mouv($row['Mouv']);
					$mtt=$mouv['tot_sans_tva']+$mouv['tva'];
					$pdf->Cell(10,7,utf8_decode($a),'TRBL','','C');			
					$pdf->Cell(65,7,utf8_decode($row['Num_facture']),'TRBL','','C');
					@$pdf->Cell(65,7,utf8_decode($mouv['ta'][0]['Nom_cli']),'TRBL','','L');
					$pdf->Cell(30,7,$m->arrondie($mouv['tot_sans_tva']),'TRBL','','C');
					$pdf->Cell(30,7,$m->arrondie($mouv['tva']),'TRBL','','C');
					$pdf->Cell(30,7,$m->arrondie(ceil($mtt)),'TRBL','','R');
					$pdf->Ln();
					$a++;
					$total=$total+ceil($mtt);
				}else
				{
					@$mouv=$m->mouv($row['Mouv']);
					$mtt=$row['Montant']+$row['Tva'];
					$pdf->Cell(10,7,utf8_decode($a),'TRBL','','C');			
					$pdf->Cell(65,7,utf8_decode($row['Num_facture']),'TRBL','','C');
					$pdf->Cell(65,7,utf8_decode($mouv['ta'][0]['Nom_cli']),'TRBL','','L');
					$pdf->Cell(30,7,$m->arrondie($row['Montant']),'TRBL','','C');
					$pdf->Cell(30,7,$m->arrondie($row['Tva']),'TRBL','','C');
					$pdf->Cell(30,7,$m->arrondie(ceil($mtt)),'TRBL','','R');
					$pdf->Ln();
					$a++;
					$total=$total+ceil($mtt);
				}
			}
			$pdf->Ln(); $pdf->Ln();
			
			$pdf->Cell(140,7,utf8_decode("TOTAL MONTANT VENTILLATION JOURNALIERE :     ". $m->arrondie(ceil($total))),'TRBL','','L');	
			$pdf->SetFont('Arial','',8);	
			$pdf->Ln(15);
			$pdf->Cell(140,7,utf8_decode("DIVISION COMMERCIALE / SERVICE DE FACTURATION"),'','','L');			
			
	}	
$pdf->Output();
?>
