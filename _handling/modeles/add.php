<?php
	@session_start();
	include("../../manager/bd/cnx.php");
	$dt=date("Y-m-d");
	$heure=date("H:i");
	$ent=$_POST["ent"];
	$id_us=$_SESSION["Idd"];
	
	class m extends main{}
	$m=new m();
	switch ($ent) {
		case "user":
			$nom=$_POST['nom'];
			$matr=$_POST['matr'];
			$priv=$_POST['priv'];
			$login=$_POST['login'];
			$mdp=$_POST['mdp'];
			$verif="select * from user where Login='$login'";
			$everif=mysqli_query($bdd,$verif); $nverif=mysqli_num_rows($everif);
			if($nverif!==0)
			{
				echo 3;
			}else
			{
				$s="insert into user value('','$matr','$nom','$login','$mdp','$priv','A')";
				if(mysqli_query($bdd,$s))
				{
					echo 1;
				}else
				{
					echo 0;
				}
			}
		break;
		case 'client':
			$id=format_text($_POST["id"]);
			$nom=($_POST["nom"]);
			$tel=format_text($_POST["tel"]);
			$adr=format_text($_POST["adr"]);
			$ville=format_text($_POST["ville"]);
			$boite_post=format_text($_POST["boite_post"]);
			$type_cl=($_POST["type_cl"]);
			$code_nat=($_POST["code_nat"]);
			
			$s="insert into client values ('','$id','$nom','$adr','$ville','$type_cl','$code_nat','$tel','$boite_post')";
			if(mysqli_query($bdd,$s))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "type_av":

			$typeav_type=format_text($_POST["typeav_type"]);
			$typeav_mtow=format_text($_POST["typeav_mtow"]);
			$typeav_nbrmoteur=format_text($_POST["typeav_nbrmoteur"]);
			$typeav_maxipayload=format_text($_POST["typeav_maxipayload"]);
			$typeav_version=format_text($_POST["typeav_version"]);
			$typeav_plmin=format_text($_POST["typeav_plmin"]);
			$typeav_plmax=format_text($_POST["typeav_plmax"]);
			
			$s="insert into type_avion values ('','$typeav_type','$typeav_mtow','$typeav_nbrmoteur','$typeav_maxipayload','$typeav_version','$typeav_plmin','$typeav_plmax')";
			if(mysqli_query($bdd,$s))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "immatriculation":
			$imm_code=format_text($_POST["imm_code"]);
			$imm_pr=format_text($_POST["imm_pr"]);
			$imm_typeav=format_text($_POST["imm_typeav"]);
			$imm_tonn=format_text($_POST["imm_tonn"]);
			$imm_siege=format_text($_POST["imm_siege"]);
			
			
			$s="insert into immatriculation values ('','$imm_code','$imm_pr','$imm_typeav','$imm_tonn','$imm_siege')";
			if(mysqli_query($bdd,$s))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "route":
			$route_prov=format_text($_POST["route_prov"]);
			$route_dest=format_text($_POST["route_dest"]);
			$route_trajet=format_text($_POST["route_trajet"]);
			$route_libelle=format_text($_POST["route_libelle"]);
						
			$s="insert into route values ('','$route_prov','$route_dest','$route_trajet','$route_libelle')";
			if(mysqli_query($bdd,$s))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "pt":
			$t=format_text($_POST["t"]);
			$libelle=format_text($_POST["libelle"]);
			$code=format_text($_POST["code"]);
			$distance=format_text($_POST["distance"]);
			$gere=$_POST["gere"];
			$s0="select * from pt_emplacement where Code_pt like '$code' or Lib_pt like '$libelle'";
			$e0=mysqli_query($bdd,$s0); $n0=mysqli_num_rows($e0);
			if($n0==0)
			{
						
				$s="insert into 
						pt_emplacement 
					values 
					(
						'',
						'$code',
						'$libelle',
						'$distance',
						'$t',
						'$gere'
					)";
				if(mysqli_query($bdd,$s))
				{
					echo 1;
				}else
				{
					echo 0;
				}
			}else
			{
				echo 3;
			}
		break;
		case "ville":	
			$code=format_text($_POST["code"]);
			$ville=format_text($_POST["ville"]);
			$s0="select * from pt_emplacement where Code_pt like '$code' or Lib_pt like '$ville'";
			$e0=mysqli_query($bdd,$s0); $n0=mysqli_num_rows($e0);
			if($n0==0)
			{
						
				$s="insert into pt_emplacement values ('','$code','$ville','','V','N')";
				if(mysqli_query($bdd,$s))
				{
					echo 1;
				}else
				{
					echo 0;
				}
			}else
			{
				echo 3;
			}
		break;
		case "taux":
			$dt=$_POST['dt'];
			$fc_usd=$_POST["fc_usd"];
			$usd_fc=$_POST["usd_fc"];
		
			$s="insert into taux values('','$dt','$fc_usd','$usd_fc','')";
			if(mysqli_query($bdd,$s))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "tarif_red":
			$tva=$_POST["tva"];
            $cpt_enr=$_POST["cpt_enr"];
            $redbal=$_POST["redbal"];
            $redsec=$_POST["redsec"];
            $assantinc=$_POST["assantinc"];
            $redsur=$_POST["redsur"];
            $redsur_form=$_POST["redsur_form"];
            $redsur_aero=$_POST["redsur_aero"];
            $redsur_int=$_POST["redsur_int"];
            $resdsur_nat=$_POST["resdsur_nat"];
            $redfr_int=$_POST["redfr_int"];
            $redfr_nat=$_POST["redfr_nat"];
            $redfr_int_idf_emb=$_POST["redfr_int_idf_emb"];
            $redfr_int_idf_deb=$_POST["redfr_int_idf_deb"];
            $redfr_nat_idf_emb=$_POST["redfr_nat_idf_emb"];
            $redfr_nat_idf_deb=$_POST["redfr_nat_idf_deb"];
            $redpass_pascorri=$_POST["redpass_pascorri"];
            $redpass_rdom=$_POST["redpass_rdom"];
            $redpass_int=$_POST["redpass_int"];
            $redpass_int_idf=$_POST["redpass_int_idf"];
            $redpass_nat=$_POST["redpass_nat"];
            $redpass_nat_idf=$_POST["redpass_nat_idf"];
            $redrou_sup_245=$_POST["redrou_sup_245"];
            $redrou_inf_245=$_POST["redrou_inf_245"];
            $redrou_vol_int=$_POST["redrou_vol_int"];
            $redstat_tarmac=$_POST["redstat_tarmac"];
            $redstat_garage=$_POST["redstat_garage"];
            $redatt_1_25_int=$_POST["redatt_1_25_int"];
            $redatt_1_25_nat=$_POST["redatt_1_25_nat"];
            $redatt_26_75_int=$_POST["redatt_26_75_int"];
            $redatt_26_75_nat=$_POST["redatt_26_75_nat"];
            $redatt_sup_75_int=$_POST["redatt_sup_75_int"];
            $redatt_sup_75_nat=$_POST["redatt_sup_75_nat"];
            $redatt_ton_min_int=$_POST["redatt_ton_min_int"];
            $redatt_ton_min_nat=$_POST["redatt_ton_min_nat"];
            $s="update tarif_red set
            		Tva=$tva,
            		Cptenreg=$cpt_enr,
            		redbal=$redbal,
            		Redsecurite=$redsec,
            		Assantinc=$assantinc,
            		Redsur_vol_int=$redsur,
            		Redsur_form=$redsur_form,
            		Redsur_aeronongere=$redsur_aero,
            		Redsur_inter=$redsur_int,
            		Redsur_nat=$resdsur_nat,
            		Redfr_res_int=$redfr_int,
            		Redfr_res_nat=$redfr_nat,
            		Redfr_res_int_idf_emb=$redfr_int_idf_emb,
            		Redfr_res_int_idf_deb=$redfr_int_idf_deb,
            		Redfr_res_nat_idf_emb =$redfr_nat_idf_emb,
            		Redfr_res_nat_idf_deb=$redfr_nat_idf_deb,
            		Redpass_pasencorri=$redpass_pascorri,
            		Redpass_rdom=$redpass_rdom,
            		Redpass_res_int =$redpass_int,
            		Redpass_res_int_idf=$redpass_int_idf,
            		Redpass_res_nat=$redpass_nat,
            		Redpass_res_nat_idf=$redpass_nat_idf,
            		Redrou_esp_sup_245=$redrou_sup_245,
            		Redrou_esp_inf_245=$redrou_inf_245,
            		Redrou_vol_int=$redrou_vol_int,
            		Redstat_tarmac=$redstat_tarmac,
            		Redstat_garage=$redstat_garage,
            		Redatt_1_25_inter=$redatt_1_25_int,
            		Redatt_1_25_nat=$redatt_1_25_nat,
            		Redatt_26_75_inter=$redatt_26_75_int,
            		Redatt_26_75_nat=$redatt_26_75_nat,
            		Redatt_sup_75_inter=$redatt_sup_75_int,
            		Redatt_sur_75_nat=$redatt_sup_75_nat,
            		Redatt_ton_min_inter=$redatt_ton_min_int,
            		Redatt_ton_min_nat=$redatt_ton_min_nat
            	";
            	if(mysqli_query($bdd,$s))
            	{
            		echo 1;
            	}else
            	{
            		echo 0;
            	}
		break;
		case "type_acces":
			$code_acces=format_text($_POST['code_acces']);
			$designation_acces=format_text($_POST['designation_acces']);
			$s0="select * from type_acces where Code_acc like '$code_acces'"; $e0=mysqli_query($bdd,$s0); $n=mysqli_num_rows($e0);
			if($n==0)
			{
				$s="insert into type_acces values ('','$code_acces','$designation_acces')";
				if(mysqli_query($bdd,$s))
				{
					echo 1;
				}else
				{
					echo 0;
				}
			}else
			{
				echo 3;
			}
		break;
		case "acces":
			$type_acc=$_POST['type_acces'];
			$dt=$_POST['dt'];
			$heure=$_POST['heure'];
			$mt=$_POST['mt'];
			$monnaie=$_POST['monnaie'];
			$quittance=$_POST['quittance'];
			$tva=$_POST['tva'];

			$stypeacc="select * from type_acces where Id_acc='$type_acc'";
			$etypeacc=mysqli_query($bdd,$stypeacc);
			$ttypeacc=mysqli_fetch_array($etypeacc);

			$snum="select * from acces order by Id_acc desc"; 
			$e_num=mysqli_query($bdd,$snum);
			$tnum=mysqli_fetch_array($e_num);	
			$num=$tnum['Num_acc']+1;
			
			$num_long=($num)."/".$ttypeacc['Code_acc'].".FZQA/".date('n.Y');

			$s="insert into 
					acces 
				values ('','$num','$num_long','$dt','$heure','$type_acc','$mt','$monnaie','$quittance','$tva','$id_us')";
			if(mysqli_query($bdd,$s))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "rda":
			$client=$_POST['client'];
			$dt=$_POST['dt'];
			$heure=$_POST['heure'];
			$mt=$_POST['mt'];
			$monnaie=$_POST['monnaie'];
			$quittance=$_POST['quittance'];

			$snum="select * from rda order by Id_rda desc"; $e_num=mysqli_query($bdd,$snum);
			$tnum=mysqli_fetch_array($e_num);
			$num=$tnum['Num_rda']+1;

			$num_long=($num)."/"."RDA.FZQA/".date('n.Y');

			$s="insert into 
					rda
				values ('','$num','$num_long','$dt','$heure','$client','$mt','$monnaie','$quittance','$id_us')";
			if(mysqli_query($bdd,$s))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "mouvement":
			$sens=$_POST["sens"];
			$dt_mouv=$_POST["dt_mouv"];
			$heure_mouv=$_POST["heure_mouv"];
			$imm=$_POST["imm"];
			$temps=$_POST["temps"];
			$categ=$_POST["categ"];
			$nv_vol=$_POST["nv_vol"];
			$esc1_aero=$_POST["esc1_aero"];
			$esc1_esc=$_POST["esc1_esc"];
			$esc1_pt_ent=$_POST["esc1_pt_ent"];
			$esc1_ad=$_POST["esc1_ad"];
			$esc1_ch=$_POST["esc1_ch"];
			$esc1_inf=$_POST["esc1_inf"];
			$esc1_tra=$_POST["esc1_tra"];
			$esc1_pec=$_POST["esc1_pec"];
			$esc1_loc=$_POST["esc1_loc"];
			$esc1_trat=$_POST["esc1_trat"];
			$esc1_ptt=$_POST["esc1_ptt"];

			$esc2_aero=$_POST["esc2_aero"];
			$esc2_esc=$_POST["esc2_esc"];
			$esc2_pt_ent=$_POST["esc2_pt_ent"];
			$esc2_ad=$_POST["esc2_ad"];
			$esc2_ch=$_POST["esc2_ch"];
			$esc2_inf=$_POST["esc2_inf"];
			$esc2_tra=$_POST["esc2_tra"];
			$esc2_pec=$_POST["esc2_pec"];
			$esc2_loc=$_POST["esc2_loc"];
			$esc2_trat=$_POST["esc2_trat"];
			$esc2_ptt=$_POST["esc2_ptt"];

			$esc3_aero=$_POST["esc3_aero"];
			$esc3_esc=$_POST["esc3_escale"];
			$esc3_pt_ent=$_POST["esc3_pt_ent"];
			$esc3_ad=$_POST["esc3_ad"];
			$esc3_ch=$_POST["esc3_ch"];
			$esc3_inf=$_POST["esc3_inf"];
			$esc3_tra=$_POST["esc3_tra"];
			$esc3_pec=$_POST["esc3_pec"];
			$esc3_loc=$_POST["esc3_loc"];
			$esc3_trat=$_POST["esc3_trat"];
			$esc3_ptt=$_POST["esc3_ptt"];

			$esc4_aero=$_POST["esc4_aero"];
			$esc4_esc=$_POST["esc4_esc"];
			$esc4_pt_ent=$_POST["esc4_pt_ent"];
			$esc4_ad=$_POST["esc4_ad"];
			$esc4_ch=$_POST["esc4_ch"];
			$esc4_inf=$_POST["esc4_inf"];
			$esc4_tra=$_POST["esc4_tra"];
			$esc4_pec=$_POST["esc4_pec"];
			$esc4_loc=$_POST["esc4_loc"];
			$esc4_trat=$_POST["esc4_trat"];
			$esc4_ptt=$_POST["esc4_ptt"]=

			$esc5_aero=$_POST["esc5_aero"];
			$esc5_esc=$_POST["esc5_esc"];
			$esc5_pt_ent=$_POST["esc5_pt_ent"];
			$esc5_ad=$_POST["esc5_ad"];
			$esc5_ch=$_POST["esc5_ch"];
			$esc5_inf=$_POST["esc5_inf"];
			$esc5_tra=$_POST["esc5_tra"];
			$esc5_pec=$_POST["esc5_pec"];
			$esc5_loc=$_POST["esc5_loc"];
			$esc5_trat=$_POST["esc5_trat"];
			$esc5_ptt=$_POST["esc5_ptt"];

			$ex_att=$_POST["ex_att"];
			$ex_stt=$_POST["ex_stt"];
			$ex_stg=$_POST["ex_stg"];
			$ex_bal=$_POST["ex_bal"];
			$ex_pax=$_POST["ex_pax"];			
			$ex_fret=$_POST["ex_fret"];
			$ex_route=$_POST["ex_route"];

			$s0="select * from mouvement where Sens='$sens' and Date_mouv='$dt_mouv' and Id_cl='$imm'"; $e0=mysqli_query($bdd,$s0);
			$n0=mysqli_num_rows($e0);
			if($n0==0)
			{
				$s="insert into mouvement
				values ('',
					'$dt_mouv',
					'$heure',
					'$imm',
					'$temps',
					'$categ',
					'$sens',
					'$esc1_aero',
					'$esc1_esc',
					'$esc1_pt_ent',
					'$esc1_ad',
					'$esc1_ch',
					'$esc1_inf',
					'$esc1_tra',
					'$esc1_pec',
					'$esc1_loc',
					'$esc1_trat',
					'$esc1_ptt',
					'$esc2_aero',
					'$esc2_esc',
					'$esc2_pt_ent',
					'$esc2_ad',
					'$esc2_ch',
					'$esc2_inf',
					'$esc2_tra',
					'$esc2_pec',
					'$esc2_loc',
					'$esc2_trat',
					'$esc2_ptt',
					'$esc3_aero',
					'$esc3_esc',
					'$esc3_pt_ent',
					'$esc3_ad',
					'$esc3_ch',
					'$esc3_inf',
					'$esc3_tra',
					'$esc3_pec',
					'$esc3_loc',
					'$esc3_trat',
					'$esc3_ptt',
					'$esc4_aero',
					'$esc4_esc',
					'$esc4_pt_ent',
					'$esc4_ad',
					'$esc4_ch',
					'$esc4_inf',
					'$esc4_tra',
					'$esc4_pec',
					'$esc4_loc',
					'$esc4_trat',
					'$esc4_ptt',
					'$esc5_aero',
					'$esc5_esc',
					'$esc5_pt_ent',
					'$esc5_ad',
					'$esc5_ch',
					'$esc5_inf',
					'$esc5_tra',
					'$esc5_pec',
					'$esc5_loc',
					'$esc5_trat',
					'$esc5_ptt',

					'$ex_att',
					'$ex_stt',
					'$ex_stg',
					'$ex_bal',
					'$ex_pax',
					'$ex_fret',
					'$ex_route'
				)";
				if(mysqli_query($bdd,$s))
				{
					echo 1;
				}else{
					echo 0;
				}
			}else
			{
				echo 3;
			}
		break;
		case "vol_nat_arr":
			$client=$_POST['client'];
			$sens=$_POST['sens'];
			$num_fic=$_POST['num_fic'];
			$num_form=$_POST['num_form'];
			$type_vol=$_POST['type_vol'];
			$categ_vol=$_POST['categ_vol'];
			$temps=$_POST['temps'];
			$compt_enr=$_POST['compt_enr'];
			$formu=$_POST['formu'];
			$niv=$_POST['niv'];
			$stat=$_POST['stat'];
			//$pret=$_POST['pret'];
			$dt=$_POST['dt'];
			$heure=$_POST['heure'];

			$pt=$_POST['pt'];
			$ad=$_POST['ad'];
			$ch=$_POST['ch'];
			$inf=$_POST['inf'];
			$tra=$_POST['tra'];
			$pec=$_POST['pec'];
			$loc=$_POST['loc'];
			$ptt=$_POST['ptt'];
			$trat=$_POST['trat'];
			
			$anti_inc=$_POST['anti_inc'];
			$ex_att_nat_arr=$_POST["ex_att_nat_arr"];
			$ex_stt_nat_arr=$_POST["ex_stt_nat_arr"];			
			$ex_stg_nat_arr=$_POST["ex_stg_nat_arr"];
			$ex_bal_nat_arr=$_POST["ex_bal_nat_arr"];
			$ex_pax_nat_arr=$_POST["ex_pax_nat_arr"];
			$ex_fret_nat_arr=$_POST["ex_fret_nat_arr"];
			$ex_route_nat_arr=$_POST["ex_route_nat_arr"];
			
			//====== VERIFICATION DU MOUVEMENT 
			if($sens=='A')
			{
				$s0="select * from mouvement2 where Immatr='$client' and Date_mouv='$dt' and Heure_mouv='$heure' and Sens='A'";
			}else
			{
				$s0="select * from mouvement2 where Immatr='$client' and Date_mouv='$dt' and Heure_mouv='$heure' and Sens='D'";
			}
			$e0=mysqli_query($bdd,$s0);
			$n0=mysqli_num_rows($e0);
			if($n0!==0)
			{
				echo 3;
			}else
			{
				$dt22=date("Y-m-d");
				$erreur=0;
				if($sens=='A')
				{
					if(check_formulaire_arr($num_form,$bdd)==1)
					{
						$erreur=1;
						$msg="Ce N° Formulaire est déjà enregistré";
					}
				}else
				{
					if(check_formulaire_dep($num_form,$bdd)==1)
					{
						$erreur=1;
						$msg="Ce N° Formulaire est déjà enregistré";
					}

					if(check_dep_form_existe_arrive($num_form,$bdd)==0)
					{
						$erreur=1;
						$msg="Il n'y a pas un arrivé pour ce formulaire";
					}
					if(check_dep_form_existe_autre_imm($num_form,$client,$bdd)==1)
					{
						$erreur=1;
						$msg="Ce N° Formulaire existe pour un arrivé d'une autre immatriculation";
					}
				}
				
				if($erreur==1)
				{
					echo  $msg;
				}else
				{
					$s="insert into mouvement2 values(
						'',
						'$dt22',
						'$num_fic',
						'$num_form',
						'$dt',
						'$heure',
						'N',
						'$sens',
						'$client',
						'$temps',
						'$categ_vol',
						'$niv',
						'$compt_enr',
						'$formu',
						'$stat',
						'$pt',
						'$stat',
						'$anti_inc',
						'$ex_att_nat_arr',
						'$ex_stt_nat_arr',
						'$ex_stg_nat_arr',
						'$ex_bal_nat_arr',
						'$ex_pax_nat_arr',
						'$ex_fret_nat_arr',
						'$ex_route_nat_arr',
						'$id_us'
					)";
					if(mysqli_query($bdd,$s))
					{
						
						add_esc($bdd,$num_fic,$sens,$pt,$pt,$ad,$ch,$inf,$tra,$pec,$loc,$trat,$ptt);
						$s2="update num_fiche set Num_fich=Num_fich+1";
						mysqli_query($bdd,$s2);
						journal_insert($_SESSION['Idd'],'mouvement',$num_fic,$bdd);
						echo 1;
					}else
					{
						echo "Erreur d'enregistrement dans la base de données, veuillez reessayer plutard";
						//echo (mysqli_error($bdd));
					}
				}
			}
		break;
		case "vol_int_arr":
			$client=$_POST['client'];
			$sens=$_POST['sens'];
			$num_fic=$_POST['num_fic'];
			$num_form=$_POST['num_form'];

			$type_vol=$_POST['type_vol'];
			$categ_vol=$_POST['categ_vol'];
			$temps=$_POST['temps'];
			$compt_enr=$_POST['compt_enr'];
			$formu=$_POST['formu'];
			$niv=$_POST['niv'];
			$stat=$_POST['stat'];
			//$pret=$_POST['pret'];
			$dt=$_POST['dt'];
			$heure=$_POST['heure'];

			$pt=$_POST['pt'];
			$ville=$_POST['ville'];
			$ad=$_POST['ad'];
			$ch=$_POST['ch'];
			$inf=$_POST['inf'];
			$tra=$_POST['tra'];
			$pec=$_POST['pec'];
			$loc=$_POST['loc'];
			$ptt=$_POST['ptt'];
			$trat=$_POST['trat'];
			$anti_inc=$_POST['anti_inc'];
			
			$ex_att_int_arr=$_POST["ex_att_int_arr"];
			$ex_stt_int_arr=$_POST["ex_stt_int_arr"];			
			$ex_stg_int_arr=$_POST["ex_stg_int_arr"];
			$ex_bal_int_arr=$_POST["ex_bal_int_arr"];
			$ex_pax_int_arr=$_POST["ex_pax_int_arr"];
			$ex_fret_int_arr=$_POST["ex_fret_int_arr"];
			$ex_route_int_arr=$_POST["ex_route_int_arr"];

			if($sens=='A')
			{
				$s0="select * from mouvement2 where Immatr='$client' and Date_mouv='$dt' and Heure_mouv='$heure' and Sens='A'";
			}else
			{
				$s0="select * from mouvement2 where Immatr='$client' and Date_mouv='$dt' and Heure_mouv='$heure' and Sens='D'";
			}

			$e0=mysqli_query($bdd,$s0);
			$n0=mysqli_num_rows($e0);
			
			if($n0!==0)
			{
				echo 3;
			}else
			{
				$dt22=date("Y-m-d");
				$s="insert into mouvement2 values(
					'',
					'$dt22',
					'$num_fic',
					'$num_form',
					'$dt',
					'$heure',
					'I',
					'$sens',
					'$client',
					'$temps',
					'$categ_vol',
					'$niv',
					'$compt_enr',
					'$formu',
					'$stat',
					'$pt',
					 0,
					'$anti_inc',
					'$ex_att_int_arr',
					'$ex_stt_int_arr',
					'$ex_stg_int_arr',
					'$ex_bal_int_arr',
					'$ex_pax_int_arr',
					'$ex_fret_int_arr',
					'$ex_route_int_arr',
					'$id_us'
				)";
				if(mysqli_query($bdd,$s))
				{
					add_esc($bdd,$num_fic,$sens,$ville,$pt,$ad,$ch,$inf,$tra,$pec,$loc,$trat,$ptt);
					$s2="update num_fiche set Num_fich=Num_fich+1";
					mysqli_query($bdd,$s2);
					journal_insert($_SESSION['Idd'],'mouvement',$num_fic,$bdd);
					echo 1;
				}else
				{
					echo mysqli_error($bdd);
				}
			}
		break;
		case "escale":
			$num_fic=$_POST["num_fic"];
			$sens=$_POST['sens'];
			$pt=$_POST["pt"];
			$ad=$_POST["ad"];
			$ch=$_POST["ch"];
			$inf=$_POST["inf"];
			$tra=$_POST["tra"];
			$pec=$_POST["pec"];
			$loc=$_POST["loc"];
			$ptt=$_POST["ptt"];
			$trat=$_POST["trat"];
			if(add_esc($bdd,$num_fic,$sens,$pt,$pt,$ad,$ch,$inf,$tra,$pec,$loc,$trat,$ptt))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "paiement_fact":
			$mouv=$_POST['mouv'];
			$num_facture=$_POST['num_facture'];
			$client=$_POST['client'];
			$mt_paye=$_POST['mt_paye'];
			$monn_paye=$_POST['monn_paye'];
			$quittance=$_POST['quittance'];
			$s="insert into paiement_facture values('',
				'$dt',
				'$heure',
				'$client',
				'$mouv',
				'$mt_paye',
				'$monn_paye',
				'$quittance',
				'$id_us')";
			if(mysqli_query($bdd,$s))
			{
				//=============== INSERTION DANS LA GESTION DE N° FACT
					$new_num=format_nbre(facture_cash_nv($bdd,$mouv));
					$s="insert into num_facture values('','$dt','$heure','$new_num','','','$mouv','')";
					mysqli_query($bdd,$s);
					
					$new_num=format_nbre(facture_cash_nv($bdd,$mouv));
						
				//====================================================
				
				$snum="select * from rda order by Id_rda desc"; 
				$e_num=mysqli_query($bdd,$snum);
				$tnum=mysqli_fetch_array($e_num);
				$num=$tnum['Num_rda']+1;
				$num_fact=num_fact($mouv,$bdd);
				$s2="insert into rda values(
					'',
					'',
					'$num_fact',
					'$dt',
					'$heure',
					'$client',
					'$mt_paye',
					'$monn_paye',
					'$quittance',
					'$id_us'
				)";
				mysqli_query($bdd,$s2);
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "idf":
			$client=$_POST['client'];
			$dt_idf=$_POST['dt'];
			$mt=$_POST['mt'];
			$monn=$_POST['monn'];
			$quittance=$_POST['quittance'];
			$s="insert into idf_paiement values('','$dt','$dt_idf','$client','$mt','$monn','$quittance','$id_us')";
			if(mysqli_query($bdd,$s))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
	//================= FINANCE ===================
		case "depense":
			$motif=format_text($_POST['motif']);
			$mt=format_text($_POST['mt']);
			$monn=format_text($_POST['monn']);
			$s="insert into caisse_mouv values ('','$dt','$heure','D','$mt','$monn','$motif','','$id_us')";
			if(mysqli_query($bdd,$s))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "entree":
			$dt=$_POST['dt_ent'];
			$type_ent=format_text($_POST['type_ent']);
			$mt=format_text($_POST['mt']);
			$monn=format_text($_POST['monn']);
			$observation=format_text($_POST['observation']);
			$s="insert into caisse_mouv values ('','$dt','$heure','$type_ent','$mt','$monn','','$observation','$id_us')";
			if(mysqli_query($bdd,$s))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "recouvrement":
			$dt=$_POST['dt_recouv'];
			$client_recouv=format_text($_POST['client_recouv']);
			$mt=format_text($_POST['mt']);
			$monn=format_text($_POST['monn']);
			$observation=format_text($_POST['observation']);
			$s="insert into caisse_mouv values ('','$dt','$heure','RE','$mt','$monn','$client_recouv','$observation','$id_us')";
			if(mysqli_query($bdd,$s))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
	//=============== HANDLING =====================
		case "handleur":
			$nom=$_POST['nom'];
			$code_hand=$_POST['code_hand'];
			$adresse=$_POST['adresse'];
			$ville=$_POST['ville'];
			$telephone=$_POST['telephone'];
			$type_paie=$_POST['type_paie'];
			$nationalite=$_POST['nationalite'];

			$s="insert into handling_handleur values ('','$code_hand','$nom','$adresse','$ville','$telephone','$type_paie','$nationalite')";
			if(mysqli_query($bdd,$s))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "handling_facturation":
			$fact_handleur=$_POST['fact_handleur'];
			$fact_imm=$_POST['fact_imm'];
			$fact_dt_arr=$_POST['fact_dt_arr'];
			$fact_heure_arr=$_POST['fact_heure_arr'];
			$fact_dt_dep=$_POST['fact_dt_dep'];
			$fact_heure_dep=$_POST['fact_heure_dep'];
			$aa=$_POST['aa'];
			$ta=$_POST['ta'];
			$fa=$_POST['fa'];

			$s="insert into 
					rva_facturation2.handling_facturation 
				(
					Date_fact,Heure_fact,Handleur,Immatriculation,Date_arr,Heure_arr,Date_dep,Heure_dep,AA,TA,FA,Id_us
				)
				values ('$dt',
						'$heure',
						'$fact_handleur',
						'$fact_imm',
						'$fact_dt_arr',
						'$fact_heure_arr',
						'$fact_dt_dep',
						'$fact_heure_dep',
						'$aa',
						'$ta',
						'$fa',
						'$id_us'
				)";
			if($m->cnx->exec($s))
			{
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "handling_paiement":
			$fact=$_POST["fact"];
			$poids=$_POST["poids"];
			$mht=$_POST["mht"];
			$tva=$_POST["tva"];
			$mttc=$_POST["mttc"];
			$s="insert into 
					rva_facturation2.handling_paiement 
				(
					Date_paie,Heure_paie,Fact_paie,Poids,Mht,Tva,Mttc,Id_us
				)
				values(
					'$dt',
					'$heure',
					'$fact',
					'$poids',
					'$mht',
					'$tva',
					'$mttc',
					'$id_us')
				";
			if($m->cnx->exec($s))
			{
				$s2="select * from rva_facturation2.handling_paiement where Fact_paie='$fact'";
				$e2=$m->cnx->query($s2);
				$t2=($e2->fetchAll());
				$num_fact_paie=$t2[0]['Id_paie'];

				$s3="select * from rva_facturation2.handling_num_fact order by Id_num desc";
				$e3=$m->cnx->query($s3);
				$t3=($e3->fetchAll());
				$n3=count($t3);
				if($n3==0)
				{
					$num_fact_nouveau=1;
					$num_fact_nouveau_long=$m->format_nbre(1)."/RDH.FZQA/".date("d.Y");
					$m->cnx->exec("insert into rva_facturation2.handling_num_fact (Num_fact,Num_fact_long,Id_fact,Id_paie,Statut) values(1,'$num_fact_nouveau_long','$fact','$num_fact_paie','V')");
				}else
				{
					$num_fact_dernier_ligne=$t3[0]['Num_fact'];
					$num_fact_nouveau=$num_fact_dernier_ligne+1;
					$num_fact_nouveau_long=$m->format_nbre($num_fact_dernier_ligne+1)."/RDH.FZQA/".date("d.Y");
					$m->cnx->exec("insert into rva_facturation2.handling_num_fact 
							(
								Num_fact,Num_fact_long,Id_fact,Id_paie,Statut
							) 
							values(
								'$num_fact_nouveau','$num_fact_nouveau_long','$fact','$num_fact_paie','V'
							)");
				}
				//echo(json_encode($m->cnx->errorInfo()));
				echo 1;
			}else
			{
				echo 0;
			}
		break;
	//==============================================
		case "signataire":
			$cmd=$_POST['cmd'];
			$division=$_POST['division'];
			$facturation=$_POST['facturation'];
			mysqli_query($bdd,'delete from signataire');
			$s="insert into signataire values('$cmd','$division','$facturation')";
			if(mysqli_query($bdd,$s))
			{
				echo 1;
			}else
			{

			}
		break;
		default:
				# code...
		break;
	}	
?>