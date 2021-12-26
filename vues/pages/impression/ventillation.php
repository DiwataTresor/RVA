<?php
	$dt=$_GET["dt"];
	$client=$_GET["client"];
	$dt2=$_GET["dt2"];
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../manager/bd/cnx.php');
	class m extends main{}
	$m=new m();

	class PDF extends FPDF
	{
	
	}
	$taille=array(290,300);
	$pdf = new PDF('P','mm',$taille);
	$pdf->AliasNbPages();
	
	$pdf->SetLeftMargin(15);
	$pdf->SetTopMargin(20);
	
	/*$pdf->Text(20, 270, utf8_decode("N° TVA : 664 / 2012"));
	$pdf->Text(20, 275, utf8_decode("N° IMPOT : A1201438C"));*/
//======================= RECUPERATION DE LA LISTE PAR DATE =======================
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
			and
				mouvement2.Sens='A'
			";
		$e=$m->cnx->query($s); 
		$row=($e->fetchAll()); $n=count($row);
		$r=array();
		$dt=$t[0]['Date_impr'];
		foreach($row as $t)
		{	
			$mouvement=$m->mouv($t['Mouv']);
			$mt_usd=$mouvement['tot_sans_tva'];
			$tva=$mouvement['tva'];
			$tot_avec_tva=$mouvement['tot_avec_tva'];
			$r[]=array("dt"=>($t['Date_impr']),"fact"=>$t['Num_long'],"mt_usd"=>$mt_usd,"tva"=>$tva,"tot_avec_tva"=>$tot_avec_tva);
			//$r[]=array("dt"=>($t['Date_impr']),"fact"=>$t['Num_long'],"mt_usd"=>"055","tva"=>"52","tot_avec_tva"=>"99");
		}
		return $r;
	}
	
//============================================ SQL ===================================
	
		$s="select  
				distinct(client.Id_cl),
				client.Id_cl,
				facture_imprime.Mouv,
				mouvement2.Num_mouv,
				mouvement2.Immatr,
				immatriculation.Id_imm,
				immatriculation.Code_pr,
				client.Id_cl,
				facture_imprime.Date_impr,
				Nom_cli
			from 
				rva_facturation2.facture_imprime,rva_facturation2.mouvement2,rva_facturation2.immatriculation,rva_facturation2.client 
			where 
				client.Id_cl='$client'
			and
				facture_imprime.Mouv=mouvement2.Num_mouv 
			and
				mouvement2.Immatr=immatriculation.Id_imm
			and
				immatriculation.Code_pr=client.Id_cl
			and 
				facture_imprime.Date_impr between '$dt' and '$dt2'
			order by
				Nom_cli asc";
		$e=$m->cnx->query($s); 
		$t=($e->fetchAll()); $n=count($t);
	
	if($n!==0)
	{
		$pdf->SetFont('Arial','',8);
		
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
				$pdf->Cell(260,7, utf8_decode("VENTILLATION PAR CLIENT "),'','','C'); $pdf->Ln();
				$pdf->SetFont('Arial','',11);
				$pdf->Cell(260,7, utf8_decode("DU ".$m->Datemysqltofr($dt)." AU ".$m->Datemysqltofr($dt2)),'','','C'); $pdf->Ln();
				$pdf->Ln(4);
			//================================================================
			$pdf->Cell(210,7, utf8_decode("Client : ".$t[0]['Nom_cli']),'','','L'); 
			$pdf->Ln();
			
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(10,7,utf8_decode("N°"),'TRBL','','C');
			$pdf->Cell(25,7,utf8_decode("DATE FACTURE"),'TRBL','','C');
			$pdf->Cell(65,7,utf8_decode("REF. FACTURE"),'TRBL','','C');
			$pdf->Cell(30,7,utf8_decode("MT.HORS TAXE"),'TRBL','','C');
			$pdf->Cell(30,7,utf8_decode("MT.TVA 16%"),'TRBL','','C');
			$pdf->Cell(30,7,utf8_decode("MT. FACTURE"),'TRBL','','C');
			$pdf->Cell(40,7,utf8_decode("OBSERVATION"),'TRBL','','C');
			$pdf->Ln();
			
				$client=$t[0]['Id_cl'];
				$s2="select 
						distinct(Mouv),
						facture_imprime.Montant,
						facture_imprime.Tva,
						facture_imprime.Statut as type_fact,
						facture_imprime.Mouv,
						mouvement2.Num_mouv,
						mouvement2.Immatr,
						immatriculation.Id_imm,
						immatriculation.Code_pr,
						client.Id_cl,
						Nom_cli,
						Date_impr,
						Num_facture
					from 
						rva_facturation2.facture_imprime,
						rva_facturation2.mouvement2,
						rva_facturation2.immatriculation,
						rva_facturation2.client 
					where 
						facture_imprime.Mouv=mouvement2.Num_mouv 
					and
						mouvement2.Immatr=immatriculation.Id_imm
					and
						immatriculation.Code_pr=client.Id_cl
					and
						client.Id_cl='$client'
					and 
						facture_imprime.Date_impr between '$dt' and '$dt2'
					order by
						Nom_cli asc";
				$e2=$m->cnx->query($s2); $t2=($e2->fetchAll());
				$dt2=$t2[0]['Date_impr'];
				$st_mt=0; $st_tva=0; $st_tot=0; 
				$st_fin=0; $st_fin_tva=0; $st_fin_tt=0;
				$tot_j=0; $tot_j_tva=0; $tot_j_tt=0;
				$st_fin_tva=0;
				foreach($t2 as $row)
				{
					
					
						$pdf->SetFont('Arial','',10);
						//continue;
						if($row['type_fact']=="I")
						{
							$pdf->Cell(10,7,utf8_decode(""),'TRBL','','C');
							$pdf->Cell(25,7,$m->Datemysqltofr($row['Date_impr']),'TRBL','','R');
							$pdf->Cell(65,7,utf8_decode($row['Num_facture']),'TRBL','','L');
							$pdf->Cell(30,7,$m->arrondie($row['Montant']),'TRBL','','R');
							$pdf->Cell(30,7,$m->arrondie($row['Tva']),'TRBL','','R');
							$pdf->Cell(30,7,$m->arrondie($row['Montant']),'TRBL','','R');
							$pdf->Cell(40,7,utf8_decode(""),'TRBL','','R');
							$pdf->Ln();
							
							/*$st_mt=$st_mt+$mouvement['tot_sans_tva'];
							$st_tva=$st_tva+$mouvement['tva'];
							$st_tot=$st_tot+$mouvement['tva'];*/
						
						
							$st_fin=$st_fin+$row['Montant'];
							$st_fin_tva=$st_fin_tva+0;
							$st_fin_tt=$st_fin_tt+($row["Montant"]);					
							
							$tot_j=$tot_j+$row["Montant"];
							$tot_j_tva=$tot_j_tva;
							$tot_j_tt=$tot_j_tt+($tot_j+$tot_j_tva);
						}else
						{

							$mouvement=$m->mouv($row['Mouv']);
							$pdf->Cell(10,7,utf8_decode(""),'TRBL','','C');
							$pdf->Cell(25,7,$m->Datemysqltofr($row['Date_impr']),'TRBL','','R');
							$pdf->Cell(65,7,utf8_decode($row['Num_facture']),'TRBL','','L');
							$pdf->Cell(30,7,$m->arrondie($mouvement['tot_sans_tva']),'TRBL','','R');
							$pdf->Cell(30,7,$m->arrondie($mouvement['tva']),'TRBL','','R');
							$pdf->Cell(30,7,$m->arrondie($mouvement['tot_avec_tva']),'TRBL','','R');
							$pdf->Cell(40,7,utf8_decode(""),'TRBL','','R');
							$pdf->Ln();
							
							/*$st_mt=$st_mt+$mouvement['tot_sans_tva'];
							$st_tva=$st_tva+$mouvement['tva'];
							$st_tot=$st_tot+$mouvement['tva'];*/
						
						
							$st_fin=$st_fin+$mouvement['tot_sans_tva'];
							$st_fin_tva=$st_fin_tva+$mouvement['tva'];
							$st_fin_tt=$st_fin_tt+$mouvement['tot_avec_tva'];					
							
							$tot_j=$tot_j+$mouvement["tot_sans_tva"];
							$tot_j_tva=$tot_j_tva+$mouvement["tva"];
							$tot_j_tt+=($tot_j+$tot_j_tva);
						}
					
				}
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(100,7,utf8_decode("SOUS TOTAL DU JOUR"),'TRBL','','C');
					$pdf->Cell(30,7,utf8_decode($m->arrondie($st_fin)),'TRBL','','R');
					$pdf->Cell(30,7,utf8_decode($m->arrondie($st_fin_tva)),'TRBL','','R');
					$pdf->Cell(30,7,utf8_decode($m->arrondie(ceil($st_fin_tva)+ceil($st_fin))),'TRBL','','R');
					$pdf->Cell(40,7,utf8_decode(""),'TRBL','','C');
					$pdf->Ln(10);
					
					$pdf->Cell(100,7,utf8_decode("TOTAL MONTANT VENTILLATION PERIODIQUE "),'TRBL','','C');
					$pdf->Cell(30,7,utf8_decode($m->arrondie($tot_j)),'TRBL','','R');
					$pdf->Cell(30,7,utf8_decode($m->arrondie($tot_j_tva)),'TRBL','','R');
					$pdf->Cell(30,7,utf8_decode($m->arrondie(ceil($st_fin_tva+$st_fin))),'TRBL','','R');
					
					$tot_t=0;$tot_t_tva=0;$tot_t_tt=0;
					
					
			/*$client=client_date($t['Id_cl'],$dt,$dt2,$bdd);
			$dt=$client[0]['dt'];
				$pdf->Cell(10,5,utf8_decode(''),'LR','','C');
				$pdf->Cell(25,5,utf8_decode($client[0]['dt']),'R','','L');
				$pdf->Cell(65,5,utf8_decode($client[0]['fact']),'R','','C');
				$pdf->Cell(30,5,utf8_decode($client[0]['mt_usd']),'R','','C');
				$pdf->Cell(30,5,utf8_decode($client[0]['tva']),'R','','C');
				$pdf->Cell(30,5,utf8_decode($client[0]['tot_avec_tva']),'R','','C');
				$pdf->Cell(40,5,utf8_decode(''),'R','','C');
				$pdf->Ln();
			for($a=0;$a<count($client);$a++)
			{
					$dt=$client[$a]['dt'];
					$pdf->Cell(10,5,utf8_decode(""),'LR','','C');
					$pdf->Cell(25,5,utf8_decode($client[$a]['dt']),'R','','L');
					$pdf->Cell(65,5,utf8_decode($client[$a]['fact']),'R','','C');
					$pdf->Cell(30,5,utf8_decode($client[$a]['mt_usd']),'R','','C');
					$pdf->Cell(30,5,utf8_decode($client[$a]['tva']),'R','','C');
					$pdf->Cell(30,5,utf8_decode($client[$a]['tot_avec_tva']),'R','','C');
					$pdf->Cell(40,5,utf8_decode(''),'R','','C'); $pdf->Ln();
		
				$pdf->Ln();
			}*/
			$a=0;
			$pdf->Ln();
	
 }else
 {
 	$pdf->AddPage();
	$pdf->SetFont('Arial','B',20);
 	$pdf->Cell(270,5,utf8_decode("AUCUNE DONNEE TROUVEE"),'','','C');
 }			
$pdf->Output();
?>
