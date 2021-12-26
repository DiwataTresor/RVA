<?php
	include("../../../manager/bd/cnx.php");
	include("../../../manager/parametre/parametre.php");
	class m extends main{}
	$m=new m();
	$acces=$_GET['acces'];
	$dt1=$_GET['dt1'];
	$dt2=$_GET['dt2'];
	$s="select * from rva_facturation2.acces,rva_facturation2.type_acces where acces.Type_acc=type_acces.Id_acc and acces.Type_acc='$acces' and Date_perc between '$dt1' and '$dt2'";
	$e=$m->cnx->query($s); $row=($e->fetchAll()); $n=count($row);
	if($n==0)
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
		$pdf->Cell(180,5,("RELEVE DE RECETTES ".$row[0]["Designation_acc"]),'','','C');	
		$pdf->Ln();
		$pdf->SetFont('Arial','BU',9);
		$pdf->Cell(180,5,("DU ".$m->Datemysqltofr($dt1)." AU ".$m->Datemysqltofr($dt1)),'','','C');	
			$pdf->Ln(10);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(20,5,("DATE"),'LTRB','','C');
			$pdf->Cell(20,5,("MHT FC"),'TRB','','C');
			$pdf->Cell(20,5,("TVA (FC)"),'TRB','','C');	
			$pdf->Cell(20,5,("MHT USD"),'TRB','','C');
			$pdf->Cell(20,5,("TVA (USD)"),'TRB','','C');	
			$pdf->Cell(15,5,("ARR. FC"),'TRB','','C');
			$pdf->Cell(15,5,("ARR. USD"),'TRB','','C');	
			$pdf->Cell(20,5,("TTC FC"),'TRB','','C');
			$pdf->Cell(30,5,("TTC USD"),'TRB','','C');	
			$mttusd=0;
			$mttcdf=0;
			$usd=0;
			$cdf=0;
			$arrondiecdf_total=0;
			$arrondieusd_total=0;
			$tvausd_total=0;
			$tvacdf_total=0;
			$ttccdf_total=0;
			$ttcusd_total=0;
			foreach($row as $t)
			{
				$pdf->Ln();
				if($t["Monn_acc"]=="USD")
				{
					$mhtusd=$t['Mt_acc'];
					$mhtcdf=0;
					$tvacdf=0;
					if($t["Tva"]=="O")
					{
						$tvausd=$m->tva($mhtusd);
					}else
					{
						$tvausd=0;
					}
					$mttusd=ceil($mhtusd+$tvausd);
					$mttcdf=0;
					$arrondieusd=$mttusd-($mhtusd+$tvausd);
					$arrondiecdf=0;
				}else
				{
					$mhtcdf=$t['Mt_acc'];
					$mhtusd=0;
					$tvausd=0;
					if($t["Tva"]=="O")
					{
						$tvacdf=tva($mhtcdf);
					}else
					{
						$tvacdf=0;
					}
					$mttcdf=($mhtcdf+$tvacdf);
					$mttusd=0;
					$arrondiecdf=0;
					$arrondieusd=0;
				}
				$pdf->Cell(20,5,$m->Datemysqltofr($t['Date_perc']),'LTRB','','C');
				$pdf->Cell(20,5,$m->arrondie($mhtcdf),'TRB','','R');
				$pdf->Cell(20,5,$m->arrondie($tvacdf),'TRB','','R');	
				$pdf->Cell(20,5,$m->arrondie($mhtusd),'TRB','','R');
				$pdf->Cell(20,5,$m->arrondie($tvausd),'TRB','','R');	
				$pdf->Cell(15,5,$m->arrondie($arrondiecdf),'TRB','','R');	
				$pdf->Cell(15,5,$m->arrondie($arrondieusd),'TRB','','R');	
				$pdf->Cell(20,5,$m->arrondie($mttcdf),'TRB','','R');	
				$pdf->Cell(30,5,$m->arrondie($mttusd),'TRB','','R');	
				
				
				//=========== TOTAUX =============
				$usd=$usd+$mhtusd;
				$cdf=$cdf+$mhtcdf;
				$tvausd_total=$tvausd_total+$tvausd;
				$tvacdf_total=$tvacdf_total+$tvacdf;
				$arrondiecdf_total=$arrondiecdf_total+$arrondiecdf;
				$arrondieusd_total=$arrondieusd_total+$arrondieusd;
				$ttccdf_total=$ttccdf_total+$mttcdf;
				$ttcusd_total=$ttcusd_total+$mttusd;
				
			}
				
				$pdf->Ln(10);
				$pdf->Cell(20,5,("TOTAL"),'LTRB','','C');
				$pdf->Cell(20,5,$m->arrondie($cdf),'TRB','','R');
				$pdf->Cell(20,5,$m->arrondie($tvacdf_total),'TRB','','R');	
				$pdf->Cell(20,5,$m->arrondie($usd),'TRB','','R');
				$pdf->Cell(20,5,$m->arrondie($tvausd_total),'TRB','','R');	
				$pdf->Cell(15,5,$m->arrondie($arrondiecdf_total),'TRB','','R');	
				$pdf->Cell(15,5,$m->arrondie($arrondieusd_total),'TRB','','R');	
				$pdf->Cell(20,5,$m->arrondie($ttccdf_total),'TRB','','R');	
				$pdf->Cell(30,5,$m->arrondie($ttcusd_total),'TRB','','R');		
		$pdf->Output();
	}
?>