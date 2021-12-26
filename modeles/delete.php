<?php
	@session_start();
	include("../manager/bd/cnx.php");
	$dt=date("Y-m-d");
	$heure=date("H:i");
	$ent=$_POST["ent"];
	class m extends main
	{}
	$m=new m();
	if(isset($_SESSION['Cnx']))
	{
		$id_us=$_SESSION["Idd"];
	}
	switch ($ent){
		case "del":
			$tabl=$_POST['tabl'];
			$colone=$_POST['colone'];
			$colone_val=$_POST['colone_val'];
			$s="delete from rva_facturation2.$tabl where $colone='$colone_val'";
			if($m->cnx->exec($s))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "mouvement":
			$formulaire=$_POST['formulaire'];
			$imm=($_POST["imm"]);
			$s="select * from rva_facturation2.immatriculation where immatriculation.Code_imm='$imm'";
			$e=$m->cnx->query($s);
			@$t=$e->fetchAll();
			$n=count($t);
			if($n==0){$id=null; }else {
				$id=$t[0]['Id_imm'];
			}
				
				$s="select * from rva_facturation2.mouvement2 where Num_form='$formulaire'";
			$e=$m->cnx->query($s);
			@$t=$e->fetchAll();
			$n=count($t);
			if($n==0)
			{
				$r=array("n"=>0);
			}else
			{
				@$num_mouv=$t[0]['Num_mouv'];
				
				$s2="select * from rva_facturation2.facture_imprime where Mouv='$num_mouv'";
				$e2=$m->cnx->query($s2); $t2=$e2->fetchAll();
				$n2=count($t2);
				if($n2==0)
				{
					@$mouv=$m->mouv($num_mouv);
					@$user=$m->user($mouv["ta"][0]['Us']);
					$dt=$m->Datemysqltofr($mouv["ta"][0]['Date_mouv']);
					$r=array("n"=>1,
						"dt"=>$dt,
						"nom"=>$user["nom"],
						"num_mouv"=>$num_mouv
					);
					@$r=array_merge_recursive($r,$mouv);
				}else
				{
					$r=array("n"=>3);

				}
				
			}
			echo (json_encode($r));
			//echo ($formulaire);
		break;
		case "mouvement_conf":
			$mouv=$_POST['mouv'];
			$motif=$m->format_text($_POST["motif"]);

			@$detail=$m->mouv($mouv,$bdd);
			$detail=$detail['ta']['Num_form']."***".$detail['ta']['Nom_cli']." (".$detail['ta']['Code_imm']." )***".$detail['tot_avec_tva']."***".$motif;
			$m->journal_insert($_SESSION['Idd'],'suppression_facture',$detail);

			$s="delete rva_facturation2.mouvement2 where Num_mouv='$mouv'";

			if($m->cnx->exec($s))
			{
				$s2="delete rva_facturation2.escale where Id_mouv='$mouv'";
				$m->cnx->exec($s2);
				
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "suppression_mouv_check":
			$_m=$_POST['mouv'];
			@$mouv=$m->mouv($_m);
			if($mouv['ta'][0]['Type_cl']=='A')
			{
				$s="delete rva_facturation2.mouvement2 where Num_mouv='$m'";
				if($m->cnx->exec($s))
				{
					$facture=$m->num_fact($m);					
					$s2="delete rva_facturation2.escale where Id_mouv='$m'";
					$m->cnx->exec($s2);	
					if($_SESSION['Priv']=='adm' || $_SESSION['Priv']=='ch_serv')
					{
						if($facture!==0)
						{
							$m->cnx->exec("delete rva_facturation2.rda where Num_long='$facture'");	
							$m->cnx->exec("delete from facture_imprime where Mouv='$m'");
							$m->cnx->exec("delete from facture_paye_imprime where Mouv='$m'");
							$m->cnx->exec("delete from paiement_facture where Mouv='$m'");
						}
					}				
					echo 1;
				}else
				{
					echo 0;
				}	
			}else
			{
				$s2="select * from rva_facturation2.facture_imprime where Mouv='$_m'";
				$e2=$m->cnx->query($s2);
				$t2=($e2->fetchAll());
				$n2=count($t2);
				if($n2==0)
				{
					$s="delete rva_facturation2.mouvement2 where Num_mouv='$_m'";
					if($m->cnx->exec($s))
					{
						$s2="delete rva_facturation2.escale where Id_mouv='$_m'";
						$m->cnx->exec($s2);	

						echo 1;
					}else
					{
						echo 0;
					}	
				}else
				{
					$facture=$t2['Num_facture'];
					if($_SESSION['Priv']=='adm' || $_SESSION['Priv']=='ch_serv')
					{
						if($facture!==0)
						{
							$m->cnx->exec("delete from rva_facturation2.rda where Num_long='$facture'");	
							$m->cnx->exec("delete from rva_facturation2.facture_imprime where Mouv='$_m'");
							$m->cnx->exec("delete from rva_facturation2.facture_paye_imprime where Mouv='$_m'");
							$m->cnx->exec("delete from rva_facturation2.paiement_facture where Mouv='$_m'");
						}
					}else
					{	
						echo 0;
					}
				}
			}
		break;
		case "suppr_fact":
			$id=$_POST["id"];
			$s="select * from rva_facturation2.facture_imprime where Id_fact='$id'"; 
			$e=$m->cnx->query($s);
			$t=($e->fetchAll());
			$mouv=$t[0]['Mouv'];

			$s2="delete from rva_facturation2.facture_imprime where Mouv='$mouv'";
			if($m->cnx->exec($s2))
			{
				echo 1;	
			}else
			{
				echo 0;
			}
		break;
		case "suppr_fact_paye":
			$fact=$_POST["fact"];
			$s1="select * from rva_facturation2.facture_imprime where Num_facture='$fact'";
			$e1=$m->cnx->query($s1);
			$t1=($e1->fetchAll());
			$mouv=$t1[0]['Mouv'];

			$s="delete from rva_facturation2.rda where Num_long='$fact'";
			if($m->cnx->exec($s))
			{
				$m->cnx->exec("delete from rva_facturation2.facture_paye_imprime where Num_facture='$fact'");
				$m->cnx->exec("delete from rva_facturation2.paiement_facture where Mouv='$mouv'");
				echo 1;	
			}else
			{
				echo 0;
			}
		break;
	}
?>