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
		case "connexion":
			$login=format_text($_POST['login']);
			$mdp=($_POST['mdp']);
			$s="select * from user where Login='$login' and Mdp='$mdp'";
			$e=$m->cnx->$s; $n=mysqli_num_rows($e); $res=mysqli_fetch_array($e);
			if($n==1)
			{
				@session_start();
				$_SESSION['Priv']=$res['Priv'];
				$_SESSION['Nom']=$res['Nom_complet'];
				$_SESSION['Idd']=$res['Id_us'];
				$_SESSION['Cnx']="ok";
				journal_insert($_SESSION['Idd'],'C','Nouvelle connexion',$bdd);
			}
			echo ($n);
		break;	
		case "client":
			$s="select * from client order by Nom_cli";
			$e=$m->cnx->$s;
			$t=mysqli_fetch_array($e);
			$r=array();
			do
			{
				$r[]=array("id_cl"=>$t['Id_cl'],
					"nom_cl"=>($t['Nom_cli']),
					"ville"=>$m->afficher_text($t['Ville']),
					"typ"=>$m->afficher_text($t['Type_cl']),
					"nat"=>$m->afficher_text($t['Code_nat']),
					"telephone"=>$m->afficher_text($t['Telephone']),
					"code"=>$m->afficher_text($t['Code_cl']),
					"boite"=>$m->afficher_text($t['Boite_postale']),
					"adresse"=>$m->afficher_text($t['Adresse_cl']));
			}while($t=mysqli_fetch_array($e));
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
				$e=$m->cnx->$s;
				$n=mysqli_num_rows($e); $t=mysqli_fetch_array($e);
				$r=array();
				if($n==0)
				{
					$r[]=array("n"=>0);
				}else
				{
					do
					{
						$r[]=array("n"=>$n,"id"=>$t['Id_cais'],"motif"=>$m->afficher_text($t['Motif']),"mt"=>$t['Montant_mouv'],"monn"=>$t['Monnaie_mouv']);
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
				$e=$m->cnx->$s;
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
				$e=$m->cnx->$s;
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
				$eaer=$m->cnx->$ser;
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
			$s="select * from rva_facturation2.handling_handleur order by Nom_hand";
			$e=$m->cnx->query($s);
			$row=($e->fetchAll()); $n=count($row);
			$r= array();
			if($n==0)
			{
				$r[]= array('n' => 0);
			}else
			{
				foreach ($row as $t) {
					$r[] =
						array("n"=>$n,
							'id' => $t['Id_hand'],
							"code_hand"=>$t['Code_hand'],
							"nom"=>$m->afficher_text($t['Nom_hand']),
							"adresse"=>$m->afficher_text($t['Adresse_hand']),
							"ville"=>$m->afficher_text($t['Ville_hand']),
							"telephone"=>$m->afficher_text($t['Telephone_hand']),
							"type_paie"=>$m->afficher_text($t['Type_paie']),
							"nationalite"=>$t["Nationalite"]
						);
				}
			}
			echo (json_encode($r));
		break;
		case "paiement_hand_liste_fact":
			$s="select TOP 250  
				handling_facturation.Immatriculation,
				immatriculation.Id_imm,
				immatriculation.Code_pr,
				client.Id_cl,
				handling_facturation.Handleur,
				handling_facturation.AA,
				handling_facturation.TA,
				handling_facturation.FA,
				handling_facturation.Id_us,
				handling_facturation.Date_fact,
				handling_facturation.Heure_fact,
				handling_facturation.Date_arr,
				handling_facturation.Heure_arr,
				handling_facturation.Date_dep,
				handling_facturation.Heure_dep,
				immatriculation.Code_imm,
				handling_facturation.Id_fact,
				client.Nom_cli,
				handling_handleur.Nom_hand
			from 
				rva_facturation2.handling_facturation,rva_facturation2.immatriculation,rva_facturation2.client,rva_facturation2.handling_handleur
			where
				handling_facturation.Immatriculation=immatriculation.Id_imm 
			and
				immatriculation.Code_pr=client.Id_cl
			and
				handling_facturation.Handleur=handling_handleur.Id_hand
			order by 
				Date_fact desc";
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
					$touche="";
					if($t['TA']=="O")
					{
						$touche=$touche." TA ";
					}
					if($t['AA']!="N")
					{
						$touche=$touche." ".$t['AA']." ";
					}
					if($t['FA']=="O")
					{
						$touche=$touche." FA ";
					}
					@$user=$m->user($t['Id_us']);
					@$r[]=array("n"=>$n,
						"id"=>$t["Id_fact"],
						"imm"=>$t['Code_imm'],
						"client"=>$t['Nom_cli'],
						"dt_fact"=>$m->Datemysqltofr($t["Date_fact"]),
						"heure_arr"=>$t["Heure_arr"],
						"dt_arr"=>$m->Datemysqltofr($t["Date_arr"]),
						"heure_dep"=>$t["Heure_dep"],
						"dt_dep"=>$m->Datemysqltofr($t["Date_dep"]),
						"handleur"=>$t['Nom_hand'],
						"aa"=>$t["AA"],
						"ta"=>$t["TA"],
						"fa"=>$t["FA"],
						"touche"=>$touche,
						"user"=>$user
					);
				}
			}
			echo (json_encode($r));
		break;
		// =====================================
		case "liste_client_tout":
			$s="select * from client order by Nom_cli";
			$e=$m->cnx->$s;
			$t=mysqli_fetch_array($e);
			$n=mysqli_num_rows($e);
			$r=array();
			do
			{
				$r[]=array("n"=>$n,
					"id"=>$t['Id_cl'],
					"code_cl"=>$t['Code_cl'],
					"nom_cli"=>$t["Nom_cli"]
				);
			}while($t=mysqli_fetch_array($e));
			echo (json_encode($r));
		break;
		case 'liste_cl':
			$s="select * from rva_facturation2.immatriculation,rva_facturation2.client where immatriculation.Code_pr=client.Code_cl order by Nom_cli, immatriculation.Code_imm";
			$e=$m->cnx->query($s);
			$row=$e->fetchAll(); $n=count($row);
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
							"id_cl"=>$t['Id_cl'],
							'id' => $t['Id_imm'],
							"code_imm"=>$m->afficher_text($t['Code_imm']),
							"code_cl"=>$m->afficher_text($t['Code_cl']),
							"nom_cli"=>$m->afficher_text($t['Nom_cli']),
							"adr_cl"=>$m->afficher_text($t['Adresse_cl']),
							"ville_cl"=>$m->afficher_text($t['Ville']),
							"type_cl"=>$m->afficher_text($t['Type_cl']),
							"codenat_cl"=>$m->afficher_text($t['Code_nat']),
							"tel_cl"=>$m->afficher_text($t['Telephone']),
							"boitepos"=>$m->afficher_text($t['Boite_postale'])
						);
				}
			}
			echo (json_encode($r));
		break;
		case 'liste_typeav':
			$s="select * from rva_facturation2.type_avion order by Libelle_typ";
			$e=$m->cnx->query($s);
			$row=($e->fetchAll()); $n=count($row);
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
							'id_typ' => $t['Id_typ'],
							"libelle"=>$m->afficher_text($t['Libelle_typ']),
							"mtow"=>$m->afficher_text($t['Mtow']),
							"nbremot"=>$m->afficher_text($t['Nbre_mot']),
							"maxpaylaod"=>$m->afficher_text($t['Maxpayload']),
							"version"=>$m->afficher_text($t['Version']),
							"plmin"=>$m->afficher_text($t['Pl_min']),
							"plmax"=>$m->afficher_text($t['Pl_max']),
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
			$e=$m->cnx->query($s); $row=($e->fetchAll());
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
			$s="select * from route";
			$e=$m->cnx->$s; $t=mysqli_fetch_array($e);
			$n=mysqli_num_rows($e);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else{
				do
				{
					$r[]=array("n"=>$n,"id"=>$t['Id_route'],"route"=>$t['Libelle']);
				}while ($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "liste_ville":
			$s="select * from pt_emplacement where Type='V' order by Code_pt";
			$e=$m->cnx->$s; $t=mysqli_fetch_array($e);
			$n=mysqli_num_rows($e);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else{
				do
				{
					$r[]=array("n"=>$n,
						"id"=>$t['Id_pt'],
						"code_ville"=>$t['Code_pt'],
						"libelle"=>$t['Lib_pt']
					);
				}while ($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "liste_ville_nat":

			$s="select * from pt_emplacement where Type='E' order by Lib_pt";
			$e=$m->cnx->$s; $t=mysqli_fetch_array($e);
			$n=mysqli_num_rows($e);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else{
				do
				{
					$r[]=array("n"=>$n,
						"id"=>$t['Id_pt'],
						"libelle"=>$t["Lib_pt"],
						"code_ville"=>$t['Code_pt']);
				}while ($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "liste_ville_nat_int":

			$s="select * from pt_emplacement where Type='E' or Type='V' order by Lib_pt";
			$e=$m->cnx->$s; $t=mysqli_fetch_array($e);
			$n=mysqli_num_rows($e);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else{
				do
				{
					$r[]=array("n"=>$n,
						"id"=>$t['Id_pt'],
						"libelle"=>$t["Lib_pt"],
						"code_ville"=>$t['Code_pt']);
				}while ($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "liste_emplacement":
			$s="select * from pt_emplacement where Type='E' order by Code_pt";
			$e=$m->cnx->$s; $t=mysqli_fetch_array($e);
			$n=mysqli_num_rows($e);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else{
				do
				{
					$r[]=array("n"=>$n,
						"id"=>$t['Id_pt'],
						"libelle"=>$m->afficher_text($t['Lib_pt']),
						"distance"=>$t['Distance'],
						"gere"=>$t['Type_gestion'],
						"code_ville"=>$t['Code_pt']);
				}while ($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "dernier_taux":
			
		break;
		case "liste_type_acces":
			$s="select * from type_acces";
			$e=$m->cnx->$s; $t=mysqli_fetch_array($e);
			$n=mysqli_num_rows($e);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else{
				do
				{
					$r[]=array("n"=>$n,
						"id"=>$t['Id_acc'],
						"code_acc"=>$t['Code_acc'],
						"designation_acc"=>$t['Designation_acc']);
				}while ($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "num_fiche_rec":
			$s="select * from Num_fiche Order by Num_fich desc";
			$e=$m->cnx->$s; 
			$n=mysqli_num_rows($e); 
			$t=mysqli_fetch_array($e);
			echo ($t['Num_fich']+1);
		break;
		case "liste_ville":
			$s="select * from pt_emplacement where Type='E' order by Code_pt";
			$e=$m->cnx->$s; 
			$t=mysqli_fetch_array($e);
			$r=array();
			do{
				$r[] = array('n' =>"n",
					"code"=>$t['Code_pt'],
					"libelle"=>$t['Lib_pt'],
					"distance"=>$t['Distance'],
					"id"=>$t['Id_pt']);
			}
			while($t=mysqli_fetch_array($e));
			echo (json_encode($r));
		break;
		case "liste_pt":
			$s="select * from pt_emplacement where Type='P' order by Code_pt";
			$e=$m->cnx->$s; 
			$t=mysqli_fetch_array($e);
			$r=array();
			do{
				$r[] = array('n' =>"n",
					"code"=>$t['Code_pt'],
					"libelle"=>$t['Lib_pt'],
					"distance"=>$t['Distance'],
					"id"=>$t['Id_pt']);
			}
			while($t=mysqli_fetch_array($e));
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
			$e=$m->cnx->$s;
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
							"nom"=>$m->afficher_text($t['Nom_pat'])." ".$m->afficher_text($t['Prenom_pat']),
						);
				}while ($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "liste_user":
			$s="select * from user order by Nom_complet";
			$e=$m->cnx->$s;
			$n=mysqli_num_rows($e); 
			$t=mysqli_fetch_array($e);
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
							'id' => $t['Id_us'],
							"nom"=>$m->afficher_text($t['Nom_complet']),
							"matricule"=>$m->afficher_text($t['Matricule']),
							"login"=>($t['Login']),
							"priv"=>($t['Priv']),
							"statut"=>$m->afficher_text($t['Statut']),
							"mdp"=>$t['Mdp']
						);
				}while ($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "bordereau":
			$dt=$_POST['dt'];
			$r=bordereau($dt,$bdd);
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
			$e=$m->cnx->$s; $n=mysqli_num_rows($e); $t=mysqli_fetch_array($e);
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
							"client"=>$m->afficher_text($mouvement['ta']['Nom_cli']),
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
				limit 0,800
				";
			$e=$m->cnx->$s;
			$t=mysqli_fetch_array($e);
			$r=array();
			do
			{
				$mouvement=$t['Num_mouv'];
				$s5="select * from facture_imprime where Mouv='$mouvement'";
				$e5=$m->cnx->$s;
				$t5=mysqli_fetch_array($e5);
				$n5=mysqli_num_rows($e5);

				$s2="select * from paiement_facture where Mouv='$mouvement'";
				$e2=$m->cnx->$s; $n2=mysqli_num_rows($e2);
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
				";
			$e=$m->cnx->$s;
			$t=mysqli_fetch_array($e);
			$r=array();
			do
			{
				$mouvement=$t['Num_mouv'];
				$s5="select * from facture_imprime where Mouv='$mouvement'";
				$e5=$m->cnx->$s;
				$t5=mysqli_fetch_array($e5);
				$n5=mysqli_num_rows($e5);
				if($n5!==0)
				{
					continue;
				}else
				{

					$s2="select * from paiement_facture where Mouv='$mouvement'";
					$e2=$m->cnx->$s; $n2=mysqli_num_rows($e2);
					if($n2==0)
					{
						$statut="Non payée"; 
						$classe="text-danger";
					}else{
						$statut="Payée"; 
						$classe="text-success";
					}
					@$r[]=array("dt_mouv"=>$t['Dt'],
							"Id_mouv"=>$t["Id_mouv"],
							"Num_mouv"=>$t['Num_mouv'],
							"Num_form"=>$t['Num_form'],
							"Code_imm"=>$t['Code_imm'],
							"Nom_cli"=>$t["Nom_cli"],
							"statut"=>$statut,
							"classe"=>$classe
						);
				}
			}while($t=mysqli_fetch_array($e));

			echo (json_encode($r));
		break;
		case "mouvement_facture":
			$s="select * from facture_imprime order by Id_fact desc limit 0,150";
			$e=$m->cnx->$s;
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
					$e2=$m->cnx->$s; $n2=mysqli_num_rows($e2);
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
		case "mouvement_facture_suite":
			$v=$_POST['v'];
			$s="select * from facture_imprime order by Id_fact desc limit $v,150";
			$e=$m->cnx->$s;
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
					$e2=$m->cnx->$s; $n2=mysqli_num_rows($e2);
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

			$s="select * from acces where Date_perc between '$dt1' and '$dt2' order by Id_acc desc";
			$e=$m->cnx->$s;
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
				@$r[]=array("n"=>$n,
					"id"=>$t["Id_acc"],
					"num_fact"=>$t["Num_long"],
					"heure"=>Heureformat($t["Heure_perc"]),
					"tva"=>$t["Tva"],
					"type_acc"=>$t["Type_acc"],
					"dt"=>$t["Date_perc"],
					"num_fact"=>$t["Num_long"],
					"quittance"=>$t["Quittance"],
					"mt"=>$t["Mt_acc"],
					"monn"=>$t["Monn_acc"]
				);
				}while($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "rapport_idf":
			$dt1=$_POST["dt1"];
			$dt2=$_POST["dt2"];

			$s="select * from idf_paiement where Date_idf between '$dt1' and '$dt2' order by Id_paie desc";
			$e=$m->cnx->$s;
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
				$exploitant=exploitant($t['Client'],$bdd);
				@$r[]=array("n"=>$n,
					"id_exp"=>$t['Client'],
					"exploitant"=>$exploitant['nom'],
					"id"=>$t["Id_paie"],
					"dt"=>$t["Date_idf"],
					"quittance"=>$t["Quittance"],
					"mt"=>$t["Mt"],
					"monn"=>$t["Monn"]
				);
				}while($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "liste_facture_non_imprime":	
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
				Limit 0,300
				";
			$e=$m->cnx->$s;
			$t=mysqli_fetch_array($e);
			$r=array();
			do
			{
				$mouvement=$t['Num_mouv'];
				$s5="select * from facture_imprime where Mouv='$mouvement'";
				$e5=$m->cnx->$s;
				$t5=mysqli_fetch_array($e5);
				$n5=mysqli_num_rows($e5);
				/*if($n5!==0)
				{
					continue;
				}else
				{*/

					$s2="select * from paiement_facture where Mouv='$mouvement'";
					$e2=$m->cnx->$s; $n2=mysqli_num_rows($e2);
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
				Limit 0,300
				";
			$e=$m->cnx->$s;
			$t=mysqli_fetch_array($e);
			$r=array();
			do
			{
				$mouvement=$t['Num_mouv'];
				$s5="select * from facture_imprime where Mouv='$mouvement'";
				$e5=$m->cnx->$s;
				$t5=mysqli_fetch_array($e5);
				$n5=mysqli_num_rows($e5);
				/*if($n5!==0)
				{
					continue;
				}else
				{*/

					$s2="select * from paiement_facture where Mouv='$mouvement'";
					$e2=$m->cnx->$s; $n2=mysqli_num_rows($e2);
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
		case "releve_client":
			$client=$_POST['client'];
			$dt1=$_POST['dt1'];
			$dt2=$_POST['dt2'];
			if($client!=='t')
			{
				$s="select * 
				from 
					mouvement2,client,immatriculation
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
					mouvement2,client,immatriculation
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
			$e=$m->cnx->$s;
			$n=mysqli_num_rows($e);
			$t=mysqli_fetch_array($e);
			$r=array();
			if($n==0)
			{
				$r[]=array("n"=>0);
			}else
			{
				$total=0;
				do
				{
					@$mouv=mouv($t['Num_mouv'],$bdd);
					$total=$total+$mouv['tot_avec_tva'];
					@$r[]=array("n"=>$n,
						"date_arr"=>Datemysqltofr($mouv['ta']['Date_mouv']),
						"date_dep"=>Datemysqltofr($mouv['td']['Date_mouv']),
						"imm"=>$mouv['ta']['Code_imm'],
						"mouv"=>$mouv,
						"total"=>arrondie($total)
					);
				}while($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case 'facture_agree':
			$client=$_POST["client"];
			$dt1=$_POST['dt1'];
			$dt2=$_POST['dt2'];
			$s="select * from mouvement2,client,immatriculation 
				where 
					mouvement2.Immatr=immatriculation.Id_imm
				and
					immatriculation.Code_pr=client.Id_cl
				and
					client.Id_cl='$client'
				and	
					mouvement2.Date_mouv between '$dt1' and '$dt2'
				group by 
					mouvement2.Num_mouv";
			$e=$m->cnx->$s; $n=mysqli_num_rows($e);
			$t=mysqli_fetch_array($e);
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
				do
				{
					$mouvement=mouv($t['Num_mouv'],$bdd);
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
				}while($t=mysqli_fetch_array($e));
				$ligne=array("route"=>arrondie($route),
						"atterissage"=>	arrondie($atterissage),
						"stationnement"=>arrondie($stationnement),
						"fret"=>arrondie($fret),
						"passager"=>arrondie($passager),
						"passager"=>arrondie($pec),
						"surete"=>arrondie($surete),
						"securite"=>arrondie($securite),
						"ass"=>arrondie($ass),
						"formu"=>arrondie($formu),
						"compt"=>arrondie($compt),
						"tot"=>arrondie(ceil($route+$atterissage+$stationnement+$fret+$passager+$pec+$surete+$securite+$ass+$formu+$compt)));
						//"tot"=>arrondie($general));
				@$r=array_merge_recursive($nb,$ligne);
						//$r=array("n"=>1)5;
			}

			echo (json_encode($r));
		break;
		case "facture_non_paye":
			$s="select * from facture_imprime where Statut='R' order by Id_fact desc limit 0,350";
			$e=$m->cnx->$s;
			$t=mysqli_fetch_array($e);
			$r=array();
			do
			{
				$mouv=mouv($t['Mouv'],$bdd);
				$user=user($mouv['ta']['Us'],$bdd);
				@$r[]=array(
					'id'=>$t['Id_fact'],
					"dt"=>Datemysqltofr($t['Date_impr']),
					'expl'=>$mouv['ta']['Nom_cli'],
					'taxateur'=>$user['nom'],
					'montant'=>$mouv['tot_avec_tva'],
					"fact"=>$t["Num_facture"]);
			}while($t=mysqli_fetch_array($e));

			echo (json_encode($r));
		break;
		case "facture_paye":
			$s="select * from rda order by Id_rda desc limit 0,350";
			$e=$m->cnx->$s;
			$t=mysqli_fetch_array($e);
			$r=array();
			do
			{
				$expl=exploitant($t['Client_rda'],$bdd);
				$user=user($t['Id_us'],$bdd);
				@$r[]=array(
					'id'=>$t['Id_rda'],
					"dt"=>Datemysqltofr($t['Date_rda']),
					'expl'=>$expl['nom'],
					'percepteur'=>$user['nom'],
					'montant'=>$t['Mt_rda'],
					"fact"=>$t["Num_long"]);
			}while($t=mysqli_fetch_array($e));

			echo (json_encode($r));
		break;
		case "num_fact_agr":
			$_SESSION['num_fact_agr']=$_POST['num'];
			echo 1;
		break;
		case "mouvement_recherche":
			$formulaire=$_POST["formulaire"];
			$s="select * from mouvement2 where Num_form='$formulaire' group by Num_form";
			$e=$m->cnx->$s;
			$t=mysqli_fetch_array($e);
			$n=mysqli_num_rows($e);
			$r=array();
			if($n==0)
			{
				$r[]=array("n1"=>0);
			}else
			{
				do
				{
					$m=mouv($t['Num_mouv'],$bdd);

					$user=user($m['ta']['Us'],$bdd);
					@$rr=array("n1"=>$n,
						"id_mouv"=>$t["Id_mouv"],
						"mouv"=>$m['ta']['Num_mouv'],
						"us"=>$user['nom'],
						"dt_arr"=>Datemysqltofr($m['ta']['Date_mouv']),
						"dt_dep"=>Datemysqltofr($m['td']['Date_mouv'])
					);
					
					$r[]=array_merge_recursive($rr,$m);

				}while($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "liste_facture_non_regle":
			$client=$_POST["client"];
			$dt=$_POST["dt"];
			$dt2=$_POST["dt2"];
			if($client=='tout')
			{
				$s="select * from facture_imprime,mouvement2,immatriculation,client where
					facture_imprime.Mouv=mouvement2.Num_mouv and
					mouvement2.Immatr=immatriculation.Id_imm and
					facture_imprime.Statut='R' and
					immatriculation.Code_pr=client.Id_cl and
					facture_imprime.Date_impr between '$dt' and '$dt2'
					group by Num_facture order by Date_impr desc
				";
			}else
			{
				$s="select * from facture_imprime,mouvement2,immatriculation,client where
					facture_imprime.Mouv=mouvement2.Num_mouv and
					mouvement2.Immatr=immatriculation.Id_imm and
					immatriculation.Code_pr=client.Id_cl and
					facture_imprime.Statut='R' and
					client.Id_cl='$client' and
					facture_imprime.Date_impr between '$dt' and '$dt2'
					group by Num_facture order by Date_impr desc
				";
			}
			$e=$m->cnx->$s;
			$t=mysqli_fetch_array($e);
			$n=mysqli_num_rows($e);
			$r=array();

			if($n==0)
			{
				$r[]=array("n"=>0);
			}else
			{
				$a=1;
				do
				{	$mouv=mouv($t['Mouv'],$bdd);	
					$facture=$t['Num_facture'];
					$s2="select * from rda where Num_long='$facture'";
					$e2=$m->cnx->$s;
					$n2=mysqli_num_rows($e2);

					if($n2==0)
					{
						$a++;
						@$r[]=array("n"=>2,
							"dt"=>Datemysqltofr($t['Date_impr']),
							"facture"=>$t['Num_facture'],
							"client"=>$t["Nom_cli"],
							"montant"=>$mouv['tot_avec_tva'],
							"formulaire"=>$mouv['ta']['Num_form']
						);
					}					
				}while($t=mysqli_fetch_array($e));
			}
			echo (json_encode($r));
		break;
		case "changer_mdp":
			$actuel=($_POST['actuel']);
			$nouveau=($_POST['nouveau']);
			$s="select * from user where Mdp='$actuel'";
			$e=$m->cnx->$s; 
			$n=mysqli_num_rows($e);
			if($n==0)
			{
				echo 'Le mot de passe actuel saisi est incorrect';
			}else
			{
				$s2="update user set Mdp='$nouveau' where Mdp='$actuel'";
				if($m->cnx->$s)
				{
					echo 1;
				}else
				{
					echo "Impossible de faire la modification maintenant,veuillez reessayer plutard";
				}
			}
		break;
		case "signataire_liste":
			$r=signataire($bdd);
			echo (json_encode($r));
		break;
		case "cnx_master":
			$mdp=$_POST['mdp'];
			$s="select * from master where Mdp='$mdp'";
			$e=$m->cnx->$s;
			$n=mysqli_num_rows($e);
			echo $n;
		break;
		case "reinitialisation_numerotation_confirm":
			$fact="000/RDA.FZQA/12/2018";
			$nume="000";
			$s="insert into rda values('',0,'$fact','','',0,0,'','$nume','$id_us')";
			$m->cnx->$s;
			
			$s="insert into paiement_facture values('','','',0,0,0,'','$nume','$id_us')";
			$m->cnx->$s;

			
			$s="insert into facture_imprime (N_ordre,Statut,Id_us) values('$fact','R','$id_us')";
			$m->cnx->$s;

			$s="insert into facture_paye_imprime (Quittance,Num_facture,Id_us) values(0,'$fact','$id_us')";
			$m->cnx->$s;


			if($m->cnx->$s)
			{
				$s2="update master set Mdp='11111'";
				$m->cnx->$s;
				echo 1;
			}else
			{
				echo (mysqli_error($bdd));
			}
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
			$s="select * from tarif_red";
			$e=$m->cnx->$s;
			$t[]=mysqli_fetch_array($e);
			echo(json_encode($t));
		break;
	}
	
?>