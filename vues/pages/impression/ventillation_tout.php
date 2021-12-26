<?php
	$dt=$_GET["dt"];
	//$client=$_GET["client"];
	$dt2=$_GET["dt2"];
	
	require("../../../plugins/fpdf/fpdf.php");
	require("../../../plugins/chiffresEnLettres.php");
	include('../../../manager/bd/cnx.php');

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
	function client_date($client,$dt,$dt2,$bdd)
	{
		$s="select * from 
				facture_imprime,mouvement2,immatriculation,client 
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
		$e=mysqli_query($bdd,$s); $t=mysqli_fetch_array($e); $n=mysqli_num_rows($e);
		$r=array();
		$dt=$t['Date_impr'];
		do
		{	
			$mouvement=mouv($t['Mouv'],$bdd);
			$mt_usd=$mouvement['tot_sans_tva'];
			$tva=$mouvement['tva'];
			$tot_avec_tva=$mouvement['tot_avec_tva'];
			$r[]=array("dt"=>($t['Date_impr']),"fact"=>$t['Num_long'],"mt_usd"=>$mt_usd,"tva"=>$tva,"tot_avec_tva"=>$tot_avec_tva);
			//$r[]=array("dt"=>($t['Date_impr']),"fact"=>$t['Num_long'],"mt_usd"=>"055","tva"=>"52","tot_avec_tva"=>"99");
		}while($t=mysqli_fetch_array($e));
		return $r;
	}
	
//============================================ SQL ===================================
			$s="select * from 
				facture_imprime,mouvement2,immatriculation,client
			where 
				facture_imprime.Mouv=mouvement2.Num_mouv 
			and
				mouvement2.Immatr=immatriculation.Id_imm
			and
				immatriculation.Code_pr=client.Id_cl
			and 
				facture_imprime.Date_impr between '$dt' and '$dt2'
			group by
				Id_cl
			order by
				Nom_cli asc";
		$e=mysqli_query($bdd,$s); $t=mysqli_fetch_array($e); $n=mysqli_num_rows($e);
	
	
	if($n!==0)
	{
		function Datetofr($dt)
		{
			return $dt;
		}
	
		$dtt2=Datemysqltofr($dt2);
		$dtt=Datemysqltofr($dt);
		$pdf->SetFont('Arial','',8);
		do
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
				$pdf->Cell(260,7, utf8_decode("VENTILLATION PERIODIQUE "),'','','C'); $pdf->Ln();
				$pdf->SetFont('Arial','',11);
				
				$pdf->Cell(260,7, utf8_decode("DU ".($dtt)." AU ".$dtt2),'','','C'); $pdf->Ln();
				$pdf->Ln(4);
			//================================================================
			$pdf->Cell(210,7, utf8_decode("Client : ".$t['Nom_cli']),'','','L'); 
			$pdf->Ln();
			
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(10,7,utf8_decode("N°"),'TRBL','','C');
			$pdf->Cell(25,7,utf8_decode("DATE FACT"),'TRBL','','C');
			$pdf->Cell(65,7,utf8_decode("REF. FACTURE"),'TRBL','','C');
			$pdf->Cell(30,7,utf8_decode("MT.HORS TAXE"),'TRBL','','C');
			$pdf->Cell(30,7,utf8_decode("MT.TVA 16%"),'TRBL','','C');
			$pdf->Cell(30,7,utf8_decode("MT. FACTURE"),'TRBL','','C');
			$pdf->Cell(40,7,utf8_decode("OBSERVATION"),'TRBL','','C');
			$pdf->Ln();
			
				$client=$t['Id_cl'];
				$s2="select * from 
						facture_imprime,mouvement2,immatriculation,client 
					where 
						facture_imprime.Mouv=mouvement2.Num_mouv 
					and
						mouvement2.Immatr=immatriculation.Id_imm
					and
						immatriculation.Code_pr=client.Id_cl
					and
						client.Id_cl=$client
					and 
						facture_imprime.Date_impr between '$dt' and '$dt2'
					group by 
						Mouv
					order by
						Nom_cli asc";
				$e2=mysqli_query($bdd,$s2); $t2=mysqli_fetch_array($e2); $n2=mysqli_num_rows($e2);
				$dt2=$t2['Date_impr'];
				$st_mt=0; $st_tva=0; $st_tot=0; 
				$st_fin=0; $st_fin_tva=0; $st_fin_tt=0;
				$tot_j=0; $tot_j_tva=0; $tot_j_tt=0;
				$st_fin_tva=0;
				//echo $n2." ";
				do
				{
					$dttt=($t2['Date_impr']);
					$pdf->SetFont('Arial','',9);
					if($dt2==$t2['Date_impr'])
					{
						$mouvement=mouv($t2['Mouv'],$bdd);
						$st_mt=$st_mt+$mouvement['tot_sans_tva'];
						$st_tva=$st_tva+$mouvement['tva'];
						$st_tot=$st_mt+$st_tva;
						$pdf->Cell(10,5,utf8_decode(""),'TRBL','','L');
						$dtimpr=explode("-",$t2['Date_impr']);
						//$pdf->Cell(25,5,(Datemysqltofr($t2['Date_impr'])),'TRBL','','C');
						$pdf->Cell(25,5,(Datetofr($t2['Date_impr'])),'TRBL','','C');
						$pdf->Cell(65,5,utf8_decode($t['Num_facture']),'TRBL','','L');
						$pdf->Cell(30,5,utf8_decode(arrondie($mouvement['tot_sans_tva'])),'TRBL','','R');
						$pdf->Cell(30,5,utf8_decode(arrondie($mouvement['tva'])),'TRBL','','R');
						$pdf->Cell(30,5,utf8_decode(arrondie($mouvement['tot_avec_tva'])),'TRBL','','R');
						$pdf->Cell(40,5,utf8_decode(""),'TRBL','','C');
						$pdf->Ln();	
					}else
					{	
						$pdf->SetFont('Arial','B',9);
						$dt2=$t2['Date_impr'];
						$pdf->Cell(100,5,utf8_decode("Sous total"),'TRBL','','R');
					
						$pdf->Cell(30,5,utf8_decode(arrondie($st_mt)),'TRBL','','R');
						$pdf->Cell(30,5,utf8_decode(arrondie($st_tva)),'TRBL','','R');
						$pdf->Cell(30,5,utf8_decode(arrondie($st_tot)),'TRBL','','R');
						$pdf->Cell(40,5,utf8_decode(""),'TRBL','','R');
						
						
						$pdf->Ln();
						$pdf->SetFont('Arial','',8);
						//continue;
						$mouvement=mouv($t2['Mouv'],$bdd);
						$pdf->Cell(10,7,utf8_decode(""),'TRBL','','C');
						$pdf->Cell(25,7,Datemysqltofr($t2['Date_impr']),'TRBL','','R');
						$pdf->Cell(65,7,utf8_decode($t2['Num_facture']),'TRBL','','L');
						$pdf->Cell(30,7,utf8_decode(arrondie($mouvement['tot_sans_tva'])),'TRBL','','R');
						$pdf->Cell(30,7,utf8_decode(arrondie($mouvement['tva'])),'TRBL','','R');
						$pdf->Cell(30,7,utf8_decode(arrondie($mouvement['tot_avec_tva'])),'TRBL','','R');
						$pdf->Cell(40,7,utf8_decode(""),'TRBL','','R');
						$pdf->Ln();
						$st_mt=$mouvement['tot_sans_tva']; 
						$st_tva=tva($st_mt);
						$st_tot=ceil($st_mt+$st_tva);
						//continue;
					}
						/*$st_mt=$st_mt+$mouvement['tot_sans_tva'];
						$st_tva=$st_tva+$mouvement['tva'];
						$st_tot=$st_tot+$mouvement['tva'];*/
					
					$st_fin=$st_fin+$mouvement['tot_sans_tva'];
					$st_fin_tva=$st_fin_tva+$mouvement['tva'];
					$st_fin_tt=$st_fin_tt+$mouvement['tot_avec_tva'];					
					
					$tot_j=$tot_j+$mouvement["tot_sans_tva"];
					$tot_j_tva=$tot_j_tva+$mouvement["tva"];
					$tot_j_tt=$tot_j_tt+$mouvement["tot_avec_tva"];
					
				}while($t2=mysqli_fetch_array($e2));
					$pdf->Cell(100,5,utf8_decode("Sous total"),'TRBL','','R');
					$pdf->Cell(30,5,utf8_decode(arrondie($st_mt)),'TRBL','','R');
					$pdf->Cell(30,5,utf8_decode(arrondie($st_tva)),'TRBL','','R');
					$pdf->Cell(30,5,utf8_decode(arrondie($st_tot)),'TRBL','','R');
					$pdf->Cell(40,5,utf8_decode(""),'TRBL','','R');
					$pdf->Ln();
					
					$pdf->SetFont('Arial','B',8);
					/*$pdf->Cell(100,7,utf8_decode("SOUS TOTAL DU JOUR"),'TRBL','','C');
					$pdf->Cell(30,7,utf8_decode(arrondie($st_fin)),'TRBL','','R');
					$pdf->Cell(30,7,utf8_decode(arrondie($st_fin_tva)),'TRBL','','R');
					$pdf->Cell(30,7,utf8_decode(arrondie($st_fin_tt)),'TRBL','','R');
					$pdf->Cell(40,7,utf8_decode(""),'TRBL','','C');*/
					$pdf->Ln(10);
					
					$pdf->Cell(100,7,utf8_decode("TOTAL MONTANT VENTILLATION PERIODIQUE "),'TRBL','','C');
					$pdf->Cell(30,7,utf8_decode(arrondie($tot_j)),'TRBL','','R');
					$pdf->Cell(30,7,utf8_decode(arrondie($tot_j_tva)),'TRBL','','R');
					$pdf->Cell(30,7,utf8_decode(arrondie($tot_j_tt)),'TRBL','','R');
					
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
			
		}while($t=mysqli_fetch_array($e));	
 }else
 {
 	$pdf->AddPage();
	$pdf->SetFont('Arial','B',20);
 	$pdf->Cell(270,5,utf8_decode("AUCUNE DONNEE TROUVEE"),'','','C');
 }			
$pdf->Output();
?>
