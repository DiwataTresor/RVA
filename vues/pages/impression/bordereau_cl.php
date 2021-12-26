<?php
	@session_start();
	$client=$_GET["client"];
	$dt=$_GET["dt"];
	$dt2=$_GET["dt2"];
	$modePaie=$_GET["modePaie"];
	
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
	//$pdf->Cell(50,5,$modePaie,'L','','L');
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
			$pdf->Cell(210,7, utf8_decode("BORDEREAU DE VERSEMENT/CLIENT "),'','','C'); 
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);
			
			$pdf->Cell(210,7, utf8_decode("DU "." ".$m->Datemysqltofr($dt))." Au ".($m->Datemysqltofr($dt2)),'','','C'); 
			$pdf->Ln();
//================================= DONNEES RETOURNEES DU BORDEREAU==================

			if($client=="T")
			{
				
				 	$s="select * 
				 	from 
				 		rva_facturation2.rda,rva_facturation2.client 
				 	where 
				 		rda.Client_rda=client.Id_cl 
				 	and 
				 		Date_rda between '$dt' and '$dt2'
				 	order by Nom_cli";
			}else
			{
				
					$s="select * 
						from 
							rva_facturation2.rda,rva_facturation2.client 
						where 
							rda.Client_rda=client.Id_cl 
						and 
							Client_rda='$client' 
						and
							Date_rda between '$dt' and '$dt2'
						order by Nom_cli";
				
			}
			$e=$m->cnx->query($s); 
			$t=($e->fetchAll()); $n=count($t);

			
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
			$pdf->Cell(30,7, utf8_decode("OBSERVATION"),'TRBL','','C'); 
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
				$pdf->Cell(30,5,"",'R','','R');
				$pdf->Ln();
				$inc=1;
				$nom=$t[0]['Nom_cli'];
				$stcli=0;
				$st_u=0; $st_c=0.00; $st_u_tva=0.00; $st_c_tva=0.00; $st_u_tt=0.00; $st_c_tt=0.00;

				$st_u_c=0; $st_c_c=0.00; $st_u_tva_c=0.00; $st_c_tva_c=0.00; $st_u_tt_c=0.00; $st_c_tt_c=0.00;
				$st_u_b=0; $st_c_b=0.00; $st_u_tva_b=0.00; $st_c_tva_b=0.00; $st_u_tt_b=0.00; $st_c_tt_b=0.00;
				
				$pdf->Cell(50,5,$t[0]["Nom_cli"],'L','','C');
				$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','L');$pdf->Cell(20,5,"",'LR','','R');
				$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','L');
				$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(27,5,"",'LR','','L');$pdf->Cell(30,5,"",'LR','','R');
				$rupture="non";
				$clientNom=$t[0]["Nom_cli"];
				$pdf->Ln();
				foreach($t as $row)
				{
					if($modePaie=="cash")
					{
						if(trim($row["ModePaie"])=="B")
						{
							continue;
						}
					}else if($modePaie=="banque")
					{
						if(trim($row["ModePaie"])!=="B")
						{
							continue;
						}
					}
					
					if($clientNom!==$row["Nom_cli"])
					{
						$pdf->Cell(50,5,$row["Nom_cli"],'L','','C');
						$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','L');$pdf->Cell(20,5,"",'LR','','R');
						$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(20,5,"",'LR','','L');
						$pdf->Cell(20,5,"",'LR','','R');$pdf->Cell(27,5,"",'LR','','L');$pdf->Cell(30,5,"",'LR','','R');
						$pdf->Ln();	
						$clientNom=$row["Nom_cli"];
					}
						
							$tva=$m->tva($row["Mt_rda"]);
							$mt=$row["Mt_rda"]-$tva;
							$mt_tva=$tva;
							$mt_tt=$mt_tva+$mt;
							$rupture="non";
							$nom=$row['Nom_cli'];	
							$pdf->Cell(50,5,$row["Num_long"]." ",'L','','C');
							$pdf->Cell(20,5,$m->arrondie($mt),'LR','','R');
							$pdf->Cell(20,5,$m->arrondie(0),'R','','R');
							$pdf->Cell(20,5,$m->arrondie($mt_tva),'R','','R');
							$pdf->Cell(20,5,$m->arrondie(0),'R','','R');
							$pdf->Cell(20,5,$m->arrondie($mt_tt),'R','','R');
							$pdf->Cell(20,5,$m->arrondie(0),'R','','R');
							$pdf->Cell(27,5,$row["Quittance"],'R','','C');
							if(trim($row["ModePaie"])=="B")
							{
								$pdf->SetFont('Arial','',6);
								$pdf->Cell(30,5,utf8_decode("N° BDV : ").trim($row["DetailModePaie"]),'R','','C');
							}else
							{
								$pdf->SetFont('Arial','B',8);
								$pdf->Cell(30,5,"TOTALITE",'R','','C');
							}
							$pdf->SetFont('Arial','B',8);
							$pdf->Ln();
							

							$st_u=(($st_u)+$mt);
							//$st_usd=(($rda[$a]["rda_mt_usd"])); 
							$st_c=($st_c+0); 
							$st_u_tva=$st_u_tva+$mt_tva; 
							$st_c_tva=$st_c_tva+0; 
							$st_u_tt=$st_u_tt+$mt_tt; 
							$st_c_tt=$st_c_tt+0;

							if(trim($row["ModePaie"])!=="B")
							{
								$st_u_c=(($st_u_c)+$mt);
								//$st_usd=(($rda[$a]["rda_mt_usd"])); 
								$st_c_c=($st_c_c+0); 
								$st_u_tva_c=$st_u_tva_c+$mt_tva; 
								$st_c_tva_c=$st_c_tva_c+0; 
								$st_u_tt_c=$st_u_tt_c+$mt_tt; 
								$st_c_tt_c=$st_c_tt_c+0;
							}else if(trim($row["ModePaie"])=="B")
							{
								$st_u_b=(($st_u_b)+$mt);
								//$st_usd=(($rda[$a]["rda_mt_usd"])); 
								$st_c_b=($st_c_b+0); 
								$st_u_tva_b=$st_u_tva_b+$mt_tva; 
								$st_c_tva_b=$st_c_tva_b+0; 
								$st_u_tt_b=$st_u_tt_b+$mt_tt; 
								$st_c_tt_b=$st_c_tt_b+0;
							}	
				}
				
				$pdf->Cell(50,5,"",'T','','C');
					$pdf->Cell(20,5,"",'T','','R');
					$pdf->Cell(20,5,"",'T','','R');
					$pdf->Cell(20,5,"",'T','','R');
					$pdf->Cell(20,5,"",'T','','R');
					$pdf->Cell(20,5,"",'T','','R');
					$pdf->Cell(20,5,"",'T','','R');
					$pdf->Cell(27,5,"",'T','','C');
					$pdf->Cell(30,5,"",'T','','C');
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
				//$pdf->Cell(50,5,$modePaie."*******",'LTB','','C');
				$pdf->Ln();
				if($modePaie=="general")
				{
					$pdf->SetFont('Arial','B',9);				
					$pdf->Cell(50,5,"Sous total cash",'LTB','','C');
					$pdf->Cell(20,5,$m->arrondie($st_u_c),'LRTB','','R');
					$pdf->Cell(20,5,$m->arrondie($st_c_c),'RTB','','R');
					$pdf->Cell(20,5,$m->arrondie($st_u_tva_c),'RTB','','R');
					$pdf->Cell(20,5,$m->arrondie($st_c_tva_c),'RTB','','R');
					$pdf->Cell(20,5,$m->arrondie($st_u_tt_c),'RTB','','R');
					$pdf->Cell(20,5,$m->arrondie($st_c_tt_c),'RTB','','R');
					$pdf->Cell(27,5,"",'RTB','','C');
					$pdf->Cell(30,5,"",'RTB','','C');
					$pdf->Ln();

					$pdf->SetFont('Arial','B',9);				
					$pdf->Cell(50,5,"Sous total banque",'LTB','','C');
					$pdf->Cell(20,5,$m->arrondie($st_u_b),'LRTB','','R');
					$pdf->Cell(20,5,$m->arrondie($st_c_b),'RTB','','R');
					$pdf->Cell(20,5,$m->arrondie($st_u_tva_b),'RTB','','R');
					$pdf->Cell(20,5,$m->arrondie($st_c_tva_b),'RTB','','R');
					$pdf->Cell(20,5,$m->arrondie($st_u_tt_b),'RTB','','R');
					$pdf->Cell(20,5,$m->arrondie($st_c_tt_b),'RTB','','R');
					$pdf->Cell(27,5,"",'RTB','','C');
					$pdf->Cell(30,5,"",'RTB','','C');

					$pdf->Ln();
				}
				$pdf->SetFont('Arial','B',9);				
				$pdf->Cell(50,5,"Sous total",'LTB','','C');
				$pdf->Cell(20,5,$m->arrondie($st_u),'LRTB','','R');
				$pdf->Cell(20,5,$m->arrondie($st_c),'RTB','','R');
				$pdf->Cell(20,5,$m->arrondie($st_u_tva),'RTB','','R');
				$pdf->Cell(20,5,$m->arrondie($st_c_tva),'RTB','','R');
				$pdf->Cell(20,5,$m->arrondie($st_u_tt),'RTB','','R');
				$pdf->Cell(20,5,$m->arrondie($st_c_tt),'RTB','','R');
				$pdf->Cell(27,5,"",'RTB','','C');
				$pdf->Cell(30,5,"",'RTB','','C');
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
