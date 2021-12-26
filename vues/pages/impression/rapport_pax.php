<?php
	include("../../../manager/bd/cnx.php");
	include("../../../manager/parametre/parametre.php");
	class m extends main{}
	$m=new m();
	
	$dt1=$_REQUEST['dt1'];
	$dt2=$_REQUEST['dt2'];
	$client=$_REQUEST["client"];
	$imm=$_REQUEST["imm"];
    $a_ad=0;
    $a_enf=0;
    $a_beb=0;
    $d_ad=0;
    $d_enf=0;
    $d_beb=0;
    $a_total=0;
	$d_total=0;
	$exploitant="";
	if($client=='T')
	{
		$exploitant="Tous";
    	$sa="select * from rva_facturation2.escale,rva_facturation2.mouvement2 
        where 
            escale.Id_mouv=mouvement2.Num_mouv
        and
            escale.Sens='A'
        and
            Date_mouv between '$dt1' and '$dt2'
        and
            mouvement2.Sens='A'";
			$ea=$m->cnx->query($sa);
			$rowa=($ea->fetchAll());
			$na=count($rowa);
			$r=array();
	}else
	{
		if($imm=="T")
		{
			$cli=$m->client($client);
			$exploitant=$cli["nom_cl"];
			$sa="select * from rva_facturation2.mouvement2,rva_facturation2.immatriculation,rva_facturation2.client
					where 
						mouvement2.Immatr=immatriculation.Id_imm
					and
						immatriculation.Code_pr=client.Id_cl
					and
						client.Id_cl='$client'
					and
						mouvement2.Sens='D' 
					and 
						Date_mouv between '$dt1' and '$dt2'";
			$ea=$m->cnx->query($sa);
			$rowa=($ea->fetchAll());
			$na=count($rowa);
			$r=array();
		}else
		{
			$cli=$m->client($client);
			$immat=$m->immatriculation($imm);
			$exploitant=$cli["nom_cl"]."/ Immatriculation : ".$immat["detail"];
			$sa="select * from rva_facturation2.mouvement2
					where 
						Immatr='$imm'
					and
						mouvement2.Sens='D' 
					and 
						Date_mouv between '$dt1' and '$dt2'";
				$ea=$m->cnx->query($sa);
				$rowa=($ea->fetchAll());
				$na=count($rowa);
				$r=array();
		}
	}    
	foreach ($rowa as $ligneMouvA) {
		$mouve=$ligneMouvA["Num_mouv"];
		$escalesa=$m->mouvEscalesA($mouve);
		foreach ($escalesa as $escalea) {
			$a_ad+=$escalea["Ad"];
        	$a_enf+=$escalea["Ch"];
			$a_beb+=$escalea["Inf"];
		}
	}
    $a_total=$a_ad+$a_enf+$a_beb;
            
    foreach ($rowa as $ligneMouvD) {
		$mouve=$ligneMouvD["Num_mouv"];
		$escalesd=$m->mouvEscalesD($mouve);
		foreach ($escalesd as $escaled) {
			$d_ad+=$escaled["Ad"];
        	$d_enf+=$escaled["Ch"];
			$d_beb+=$escaled["Inf"];
		}
	}
    $d_total=$d_ad+$d_enf+$d_beb;
	if($na==0)
	{		
		echo "<div align='center' class='bold center green'>Aucune donnée trouvée à cette periode</div>";
	}else
	{
		require("../../../plugins/fpdf/fpdf.php");
		require("../../../plugins/chiffresEnLettres.php");
		
	
		class PDF extends FPDF
		{
			function Footer()
			{
				
			}
		}
		$taille=array(250,300);
		$pdf = new PDF('P','mm','A4');
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetLeftMargin(15);
		$pdf->SetTopMargin(25);
		$pdf->SetFont('Arial','B',10);
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
		
		$pdf->Ln(28);
		$pdf->SetFont('Arial','BU',10);
		$pdf->Cell(180,5,("RAPPORT PERIODIQUE DES PASSAGERS "),'','','C');	
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(180,5,("DU ".$m->Datemysqltofr($dt1)." AU ".$m->Datemysqltofr($dt2)),'','','C');	
		$pdf->Ln();
		$pdf->Cell(180,5,("Exploitant : ".$exploitant),'','','C');	
			$pdf->Ln(10);
			$pdf->SetFont('Arial','B',8);

			$pdf->Cell(180,5,("Nombre mouv : ".count($rowa)),'','','L');	
			$pdf->Ln();
			
			$pdf->Cell(15,5,("SENS"),'LTRB','','C');
			
			$pdf->Cell(30,5,("ADULTE(S)"),'LTRB','','C');
			$pdf->Cell(20,5,("ENFANT(S)"),'TRB','','C');
            $pdf->Cell(20,5,("BEBE(S)"),'TRB','','C');	
            $pdf->Cell(20,5,("TOTAL"),'TRB','','C');		
            
            $pdf->Ln();
			$pdf->Cell(15,5,utf8_decode("Arrivée"),'LTRB','','C');
			$pdf->Cell(30,5,($a_ad),'LTRB','','C');
			$pdf->Cell(20,5,($a_enf),'TRB','','C');
            $pdf->Cell(20,5,($a_beb),'TRB','','C');	
            $pdf->Cell(20,5,($a_total),'TRB','','C');
            $pdf->Ln();
			$pdf->Cell(15,5,utf8_decode("Depart"),'LTRB','','C');
			$pdf->Cell(30,5,($d_ad),'LTRB','','C');
			$pdf->Cell(20,5,($d_enf),'TRB','','C');
            $pdf->Cell(20,5,($d_beb),'TRB','','C');	
            $pdf->Cell(20,5,($d_total),'TRB','','C');

           $pdf->Ln();
			$pdf->Cell(15,5,utf8_decode("TOTAL"),'LTRB','','C');
			$pdf->Cell(30,5,($a_ad+$d_ad),'LTRB','','C');
			$pdf->Cell(20,5,($a_enf+$d_enf),'TRB','','C');
            $pdf->Cell(20,5,($a_beb+$d_beb),'TRB','','C');		
            $pdf->Cell(20,5,($d_total+$a_total),'TRB','','C');
		
			 //$pdf->Ln(10);
			$pdf->AddPage();
			$pdf->Cell(20,5,utf8_decode("IMMATR"),'LTBR','','C');
			$pdf->Cell(15,5,utf8_decode("DATE ARR"),'LTBR','','C');
			$pdf->Cell(20,5,("Adulte(s)"),'TRB','','C');
			$pdf->Cell(20,5,("Enfant(S)"),'TRB','','C');
			$pdf->Cell(20,5,utf8_decode("Bébé(S)"),'TRB','','C');
			$pdf->Cell(15,5,utf8_decode("DATE DEP"),'TRB','','C');
			$pdf->Cell(20,5,("Adulte(S)"),'TRB','','C');
			$pdf->Cell(20,5,("Enfant(S)"),'TRB','','C');
			$pdf->Cell(20,5,utf8_decode("Bébé(S)"),'TRBR','','C');
			$pdf->Ln();
			$Tadultes=0;
				$Tenfants=0;
				$Tbebes=0;
			foreach ($rowa as $ligne) {
				
				$mouve=$ligne["Num_mouv"];
				
				$Mouve=$m->mouv($mouve);
				//var_dump($Mouve);
				$mouva=$m->mouvEscalesA($mouve);
				$mouvd=$m->mouvEscalesD($mouve);
				$adultes=0;
				$enfants=0;
				$bebes=0;
				
				$adultesD=0;
				$enfantsD=0;
				$bebesD=0;
				
				foreach ($mouva as $ligne) {
					$adultes+=$ligne["Ad"];
					$enfants+=$ligne["Ch"];
					$bebes+=$ligne["Inf"];
				}
				$Tadultes+=$adultes;
				foreach ($mouvd as $ligne) {
					@$adultesD+=$ligne["Ad"];
					@$enfantsD+=$ligne["Ch"];
					@$bebesD+=$ligne["Inf"];
				}
				$pdf->Cell(20,5,($Mouve["code_imm"]),'TRL','','C');
				$pdf->Cell(15,5,utf8_decode($m->Datemysqltofr($Mouve["ta"][0]["Date_mouv"])),'LTBR','','C');
				$pdf->Cell(20,5,($adultes),'TR','','C');
				$pdf->Cell(20,5,($enfants),'TR','','C');
				$pdf->Cell(20,5,utf8_decode($bebes),'TR','','C');
				@$pdf->Cell(15,5,utf8_decode($m->Datemysqltofr($Mouve["td"][0]["Date_mouv"])),'TRB','','C');
				$pdf->Cell(20,5,($adultesD),'TR','','C');
				$pdf->Cell(20,5,($enfantsD),'TR','','C');
				$pdf->Cell(20,5,utf8_decode($bebesD),'TRR','','C');
				$pdf->Ln();
			}
			$pdf->Cell(15,5,"",'T','','C');
				$pdf->Cell(30,5,'','T','','C');
				$pdf->Cell(20,5,"",'T','','C');
				$pdf->Cell(20,5,"",'T','','C');
				$pdf->Cell(15,5,"",'T','','C');
				$pdf->Cell(30,5,'','T','','C');
				$pdf->Cell(20,5,'','T','','C');
				$pdf->Cell(20,5,'','T','','C');
				$pdf->Ln();

		$pdf->Output();
	}
?>