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
	class m extends main
	{

	}
	$m=new main();
	switch($ent)
	{
		case "connexion":
			$login=$m->format_text($_POST['login']);
			$mdp=($_POST['mdp']);
			$s="select * from rva_facturation2.utilisateur where Login='$login' and Mdp='$mdp' and Statut!='S'";
			$e=$m->cnx->query($s); 
			$res=$e->fetchAll(); 
			$n=count($res);
			if($n==1)
			{ 
				@session_start();
				$_SESSION['Priv']=$res[0]['Priv'];
				$_SESSION['Nom']=$res[0]['Nom_complet'];
				$_SESSION['Idd']=$res[0]['Id_us'];
				$_SESSION['Cnx']="ok";
				$m->journal_insert($_SESSION['Idd'],'C','Nouvelle connexion');
			}
			echo ($n);
		break;	
		case "client":
			$s="select * from rva_facturation2.client order by Nom_cli";
			$e=$m->cnx->query($s);
			$t=$e->fetchAll();
			$r=array();
			foreach($t as $row)
			{
				$r[]=array("id_cl"=>$row['Id_cl'],
					"nom_cl"=>($row['Nom_cli']),
					"ville"=>$m->afficher_text($row['Ville']),
					"typ"=>$m->afficher_text($row['Type_cl']),
					"nat"=>$m->afficher_text($row['Code_nat']),
					"telephone"=>$m->afficher_text($row['Telephone']),
					"code"=>$m->afficher_text($row['Code_cl']),
					"boite"=>$m->afficher_text($row['Boite_postale']),
					"adresse"=>$m->afficher_text($row['Adresse_cl']));
			};
			echo (json_encode($r));
		break;
		//============= RAPPORT ======
		case "rapport":
			switch ($_POST["p"]) {
				case 'acces':
					echo ("bonjour");
				break;
				default:
					# code...
				break;
			}
		break;
		//============= FINANCE=======
			case "user_dep_jour":
				$s="select * from caisse_mouv where Id_us='$id_us' and Type_mouv='D' and Date_mouv='$dt'";
				$e=$m->cnx->query($s);
				$n=mysqli_num_rows($e); $t=mysqli_fetch_array($e);
				$r=array();
				if($n==0)
				{
					$r[]=array("n"=>0);
				}else
				{
					do
					{
						$r[]=array("n"=>$n,"id"=>$t['Id_cais'],"motif"=>afficher_text($t['Motif']),"mt"=>$t['Montant_mouv'],"monn"=>$t['Monnaie_mouv']);
					}while($t=mysqli_fetch_array($e));
				}
				echo (json_encode($r));
			break;
			case "rapp_dep_d":
				$dt=$_POST['dt'];
				$s="select * 
					from 
						caisse_mouv,user 
					where 
						Date_mouv='$dt' 
					and 
						Type_mouv='D' 
					and 
						caisse_mouv.Id_us=user.Id_us";
				$e=$m->cnx->query($s);
				$n=mysqli_num_rows($e); $t=mysqli_fetch_array($e);
				$r=array();
				if($n==0)
				{
					$r[]=array("n"=>0);
				}else
				{
					do
					{
						$r[]=array("n"=>$n,
							"heure"=>$t["Heure_mouv"],
							"mt"=>$t['Montant_mouv'],
							"monn"=>$t['Monnaie_mouv'],
							"motif"=>$t['Motif'],
							"nom_complet"=>$t['Nom_complet']);
					}while($t=mysqli_fetch_array($e));
				}
				echo(json_encode($r));
			break;
			case "rapp_dep_p_d":
				$dt1=$_POST['dt1'];
				$dt2=$_POST['dt2'];
				$s="select * 
					from 
						caisse_mouv,user 
					where 
						Date_mouv between '$dt1' and '$dt2' 
					and 
						Type_mouv='D' 
					and 
						caisse_mouv.Id_us=user.Id_us";
				$e=$m->cnx->query($s);
				$n=mysqli_num_rows($e); $t=mysqli_fetch_array($e);
				$r=array();
				if($n==0)
				{
					$r[]=array("n"=>0);
				}else
				{
					do
					{
						$r[]=array("n"=>$n,
							"heure"=>$t["Heure_mouv"],
							"mt"=>$t['Montant_mouv'],
							"monn"=>$t['Monnaie_mouv'],
							"motif"=>$t['Motif'],
							"nom_complet"=>$t['Nom_complet']);
					}while($t=mysqli_fetch_array($e));
				}
				echo(json_encode($r));
			break;
			case "rapp_journ":
				$dt=$_POST['dt'];
				$saer="select * from caisse_mouv where Type_mouv='AE' and Date_mouv='$dt'";
				$eaer=$m->cnx->query($saer);
				$naer=mysqli_num_rows($eaer);
				$taer=mysqli_fetch_array($eaer);
				$r=array();
				if($naer==0)
				{
					$raer=array("n"=>0);
				}else
				{
					
					do
					{
						if($taer['Monnaie_mouv']=='USD')
						{
							$monn="USD";
						}else
						{
							$monn='FC';
						}
						$raer=array("n"=>0,"monn");
					}while($taer=mysqli_fetch_array($eaer));
				}
				$resultat=array("raer"=>$raer);
				echo(json_encode($resultat));
			break;
		//============== HANDLING ==============
		case 'liste_handleur':
			$s="select * from handling_handleur order by Nom_hand";
			$e=$m->cnx->query($s);
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
							"code_hand"=>$t['Code_hand'],
							"nom"=>afficher_text($t['Nom_hand']),
							"adresse"=>afficher_text($t['Adresse_hand']),
							"ville"=>afficher_text($t['Ville_hand']),
							"telephone"=>afficher_text($t['Telephone_hand']),
							"type_paie"=>afficher_text($t['Type_paie']),
							"nationalite"=>$t["Nationalite"]
						);
				}while ($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "paiement_hand_liste_fact":
			$s="select * 
			from 
				handling_facturation,immatriculation,client,handling_handleur
			where
				handling_facturation.Immatriculation=immatriculation.Id_imm 
			and
				immatriculation.Code_pr=client.Id_cl
			and
				handling_facturation.Handleur=handling_handleur.Id_hand
			order by 
				Date_fact desc 
			limit 0,50";
			$e=$m->cnx->query($s);
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
					$touche="";
					if($t['TA']=="O")
					{
						$touche=$touche." TA ";
					}
					if($t['AA']=="O")
					{
						$touche=$touche." AA ";
					}
					if($t['FA']=="O")
					{
						$touche=$touche." FA ";
					}
					$user=user($t['Id_us'],$bdd);
					$r[]=array("n"=>$n,
						"id"=>$t["Id_fact"],
						"imm"=>$t['Code_imm'],
						"client"=>$t['Nom_cli'],
						"dt_fact"=>Datemysqltofr($t["Date_fact"]),
						"heure_arr"=>$t["Heure_arr"],
						"dt_arr"=>Datemysqltofr($t["Date_arr"]),
						"heure_dep"=>$t["Heure_dep"],
						"dt_dep"=>Datemysqltofr($t["Date_dep"]),
						"handleur"=>$t['Nom_hand'],
						"aa"=>$t["AA"],
						"ta"=>$t["TA"],
						"fa"=>$t["FA"],
						"touche"=>$touche,
						"user"=>$user
					);
				}while($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		// =====================================
		case "liste_client_tout":
			$s="select * from rva_facturation2.client order by Nom_cli";
			$e=$m->cnx->query($s);
			$t=($e->fetchAll());
			$n=count($t);
			$r=array();
			foreach($t as $row)
			{
				$r[]=array("n"=>$n,
					"id"=>$row['Id_cl'],
					"code_cl"=>$row['Code_cl'],
					"nom_cli"=>$row["Nom_cli"]
				);
			}
			echo (json_encode($r));
		break;
		case 'liste_cl':
			$s="select * from immatriculation,client where immatriculation.Code_pr=client.Code_cl order by Nom_cli, immatriculation.Code_imm";
			$e=$m->cnx->query($s);
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
							"id_cl"=>$t['Id_cl'],
							'id' => $t['Id_imm'],
							"code_imm"=>afficher_text($t['Code_imm']),
							"code_cl"=>afficher_text($t['Code_cl']),
							"nom_cli"=>afficher_text($t['Nom_cli']),
							"adr_cl"=>afficher_text($t['Adresse_cl']),
							"ville_cl"=>afficher_text($t['Ville']),
							"type_cl"=>afficher_text($t['Type_cl']),
							"codenat_cl"=>afficher_text($t['Code_nat']),
							"tel_cl"=>afficher_text($t['Telephone']),
							"boitepos"=>afficher_text($t['Boite_postale'])
						);
				}while ($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case 'liste_typeav':
			$s="select * from rva_facturation2.type_avion order by Libelle_typ";
			$e=$m->cnx->query($s);
			$t=($e->fetchAll()); $n=count($t);
			$r= array();
			if($n==0)
			{
				$r[]= array('n' => 0);
			}else
			{
				foreach($t as $row)
				{
					$r[] =
						array("n"=>$n,
							'id_typ' => $row['Id_typ'],
							"libelle"=>$m->afficher_text($row['Libelle_typ']),
							"mtow"=>$m->afficher_text($row['Mtow']),
							"nbremot"=>$m->afficher_text($row['Nbre_mot']),
							"maxpaylaod"=>$m->afficher_text($row['Maxpayload']),
							"version"=>$m->afficher_text($row['Version']),
							"plmin"=>$m->afficher_text($row['Pl_min']),
							"plmax"=>$m->afficher_text($row['Pl_max']),
						);
				}
			}
			echo (json_encode($r));
		break;
		case "liste_imm":
			$s="select * 
				from 
					rva_facturation2.immatriculation,rva_facturation2.client,rva_facturation2.type_avion 
				where 
					immatriculation.Code_pr=client.Id_cl 
				and 
					immatriculation.Type_av=Type_avion.Id_typ 
				order by Code_imm";
			$e=$m->cnx->query($s); 
			$row=$e->fetchAll();
			$n=count($row);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else{
				foreach($row as $t)
				{
					$r[]=array("n"=>$n,
						"id"=>$t['Id_imm'],
						"code_imm"=>$t['Code_imm'],
						"id_proprietaire"=>$t['Code_pr'],
						"proprietaire"=>$t["Nom_cli"],
						"code_pr"=>$t['Code_pr'],
						"type_av"=>$t['Libelle_typ'],
						"idtype_av"=>$t['Type_av'],
						"poids"=>$t['Poids'],
						"nbre_siege"=>$t['Nbre_siege']
					);
				}
			}
			echo (json_encode($r));
		break;
		case "liste_imm_cl":
			$cl=$_POST["client"];
			$s="select * 
				from  
					rva_facturation2.immatriculation,rva_facturation2.client,rva_facturation2.type_avion 
				where 
					immatriculation.Code_pr=client.Id_cl 
				and 
					immatriculation.Type_av=Type_avion.Id_typ 
				and
					immatriculation.Code_pr='$cl'
				order by Code_imm";
			$e=$m->cnx->query($s); 
			$row=$e->fetchAll();
			$n=count($row);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else{
				foreach($row as $t)
				{
					$r[]=array("n"=>$n,
						"id"=>$t['Id_imm'],
						"code_imm"=>$t['Code_imm'],
						"id_proprietaire"=>$t['Code_pr'],
						"proprietaire"=>$t["Nom_cli"],
						"code_pr"=>$t['Code_pr'],
						"type_av"=>$t['Libelle_typ'],
						"idtype_av"=>$t['Type_av'],
						"poids"=>$t['Poids'],
						"nbre_siege"=>$t['Nbre_siege']
					);
				}
			}
			echo (json_encode($r));
		break;
		case "liste_route":
			$s="select * from rva_facturation2.route";
			$e=$m->cnx->query($s); 
			$row=($e->fetchAll());
			$n=count($row);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else{
				foreach($row as $t)
				{
					$r[]=array("n"=>$n,"id"=>$t['Id_route'],"route"=>$t['Libelle']);
				}
			}
			echo (json_encode($r));
		break;
		case "liste_ville":
			$s="select * from rva_facturation2.pt_emplacement where Type='V' order by Code_pt";
			$e=$m->cnx->query($s); 
			$row=$e->fetchAll();
			$n=count($row);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else{
				foreach($row as $t)
				{
					$r[]=array("n"=>$n,
						"id"=>$t['Id_pt'],
						"code_ville"=>$t['Code_pt'],
						"libelle"=>$t['Lib_pt']
					);
				}
			}
			echo (json_encode($r));
		break;
		case "liste_ville_nat":

			$s="select * from rva_facturation2.pt_emplacement where Type='E' order by Lib_pt";
			$e=$m->cnx->query($s); 
			$row=$e->fetchAll();
			$n=count($row);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else{
				foreach($row as $t)
				{
					$r[]=array("n"=>$n,
						"id"=>$t['Id_pt'],
						"libelle"=>$t["Lib_pt"],
						"code_ville"=>$t['Code_pt']);
				}
			}
			echo (json_encode($r));
		break;
		case "liste_ville_nat_int":

			$s="select * from rva_facturation2.pt_emplacement where Type='E' or Type='V' order by Lib_pt";
			$e=$m->cnx->query($s); 
			$row=$e->fetchAll();
			$n=count($row);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else{
				foreach($row as $t)
				{
					$r[]=array("n"=>$n,
						"id"=>$t['Id_pt'],
						"libelle"=>$t["Lib_pt"],
						"code_ville"=>$t['Code_pt']);
				}
			}
			echo (json_encode($r));
		break;
		case "liste_emplacement":
			$s="select * from rva_facturation2.pt_emplacement where Type='E' order by Code_pt";
			$e=$m->cnx->query($s); 
			$row=$e->fetchAll();
			$n=count($row);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else{
				foreach($row as $t)
				{
					$r[]=array("n"=>$n,
						"id"=>$t['Id_pt'],
						"libelle"=>$m->afficher_text($t['Lib_pt']),
						"distance"=>$t['Distance'],
						"gere"=>$t['Type_gestion'],
						"code_ville"=>$t['Code_pt']);
				}
			}
			echo (json_encode($r));
		break;
		case "dernier_taux":
			$s="select * from rva_facturation2.taux order by Id_taux desc";
			$e=$m->cnx->query($s);
			$t=$e->fetchAll();
			echo(json_encode($t));		
		break;
		case "liste_type_acces":
			$s="select * from rva_facturation2.type_acces";
			$e=$m->cnx->query($s); 
			$row=$e->fetchAll();
			$n=count($row);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else{
				foreach($row as $t)
				{
					$r[]=array("n"=>$n,
						"id"=>$t['Id_acc'],
						"code_acc"=>$t['Code_acc'],
						"designation_acc"=>$t['Designation_acc']);
				}
			}
			echo (json_encode($r));
		break;
		case "num_fiche_rec":
			$s="select * from rva_facturation2.Num_fiche Order by Num_fich desc";
			$e=$m->cnx->query($s); 
			$t=$e->fetchAll();
			$n=count($t);
			
				echo ($t[0]['Num_fich']+1);
		break;
		case "liste_ville":
			$s="select * from rva_facturation2.pt_emplacement where Type='E' order by Code_pt";
			$e=$m->cnx->query($s); 
			$row=$e->fetchAll();
			$r=array();
			foreach($row as $t)
			{
				$r[] = array('n' =>"n",
					"code"=>$t['Code_pt'],
					"libelle"=>$t['Lib_pt'],
					"distance"=>$t['Distance'],
					"id"=>$t['Id_pt']);
			}
			echo (json_encode($r));
		break;
		case "liste_pt":
			$s="select * from rva_facturation2.pt_emplacement where Type='P' order by Code_pt";
			$e=$m->cnx->query($s); 
			$row=$e->fetchAll();
			$r=array();
			foreach($row as $t)
			{
				$r[] = array('n' =>"n",
					"code"=>$t['Code_pt'],
					"libelle"=>$t['Lib_pt'],
					"distance"=>$t['Distance'],
					"id"=>$t['Id_pt']);
			}
			echo (json_encode($r));
		break;
		case 'liste_pat_att_inf':
			$s="select * 
				from 
					fil_attente_infirmerie,patient  
				where 
					fil_attente_infirmerie.Id_pat=patient.Id_pat 
				and
					fil_attente_infirmerie.Statut='N'";
			$e=$m->cnx->query($s);
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
						array("n"=>$n,'id_pat' => $t['Id_pat'],
							"nom"=>afficher_text($t['Nom_pat'])." ".afficher_text($t['Prenom_pat']),
						);
				}while ($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "liste_user":
			$s="select * from rva_facturation2.utilisateur order by Nom_complet";
			$e=$m->cnx->query($s);
			$t=($e->fetchAll()); 
			$n=count($t);
			$r= array();
			if($n==0)
			{
				$r[]= array('n' => 0);
			}else
			{
				foreach($t as $row)
				{
					$r[] =
						array("n"=>$n,
							'id' => $row['Id_us'],
							"nom"=>$m->afficher_text($row['Nom_complet']),
							"matricule"=>$m->afficher_text($row['Matricule']),
							"login"=>($row['Login']),
							"priv"=>($row['Priv']),
							"statut"=>$m->afficher_text($row['Statut']),
							"mdp"=>$row['Mdp']
						);
				}
			}
			echo (json_encode($r));
		break;
		case "bordereau":
			$dt=$_POST['dt'];
			$r=bordereau($dt);
			echo(json_encode($r));
		break;
		case "ventillation":
			$dt1=$_POST['dt1'];
			$dt2=$_POST['dt2'];
			$s="select *
				from 
					num_facture,mouvement2,immatriculation,client 
				where 
					num_facture.Mouv=mouvement2.Num_mouv
				and
					mouvement2.Immatr=immatriculation.Id_imm
				and
					immatriculation.Code_pr=client.Id_cl
				and
					num_facture.Date_impr between '$dt1'and '$dt2'
				group by 
					Nom_cli asc
				";
			//$s="select * from num_facture where Date_impr between '$dt1' and '$dt2'";
			$e=$m->cnx->query($s); $n=mysqli_num_rows($e); $t=mysqli_fetch_array($e);
			$r=array();
			$resultat=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else
			{
				do
				{
					$mouvement=mouv($t['Mouv'],$bdd);
					$detail=array("Date"=>$t['Date_impr'],
							"client"=>afficher_text($mouvement['ta']['Nom_cli']),
							"mouv"=>$t['Mouv'],
							"dt"=>Datemysqltofr($t['Date_impr']),
							"heure"=>$t['Heure'],
							"nn"=>$n,
							"id_cl"=>$mouvement['ta']['Id_cl'],
							"imm"=>$mouvement['ta']['Code_imm']
					);
					$resultat[]=$detail;
				}while($t=mysqli_fetch_array($e));
				$r[]=array("n"=>$n,"resultat"=>$resultat);
			}
			echo (json_encode($r));
		break;
		case "mouvement_liste_tout":	
			$s="select *,
					date_format(Dt,'%d/%m/%Y') as dt_mouv 
				from 
					mouvement2, immatriculation, client
				where
					mouvement2.Immatr=immatriculation.Id_imm
				and
					immatriculation.Code_pr=client.Id_cl
				group by 
					Num_form
				order by 
					Dt desc
				limit 0,50
				";
			$e=$m->cnx->query($s);
			$t=mysqli_fetch_array($e);
			$r=array();
			do
			{
				$mouvement=$t['Num_mouv'];
				$s5="select * from facture_imprime where Mouv='$mouvement'";
				$e5=$m->cnx->query($s5);
				$t5=mysqli_fetch_array($e5);
				$n5=mysqli_num_rows($e5);

				$s2="select * from paiement_facture where Mouv='$mouvement'";
				$e2=$m->cnx->query($s2); $n2=mysqli_num_rows($e2);
				if($n2==0)
				{
					$statut="Non payée"; 
					$classe="text-danger";
				}else{
					$statut="Payée"; 
					$classe="text-success";
				}
				$m=mouv($t["Num_mouv"],$bdd);
				@$r[]=array("dt_mouv"=>Datemysqltofr($t['Dt']),
						"Id_mouv"=>$t["Id_mouv"],
						"Num_mouv"=>$t['Num_mouv'],
						"Num_form"=>$t['Num_form'],
						"Code_imm"=>$t['Code_imm'],
						"Nom_cli"=>$t["Nom_cli"],
						"statut"=>$statut,
						"classe"=>$classe,
						"mouv"=>$m
					);
			}while($t=mysqli_fetch_array($e));

			echo (json_encode($r));
		break;
		case "mouvement_liste":	
			$s="select *,
					format(Dt,'%d/%m/%Y') as dt_mouv 
				from 
					rva_facturation2.mouvement2, rva_facturation2.immatriculation, rva_facturation2.client
				where
					mouvement2.Immatr=immatriculation.Id_imm
				and
					immatriculation.Code_pr=client.Id_cl
				and
					Sens='A'
				order by 
					Dt desc
				";
			$e=$m->cnx->query($s);
			$t=($e->fetchAll());
			$r=array();
			foreach($t as $row)
			{
				$mouvement=$row['Num_mouv'];
				$s5="select * from rva_facturation2.facture_imprime where Mouv='$mouvement'";
				$e5=$m->cnx->query($s5);
				$t5=($e5->fetchAll());
				$n5=count($t5);
				if($n5!==0)
				{
					continue;
				}else
				{

					$s2="select * from rva_facturation2.paiement_facture where Mouv='$mouvement'";
					$e2=$m->cnx->query($s2);
					$t2=$e->fetchAll(); 
					$n2=count($t2);
					if($n2==0)
					{
						$statut="Non payée"; 
						$classe="text-danger";
					}else{
						$statut="Payée"; 
						$classe="text-success";
					}
					@$r[]=array("dt_mouv"=>$m->Datemysqltofr($row['Dt']),
							"Id_mouv"=>$row["Id_mouv"],
							"Num_mouv"=>$row['Num_mouv'],
							"Num_form"=>$row['Num_form'],
							"Code_imm"=>$row['Code_imm'],
							"Nom_cli"=>$row["Nom_cli"],
							"statut"=>$statut,
							"classe"=>$classe
						);
				}
			}

			echo (json_encode($r));
		break;
		case "mouvement_facture":

			$s="select TOP 50 facture_imprime.Mouv,facture_imprime.Id_fact 
				from 
					rva_facturation2.facture_imprime 
				order by 
					Id_fact desc";
			$e=$m->cnx->query($s);
			$row=$e->fetchAll();
			$n=count($row);
			$r=array();
			if($n==0)
			{

			}else
			{
				foreach($row as $t)
				{
					@$mouv=$m->mouv($t['Mouv']);
					$_m=$t['Mouv'];
					$s2="select * from rva_facturation2.paiement_facture where Mouv='$_m'";
					$e2=$m->cnx->query($s2); 
					$t2=$e2->fetchAll();
					$n2=count($t2);
					if($n2==0)
					{
						$statut="Non payée"; 
						$classe="text-danger";
					}else{
						$statut="Payée"; 
						$classe="text-success";
					}
					@$r[]=array("n"=>$n,
						"Id_mouv"=>$mouv['ta'][0]['Id_mouv'],
						"Num_mouv"=>$mouv['ta'][0]['Num_mouv'],
						"dt_mouv"=>$m->Datemysqltofr($mouv['ta'][0]['Date_mouv'])." - ".$m->Datemysqltofr($mouv['td'][0]['Date_mouv']),
						"Num_form"=>$mouv['ta'][0]['Num_form'],
						"Code_imm"=>$mouv['ta'][0]['Code_imm'],
						"Nom_cli"=>$mouv['ta'][0]['Nom_cli'],
						"classe"=>$classe,
						"statut"=>$statut
					);
				}
			}
			echo (json_encode($r));
		break;
		case "mouvement_facture_dt":
			$dt1=$_POST['dt1'];
			$dt2=$_POST["dt2"];
			$s="select * from rva_facturation2.facture_imprime where Date_impr between '$dt1' and '$dt2' order by Id_fact desc";
			$e=$m->cnx->query($s);
			$row=$e->fetchAll();
			$n=count($row);
			$r=array();
			if($n==0)
			{

			}else
			{
				foreach($row as $t)
				{
					$mouv=$m->mouv($t['Mouv']);
					$_m=$t['Mouv'];
					$s2="select * from rva_facturation2.paiement_facture where Mouv='$_m'";
					$e2=$m->cnx->query($s2); 
					$t2=$e2->fetchAll();
					$n2=count($t2);
					if($n2==0)
					{
						$statut="Non payée"; 
						$classe="text-danger";
					}else{
						$statut="Payée"; 
						$classe="text-success";
					}
					@$r[]=array("n"=>$n,
						"Id_mouv"=>$mouv['ta'][0]['Id_mouv'],
						"Num_mouv"=>$mouv['ta'][0]['Num_mouv'],
						"dt_mouv"=>$m->Datemysqltofr($mouv['ta'][0]['Date_mouv'])." - ".$m->Datemysqltofr($mouv['td'][0]['Date_mouv']),
						"Num_form"=>$mouv['ta'][0]['Num_form'],
						"Code_imm"=>$mouv['ta'][0]['Code_imm'],
						"Nom_cli"=>$mouv['ta'][0]['Nom_cli'],
						"classe"=>$classe,
						"statut"=>$statut
					);
				}
			}
			echo (json_encode($r));
		break;
		case "mouvement_facture_suite":
			$v=$_POST['v'];
			$s="select * from facture_imprime order by Id_fact desc limit $v,50";
			$e=$m->cnx->query($s);
			$n=mysqli_num_rows($e);
			$t=mysqli_fetch_array($e);
			$r=array();
			if($n==0)
			{

			}else
			{
				do
				{
					$mouv=mouv($t['Mouv'],$bdd);
					$m=$t['Mouv'];
					$s2="select * from paiement_facture where Mouv='$m'";
					$e2=$m->cnx->query($s2); $n2=mysqli_num_rows($e2);
					if($n2==0)
					{
						$statut="Non payée"; 
						$classe="text-danger";
					}else{
						$statut="Payée"; 
						$classe="text-success";
					}
					@$r[]=array("n"=>$n,
						"Id_mouv"=>$mouv['ta']['Id_mouv'],
						"Num_mouv"=>$mouv['ta']['Num_mouv'],
						"dt_mouv"=>Datemysqltofr($mouv['ta']['Date_mouv'])." - ".Datemysqltofr($mouv['td']['Date_mouv']),
						"Num_form"=>$mouv['ta']['Num_form'],
						"Code_imm"=>$mouv['ta']['Code_imm'],
						"Nom_cli"=>$mouv['ta']['Nom_cli'],
						"classe"=>$classe,
						"statut"=>$statut
					);
				}while($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "rapport_acces":
			$dt1=$_POST["dt1"];
			$dt2=$_POST["dt2"];

			$s="select * from rva_facturation2.acces where Date_perc between '$dt1' and '$dt2' order by Id_acc desc";
			$e=$m->cnx->query($s);
			$row=($e->fetchAll());
			$n=count($row);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else
			{
				foreach($row as $t)
				{
				@$r[]=array("n"=>$n,
					"id"=>$t["Id_acc"],
					"num_fact"=>$t["Num_long"],
					"heure"=>$m->Heureformat($t["Heure_perc"]),
					"tva"=>$t["Tva"],
					"type_acc"=>$t["Type_acc"],
					"dt"=>$t["Date_perc"],
					"num_fact"=>$t["Num_long"],
					"quittance"=>$t["Quittance"],
					"mt"=>$t["Mt_acc"],
					"monn"=>$t["Monn_acc"]
				);
				}
			}
			echo (json_encode($r));
		break;
		case "rapport_idf":
			$dt1=$_POST["dt1"];
			$dt2=$_POST["dt2"];

			$s="select * from rva_facturation2.idf_paiement where Date_idf between '$dt1' and '$dt2' order by Id_paie desc";
			$e=$m->cnx->query($s);
			$t=($e->fetchAll());
			$n=count($t);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else
			{
				foreach($t as $row)
				{
				$exploitant=$m->exploitant($row['Client']);
				@$r[]=array("n"=>$n,
					"id_exp"=>$row['Client'],
					"exploitant"=>$exploitant['nom'],
					"id"=>$row["Id_paie"],
					"dt"=>$row["Date_idf"],
					"quittance"=>$row["Quittance"],
					"mt"=>$row["Mt"],
					"monn"=>$row["Monn"]
				);
				}
			}
			echo (json_encode($r));
		break;
		case "liste_facture_non_imprime":	
			$s="select TOP 50 
					mouvement2.Immatr,
					immatriculation.Id_imm,
					mouvement2.Sens,
					immatriculation.Code_pr,
					client.Id_cl,
					mouvement2.Date_mouv,
					mouvement2.Id_mouv,
					mouvement2.Num_mouv,
					mouvement2.Dt,
					mouvement2.Num_form,
					mouvement2.Immatr,
					client.Nom_cli,
					immatriculation.Code_imm,
					format(mouvement2.Date_mouv,'%d/%m/%Y') as dt_mouv 
				from 
					rva_facturation2.mouvement2, 
					rva_facturation2.immatriculation, 
					rva_facturation2.client
				where
					mouvement2.Immatr=immatriculation.Id_imm
				and
					mouvement2.Sens='D'
				and
					immatriculation.Code_pr=client.Id_cl
				order by 
					Date_mouv desc,Id_mouv desc
				";
			$e=$m->cnx->query($s);
			$row=$e->fetchAll();
			$r=array();
			foreach($row as $t)
			{
				$mouvement=$t['Num_mouv'];
				$s5="select * from rva_facturation2.facture_imprime where Mouv='$mouvement'";
				$e5=$m->cnx->query($s5);
				$t5=($e5->fetchAll());
				$n5=count($t5);
				/*if($n5!==0)
				{
					continue;
				}else
				{*/

					$s2="select * from rva_facturation2.paiement_facture where Mouv='$mouvement'";
					$e2=$m->cnx->query($s2); 
					$t2=$e2->fetchAll();
					$n2=count($t2);
					if($n2==0)
					{
						$statut="Non payée"; 
						$classe="text-danger";
					}else{
						$statut="Payée"; 
						$classe="text-success";
					}
					@$_m=$m->mouv($t['Num_mouv']);
					@$r[]=array(
							"dt_saisie"=>$m->Datemysqltofr($t['Dt']),
							"dt_mouv"=>$m->Datemysqltofr($_m['ta'][0]['Date_mouv'])." - ".$m->Datemysqltofr($_m['td'][0]['Date_mouv']),
							"Id_mouv"=>$t["Id_mouv"],
							"Num_mouv"=>$t['Num_mouv'],
							"Num_form"=>$t['Num_form'],
							"Code_imm"=>$t['Code_imm'],
							"Nom_cli"=>$t["Nom_cli"],
							"statut"=>$statut,
							"classe"=>$classe
						);
				//}
			}

			echo (json_encode($r));
		break;
		case "liste_facture_non_imprime_dt":	
			$dt1=$_POST["dt1"];
			$dt2=$_POST["dt2"];
			$s="select
					mouvement2.Immatr,
					immatriculation.Id_imm,
					mouvement2.Sens,
					immatriculation.Code_pr,
					client.Id_cl,
					mouvement2.Date_mouv,
					mouvement2.Id_mouv,
					mouvement2.Num_mouv,
					mouvement2.Dt,
					mouvement2.Num_form,
					mouvement2.Immatr,
					client.Nom_cli,
					immatriculation.Code_imm,
					format(mouvement2.Date_mouv,'%d/%m/%Y') as dt_mouv 
				from 
					rva_facturation2.mouvement2, 
					rva_facturation2.immatriculation, 
					rva_facturation2.client
				where
					mouvement2.Dt between '$dt1' and '$dt2'
				and
					mouvement2.Immatr=immatriculation.Id_imm
				and
					mouvement2.Sens='D'
				and
					immatriculation.Code_pr=client.Id_cl
				order by 
					Date_mouv desc,Id_mouv desc
				";
			$e=$m->cnx->query($s);
			$row=$e->fetchAll();
			$r=array();
			foreach($row as $t)
			{
				$mouvement=$t['Num_mouv'];
				$s5="select * from rva_facturation2.facture_imprime where Mouv='$mouvement'";
				$e5=$m->cnx->query($s5);
				$t5=($e5->fetchAll());
				$n5=count($t5);
				/*if($n5!==0)
				{
					continue;
				}else
				{*/

					$s2="select * from rva_facturation2.paiement_facture where Mouv='$mouvement'";
					$e2=$m->cnx->query($s2); 
					$t2=$e2->fetchAll();
					$n2=count($t2);
					if($n2==0)
					{
						$statut="Non payée"; 
						$classe="text-danger";
					}else{
						$statut="Payée"; 
						$classe="text-success";
					}
					@$_m=$m->mouv($t['Num_mouv']);
					@$r[]=array(
							"dt_saisie"=>$m->Datemysqltofr($t['Dt']),
							"dt_mouv"=>$m->Datemysqltofr($_m['ta'][0]['Date_mouv'])." - ".$m->Datemysqltofr($_m['td'][0]['Date_mouv']),
							"Id_mouv"=>$t["Id_mouv"],
							"Num_mouv"=>$t['Num_mouv'],
							"Num_form"=>$t['Num_form'],
							"Code_imm"=>$t['Code_imm'],
							"Nom_cli"=>$t["Nom_cli"],
							"statut"=>$statut,
							"classe"=>$classe
						);
				//}
			}

			echo (json_encode($r));
		break;
		case "liste_facture_non_imprime_suite":	
			$s="select *,
					date_format(Date_mouv,'%d/%m/%Y') as dt_mouv 
				from 
					mouvement2, immatriculation, client
				where
					mouvement2.Immatr=immatriculation.Id_imm
				and
					mouvement2.Sens='D'
				and
					immatriculation.Code_pr=client.Id_cl
				group by 
					Num_form
				order by 
					Date_mouv desc,Id_mouv desc
				Limit 0,50
				";
			$e=$m->cnx->query($s);
			$t=mysqli_fetch_array($e);
			$r=array();
			do
			{
				$mouvement=$t['Num_mouv'];
				$s5="select * from facture_imprime where Mouv='$mouvement'";
				$e5=$m->cnx->query($s5);
				$t5=mysqli_fetch_array($e5);
				$n5=mysqli_num_rows($e5);
				/*if($n5!==0)
				{
					continue;
				}else
				{*/

					$s2="select * from paiement_facture where Mouv='$mouvement'";
					$e2=$m->cnx->query($s2); $n2=mysqli_num_rows($e2);
					if($n2==0)
					{
						$statut="Non payée"; 
						$classe="text-danger";
					}else{
						$statut="Payée"; 
						$classe="text-success";
					}
					$m=mouv($t['Num_mouv'],$bdd);
					@$r[]=array(
							"dt_saisie"=>Datemysqltofr($t['Dt']),
							"dt_mouv"=>Datemysqltofr($m['ta']['Date_mouv'])." - ".Datemysqltofr($m['td']['Date_mouv']),
							"Id_mouv"=>$t["Id_mouv"],
							"Num_mouv"=>$t['Num_mouv'],
							"Num_form"=>$t['Num_form'],
							"Code_imm"=>$t['Code_imm'],
							"Nom_cli"=>$t["Nom_cli"],
							"statut"=>$statut,
							"classe"=>$classe
						);
				//}
			}while($t=mysqli_fetch_array($e));

			echo (json_encode($r));
		break;
		case "reimpression_fact_cash_dt":
			$dt1=$_POST["dt1"];
			$dt2=$_POST["dt2"];
			$s="select * from rva_facturation2.facture_imprime where Date_impr between '$dt1' and '$dt2' and Statut='R' and Valide='O' order by Id_fact desc";
	
			$e=$m->cnx->query($s);
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
					@$mouv=$m->mouv($row['Mouv']);
					$user=$m->user($row['Id_us']);
					@$r[]=array(
							"n"=>$n,
							"dt"=>$m->Datemysqltofr($row['Date_impr']),
							"heure"=>$m->Heureformat($row['Heure_impr']),
							"formulaire"=>$mouv['ta'][0]['Num_form'],
							"immatr"=>$mouv['ta'][0]['Code_imm'],
							"nom_cli"=>$mouv['ta'][0]['Nom_cli'],
							"num_fact"=>$row['Num_facture'],
							"ttc"=>$mouv['tot_avec_tva']." USD",
							"user"=>$user['nom'],
							"mouv"=>$row['Mouv']
						);
				}
			}
			echo(json_encode($r));
		break;
		case "reimpression_fact_paye_dt":
			$dt1=$_POST["dt1"];
			$dt2=$_POST["dt2"];
			$s="select * from rva_facturation2.facture_paye_imprime where Valide='V' order by Id_impr desc";
	
			$e=$m->cnx->query($s);
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
					@$mouv=$m->mouv($row['Mouv']);
					@$user=$m->user($row['Id_us']);
					@$r[]=array(
							"n"=>$n,
							"dt"=>$m->Datemysqltofr($row['Date_impr']),
							"heure"=>$m->Heureformat($row['Heure_impr']),
							"formulaire"=>$mouv['ta'][0]['Num_form'],
							"immatr"=>$mouv['ta'][0]['Code_imm'],
							"nom_cli"=>$mouv['ta'][0]['Nom_cli'],
							"num_fact"=>$row['Num_facture'],
							"ttc"=>$mouv['tot_avec_tva']." USD",
							"user"=>$user['nom'],
							"mouv"=>$t[0]['Mouv']
						);
				}
			}
			echo(json_encode($r));
		break;
		case "releve_client":
			$client=$_POST['client'];
			$dt1=$_POST['dt1'];
			$dt2=$_POST['dt2'];
			if($client!=='t')
			{
				$s="select * 
				from 
					rva_facturation2.mouvement2,rva_facturation2.client,rva_facturation2.immatriculation
				where 
					mouvement2.Immatr=immatriculation.Id_imm
				and
					immatriculation.Code_pr=client.Id_cl
				and
					client.Id_cl='$client'	
				and
					mouvement2.Sens='D'	
				and
					mouvement2.Date_mouv between '$dt1' and '$dt2'	
				order by Date_mouv	
				";
			}else
			{
				$s="select * 
				from 
					rva_facturation2.mouvement2,rva_facturation2.client,rva_facturation2.immatriculation
				where 
					mouvement2.Immatr=immatriculation.Id_imm
				and
					immatriculation.Code_pr=client.Id_cl	
				and
					mouvement2.Sens='D'	
				and
					mouvement2.Date_mouv between '$dt1' and '$dt2'	
				order by Date_mouv	
				";
			}
			$e=$m->cnx->query($s);
			$t=($e->fetchAll());
			$n=count($t);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else
			{
				$total=0;
				foreach($t as $row)
				{
					@$mouv=$m->mouv($row['Num_mouv']);
					$total=$total+$mouv['tot_avec_tva'];
					@$r[]=array("n"=>$n,
						"date_arr"=>$m->Datemysqltofr($mouv['ta'][0]['Date_mouv']),
						"date_dep"=>$m->Datemysqltofr($mouv['td'][0]['Date_mouv']),
						"imm"=>$mouv['ta']['Code_imm'],
						"mouv"=>$mouv,
						"total"=>$m->arrondie($total)
					);
				}
			}
			echo (json_encode($r));
		break;
		case 'facture_agree':
			$client=$_POST["client"];
			$dt1=$_POST['dt1'];
			$dt2=$_POST['dt2'];
			//echo($dt);
			/*$s="select * from 
				rva_facturation2.mouvement2,rva_facturation2.client,rva_facturation2.immatriculation 
				where 
					mouvement2.Immatr=immatriculation.Id_imm
				and
					immatriculation.Code_pr=client.Id_cl
				and
					client.Id_cl='$client'
				and	
					mouvement2.Date_mouv between '$dt1' and '$dt2'
				group by 
					mouvement2.Num_mouv";*/
			$s="select * from 
				rva_facturation2.mouvement2,rva_facturation2.client,rva_facturation2.immatriculation 
				where 
					mouvement2.Immatr=immatriculation.Id_imm
				and
					immatriculation.Code_pr=client.Id_cl
				and
					client.Id_cl='$client'
				and	
					mouvement2.Date_mouv between '$dt1' and '$dt2' and Sens='A'
				";
			$e=$m->cnx->query($s); 
			$t=$e->fetchAll();
			$n=count($t);
			$r=array();
			//==================
				$route=0;
				$atterissage=0;
				$stationnement=0;
				$fret=0;
				$passager=0;
				$pec=0;
				$surete=0;
				$securite=0;
				$ass=0;
				$formu=0;
				$compt=0;
				$general=0;
			//==================
			if($n==0){$r[]=array("n"=>0);}
			else
			{
				$nb=array("n"=>$n);
				foreach($t as $row)
				{
					$mouvement=$m->mouv($row['Num_mouv']);
					$route=$route+$mouvement['tot_red_rout'];
					$atterissage=$atterissage+$mouvement['tot_red_att'];
					$stationnement=$stationnement+$mouvement['tot_red_stat'];
					$fret=$fret+$mouvement['tot_red_fret'];
					$passager=$passager+$mouvement['tot_red_pass'];
					$pec=$pec+$mouvement['tot_red_pec'];
					$surete=$surete+$mouvement['tot_red_surete'];
					$securite=$securite+$mouvement['tot_red_securite'];
					$ass=$ass+$mouvement['tot_red_assantinc'];
					$formu=$formu+$mouvement['tot_red_formu'];
					$compt=$compt+$mouvement['tot_red_compt'];
					$general=$general+$mouvement['tot_avec_tva'];
				}
				$ligne=array("route"=>$m->arrondie($route),
						"atterissage"=>	$m->arrondie($atterissage),
						"stationnement"=>$m->arrondie($stationnement),
						"fret"=>$m->arrondie($fret),
						"passager"=>$m->arrondie($passager),
						"passager"=>$m->arrondie($pec),
						"surete"=>$m->arrondie($surete),
						"securite"=>$m->arrondie($securite),
						"ass"=>$m->arrondie($ass),
						"formu"=>$m->arrondie($formu),
						"compt"=>$m->arrondie($compt),
						"tot"=>$m->arrondie(ceil($route+$atterissage+$stationnement+$fret+$passager+$pec+$surete+$securite+$ass+$formu+$compt)));
						//"tot"=>arrondie($general));
				@$r=array_merge_recursive($nb,$ligne);
						//$r=array("n"=>1)5;
			}

			echo (json_encode($r));
		break;
		case "facture_non_paye":
			$s="select TOP 220 * from rva_facturation2.facture_imprime where Statut='R' order by Id_fact desc";
			$e=$m->cnx->query($s);
			$t=($e->fetchAll());
			$r=array();
			foreach($t as $row)
			{
				@$mouv=$m->mouv($row['Mouv']);
				@$user=$m->user($mouv['ta'][0]['Us']);
				@$r[]=array(
					'id'=>$row['Id_fact'],
					"dt"=>$m->Datemysqltofr($row['Date_impr']),
					'expl'=>$mouv['ta'][0]['Nom_cli'],
					'taxateur'=>$user['nom'],
					'montant'=>$mouv['tot_avec_tva'],
					"fact"=>$row["Num_facture"]);
			}

			echo (json_encode($r));
		break;
		case "facture_paye":
			$s="select TOP 180 * from rva_facturation2.rda order by Id_rda desc";
			$e=$m->cnx->query($s);
			$t=($e->fetchAll());
			$r=array();
			foreach($t as $row)
			{
				@$expl=$m->exploitant($row['Client_rda']);
				@$user=$m->user($row['Id_us']);
				@$r[]=array(
					'id'=>$row['Id_rda'],
					"dt"=>$m->Datemysqltofr($row['Date_rda']),
					'expl'=>$expl['nom'],
					'percepteur'=>$user['nom'],
					'montant'=>$row['Mt_rda'],
					"fact"=>$row["Num_long"]);
			}

			echo (json_encode($r));
		break;
		case "num_fact_agr":
			$_SESSION['num_fact_agr']=$_POST['num'];
			echo 1;
		break;
		case "mouvement_recherche":
			$formulaire=$_POST["formulaire"];
			$s="select distinct(Num_mouv),Dt,Id_mouv from rva_facturation2.mouvement2 where Num_form='$formulaire' and Sens='A'";
			$e=$m->cnx->query($s);
			$t=($e->fetchAll());
			$n=count($t);
			$r=array();
			if($n==0)
			{
				$r[]=array("n1"=>0);
			}else
			{
				foreach($t as $row)
				{
					@$_m=$m->mouv($row['Num_mouv']);

					@$user=$m->user($_m['ta'][0]['Us']);
					@$rr=array("n1"=>$n,
						"id_mouv"=>$row["Id_mouv"],
						"dt_saisie"=>$m->Datemysqltofr($row['Dt']),
						"mouv"=>$_m['ta'][0]['Num_mouv'],
						"us"=>$user['nom'],
						"dt_arr"=>$m->Datemysqltofr($_m['ta'][0]['Date_mouv']),
						"dt_dep"=>$m->Datemysqltofr($_m['td'][0]['Date_mouv'])
					);
					
					$r[]=array_merge_recursive($rr,$_m);

				}
			}
			//echo(js)
			echo (json_encode($r));
		break;
		case "liste_facture_non_regle":
			$client=$_POST["client"];
			$dt=$_POST["dt"];
			$dt2=$_POST["dt2"];
			if($client=='tout')
			{
				$s="select 
						distinct(facture_imprime.Num_facture),
						facture_imprime.Mouv,
						mouvement2.Num_mouv, 
						mouvement2.Immatr,
						immatriculation.Id_imm,
						facture_imprime.Statut,
						immatriculation.Code_pr,
						client.Id_cl,
						facture_imprime.Date_impr
					from 
						rva_facturation2.facture_imprime,
						rva_facturation2.mouvement2,
						rva_facturation2.immatriculation,
						rva_facturation2.client 
					where
						facture_imprime.Mouv=mouvement2.Num_mouv 
					and
						mouvement2.Immatr=immatriculation.Id_imm 
					and
						facture_imprime.Statut='R' 
					and
						immatriculation.Code_pr=client.Id_cl 
					and
						facture_imprime.Date_impr between '$dt' and '$dt2'
					order by 
						Date_impr desc
				";
			}else
			{
				$s="select 
						distinct(facture_imprime.Num_facture),
						facture_imprime.Mouv,
						mouvement2.Num_mouv, 
						mouvement2.Immatr,
						immatriculation.Id_imm,
						facture_imprime.Statut,
						immatriculation.Code_pr,
						client.Id_cl,
						facture_imprime.Date_impr
					from  
						rva_facturation2.facture_imprime,
						rva_facturation2.mouvement2,
						rva_facturation2.immatriculation,
						rva_facturation2.client 
					where
						facture_imprime.Mouv=mouvement2.Num_mouv 
					and
						mouvement2.Immatr=immatriculation.Id_imm 
					and
						immatriculation.Code_pr=client.Id_cl 
					and
						facture_imprime.Statut='R' 
					and
						client.Id_cl='$client' 
					and
						facture_imprime.Date_impr between '$dt' and '$dt2'
					order 
						by Date_impr desc
				";
			}
			$e=$m->cnx->query($s);
			$t=$e->fetchAll();
			$n=count($t);
			$r=array();

			if($n==0)
			{
				$r[]=array("n"=>0);
			}else
			{
				$a=1;
				foreach($t as $row)
				{	$mouv=$m->mouv($row['Mouv']);	
					$facture=$row['Num_facture'];
					$s2="select * from rva_facturation2.rda where Num_long='$facture'";
					$e2=$m->cnx->query($s2);
					$t2=$e2->fetchAll();
					$n2=count($t2);

					if($n2==0)
					{
						$a++;
						@$r[]=array("n"=>2,
							"dt"=>$m->Datemysqltofr($row['Date_impr']),
							"facture"=>$row['Num_facture'],
							"client"=>$mouv["nom_cli"],
							"montant"=>$mouv['tot_avec_tva'],
							"formulaire"=>$mouv['ta'][0]['Num_form']
						);
					}					
				}
			}
			echo (json_encode($r));
		break;
		case "handling_liste_paiement":
			$s="select TOP 200 * from rva_facturation2.handling_paiement order by Id_paie desc";
			$e=$m->cnx->query($s);
			$t=$e->fetchAll();
			$n=count($t);
			$resultat=array();
			if($n==0)
			{
				@$resultat[]=array("n"=>0);
			}else
			{
				foreach($t as $row)
				{
					@$facture=$m->handling_facture($row['Fact_paie']);
					@$facture_payee=$m->paie_handling_detail($row["Fact_paie"]);
					@$resultat[]=array("n"=>$n,
								"id"=>$row["Id_paie"],
								"handleur"=>$facture["handleur"],
								"dt"=>$m->Datemysqltofr($row["Date_paie"]),
								"fact"=>$facture_payee["num_fact"],
								"imm"=>$facture["imm"],
								"client"=>$facture["client"],
								"mt"=>$facture["mttc"],
								"touche"=>$facture["touche"],
								"user"=>$facture["user"]
							);
				}
			}
			echo (json_encode($resultat));
		break;
		case "supp_liste_facture":
			$expl=$_POST["expl"];
			$dt=$_POST["dt"];
			$dt2=$_POST["dt2"];
			$s="select * from 
					rva_facturation2.paiement_facture,rva_facturation2.rda
				where
					paiement_facture.Quittance=rda.Quittance
				and
					paiement_facture.Date_paie between '$dt' and '$dt2'
				and
					rda.Client_rda='$expl'
				order by
					rda.Id_rda desc
				";
			$e=$m->cnx->query($s);
			$t=$e->fetchAll();
			$n=count($t);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else
			{
				foreach ($t as $row) {
					$r[]=array(
						"id_paie"=>$row['Id_paie'],
						"n"=>$n,
						"dt"=>$m->Datemysqltofr($row['Date_paie']),
						"mt"=>$row['Mt_paye'],
						"facture"=>$row['Num_long']
					);
				}
			}
			echo (json_encode($r));
		break;
		case "tableau_bord":
			$resultat=$m->tableau_de_bord($_POST['dt'],$_POST["dt2"]);
			echo json_encode($resultat);
		break;
		case "changer_mdp":
			$actuel=($_POST['actuel']);
			$nouveau=($_POST['nouveau']);
			$s="select * from rva_facturation2.utilisateur where Mdp='$actuel'";
			$e=$m->cnx->query($s); 
			$t=$e->fetchAll();
			$n=count($t);
			if($n==0)
			{
				echo 'Le mot de passe actuel saisi est incorrect';
			}else
			{
				$s2="update rva_facturation2.utilisateur set Mdp='$nouveau' where Mdp='$actuel'";
				if($m->cnx->exec($s2))
				{
					echo 1;
				}else
				{
					echo "Impossible de faire la modification maintenant,veuillez reessayer plutard";
				}
			}
		break;
		case "signataire_liste":
			$r=$m->signataire();
			echo (json_encode($r));
		break;
		case "cnx_master":
			$mdp=$_POST['mdp'];
			$s="select * from rva_facturation2.master where Mdp='$mdp'";
			$e=$m->cnx->query($s);
			$t=$e->fetchAll();
			$n=count($t);
			echo $n;
		break;
		case "reinitialisation_numerotation_confirm":
			$fact="000/RDA.FZQA/12/2019";
			$nume="000";
			$s="insert into 
				rva_facturation2.rda 
					(Num_rda,Num_long,Client_rda,Quittance,Id_us)	
				values(0,'$fact',0,'$nume','$id_us')";
			$m->cnx->exec($s);
			
			$s="insert into rva_facturation2.paiement_facture 
				(Quittance,Id_us)
			values($nume','$id_us')";
			$m->cnx->exec($s);

			
			$s="insert into rva_facturation2.facture_imprime (Date_impr,Heure_impr,N_ordre,Mouv,Num_facture,Montant,Tva,Taux,Statut,Valide,Id_us) values('01-01-2020','00:00:00','0','0',' ',0,0,0,'R','O','$id_us')";
			if($m->cnx->exec($s))
			{
				
			}else
			{
				
			}

			$s="insert into rva_facturation2.facture_paye_imprime 
					(Date_impr,Heure_impr,Mouv,Quittance,Num_facture,Montant,Tva,Taux,Valide,Id_us) 
				values
					('2020-01-01','00:00:00',0,0,'$fact',0,0,0,'V','$id_us')";
			$m->cnx->exec($s);

			$s="insert into rva_facturation2.handling_num_fact (Num_fact,Num_fact_long,Id_fact,Id_paie,Statut) values (0,'000/RDH.FZQA/01.2020',0,0,'V')";


			if($m->cnx->exec($s))
			{
				$s2="update rva_facturation2.master set Mdp='21112'";
				$m->cnx->exec($s2);
				echo 1;
			}else
			{
				echo ("Erreur");
			}
		break;
		case "chart_data_rda":
		
		break;
		case "quitter":
			
			if(session_destroy())
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		default:
			$s="select * from rva_facturation2.tarif_red";
			$e=$m->cnx->query($s);
			$t=($e->fetchAll());
			echo(json_encode($t));
		break;
	}
	
?>