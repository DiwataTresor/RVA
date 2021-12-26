<?php
	@session_start();
	include("../manager/bd/cnx.php");
	
	if(isset($_SESSION['Cnx']))
	{
		$id_us=$_SESSION["Idd"];
	}
	$dt=date("Y-m-d");
	$heure=date("H:i:s");

	$ent=$_POST["ent"];
	switch($ent)
	{
		case "liste_facture_handling":
			$lim=$_POST['lim'];
			$s="select * from handling_paiement order by Id_paie desc limit $lim,150";
			$e=mysqli_query($bdd,$s);
			$n=mysqli_num_rows($e);
			$t=mysqli_fetch_array($e);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else
			{
				do
				{
					$detail=paie_handling_detail($t['Fact_paie'],$bdd);
					$user=user($t['Id_us'],$bdd);
					$mouv=handling_facture($t['Fact_paie'],$bdd);
					$r[]=array("n"=>$n,
							"dt_paie"=>Datemysqltofr($t['Date_paie']),
							"fact"=>$t["Fact_paie"],
							"imm"=>$mouv['imm'],
							"handleur"=>$mouv['handleur'],
							"mouv"=>$mouv,
							"montant"=>$t["Mttc"],
							"detail_paie"=>$detail,
							"user"=>$user
						);
				}while($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case 'liste_handleur':
			$s="select * from handling_handleur order by Nom_hand";
			$e=mysqli_query($bdd,$s);
			$n=mysqli_num_rows($e); $t=mysqli_fetch_array($e);
			$r= array();
			if($n==0)
			{
				$r[]= array('n' => 0);
			}else
			{
				do
				{
					$r[] =
						array("n"=>$n,
							'id' => $t['Id_hand'],
							"nom"=>afficher_text($t['Nom_hand']),
							"adresse"=>afficher_text($t['Adresse_hand']),
							"ville"=>afficher_text($t['Ville_hand']),
							"telephone"=>afficher_text($t['Telephone_hand']),
							"type_paie"=>afficher_text($t['Type_paie'])
						);
				}while ($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "hand_mouv_periode":
			$r=array("n"=>"50s");
			echo (json_encode($r));
		break;
		
		default:
			$s="select * from tarif_red";
			$e=mysqli_query($bdd,$s);
			$t[]=mysqli_fetch_array($e);
			echo(json_encode($t));
		break;
	}
	
?>