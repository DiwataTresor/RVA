<?php
	@session_start();
	include("../../manager/bd/cnx.php");
	class m extends main{}
	$m=new m();
	
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
			$s="select TOP 150 handling_paiement.Fact_paie,
					handling_paiement.Id_us,
					handling_paiement.Date_paie,
					handling_paiement.Mttc
				from 
					rva_facturation2.handling_paiement order by Id_paie desc";
			$e=$m->cnx->query($s);
			$row=($e->fetchall());
			$n=count($row);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else
			{
				foreach($row as $t)
				{
					@$detail=$m->paie_handling_detail($t['Fact_paie']);
					@$user=$m->user($t['Id_us']);
					@$mouv=$m->handling_facture($t['Fact_paie']);
					$r[]=array("n"=>$n,
							"dt_paie"=>$m->Datemysqltofr($t['Date_paie']),
							"fact"=>$t["Fact_paie"],
							"imm"=>$mouv['imm'],
							"handleur"=>$mouv['handleur'],
							"mouv"=>$mouv,
							"montant"=>$t["Mttc"],
							"detail_paie"=>$detail,
							"user"=>$user
						);
				}
			}
			echo (json_encode($r));
		break;
		case 'liste_handleur':
			$s="select * from rva_facturation2.handling_handleur order by Nom_hand";
			$e=$m->cnx->query($s);
			$row=($e->fetchall()); $n=count($row);
			$r= array();
			if($n==0)
			{
				$r[]= array('n' => 0);
			}else
			{
				foreach($row as $t)
				{
					$r[] =
						array("n"=>$n,
							'id' => $t['Id_hand'],
							"nom"=>$m->afficher_text($t['Nom_hand']),
							"adresse"=>$m->afficher_text($t['Adresse_hand']),
							"ville"=>$m->afficher_text($t['Ville_hand']),
							"telephone"=>$m->afficher_text($t['Telephone_hand']),
							"type_paie"=>$m->afficher_text($t['Type_paie'])
						);
				}
			}
			echo (json_encode($r));
		break;
		case "hand_mouv_periode":
			$client=$_POST["client"];
			$dt1=$_POST["dt1"];
			$dt2=$_POST["dt2"];
			$r=array();
			$ligne=array();
			if($client=="T")
			{
				$s="select * from rva_facturation2.handling_facturation where Date_dep between '$dt1' and '$dt2'";
				$e=$m->cnx->query($s);
				$t=($e->fetchall());
				$n=count($t);
			}else
			{
				$s="select * from rva_facturation2.handling_facturation where handleur='$client' and Date_dep between '$dt1' and '$dt2'";
				$e=$m->cnx->query($s);
				$t=($e->fetchall());
				$n=count($t);
			}
			if($n==0)
			{
				$r=array("n"=>0);
			}else
			{

				foreach($t as $row)
				{
					@$l=$m->handling_facture($row["Id_fact"]);
					$ligne[]=array($l);
				}
				@$r=array("n"=>$n,"ligne"=>$ligne);

			}
			echo(json_encode($r));
		break;
		case "hand_del":
			$arg=$_POST["e"];
			$id=$_POST["id"];
			switch ($arg) {
				case 'facture':
					$s0="select * from rva_facturation2.handling_facturation where Id_fact='$id'";
					$e0=$m->cnx->query($s0);
					$t0=($e0->fetchall());
					$facture=$m->handling_facture($id);
					if($facture["handleur_type_paie"]!="C")
					{
						$s="delete from rva_facturation2.handling_facturation where Id_fact='$id'";
						if($m->cnx->exec($s))
						{
							echo(1);
						}else
						{
							echo(0);
						}
					}else
					{
						if($_SESSION["Priv"]=="adm")
						{
							$s="delete from rva_facturation2.handling_facturation where Id_fact='$id'";
							if($m->cnx->exec($s))
							{
								$m->cnx->exec("delete from rva_facturation2.handling_paiement where Fact_paie='$id'");
								$m->cnx->exec("delete from rva_facturation2.handling_num_fact where Id_fact='$id'");
								echo(1);
							}else
							{
								echo ("Erreur pendant la suppression, veuillez reessayer");
							}
						}else
						{
							$s3="select * from rva_facturation2.handling_paiement where Fact_paie='$id'";
							$e3=$m->cnx->query($s3);
							$t3=($e3->fetchall());
							$n3=count($t3);
							if($n3!=0)
							{
								echo (3);
							}else
							{
								$s="delete from rva_facturation2.handling_facturation where Id_fact='$id'";
								$m->cnx->exec($s);
								echo(1);
							}
						}
					}
					break;
				
				default:
					# code...
					break;
			}
		break;
		
		default:
			$s="select * from tarif_red";
			$e=mysqli_query($bdd,$s);
			$t[]=mysqli_fetch_array($e);
			echo(json_encode($t));
		break;
	}
	
?>