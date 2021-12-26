<?php
	@session_start();
	$dt=$_GET["dt"];
	$dt2=$_GET["dt2"];
	//echo($dt2);
	$redevance_type=$_GET["redevance_type"];
	
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
	$taille=array(250,300);
	$pdf = new PDF('P','mm',$taille);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetLeftMargin(15);
	$pdf->SetTopMargin(5);
	$pdf->SetFont('Arial','B',11);
	$pdf->Image('../../../images/entete_pdf.png',86,15,60,20);
	$npage=$pdf->PageNo();
	
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
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(179,7, utf8_decode("EDITE LE : ".date('d/m/Y')),'','','R'); 
			$pdf->Ln();
			$pdf->Cell(109,7, "",'','','R'); 
			$pdf->Cell(60,7, "PAGE : ".$npage,'','','R');  
			$pdf->Ln(14);
			//$pdf->Cell(169,7, utf8_decode("NOM PERCEPTEUR(TRICE) : ".$user['nom']."      ".$user['matr']),'','','L'); 
			$pdf->Ln(9);
			$pdf->SetFont('Arial','BU',11);
			$pdf->Cell(210,7, utf8_decode("BORDEREAU DE VERSEMENT/EXTRA AER "),'','','C'); 
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);
			
			$pdf->Cell(210,7, utf8_decode("DU "." ".$m->Datemysqltofr($dt))." Au ".($m->Datemysqltofr($dt2)),'','','C'); 
			$pdf->Ln();
			
			if($redevance_type=="acces")
			{
				$redevance_detail="ACCESS";
			}else if($redevance_type=="handling"){
				$redevance_detail="HANDLING";
			}else if($redevance_type=="parking"){
				$redevance_detail="PARKING";
			}else
			{
				$redevance_detail="AUTRE";
			}
			$pdf->Cell(210,7, utf8_decode("REDEVANCE : ".$redevance_detail),'','','L'); 
			$pdf->Ln();
//================================= DONNEES RETOURNEES DU BORDEREAU==================

			if($redevance_type=="acces")
			{
				/*$s="select * 
				from 
					rva_facturation2.acces 
				where 
					(Type_acc=2 or Type_acc=3 or Type_acc=4 or Type_acc=5)
				and
					acces.Date_perc between '$dt' and '$dt2'
				";*/
				$s="select * from rva_facturation2.acces
					where
						(acces.Type_acc=2 and acces.Date_perc between '$dt' and '$dt2')
					or
						(acces.Type_acc=3 and acces.Date_perc between '$dt' and '$dt2')
					or
						(acces.Type_acc=4 and acces.Date_perc between '$dt' and '$dt2')
					or
						(acces.Type_acc=5 and acces.Date_perc between '$dt' and '$dt2')
					";
			}else if($redevance_type=="handling")
			{
				$s="select * 
				from 
					rva_facturation2.acces 
				where 
					Type_acc=6 
				and 
					acces.Date_perc between '$dt' and '$dt2'";
			}else if($redevance_type=="autre")
			{
				$s="select * 
				from 
					rva_facturation2.acces 
				where 
					Type_acc=8 
				and 
					acces.Date_perc between '$dt' and '$dt2'";
			}else  if($redevance_type=="parking")
			{

				$s="select * from 
					rva_facturation2.acces
			 	where 
					acces.Type_acc=1
				and 
					acces.Date_perc between '$dt' and '$dt2'";
			}
			$e=$m->cnx->query($s); 
			$t=($e->fetchAll()); 
			$n=count($t);
//================================ ENTETE DU TABLEAU==================================
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(50,7, utf8_decode("FACTURE "),'TRBL','','C');
			//$pdf->Cell(50,7, ($bord['acc']),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT.HT USD"),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT. HT CDF."),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT. TVA US"),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT.TVA CDF"),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT.TTC USD"),'TRBL','','C'); 
			$pdf->Cell(20,7, utf8_decode("MT. TTC CDF"),'TRBL','','C'); 
			$pdf->Cell(27,7, utf8_decode("N° QUITTANCE"),'TRBL','','C'); 
//=============================== CONTENU DU TABLEAU=================================
//================ REDEVANCES AER===========================================================	
			$pdf->Ln();
		
			if($n==0)
			{
				//$pdf->Cell(50,7,$rda[$a]["num_rda"],'','','R');
			}else
			{	
				$pdf->Cell(50,5,"",'L','','L');
				$pdf->Cell(20,5,"",'LR','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','R');
				$pdf->Cell(20,5,"",'R','','C');
				$pdf->Cell(27,5,"",'R','','C');
				$pdf->Ln();
				$inc=1;
				$stcli=0;
				$tva_cdf=0.00;
				$tva_usd=0.00;
				$st_u=0; 
				$st_c=0.00; 
				$st_u_tva=0.00; 
				$st_c_tva=0.00; 
				$st_u_tt=0.00; 
				$st_c_tt=0.00;
				
				foreach($t as $row)
				{
										
					if($row["Monn_acc"]=="USD")
					{
						if(trim($row["Tva"])=="N")
						{
							$tva_usd=0;
							$tva_cdf=0;
						}else
						{
							$tva_usd=$m->tva($row['Mt_acc']);	
							$tva_cdf=0;
						}
						$mt_usd=ceil($row["Mt_acc"]);
						$mt_cdf=0;
					}else
					{
						if(trim($row["Tva"])=="N")
						{
							$tva_usd=0;
							$tva_cdf=0;
						}else
						{
							$tva_cdf=$m->tva($row['Mt_acc']);	
							$tva_usd=0;
						}
						$mt_cdf=($row["Mt_acc"]);
						$mt_usd=0;
					}
					$ttc_usd=ceil($mt_usd+$tva_usd);
					$ttc_cdf=ceil($mt_cdf+$tva_cdf);
					
					$st_u=$st_u+$mt_usd;	
					$st_c=($st_c+$mt_cdf); 
					$st_u_tva=ceil($st_u_tva+$tva_usd); 
					$st_c_tva=$st_c_tva+$tva_cdf; 
					
					
					$st_u_tt=$st_u_tt+ceil(($ttc_usd)); 
					$st_c_tt=$st_c_tt+($st_c+$ttc_cdf);
				
																		
							//$nom=$t['Nom_cli'];	
							$pdf->Cell(50,5,$row["Num_long"],'L','','C');
							$pdf->Cell(20,5,$m->arrondie($mt_usd),'LR','','R');
							$pdf->Cell(20,5,$m->arrondie($mt_cdf),'R','','R');
							$pdf->Cell(20,5,$m->arrondie($tva_usd),'R','','R');
							$pdf->Cell(20,5,$m->arrondie($tva_cdf),'R','','R');
							$pdf->Cell(20,5,$m->arrondie($ttc_usd),'R','','R');
							$pdf->Cell(20,5,$m->arrondie($ttc_cdf),'R','','R');
							$pdf->Cell(27,5,$row["Quittance"],'R','','C');
							$pdf->Ln();
							//$st_u=(($st_u)+$mt);
							//$st_usd=(($rda[$a]["rda_mt_usd"])); 
							
							
				}
				/*$pdf->Cell(50,5,"Sous total",'L','','R');
				$pdf->Cell(20,5,$rda[count($rda)-1]['st'][0]['mt_usd'],'LR','','R');
				$pdf->Cell(20,5,$rda[count($rda)-1]['st'][0]['mt_cdf'],'LR','','R');
				$pdf->Cell(20,5,$rda[count($rda)-1]['st'][0]['mt_usd_tva'],'LR','','R');
				$pdf->Cell(20,5,$rda[count($rda)-1]['st'][0]['mt_cdf_tva'],'LR','','R');
				$pdf->Cell(20,5,$rda[count($rda)-1]['st'][0]['mt_usd_tt'],'LR','','R');
				$pdf->Cell(20,5,$rda[count($rda)-1]['st'][0]['mt_cdf_tt'],'LR','','R');
				$pdf->Cell(27,5,"",'LR','','R');
				$pdf->Cell(30,5,"",'LR','','R');
				$rupture="non";
				$pdf->Ln();*/
				
				$pdf->SetFont('Arial','B',7);				
				$pdf->Cell(50,5,"Sous total",'LTB','','C');
				$pdf->Cell(20,5,$m->arrondie($st_u),'LRTB','','R');
				$pdf->Cell(20,5,$m->arrondie($st_c),'RTB','','R');
				$pdf->Cell(20,5,$m->arrondie($st_u_tva),'RTB','','R');
				$pdf->Cell(20,5,$m->arrondie($st_c_tva),'RTB','','R');
				$pdf->Cell(20,5,$m->arrondie(ceil($st_u+$st_u_tva)),'RTB','','R');
				$pdf->Cell(20,5,$m->arrondie($st_c+$st_c_tva),'RTB','','R');
				$pdf->Cell(27,5,"",'RTB','','C');
			}	
			
			
//==================================== TOTALITE DU BORDEREAU===============================================	
			/*$pdf->Ln();$pdf->Ln();
			$pdf->SetFont('Arial','B',7);				
			$pdf->Cell(50,5,"TOTAL BORDEREAU JOURN.",'LTB','','C');
			$pdf->Cell(20,5,$t_usd,'LRTB','','R');
			$pdf->Cell(20,5,$t_cdf,'RTB','','R');
			$pdf->Cell(20,5,$t_tva_usd,'RTB','','R');
			$pdf->Cell(20,5,$t_tva_cdf,'RTB','','R');
			$pdf->Cell(20,5,$t_tt_usd,'RTB','','R');
			$pdf->Cell(20,5,$t_tt_cdf,'RTB','','R');	*/
			
			$pdf->Ln();$pdf->Ln();
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(200,5,"Lubumbashi, Le ".$m->Datemysqltofr(Date('Y-m-d')),'','','R'); $pdf->Ln(); $pdf->Ln(); $pdf->Ln();
			
			$pdf->Ln();$pdf->Ln();
			$pdf->Cell(200,5,"Visa du Coordonnateur",'','','C');
			
			
			
$pdf->Output();



?>
