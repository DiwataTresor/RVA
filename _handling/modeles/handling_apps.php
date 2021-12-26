<?php
	header('Content-Type: application/json');
	require("../plugins/chiffresEnLettres.php");

	
	$cnx=new PDO("mysql:host=localhost;dbname=rva_facturation","root","");
	
	if(isset($_SESSION['Cnx']))
	{
		$id_us=$_SESSION["Idd"];
	}
	$dt=date("Y-m-d");
	$heure=date("H:i:s");

	$ent=$_GET["ent"];
	$type_paie=array("C"=>"Cash","M"=>"Mensuel");
	$nationalite=array("C"=>"Congolaise","E"=>"Etrangère");
	function user($id,$cnx)
	{
		$priv = array('perc' =>"Percepteur/Taxateur/Facturateur",
			"agent_handl"=>"Agent Handling",
			"ch_serv"=>"Chef de service",
			"ch_bur"=>"Chef de bureau",
			"ut"=>"Utilisateur",
			"adm"=>"Administrateur");
		$s="select * from user where Id_us='$id'"; 
		$e=$cnx->query($s);
		$t=$e->fetchAll();
		$r=array("matr"=>$t[0]['Matricule'],"nom"=>($t[0]['Nom_complet']),"login"=>$t[0]['Login'],"priv"=>$t[0]['Priv']);
		return $r;
	}
	function tva($n)
	{
		$tva=($n*16)/100;
		return $tva;
	}
	function format_nbre($n)
	{
		if($n>0 && $n<10)
		{
			$v="00".$n;
		}else if($n>9 || $n<100 )
		{
			$v="0".$n;
		}else
		{
			$v=$n;
		}
		return $v;
	}
	function arrondie($n)
	{
		return(number_format($n,2,","," "));
	}
	function arrondie_sup($n)
	{
		$v=explode(",", ($n));
		if(isset($v[1]) && intval($v[1])!==00 && intval($v[1])!==0)
		{
			$r=intval($v[0])+1;
		}else
		{
			$r=$v[0];
		}
		return $r;
		//return $n[1];
	}
	function Datemysqltofr($d)
	{
		$d=explode("-",$d);
		@$new_date=$d[2]."/".$d[1]."/".$d[0];
		return $new_date;
	}
	function Heureformat($h)
	{
		return (substr($h, 0,5));
	}
	function jrSemaine($dt)
	{
		$jr_mois=array(0=>"Dimanche",1=>"Lundi",2=>"Mardi",3=>"Mercredi",4=>"Jeudi",5=>"Vendredi",6=>"Samedi");
		$jour=explode("-",$dt);
		$jour_ann=$jour[0];
		$jour_mois=$jour[1];
		$jour_annee=$jour[2];
				
		$jr=mktime(0,0,0,$jour[1],$jour[2],$jour[0]);
		$jr=date('w',$jr);
		return $jr_mois[$jr];
	}
	function mois($dt)
	{
		$liste_mois=array('Jan'=>"JAN",'Feb'=>"FEV",'Mar'=>"MAR",'Apr'=>"AVR",'May'=>"MAI",'Jun'=>"JUI",'Jul'=>"JUIL",'Aug'=>'AOUT','Sep'=>'SEPT','Oct'=>'OCT','Nov'=>'NOV','Dec'=>'DEC');
		$jour=explode("-",$dt);
		$jour_ann=$jour[0];
		$jour_mois=$jour[1];
		$jour_annee=$jour[2];
				
		$jr=mktime(0,0,0,$jour[1],$jour[2],$jour[0]);
		$mois=date('M',$jr);
		return $liste_mois[$mois];
		//return $jr;
	}
	function mois_chiffre($dt)
	{
		$jour=explode("-",$dt);
		$jour_ann=$jour[0];
		$jour_mois=$jour[1];
		$jour_annee=$jour[2];
		return $jour_mois;	
	}
	function mois_long($dt)
	{
		$liste_mois=array('Jan'=>"Janvier",'Feb'=>"Février",'Mar'=>"Mars",'Apr'=>"Avril",'May'=>"Mai",'Jun'=>"Juin",'Jul'=>"Juillet",'Aug'=>'Aout','Sep'=>'Septembre','Oct'=>'Octobre','Nov'=>'Novembre','Dec'=>'Decembre');
		$jour=explode("-",$dt);
		$jour_ann=$jour[0];
		$jour_mois=$jour[1];
		$jour_annee=$jour[2];
				
		$jr=mktime(0,0,0,$jour[1],$jour[2],$jour[0]);
		$mois=date('M',$jr);
		return $liste_mois[$mois];
		//return $jr;
	}
	function annee($dt)
	{
		$liste_mois=array('Jan'=>"Janvier",'Feb'=>"Février",'Mar'=>"Mars",'Apr'=>"Avril",'May'=>"Mai",'Jun'=>"Juin",'Jul'=>"Juillet",'Aug'=>'Aout','Sep'=>'Septembre','Oct'=>'Octobre','Nov'=>'Novembre','Dec'=>'Decembre');
		$jour=explode("-",$dt);
		$jour_ann=$jour[0];
		$jour_mois=$jour[1];
		$jour_annee=$jour[2];
				
		$jr=mktime(0,0,0,$jour[1],$jour[2],$jour[0]);
		$annee=date('Y',$jr);
		return $annee;
		//return $jr;
	}

	function retour_champ($table,$col,$v,$col_ret,$cnx)
	{
		$s="select * from $table where $col='$v'";
		$e=$cnx->query($s);
		$t=$e->fetchAll();
		return $t[0][$col_ret];
	}
	function handling_facture($id,$cnx)
	{
		$s="select * from 
				handling_facturation,immatriculation,handling_handleur,client,type_avion
			where 
				handling_facturation.Immatriculation=immatriculation.Id_imm 
			and
				handling_facturation.Handleur=handling_handleur.Id_hand
			and
				immatriculation.Code_pr=client.Id_cl
			and
				immatriculation.Type_av=type_avion.Id_typ
			and
				handling_facturation.Id_fact='$id'
			";
		$e=$cnx->query($s);
		$t=$e->fetchAll();
		//$n=mysqli_num_rows($e);
		if($t[0]['Poids']<150)
		{
			if($t[0]['AA']=="O")
			{
				$AA_prix=31;
			}else
			{
				$AA_prix=0;
			}

			if($t[0]['TA']=="O")
			{
				$TA_prix=21;
			}else
			{
				$TA_prix=0;
			}

			if($t[0]['FA']=="O")
			{
				$FA_prix=42;
			}else
			{
				$FA_prix=0;
			}
		}else
		{
			if($t[0]['AA']=="O")
			{
				$AA_prix=37;
			}else
			{
				$AA_prix=0;
			}

			if($t[0]['TA']=="O")
			{
				$TA_prix=54;
			}else
			{
				$TA_prix=0;
			}

			if($t[0]['FA']=="O")
			{
				$FA_prix=54;
			}else
			{
				$FA_prix=0;
			}
		}

		$prix_fact=$AA_prix+$TA_prix+$FA_prix;


		//========== TOUCHE ==============
			$touche="";
			if($t[0]['TA']=="O")
			{
				$touche=$touche." TA ";
			}
			if($t[0]['AA']=="O")
			{
				$touche=$touche." AA ";
			}
			if($t[0]['FA']=="O")
			{
				$touche=$touche." FA ";
			}
		//================================
		$user=user($t[0]['Id_us'],$cnx);
		$r=array("dt_fact"=>Datemysqltofr($t[0]['Date_fact']),
				"imm"=>$t[0]["Code_imm"],
				"poids"=>$t[0]['Poids'],
				"type_av"=>$t[0]["Libelle_typ"],
				"heure"=>$t[0]["Heure_fact"],
				"handleur"=>$t[0]['Nom_hand'],
				"handleur_code"=>$t[0]['Code_hand'],
				"handleur_nationalite"=>$t[0]['Nationalite'],
				"client"=>$t[0]['Nom_cli'],
				"adresse_handleur"=>$t[0]['Adresse_hand'],
				"ville_handleur"=>$t[0]['Ville_hand'],
				"dt_fact"=>Datemysqltofr($t[0]["Date_fact"]),
				"heure_arr"=>$t[0]["Heure_arr"],
				"dt_arr"=>Datemysqltofr($t[0]["Date_arr"]),
				"heure_dep"=>$t[0]["Heure_dep"],
				"dt_dep"=>Datemysqltofr($t[0]["Date_dep"]),
				"handleur"=>$t[0]['Nom_hand'],
				"aa"=>$t[0]["AA"],
				"ta"=>$t[0]["TA"],
				"fa"=>$t[0]["FA"],
				"aa_prix"=>arrondie($AA_prix),
				"ta_prix"=>arrondie($TA_prix),
				"fa_prix"=>arrondie($FA_prix),
				"mht"=>arrondie($prix_fact),
				"tva"=>arrondie(tva($prix_fact)),
				"mttc"=>arrondie(ceil($prix_fact+tva($prix_fact))),
				"touche"=>$touche,
				"user"=>$user
			);
		return $r;
	}
	function paie_handling_detail($fact,$cnx)
	{
		$s="select * from handling_num_fact where Id_fact='$fact'";
		$e=$cnx->query($s);
		$t=$e->fetchAll();

		$s2="select * from handling_paiement where Fact_paie='$fact'";
		$e2=$cnx->query($s2);
		$t2=$e2->fetchAll();

		$s3="select * from handling_num_fact where Id_fact='$fact'";
		$e3=$cnx->query($s3);
		$t3=$e3->fetchAll();

		$user=user($t2[0]['Id_us'],$cnx);
		$detail_fact=handling_facture($fact,$cnx);
		@$r=array(
			"lelo"=>Datemysqltofr(date("Y-m-d")),
			"dt_fact"=>Datemysqltofr($t[0]['Date_fact']),
			"dt_paie"=>Datemysqltofr($t2[0]['Date_paie']),
			"num_fact"=>$t3[0]['Num_fact_long'],
			"percepteur"=>$user['nom'],
			"mht"=>arrondie($t2[0]['Mht']),
			"tva"=>arrondie($t2[0]['Tva']),
			"mttc"=>arrondie($t2[0]['Mttc']),
			"quittance"=>format_nbre($t2[0]['Id_paie']),
			"detail"=>$detail_fact
			);

		return $r;
	}
	switch($ent)
	{
		case "test":
			$imm=retour_champ("immatriculation","Code_imm","ETALK","Id_imm",$cnx);
			echo($imm);
		break;
		case "login":
			$login=$_GET["login"];
			$mdp=$_GET["mdp"];
			$s="select * from user where Login='$login' and Mdp='$mdp' and Statut!='S'";
			$e=$cnx->query($s);
			$t=$e->fetchAll();
			if(count($t)!=0)
			{
				$r=array("n"=>1,"id"=>$t[0]["Id_us"],"nom"=>$t[0]["Nom_complet"],"login"=>$t[0]["Login"],"mdp"=>$t[0]["Mdp"],"priv"=>$t[0]["Priv"]);
			}else
			{
				$r=array("n"=>0);	
			}
			
			echo(json_encode($r));
		break;
		case "add_handleur":
			$nom=$_GET["nom"];
			$code=$_GET["code"];
			$adresse=$_GET["adresse"];
			$ville=$_GET["ville"];
			$telephone=$_GET["telephone"];
			$paiement=$_GET["paiement"];
			$nationalite=$_GET["nationalite"];

			$s="insert into handling_handleur values ('','$code','$nom','$adresse','$ville','$telephone','$paiement','$nationalite')";
			if($cnx->exec($s))
			{
				$r=array(1);
			}else
			{
				$r=array(0);
			}
			echo(json_encode($r));
		break;
		case "facturation":
			$operateur=explode("|", $_GET["operateur"]);
			$operateur=trim($operateur[0]);
			$operateur=retour_champ("handling_handleur","Code_hand",$operateur,"Id_hand",$cnx);
			$immatriculation=explode("|", $_GET["immatriculation"]);
			$immatriculation=trim($immatriculation[0]);
			$immatriculation=retour_champ("immatriculation","Code_imm",$immatriculation,"Id_imm",$cnx);
			$dt_arr=$_GET["dt_arr"];
			$h_arr=$_GET["h_arr"];
			$dt_dep=$_GET["dt_dep"];
			$h_dep=$_GET["h_dep"];
			$aa=$_GET["aa"];
			$ta=$_GET["ta"];
			$fa=$_GET["fa"];
			$id=$_GET["id"];

			$s="insert into handling_facturation values('','$dt','$heure','$operateur','$immatriculation','$dt_arr','$h_arr','$dt_dep','$h_dep','$aa','$ta','$fa','$id')";
			if ($cnx->exec($s)) {
				$r=array(1);
			}else
			{
				$r=array(0);
			}
			echo(json_encode($r));
		break;
		case "paiement_facture":
			$fact=$_GET["facture"];
			$poids=$_GET["poids"];
			$mht=$_GET["mht"];
			$tva=$_GET["tva"];
			$mttc=$_GET["mttc"];
			$id_us=$_GET["id"];

			$s="select * from handling_paiement where Fact_paie='$fact'";
			$e=$cnx->query($s);
			$t=$e->fetchAll();
			$n=count($t);
			if($n!==0)
			{
				$r=array(3);
			}else
			{
				$s="insert into 
						handling_paiement 
					values('',
						'$dt',
						'$heure',
						'$fact',
						'$poids',
						'$mht',
						'$tva',
						'$mttc',
						'$id_us')
					";
				if($cnx->exec($s))
				{
					$s2="select * from handling_paiement where Fact_paie='$fact'";
					$e2=$cnx->query($s2);
					$t2=$e2->fetchAll();
					$num_fact_paie=$t2[0]['Id_paie'];

					$s3="select * from handling_num_fact order by Id_num desc";
					$e3=$cnx->query($s3);
					$t3=$e3->fetchAll();
					$n3=count($t3);
					if($n3==0)
					{
						$num_fact_nouveau=1;
						$num_fact_nouveau_long=format_nbre(1)."/RDH.FZQA/".date("d.Y");
						$cnx->exec("insert into handling_num_fact values('',1,'$num_fact_nouveau_long','$fact','$num_fact_paie','V')");
					}else
					{
						$num_fact_dernier_ligne=$t3[0]['Num_fact'];
						$num_fact_nouveau=$num_fact_dernier_ligne+1;
						$num_fact_nouveau_long=format_nbre($num_fact_dernier_ligne+1)."/RDH.FZQA/".date("d.Y");
						$cnx->exec("insert into handling_num_fact values('','$num_fact_nouveau','$num_fact_nouveau_long','$fact','$num_fact_paie','V')");
					}
					$r=array(1);
				}else
				{
					$r=array(0);
				}
			}
			echo (json_encode($r));
		break;
		case "liste_handleur":
			$s="select * from handling_handleur order by Nom_hand";
			$e=$cnx->query($s);
			$t=$e->fetchAll();
			$r=array();
			if(count($t)==0)
			{
				$r[]=array("n"=>0);
			}else
			{
				foreach ($t as $row) {
					$r[]=array(
						"n"=>count($t),
						"id"=>$row["Id_hand"],
						"code"=>$row["Code_hand"],
						"nom"=>$row["Nom_hand"],
						"adresse"=>$row["Adresse_hand"],
						"telephone"=>$row["Telephone_hand"],
						"ville"=>$row["Ville_hand"],
						"adresse"=>$row["Adresse_hand"],
						"paiement"=>$type_paie[$row["Type_paie"]],
						"nationalite"=>$nationalite[$row["Nationalite"]]
					);
				}
			}
			echo(json_encode($r));
		break;
		case "liste_immatriculation":
			$s="select * from immatriculation,client where immatriculation.Code_pr=client.Id_cl order by Code_imm";
			$e=$cnx->query($s);
			$t=$e->fetchAll();
			$r=array();
			if(count($t)==0)
			{
				$r[]=array("n"=>0);
			}else
			{
				foreach ($t as $row) {
					$r[]=array(
						"n"=>count($t),
						"id"=>$row["Id_imm"],
						"code"=>$row["Code_imm"],
						"client"=>$row["Nom_cli"]
					);
				}
			}
			echo(json_encode($r));
		break;
		case "liste_facture":
			$s="select * from 
					handling_facturation
				order by 
					handling_facturation.Id_fact desc 
				limit 
					0,200";
			$e=$cnx->query($s);
			$t=$e->fetchAll();
			$r=array();
			if(count($t)==0)
			{
				$r[]=array("n"=>0);
			}else
			{
				foreach($t as $row)
				{
					$r[]=array(
						"n"=>count($t),
						"id"=>$row["Id_fact"],
						"detail"=>handling_facture($row["Id_fact"],$cnx)
					);
				}
			}
			echo(json_encode($r));
		break;
		case "liste_paie":
			$lim=$_GET['lim'];
			$s="select * from handling_paiement order by Id_paie desc limit $lim,150";
			$e=$cnx->query($s);
			$t=$e->fetchAll();
			$n=count($t);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else
			{
				foreach($t as $row)
				{
					$detail=paie_handling_detail($row['Fact_paie'],$cnx);
					$user=user($row['Id_us'],$cnx);
					$mouv=handling_facture($row['Fact_paie'],$cnx);
					$r[]=array("n"=>$n,
							"dt_paie"=>Datemysqltofr($row['Date_paie']),
							"fact"=>$row["Fact_paie"],
							"imm"=>$mouv['imm'],
							"handleur"=>$mouv['handleur'],
							"mouv"=>$mouv,
							"montant"=>$row["Mttc"],
							"detail_paie"=>$detail,
							"user"=>$user
						);
				}
			}
			echo (json_encode($r));
		break;
		case "detail_fact":
			$id_fact=$_GET["id"];
			$r=array("detail"=>handling_facture($id_fact,$cnx));
			echo(json_encode($r));
		break;
		case "facture":

			$detail=paie_handling_detail($_GET["id"],$cnx);
			$lettre=new ChiffreEnLettre();
			//$tot_avec_tva=explode(",",arrondie($tot_avec_tva));
			
			//$tot_avec_tva=$tot_avec_tva[0]+1;
 			$v=$lettre->Conversion($detail['mttc']);
			$v=str_replace("deux","deux ",$v);
			$v=str_replace("mille","",$v);
			$_enlettre=ucwords($v);


			$r=array($detail,$_enlettre);
			echo(json_encode($r));
		break;
		case "upd_handleur":
			$nom=$_GET["nom"];
			$code=$_GET["code"];
			$adresse=$_GET["adresse"];
			$ville=$_GET["ville"];
			$telephone=$_GET["telephone"];
			$paiement=$_GET["paiement"];
			$nationalite=$_GET["nationalite"];
			$id=$_GET["id"];

			$s="update handling_handleur set Code_hand='$code',Nom_hand='$nom',Adresse_hand='$adresse',Ville_hand='$ville',Telephone_hand='$telephone',Type_paie='$paiement',Nationalite='$nationalite' where Id_hand='$id'";
			try{
				$cnx->exec($s);
				$r=array(1);
			}catch(Exception $ex)
			{
				
				$r=array($ex);
			}
			echo(json_encode($r));
		break;
		case "del_handleur":
			$id=$_GET["id"];
			$s="delete from handling_handleur where Id_hand='$id'";
			try{
				$cnx->exec($s);
				$r=array(1);
			}catch(Exception $ex)
			{
				
				$r=array(0);
			}
			echo(json_encode($r));
		break;
	}
	
?>