<?php
	@session_start();
	include("../manager/bd/cnx.php");
	$dt=date("Y-m-d");
	$heure=date("H:i");
	$ent=$_POST["ent"];
	if(isset($_SESSION['Cnx']))
	{
		$id_us=$_SESSION["Idd"];
	}
	switch ($ent){
		case "del":
			$tabl=$_POST['tabl'];
			$colone=$_POST['colone'];
			$colone_val=$_POST['colone_val'];
			$s="delete from $tabl where $colone='$colone_val'";
			if(mysqli_query($bdd,$s))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "mouvement":
			$formulaire=$_POST['formulaire'];
			$imm=$_POST["imm"];
			$s="select * from immatriculation where Id_imm='$imm'";
			$t=mysqli_fetch_array(mysqli_query($bdd,$s));
			$id=$t['Id_imm'];
				
				$s="select * from mouvement2 where Num_form='$formulaire'";
			$e=mysqli_query($bdd,$s);
			$n=mysqli_num_rows($e);
			$t=mysqli_fetch_array($e);
			if($n==0)
			{
				$r=array("n"=>0);
			}else
			{
				$num_mouv=$t['Num_mouv'];
				
				$s2="select * from facture_imprime where Mouv='$num_mouv'";
				$e2=mysqli_query($bdd,$s2);
				$n2=mysqli_num_rows($e2);
				if($n2==0)
				{
					$mouv=mouv($num_mouv,$bdd);
					$user=user($mouv["ta"]['Us'],$bdd);
					$dt=Datemysqltofr($mouv["ta"]['Date_mouv']);
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
			$motif=format_text($_POST["motif"]);

			$detail=mouv($mouv,$bdd);
			$detail=$detail['ta']['Num_form']."***".$detail['ta']['Nom_cli']." (".$detail['ta']['Code_imm']." )***".$detail['tot_avec_tva']."***".$motif;
			journal_insert($_SESSION['Idd'],'suppression_facture',$detail,$bdd);

			$s="delete from mouvement2 where Num_mouv='$mouv'";

			if(mysqli_query($bdd,$s))
			{
				$s2="delete from escale where Id_mouv='$mouv'";
				mysqli_query($bdd,$s2);
				
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "suppression_mouv_check":
			$m=$_POST['mouv'];
			$mouv=mouv($m,$bdd);
			if($mouv['ta']['Type_cl']=='A')
			{
				$s="delete from mouvement2 where Num_mouv='$m'";
				if(mysqli_query($bdd,$s))
				{
					$facture=num_fact($m,$bdd);					
					$s2="delete from escale where Id_mouv='$m'";
					mysqli_query($bdd,$s2);	
					if($_SESSION['Priv']=='adm' || $_SESSION['Priv']=='ch_serv')
					{
						if($facture!==0)
						{
							mysqli_query($bdd,"delete from rda where Num_long='$facture'");	
							mysqli_query($bdd,"delete from facture_imprime where Mouv='$m'");
							mysqli_query($bdd,"delete from facture_paye_imprime where Mouv='$m'");
							mysqli_query($bdd,"delete from paiement_facture where Mouv='$m'");
						}
					}				
					echo 1;
				}else
				{
					echo 0;
				}	
			}else
			{
				$s2="select * from facture_imprime where Mouv='$m'";
				$e2=mysqli_query($bdd,$s2);
				$n2=mysqli_num_rows($e2);
				$t2=mysqli_fetch_array($e2);
				if($n2==0)
				{
					$s="delete from mouvement2 where Num_mouv='$m'";
					if(mysqli_query($bdd,$s))
					{
						$s2="delete from escale where Id_mouv='$m'";
						mysqli_query($bdd,$s2);	

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
							mysqli_query($bdd,"delete from rda where Num_long='$facture'");	
							mysqli_query($bdd,"delete from facture_imprime where Mouv='$m'");
							mysqli_query($bdd,"delete from facture_paye_imprime where Mouv='$m'");
							mysqli_query($bdd,"delete from paiement_facture where Mouv='$m'");
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
			$s="select * from facture_imprime where Id_fact='$id'"; $e=mysqli_query($bdd,$s);
			$t=mysqli_fetch_array($e);
			$mouv=$t['Mouv'];

			$s2="delete from facture_imprime where Mouv='$mouv'";
			if(mysqli_query($bdd,$s2))
			{
				echo 1;	
			}else
			{
				echo 0;
			}
		break;
		case "suppr_fact_paye":
			$fact=$_POST["fact"];
			$s1="select * from facture_imprime where Num_fact='$fact'";
			$e1=mysqli_query($bdd,$s1);
			$t1=mysqli_fetch_array($e1);
			$mouv=$t['Mouv'];

			$s="delete from rda where Num_long='$fact'";
			if(mysqli_query($bdd,$s))
			{
				mysqli_query($bdd,"delete from facture_paye_imprime where Num_facture='$fact'");
				mysqli_query($bdd,"delete from paiement_facture where Mouv='$mouv'");
				echo 1;	
			}else
			{
				echo 0;
			}
		break;
	}
?>