<?php
	@session_start();
	include("../manager/bd/cnx.php");
	$dt=date("Y-m-d");
	$heure=date("H:i");
	$ent=$_POST["ent"];
	$id_us=1;
	class m extends main
	{

	}
	$m=new main();
	if($_SESSION['Priv']=='adm' || $_SESSION['Priv']=='ch_serv' || $_SESSION['Priv']=="dicom")
	{
		switch($ent)
		{
			case "client":
				$id=$_POST['id'];
				$code=$m->format_text($_POST['code']);
				$nom=$m->format_text($_POST['nom']);
				$tel=$m->format_text($_POST['tel']);
				$adr=$m->format_text($_POST['adr']);
				$ville=$m->format_text($_POST['ville']);
				$boite=$m->format_text($_POST['boite']);
				$type_cl=$m->format_text($_POST['type_cl']);
				$code_nat=$m->format_text($_POST['code_nat']);
				$s="update rva_facturation2.client 
					set 
						Code_cl='$code',
						Nom_cli='$nom',
						Adresse_cl='$adr',
						Ville='$ville',
						Type_cl='$type_cl',
						Code_nat='$code_nat',
						Telephone='$tel',
						Boite_postale='' 
					where 
						Id_cl='$id'";
				if($m->cnx->exec($s))
				{
					echo 1;
				}else
				{
					echo($boite);
				}
			break;
			case "acces":
				$id=$_POST['id'];
				$dt=($_POST['dt']);
				$heure=($_POST['heure']);
				$acces_liste=$m->format_text($_POST['acces_liste']);
				$quittance=$m->format_text($_POST['quittance']);
				$mt=$m->format_text($_POST['mt']);
				$monnaie=$m->format_text($_POST['monnaie']);
				$tva=$m->format_text($_POST['tva']);
				$s="update rva_facturation2.acces 
					set 
						Date_perc='$dt',
						Heure_perc='$heure',
						Type_acc='$acces_liste',
						Mt_acc='$mt',
						Monn_acc='$monnaie',
						Quittance='$quittance',
						Tva='$tva'
					where 
						Id_acc='$id'";
				if($m->cnx->exec($s))
				{
					echo 1;
				}else
				{
					echo ("Erreur");
				}
			break;
			case "idf":
				$id=$_POST['id'];
				$dt=($_POST['dt']);
				$client=($_POST['client']);
				$quittance=$m->format_text($_POST['quittance']);
				$mt=$m->format_text($_POST['mt']);
				$monn=$m->format_text($_POST['monn']);
				$s="update rva_facturation2.idf_paiement 
					set 
						Date_idf='$dt',
						Client='$client',
						Mt='$mt',
						Monn='$monn',
						Quittance='$quittance'
					where 
						Id_paie='$id'";
				if($m->cnx->query($s))
				{
					echo 1;
				}else
				{
					//echo 0;
					echo ("Erreur");
				}
			break;
			case "empl":
				$id=$_POST["id"];
				$libelle=$m->format_text($_POST['libelle']);
				$code=$_POST["code"];
				$distance=$_POST["distance"];
				$gere=$_POST["gere"];

				$s="update rva_facturation2.pt_emplacement set 
						Code_pt='$code',
						Lib_pt='$libelle',
						Distance='$distance',
						Type_gestion='$gere'
					where Id_pt='$id'
					";
				if($m->cnx->exec($s))
				{
					echo 1;
				}else
				{
					echo 0;
				}
			break;
			case "pt":
				$id=$_POST["id"];
				$libelle=$m->format_text($_POST['libelle']);
				$code=$_POST["code"];
				$distance=$_POST["distance"];

				$s="update rva_facturation2.pt_emplacement set 
						Code_pt='$code',
						Lib_pt='$libelle',
						Distance='$distance'
					where Id_pt='$id'
					";
				if($m->cnx->exec($s))
				{
					echo 1;
				}else
				{
					echo 0;
				}
			break;
			case "ville":
				$id=$_POST["id"];
				$ville=$m->format_text($_POST['ville']);
				$code=$_POST["code"];

				$s="update rva_facturation2.pt_emplacement set 
						Code_pt='$code',
						Lib_pt='$ville'
					where Id_pt='$id'
					";
				if($m->cnx->exec($s))
				{
					echo 1;
				}else
				{
					echo 0;
				}
			break;
			case "typeavion":
				$id=$_POST["id"];
				$typeav=$m->format_text($_POST['typeav']);
				$mtow=$_POST["mtow"];
				$moteur=$_POST["moteur"];
				$maxipayload=$_POST["maxipayload"];
				$version=$_POST["version"];
				$moteur=$_POST["moteur"];
				$plmax=$_POST["plmax"];
				$plmin=$_POST["plmin"];
				$s="update rva_facturation2.type_avion set 
						Libelle_typ='$typeav',
						Mtow='$mtow',
						Nbre_mot='$moteur',
						Maxpayload='$maxipayload',
						Version='$version',
						Pl_min='$plmin',
						Pl_max='$plmax'
					where Id_typ='$id'
					";
				if($m->cnx->exec($s))
				{
					echo 1;
				}else
				{
					echo 0;
				}
			break;
			case "immatriculation":
				$id=$_POST["id"];
				$code=$m->format_text($_POST['code']);
				$pr=$_POST["pr"];
				$type_av=$_POST["type_av"];
				$poids=$_POST["poids"];
				$siege=$_POST["siege"];
				
				$s="update rva_facturation2.immatriculation set 
						Code_imm='$code',
						Code_pr='$pr',
						Type_av='$type_av',
						Poids='$poids',
						Nbre_siege='$siege'
					where Id_imm='$id'
					";
				if($m->cnx->exec($s))
				{
					echo 1;
				}else
				{
					echo 0;
				}
			break;
			case "user":
				$id=$_POST['id'];
				$nom=$m->format_text($_POST['nom']);
				$login=($_POST['login']);
				$mdp=($_POST['mdp']);
				$matr=$m->format_text($_POST['matr']);
				$priv=($_POST['priv']);
				$statut=$m->format_text($_POST['statut']);
				$s="update rva_facturation2.utilisateur set
						Login='$login',
						Nom_complet='$nom',
						Mdp='$mdp',
						Priv='$priv',
						Matricule='$matr',
						Statut='$statut'
					where Id_us='$id'
					";
				if($m->cnx->exec($s))
				{
					echo 1;
				}else
				{
					echo json_encode($m->cnx->errorInfo());
				}
			break;
			case "modif_esc_nat":
				$id_esc=$_POST["id_esc"];
				$prov=$_POST["prov"];
				$ad=$_POST["ad"];
				$ch=$_POST["ch"];
				$inf=$_POST["inf"];
				$tra=$_POST["tra"];
				$pec=$_POST["pec"];
				$loc=$_POST["loc"];
				$trat=$_POST["trat"];
				$ptt=$_POST["ptt"];
				$s="update rva_facturation2.escale set 
						Prov_dest='$prov',
						Ad='$ad',
						Ch='$ch',
						Inf='$inf',
						Tra='$tra',
						Pec='$pec',
						Loc='$loc',
						Trat='$trat',
						Ptt='$ptt'
					where 
						Id_esc='$id_esc'
				";
				if($m->cnx->exec($s))
				{
					echo 1;
				}else
				{
					echo 0;
					//echo(5656);
				}
			break;
			case "modif_esc_int":
				$id_esc=$_POST["id_esc"];
				$prov=$_POST["prov"];
				$pt=$_POST["pt"];
				$ad=$_POST["ad"];
				$ch=$_POST["ch"];
				$inf=$_POST["inf"];
				$tra=$_POST["tra"];
				$pec=$_POST["pec"];
				$loc=$_POST["loc"];
				$trat=$_POST["trat"];
				$ptt=$_POST["ptt"];
				$s="update rva_facturation2.escale set 
						Prov_dest='$prov',
						Pt_ent='$pt',
						Ad='$ad',
						Ch='$ch',
						Inf='$inf',
						Tra='$tra',
						Pec='$pec',
						Loc='$loc',
						Trat='$trat',
						Ptt='$ptt'
					where 
						Id_esc='$id_esc'
				";
				if($m->cnx->exec($s))
				{
					echo 1;
				}else
				{
					echo 0;
				}
			break;
			case "modif_mouv_nat_arr":
				$id_mouv=$_POST["id_mouv"];
				$dt=$_POST["dt"];
				$heure=$_POST["heure"];
				$nature_vol=$_POST["nature_vol"];
				$num_form=$_POST["num_form"];
				$temps=$_POST["temps"];
				$niv_vol=$_POST["niv_vol"];
		
				$s="update rva_facturation2.mouvement2 set 
						Date_mouv='$dt',
						Heure_mouv='$heure',
						Num_form='$num_form',
						Type_mouv='$nature_vol',
						Temps='$temps',
						Nv_vol='$niv_vol'
					where 
						Id_mouv='$id_mouv'
				";
				if($m->cnx->exec($s))
				{
					echo 1;
				}else
				{
					echo 0;
				}
			break;
			case "modif_exon_arr":
				$id_mouv=$_POST["id_mouv"];
				$ex_att_nat_arr=$_POST["ex_att_nat_arr"];
				$ex_stt_nat_arr=$_POST["ex_stt_nat_arr"];
				$ex_stg_nat_arr=$_POST["ex_stg_nat_arr"];
				$ex_bal_nat_arr=$_POST["ex_bal_nat_arr"];
				$ex_pax_nat_arr=$_POST["ex_pax_nat_arr"];
				$ex_fret_nat_arr=$_POST["ex_fret_nat_arr"];
				$ex_route_nat_arr=$_POST["ex_route_nat_arr"];
		
				$s="update rva_facturation2.mouvement2 set 
						Ex_att='$ex_att_nat_arr',
						Ex_stt='$ex_stt_nat_arr',
						Ex_stg='$ex_stg_nat_arr',
						Ex_bal='$ex_bal_nat_arr',
						Ex_pax='$ex_pax_nat_arr',
						Ex_fret='$ex_fret_nat_arr',
						Ex_rout='$ex_route_nat_arr'
					where 
						Id_mouv='$id_mouv'
				";
				if($m->cnx->exec($s))
				{
					echo 1;
				}else
				{
					echo 0;
				}
			break;
			case "modif_mouv_nat_dep":
				$id_mouv=$_POST["id_mouv"];
				$dt=$_POST["dt"];
				$heure=$_POST["heure"];
				$nature_vol=$_POST["nature_vol"];
				$num_form=$_POST["num_form"];
				$temps=$_POST["temps"];
				$niv_vol=$_POST["niv_vol"];
				$stat=$_POST["stat"];
				$compt=$_POST["compt"];
				$formulaire=$_POST["formulaire"];
				$anti_inc=$_POST["anti_inc"];
		
				$s="update rva_facturation2.mouvement2 set 
						Date_mouv='$dt',
						Heure_mouv='$heure',
						Type_mouv='$nature_vol',
						Temps='$temps',
						Nv_vol='$niv_vol',
						Compt_enr='$compt',
						Formu='$formulaire',
						Stat='$stat',
						Anti_inc='$anti_inc'
					where 
						Id_mouv='$id_mouv'
				";
				if($m->cnx->exec($s))
				{
					echo 1;
				}else
				{
					echo 0;
				}
			break;
		}
	}else
	{
		echo 0;
	}

?>