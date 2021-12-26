<?php
//$bdd=mysqli_connect('192.168.88.50','root','','rva_facturation');



$dt_2=date("Y-m-d");
$heure_2=date("H:i:s");
$jour_fin="2019-10-12";
$heure_fin="11:30:00";
/*if($dt_2>=$jour_fin && $heure_2>$heure_fin)
{
	
}else
{
	//echo "cool";*/
	$bdd=mysqli_connect('localhost','root','','rva_facturation');
//$bdd=mysqli_connect('192.168.88.50','root','','rva_facturation');
//}
function existe_il($table,$col,$v,$bdd)
{
	$s="select * from $table where '$col'='$v'";
	$e=mysqli_query($bdd,$s);
	$n=mysqli_num_rows($e);
	if($n==0)
	{
		$r=0;
	}else
	{
		$r=1;
	}
	return $r;
}
function truncate($txt,$nbr)
{
	if(strlen($txt)>$nbr)
	{
		$txt=substr($txt,0,$nbr);
		$r=$txt."...";
	}else
	{
		$r=$txt;
	}
			
	return $r;
			
}
function format_text($text)
{
	//return htmlentities(utf8_decode(htmlspecialchars(mysql_real_escape_string($text))));
	return htmlspecialchars(utf8_decode(htmlspecialchars((addslashes(ucfirst($text))))));
	//return $text;
}
function afficher_text($text)
{
	if($text=="")
	{
		$text="&nbsp;";
	}else
	{
		$text=$text;
	}
	return (ucfirst(ltrim(utf8_encode(htmlentities(stripslashes($text))))));
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
	$new_date=$d[2]."/".$d[1]."/".$d[0];
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
function journal_insert($us,$type_op,$detail_op,$bdd)
{
		$dt2=date("Y-m-d");
		$heure2=date('H:i:s');
		$s="insert into journal 
			values(
			'',
			'$dt2',
			'$heure2',
			'$us',
			'$type_op',
			'$detail_op'
		)";

		mysqli_query($bdd,$s);
}
function facture_cash_nv($bdd,$num_mouv)
{
		$s="select * from num_facture order by Id_num desc"; 
		$e=mysqli_query($bdd,$s);
		$n=mysqli_num_rows($e);
		$t=mysqli_fetch_array($e);

		$n1=$t['Num']+1;

		$dt=date("Y-m-d");
		$s1="insert into num_facture values('','$dt','$n1','','','$num_mouv','')";
		mysqli_query($bdd,$s1);

		return $n1;
}
function user($id,$bdd)
{
	$priv = array('perc' =>"Percepteur/Taxateur/Facturateur","ch_serv"=>"Chef de service","ch_bur"=>"Chef de bureau","ut"=>"Utilisateur","adm"=>"Administrateur");
	$s="select * from user where Id_us='$id'"; $e=mysqli_query($bdd,$s);
	$t=mysqli_fetch_array($e);
	$r=array("matr"=>$t['Matricule'],"nom"=>afficher_text($t['Nom_complet']),"login"=>$t['Login'],"priv"=>$t['Priv']);
	return $r;
}
function signataire($bdd)
{
	$s="select * from signataire";
	$e=mysqli_query($bdd,$s);
	$t=mysqli_fetch_array($e);
	$r=array("cmd"=>$t["Cmd"],"division"=>$t['Division'],"facturation"=>$t['Facturation']);
	return $r;
}
function exploitant($id,$bdd)
{
	$s="select * from client where Id_cl='$id'"; 
	$e=mysqli_query($bdd,$s);
	$t=mysqli_fetch_array($e);
	$r=array("code"=>$t['Code_cl'],"nom"=>afficher_text($t['Nom_cli']),"adresse"=>$t['Adresse_cl'],"type_cl"=>$t['Type_cl']);
	return $r;	
}
function client($id,$bdd)
{
	$s="select * from client where Id_cl='$id'"; 
	$e=mysqli_query($bdd,$s); 
	$t=mysqli_fetch_array($e);
	$r=array("code_cl"=>$t['Code_cl'],"nom_cl"=>$t['Nom_cli'],"adresse"=>$t['Adresse_cl'],"type_cl"=>$t['Type_cl'],"code_nat"=>$t['Code_nat']);
	return $r;
}
function mouv($num_mouv,$bdd)
{		
	//========= TARIF=====================
		$tarif="select * from tarif_red";
		 $etarif=mysqli_query($bdd,$tarif); 
		 $ttarif=mysqli_fetch_array($etarif);
	//========= TAUX======================
		$s_taux="select * from taux order by Id_taux desc"; 
		$e_taux=mysqli_query($bdd,$s_taux); $taux=mysqli_fetch_array($e_taux);
	//========= Arrive===================
		$sa="select *,date_format(Date_mouv,'%d/%m/%Y') as dt_mouv from mouvement2,pt_emplacement,immatriculation,type_avion,client 
			where 
				mouvement2.Pt=pt_emplacement.Id_pt 
			and 
				mouvement2.Immatr=immatriculation.Id_imm
			and
				immatriculation.Code_pr=client.Id_cl
			and
				immatriculation.Type_av=type_avion.Id_typ
			and
				Sens='A' 
			and 
				Num_mouv='$num_mouv'";
		$ea=mysqli_query($bdd,$sa);
		$ta=mysqli_fetch_array($ea);
		$escale_a="select * from escale,pt_emplacement where escale.Id_mouv='$num_mouv' and escale.Pt_ent=pt_emplacement.Id_pt and escale.Sens='A'"; 
		$e_escale_a=mysqli_query($bdd,$escale_a); $tescale_a=mysqli_fetch_array($e_escale_a);
		$escalesA=array();
		do
		{
			$escalesA[]=(mysqli_fetch_array($e_escale_a));
		}while($tescale_a=mysqli_fetch_array($e_escale_a));
	//=====================================
	//========== DEPART ===================
		$sd="select *,date_format(Date_mouv,'%d/%m/%Y') as dt_mouv from mouvement2,pt_emplacement,immatriculation,client 
			where 
				mouvement2.Pt=pt_emplacement.Id_pt 
			and 
				mouvement2.Immatr=immatriculation.Id_imm
			and
				immatriculation.Code_pr=client.Id_cl
			and
				Sens='D' 
			and 
				Num_mouv='$num_mouv'";
		$ed=mysqli_query($bdd,$sd);
		$td=mysqli_fetch_array($ed);
		$escale_d="select * from escale,pt_emplacement where escale.Id_mouv='$num_mouv' and escale.Pt_ent=pt_emplacement.Id_pt and Sens='D'"; 
		$e_escale_d=mysqli_query($bdd,$escale_d); $tescale_d=mysqli_fetch_array($e_escale_d); $nescale_d=mysqli_num_rows($e_escale_d);
		$escalesD=array();
		do
		{
			$escalesD[].=array(mysqli_fetch_array($e_escale_d));
		}while($tescale_d=mysqli_fetch_array($e_escale_d));
	//=====================================
	//========= TOTAL PASSAGER ============
		$tot_pax_a=$tescale_a['Ad']+$tescale_a['Ch']+$tescale_a['Inf'];
		$tot_pax_d=0;
		do
		{
			$tot_pax_d=$tot_pax_d+($tescale_d['Ad']+$tescale_d['Ch']+$tescale_d['Inf']);
		}while($tescale_d=mysqli_fetch_array($e_escale_d));
		$spass="select *, sum(Ad+Ch+Inf) as tot_pax_d from escale where Id_mouv='$num_mouv' and sens='D'";
		$epass=mysqli_query($bdd,$spass); $tpass=mysqli_fetch_array($epass);
		$tot_pax_d=$tpass['tot_pax_d'];
	//=====================================
	//========= BALISAGE===================
		if($ta['Temps']=="B")
		{
			$balisage_a="N";
		}else
		{
			$balisage_a="O";
		}
		
		if($td['Temps']=="B")
		{
			$balisage_d="N";
		}else
		{
			$balisage_d="O";
		}
	//====================================
	//============== STATIONNEMENT =================
		$stationement=$td['Stat'];
		//
	// =============== CALCUL REDEVANCES ========================

	// RED ROUTE A
		if($ta['Distance']<300){$distance_a=300;}else{$distance_a=$ta['Distance'];}
		if($td['Distance']<300){$distance_d=300;}else{$distance_d=$td['Distance'];}

		if($ta['Type_mouv']=="N")
		{
			if($ta['Nv_vol']<245)
			{
				$route_d=0;
				$route_a=(($ttarif['Redrou_esp_inf_245'])*($distance_a/100)*(sqrt($ta['Poids']/50)));
			}else
			{
				$route_a=0;
				$route_a=(($ttarif['Redrou_esp_sup_245'])*($distance_a/100)*(sqrt($ta['Poids']/50)));
				$route_d=(($ttarif['Redrou_esp_sup_245'])*($distance_d/100)*(sqrt($td['Poids']/50)));
			}
		}else
		{
			if($ta['Nv_vol']<245)
			{
				$route_a=(($ttarif['Redrou_esp_inf_245'])*($distance_a/100)*(sqrt($ta['Poids']/50)));
				$route_d=(($ttarif['Redrou_esp_inf_245'])*($distance_d/100)*(sqrt($ta['Poids']/50)));	
			}else
			{
				$route_a=(($ttarif['Redrou_esp_sup_245'])*($distance_a/100)*(sqrt($ta['Poids']/50)));
				$route_d=(($ttarif['Redrou_esp_sup_245'])*($distance_d/100)*(sqrt($ta['Poids']/50)));
			}
		}

		if($td['Type_mouv']=="N")
		{
			if($td['Type_gestion']=='G')
			{
				$route_d=0;
			}else
			{
				if($td['Nv_vol']<245)
				{
					
					$route_d=(($ttarif['Redrou_esp_inf_245'])*($distance_d/100)*(sqrt($ta['Poids']/50)));
				}else
				{
					$route_d=(($ttarif['Redrou_esp_sup_245'])*($distance_d/100)*(sqrt($ta['Poids']/50)));
				}
			}
		}else
		{
			if($td['Nv_vol']<245)
			{
				$route_d=(($ttarif['Redrou_esp_inf_245'])*($distance_d/100)*(sqrt($ta['Poids']/50)));	
			}else
			{
				$route_d=(($ttarif['Redrou_esp_sup_245'])*($distance_d/100)*(sqrt($ta['Poids']/50)));
			}
		}
		if($ta["Ex_rout"]=='O' || $td['Ex_rout']=='O'){$route_a=0; $route_d=0;}
		//$route_a=$ta['Nv_vol'];
		//$route_d=$td['Nv_vol'];
	// RED ROUTE D
	//===BALISAGE 
		if($balisage_a=="O")
		{
			if($ta['Ex_bal']=='N')
			{
				$red_bal_a=$ttarif['Redbal'];
			}else
			{
				$red_bal_a=0;
			}
		}else{
			$red_bal_a=0;
		}

		if($balisage_d=="O")
		{
			if($td['Ex_bal']=='N')
			{
				$red_bal_d=$ttarif['Redbal'];
			}else
			{
				$red_bal_d=0;
			}
		}else{
			$red_bal_d=0;
		}
		if($ta["Ex_bal"]=='O' || $td['Ex_bal']=='O'){$red_bal_a=0;$red_bal_d=0;}

	//=== RED ATTERISSAGE
		if($ta['Type_mouv']=='N')
		{
			if($ta['Poids']<4)
			{
				$red_att_a=5;
				$red_att_d=0;
			}else if($ta['Poids']>=4 && $ta['Poids']<26)
			{
				$red_att_a=$ta['Poids']*$ttarif['Redatt_1_25_nat'];
				$red_att_d=0;
			}else if($ta['Poids']>25 && $ta['Poids']<76)
			{
				$red_att_a=40+($ta['Poids']-25)*$ttarif['Redatt_26_75_nat'];
				$red_att_d=0;
			}else if($ta['Poids']>75)
			{
				$red_att_a=200+($ta['Poids']-75)*$ttarif['Redatt_sur_75_nat'];
				$red_att_d=0;
			}
		}else
		{
			if($ta['Poids']<4)
			{
				$red_att_a=12.5;
				$red_att_d=0;
			}else if($ta['Poids']>=4 && $ta['Poids']<26)
			{
				$red_att_a=$ta['Poids']*$ttarif['Redatt_1_25_inter'];
				$red_att_d=0;
			}else if($ta['Poids']>25 && $ta['Poids']<76)
			{
				$red_att_a=100+($ta['Poids']-25)*$ttarif['Redatt_26_75_inter'];
				$red_att_d=0;
			}else if($ta['Poids']>75)
			{
				$red_att_a=500+($ta['Poids']-75)*$ttarif['Redatt_sup_75_inter'];
				$red_att_d=0;
			}
		}
		if($ta["Ex_att"]=='O' || $td['Ex_att']=='O'){$red_att_a=0; $red_att_d=0;}
	//== RED FRET
		if($ta['Type_mouv']=='N')
		{
			
			$red_fret_a=0;	
		}else
		{
			$sfreta="select *,sum(Loc) as somme from escale where Id_mouv='$num_mouv' and Sens='A'";
			$efreta=mysqli_query($bdd,$sfreta);
			$tfreta=mysqli_fetch_array($efreta);
			$red_fret_a=$tfreta['somme']*$ttarif['Redfr_res_int'];
		}

		if($td['Type_mouv']=='N')
		{
			$sfretd="select *,sum(Loc) as somme from escale where Id_mouv='$num_mouv' and Sens='D'";
			$efretd=mysqli_query($bdd,$sfretd);
			$tfretd=mysqli_fetch_array($efretd);
			$red_fret_d=$tfretd['somme']*$ttarif['Redfr_res_nat'];
			//$red_fret_d=($ttarif['Redfr_res_nat']*($tescale_d['Loc']+$tescale_d['Trat']+$tescale_d['Ptt']));	
		}else
		{
			$sfretd="select *,sum(Loc) as somme from escale where Id_mouv='$num_mouv' and Sens='D'";
			$efretd=mysqli_query($bdd,$sfretd);
			$tfretd=mysqli_fetch_array($efretd);
			$red_fret_d=$tfretd['somme']*$ttarif['Redfr_res_int'];	
		}
		if($ta["Ex_fret"]=='O' || $td['Ex_fret']=='O'){$red_fret_a=0; $red_fret_d=0;}

	//==RED PASSGER 
		if($ta['Type_mouv']=='N')
		{
			$red_pass_a=0;
			$red_pass_d=$tot_pax_d*$ttarif['Redpass_res_nat'];
		}else
		{
			//$spassager="select * from escale 
			$red_pass_a=0;
			$red_pass_d=$ttarif['Redpass_res_int']*$tot_pax_d;
		}
		if($td['Type_mouv']=='N')
		{
			$red_pass_d=$tot_pax_d*$ttarif['Redpass_res_nat'];
		}else
		{
			//$spassager="select * from escale 
			$red_pass_d=$ttarif['Redpass_res_int']*$tot_pax_d;
		}
		if($ta["Ex_pax"]=='O' || $td['Ex_pax']=='O'){$red_pass_a=0; $red_pass_d=0;}
	//==PEC
			$s_pec_d="select * from escale where escale.Id_mouv='$num_mouv' and escale.Sens='D'"; $e_pec_d=mysqli_query($bdd,$s_pec_d);
			$t_pec_d=mysqli_fetch_array($e_pec_d);
			if($td['Type_mouv']=='N')
			{
				//$red_pec=($tescale_d['Pec']*(($ttarif['Redpass_res_nat']*10)/100));
				$red_pec=($t_pec_d['Pec']*(($ttarif['Redpass_res_nat']*10)/100));
			}else
			{
			//$red_pec=($tescale_d['Pec']*(($ttarif['Redpass_res_int']*10)/100));
				$red_pec=($t_pec_d['Pec']*(($ttarif['Redpass_res_int']*10)/100));
			}	
			if($ta["Ex_pax"]=='O' || $td['Ex_pax']=='O'){$red_pec=0;}
	//==RED COMPT ENREG
		$red_compt_a=$ta['Compt_enr']*$ttarif['Cptenreg'];
		$red_compt_d=$td['Compt_enr']*$ttarif['Cptenreg'];
	//== RED FORM
		$red_formu_a=$ta['Formu'];
		$red_formu_d=$td['Formu'];
	//==ANTI INC
		if($td['Anti_inc']=="N")
		{
			$red_assantinc_d=0;
			$red_assantinc=0;
		}else
		{
			$red_assantinc_d=$ttarif['Assantinc'];
			$red_assantinc=$ttarif['Assantinc'];
		}
		if($ta['Anti_inc']=="N")
		{
			$red_assantinc_a=0;
		}else
		{
			$red_assantinc_a=$ttarif['Assantinc'];
		}
		
	//== RED SURETE
		if($ta['Type_mouv']=='N')
		{
			$red_sur_a=0;
			$red_sur_d=($ttarif['Redsur_nat']*($tot_pax_d));
		}else
		{
			$red_sur_a=0;
			$red_sur_d=($ttarif['Redsur_inter']*($tot_pax_d));
		}
		if($td['Type_mouv']=='N')
		{
			$red_sur_d=($ttarif['Redsur_nat']*($tot_pax_d));
		}else
		{
			
			$red_sur_d=($ttarif['Redsur_inter']*($tot_pax_d));
		}
	//== RED SECURITE
		/*if($ta['Code_nat']=='Z')
		{
			$red_sec_a=0;
			if($tot_pax_d<20)
			{
				$red_sec_d=0;
				
			}else
			{
				$red_sec_d=($ttarif['Redsecurite']*($tot_pax_d));
			}
			
		}else
		{
			$red_sec_a=0;
			$red_sec_d=0;
		}
		if($td['Code_nat']=='Z')
		{
			
			if($tot_pax_d<20)
			{
				$red_sec_d=0;
				if($ta['Nbre_siege']<20)
				{
				
				}else
				{
					$red_sec_d=($ttarif['Redsecurite']*($tot_pax_d));
				}
			}else
			{
				$red_sec_d=($ttarif['Redsecurite']*($tot_pax_d));
			}
			
		}else
		{
			$red_sec_d=0;
		}*/

		if($ta['Type_mouv']=='N')
		{
			$red_sec_a=0;
			if($tot_pax_d<20)
			{
				$red_sec_d=0;
				
			}else
			{
				$red_sec_d=($ttarif['Redsecurite']*($tot_pax_d));
			}
			
		}else
		{
			$red_sec_a=0;
			$red_sec_d=0;
		}
		if($td['Type_mouv']=='N')
		{
			
			if($tot_pax_d<20)
			{
				$red_sec_d=0;
				if($ta['Nbre_siege']<20)
				{
				
				}else
				{
					$red_sec_d=($ttarif['Redsecurite']*($tot_pax_d));
				}
			}else
			{
				$red_sec_d=($ttarif['Redsecurite']*($tot_pax_d));
			}
			
		}else
		{
			$red_sec_d=0;
		}
	//== RED STATIONNMENT 
		$dt_arr=$ta['Date_mouv'];
		$heure_arr=$ta['Heure_mouv'];
		$dt_dep=$td['Date_mouv'];
		$heure_dep=$td['Heure_mouv'];
		$tps_arr=strtotime($dt_arr." ".$heure_arr);	
		$tps_dep=strtotime($dt_dep." ".$heure_dep);
		$heure=((($tps_dep-$tps_arr)/60)/60);
		$HEURE=$heure;
		$tabl_heure=explode('.',$heure);
		if(isset($tabl_heure[1]))
		{
			$heure=$tabl_heure[0]+1;
		}else
		{
			$heure=$heure;
		}
		if($td['Code_nat']=='Z')
		{
			$heure=$heure-2;
			
			if($heure>3)
			{
				$red_stat=$td['Poids']*$ttarif['Redstat_tarmac']*$heure;
			}
			else if($heure<1)
			{
				$red_stat=0;
				
			}else if($heure==1)
			{
				$red_stat=$td['Poids']*$ttarif['Redstat_tarmac'];
			}else
			{
				if($td['Stat']=='T')
				{
					$red_stat=$td['Poids']*$ttarif['Redstat_tarmac']*$heure;
				}else if($td['Stat']=='G')
				{
					$red_stat=$td['Poids']*$ttarif['Redstat_garage']*$heure;
				}else
				{
					$red_stat=0;
				}
			}
			if($td['Stat']=='N' || $td['Stat']=="0" || $td["Stat"]=="O")
			{
				$red_stat=0;
				//$red_stat=$td['Stat'];
			}
			
		}else
		{
			if($td['Stat']=='T')
			{
				$red_stat=$ta['Poids']*$ttarif['Redstat_tarmac']*$heure;
			}else if($td['Stat']=='G')
			{
				$red_stat=$ta['Poids']*$ttarif['Redstat_garage']*$heure;
			}else
			{
				$red_stat=0;
			}
		}
		if($ta["Ex_stt"]=='O' || $td['Ex_stt']=='O'){$red_stat=0;}
		if($ta["Ex_stg"]=='O' || $td['Ex_stg']=='O'){$red_stat=0;}
	//== VILLE ARRIVEE OU DE DESTINATION
	$sville_arr="select * from escale, pt_emplacement where Prov_dest=pt_emplacement.Id_pt and escale.Id_mouv='$num_mouv' and Sens='A'";
	$eville_arr=mysqli_query($bdd,$sville_arr);
	$tville_arr=mysqli_fetch_array($eville_arr);
	$ville_arr=$tville_arr['Code_pt'];

	$sville_dep="select * from escale, pt_emplacement where Prov_dest=pt_emplacement.Id_pt and escale.Id_mouv='$num_mouv' and Sens='D'";
	$eville_dep=mysqli_query($bdd,$sville_dep);
	$tville_dep=mysqli_fetch_array($eville_dep);
	@$ville_dep=$tville_dep['Code_pt'];

	//====== TOTAL REDEVANCE
		$tot_red_rout=($route_a)+($route_d); 
	    $tot_red_att=($red_att_a); 
	    $tot_red_bal=($red_bal_a+$red_bal_d); 
	    $tot_red_fret=($red_fret_a+$red_fret_d); 
	    $tot_red_pass=($red_pass_a+$red_pass_d);  
	    $tot_red_pec=($red_pec);  
	    $tot_red_stat=($red_stat);
	    $tot_red_compt=($red_compt_a+$red_compt_d); 
	    $tot_red_formu=($red_formu_a+$red_formu_d);
	    $tot_red_assantinc=($red_assantinc_d); 
	    $tot_red_sur=($red_sur_d); 
	    $tot_red_sec=($red_sec_d); 
		
		$tot_sans_tva=$tot_red_rout+$tot_red_att+$tot_red_bal+$tot_red_fret+$tot_red_pass+$tot_red_pec+$tot_red_stat+$tot_red_compt+$tot_red_formu+$tot_red_assantinc+$tot_red_sur+$tot_red_sec;
		//$tot_sans_tva=$tot_red_rout+$tot_red_att+$tot_red_pass+$tot_red_formu+$tot_red_sur+$tot_red_sec; 
		$tot_sans_tva_fc=$tot_sans_tva*$taux['Usd_fc'];

	//======= DONNEES RETOURNEES ===============
		if($ta['Code_nat']!=='Z')
		{
			$tva=0;
		}else
		{
			$tva=(($tot_sans_tva*16)/100);
		}
		$total_avec_tva=ceil($tot_sans_tva+$tva);
		$total_avec_tva_fc=$total_avec_tva*$taux["Usd_fc"];

		@$r=array("ttarif"=>$ttarif,
			"dt_saisie"=>Datemysqltofr($ta['Dt']),
			"taux"=>$taux,
			"ta"=>$ta,
			"td"=>$td,	
			"ville_arr"=>$ville_arr,
			"ville_dep"=>$ville_dep,
			"nom_cli"=>$ta['Nom_cli'],
			"code_imm"=>$ta['Code_imm'],
			"num_form"=>$ta['Num_form'],
			"type_av"=>$ta['Libelle_typ'],
			"poids"=>$ta['Poids'],			
			"heure_stat"=>$heure,			
			"escalesA"=>$escalesA,
			"escalesD"=>array($escalesD),
			"tescale_a"=>$tescale_a,
			"balisage_a"=>$balisage_a,
			"balisage_d"=>$balisage_d,
			"stat_a"=>$ta['Stat'],
			"stat_d"=>$td['Stat'],
			"tot_pax_a"=>$tot_pax_a,
			"tot_pax_d"=>$tpass['tot_pax_d'],
			"tescale_d"=>$tescale_d,
			"red_route_a"=>$route_a,
			"red_route_d"=>$route_d,
			"red_att"=>$red_att_a,
			"red_bal_a"=>$red_bal_a,
			"red_bal_d"=>$red_bal_d,
			"red_fret_a"=>$red_fret_a,
			"red_fret_d"=>$red_fret_d,
			"red_pass_a"=>$red_pass_a,
			"red_pass_d"=>$red_pass_d,
			"red_pec"=>$red_pec,
			"red_stat"=>$red_stat,
			"red_compt"=>$red_compt_d,
			"red_formu"=>$red_formu_d,
			"red_assantinc"=>$red_assantinc,
			"red_surete"=>$red_sur_d,
			"red_securite"=>$red_sec_d,
			
			"tot_red_rout"=>$tot_red_rout, 
			"tot_red_att"=>$tot_red_att,
			"tot_red_bal"=>$tot_red_bal,
			"tot_red_fret"=>$tot_red_fret, 
			"tot_red_pass"=>$tot_red_pass,  
			"tot_red_pec"=>$tot_red_pec,  
			"tot_red_stat"=>$tot_red_stat,
			"tot_red_compt"=>$tot_red_compt, 
			"tot_red_formu"=>$tot_red_formu,
			"tot_red_assantinc"=>$tot_red_assantinc,
			"tot_red_surete"=>$tot_red_sur,
			"tot_red_securite"=>$tot_red_sec,
			
			"tot_sans_tva"=>$tot_sans_tva,
			"tot_sans_tva_fc"=>$tot_sans_tva*1650,
			
			"tva"=>$tva,
			"tva_fc"=>(($tva)*$taux['Usd_fc']),
			
			"tot_avec_tva"=>(($total_avec_tva)),
			"tot_avec_tva_fc"=>(($total_avec_tva_fc))
			//"tot_avec_tva_fc"=>ceil($tot_sans_tva_fc)+((($tva)*$taux['Usd_fc']))
			);
	//===============================
	return $r;
}

function escales_a($num_mouv,$bdd)
{
	$s="select * from escale where Id_mouv='$num_mouv' and Sens='A'";
	$e=mysqli_query($bdd,$s); $r=array();
	do
	{
		$r[]=mysqli_fetch_array($e);
	}while($t=mysqli_fetch_array($e));
	return $r;
}

function escales_d($num_mouv,$bdd)
{
	$s12="select * from escale where Id_mouv='$num_mouv' and Sens='D'";
	$e12=mysqli_query($bdd,$s12); $r=array(); $t12=mysqli_fetch_array($e12);
	$a=0;
	do
	{
		$r[]=array("sens"=>$t12['Sens']);
		$a++;
	}while($t12=mysqli_fetch_array($e12));
	return $r;
}
function bordereau($dt,$bdd)
{
	//============== VARIABLES ACCES=======================
		$acces="";
		$acc_mt_usd=0;
		$acc_mt_tva_usd=0;
		$acc_mt_tt_usd=0;
		$acc_mt_cdf=0;
		$acc_mt_tva_cdf=0;
		$acc_mt_tt_cdf=0;
		$acc_quittance=0;
		$acc_observation="PERCUS";
		
	//============== VARIABLES RDA=======================
		$rda="";
		$rda_mt_usd=0;
		$rda_mt_tva_usd=0;
		$rda_mt_tt_usd=0;
		$rda_mt_cdf=0;
		$rda_mt_tva_cdf=0;
		$rda_mt_tt_cdf=0;
		$rda_quittance=0;
		$rda_observation="TOTALITE";
	//============== VARIABLES SOUS TOTAL=======================
		
		$st_acc_usd=0;
		$st_acc_tva_usd=0;
		$st_acc_tt_usd=0;
		$st_acc_cdf=0;
		$st_acc_tva_cdf=0;
		$st_acc_tt_cdf=0;
		
		$st_rda_usd=0;
		$st_rda_tva_usd=0;
		$st_rda_tt_usd=0;
		$st_rda_cdf=0;
		$st_rda_tva_cdf=0;
		$st_rda_tt_cdf=0;

		$t_usd=0;
		$t_rda_tva_usd=0;
		$t_rda_tt_usd=0;
		$t_rda_cdf=0;
		$t_rda_tva_cdf=0;
		$t_rda_tt_cdf=0;
		
	//============== ACCES PONCTUEL ===================
		$s_acc="select * from acces,type_acces where acces.Type_acc=type_acces.Id_acc and acces.Date_perc='$dt'";
		$e_acc=mysqli_query($bdd,$s_acc); $t_acc=mysqli_fetch_array($e_acc); 
		$n_acc=mysqli_num_rows($e_acc);
		$r_acc=array();
		if($n_acc==0)
		{
			$r_acc[]=array("n"=>0);
		}else
		{
			do
			{
				if($t_acc['Monn_acc']=='USD')
				{
					$tva=tva($t_acc['Mt_acc']);
					$acc_mt_usd=$t_acc['Mt_acc']-$tva;

					$acc_mt_tva_usd=$tva;
					$acc_mt_tt_usd=$t_acc['Mt_acc'];

					$acc_mt_cdf=0;
					$acc_mt_tva_cdf=0;
					$acc_mt_tt_cdf=0;	

					//========================= CALCUL SOUS TOTAL 
					$st_acc_usd=$st_acc_usd+$acc_mt_usd;
					$st_acc_tva_usd=$st_acc_tva_usd+$acc_mt_tva_usd;
					$st_acc_tt_usd=$acc_mt_tt_usd+$acc_mt_tt_usd;
					
				}else
				{
					$tva=tva($t_acc['Mt_acc']);
					$acc_mt_cdf=$t_acc['Mt_acc']-$tva;
					$acc_mt_tva_cdf=(($acc_mt_cdf*16)/100);
					$acc_mt_tt_cdf=$t_acc['Mt_acc'];	

					$acc_mt_usd=0;
					$acc_mt_tva_usd=0;
					$acc_mt_tt_usd=0;
					//========================= CALCUL SOUS TOTAL 
					$st_acc_cdf=$st_acc_cdf+$acc_mt_cdf;
					$st_acc_tva_cdf=$st_acc_tva_cdf+$acc_mt_tva_cdf;
					$st_acc_tt_cdf=$st_acc_cdf+$st_acc_tva_cdf;	
				}
				$r_acc[]=array("n"=>$n_acc,
						"id"=>$t_acc['Id_acc'],
						"num_acc"=>$t_acc['Num_long'],
						"acc_mt_cdf"=>arrondie($acc_mt_cdf),
						"acc_mt_tva_cdf"=>arrondie($acc_mt_tva_cdf),
						"acc_mt_tt_cdf"=>arrondie($acc_mt_tt_cdf),

						"acc_mt_usd"=>arrondie($acc_mt_usd),
						"acc_mt_tva_usd"=>arrondie($acc_mt_tva_usd),
						"acc_mt_tt_usd"=>arrondie($acc_mt_tt_usd),
						"acc_quittance"=>$t_acc['Quittance']
				);
			}while($t_acc=mysqli_fetch_array($e_acc));

		}
	//================== RDA========================
		$s_rda="select * from rda,client where rda.Client_rda=client.Id_cl and rda.Date_rda='$dt'";
		$e_rda=mysqli_query($bdd,$s_rda); 
		$t_rda=mysqli_fetch_array($e_rda); 
		$n_rda=mysqli_num_rows($e_rda);
		$r_rda=array();
		if($n_rda==0)
		{
			$r_rda[]=array("n"=>0);
		}else
		{
			$nom=$t_rda['Nom_cli'];
			$st_cl_usd=0;
			$st_cl_cdf=0;
			$st_cl_usd_tva=0;
			$st_cl_cdf_tva=0;
			$st_cl_usd_tt=0;
			$st_cl_cdf_tt=0;
			do
			{
				
				if($t_rda['Monn_rda']=='USD')
				{
					$tva=tva($t_rda['Mt_rda']);

					$rda_mt_usd=floatval($t_rda['Mt_rda']-$tva);
					$rda_mt_tva_usd=$tva;
					$rda_mt_tt_usd=$rda_mt_usd+$tva;

					$rda_mt_cdf=0;
					$rda_mt_tva_cdf=0;
					$rda_mt_tt_cdf=0;	

					//========================= CALCUL SOUS TOTAL 
					$st_rda_usd=$st_rda_usd+$rda_mt_usd;
					$st_rda_tva_usd=$st_rda_tva_usd+$rda_mt_tva_usd;
					$st_rda_tt_usd=$st_rda_tt_usd+$st_rda_usd;
					
				}else
				{
					$tva=tva($t_rda['Mt_rda']);

					$rda_mt_cdf=floatval($t_rda['Mt_rda'])-$tva;
					$rda_mt_tva_cdf=(($rda_mt_cdf*16)/100);
					$rda_mt_tt_cdf=$rda_mt_cdf+$tva;	

					$rda_mt_usd=0;
					$rda_mt_tva_usd=0;
					$rda_mt_tt_usd=0;
					//========================= CALCUL SOUS TOTAL 
					$st_rda_cdf=$st_rda_cdf+$rda_mt_cdf;
					$st_rda_tva_cdf=$st_rda_tva_cdf+$rda_mt_tva_cdf;
					$st_rda_tt_cdf=$rda_mt_tt_cdf+$rda_mt_tt_cdf;	
				}
					//====================  SOUS TOTAL POUR UN CLIENT =============
						if($nom==$t_rda['Nom_cli'])
						{
							$st_cl_usd=arrondie($st_cl_usd+$rda_mt_usd);
							$st_cl_cdf=arrondie($st_cl_cdf+$rda_mt_cdf);
							$st_cl_usd_tva=arrondie($st_cl_usd+$rda_mt_tva_usd);
							$st_cl_cdf_tva=arrondie($st_cl_cdf+$rda_mt_tva_cdf);
							$st_cl_usd_tt=arrondie($st_cl_usd+$rda_mt_tt_usd);
							$st_cl_cdf_tt=arrondie($st_cl_cdf+$rda_mt_tt_cdf);
						}else
						{
							$nom=$t_rda['Nom_cli'];
							$st_cl_usd=0;
							$st_cl_cdf=0;
							$st_cl_usd_tva=0;
							$st_cl_cdf_tva=0;
							$st_cl_usd_tt=0;
							$st_cl_usd_tt=0;
							$st_cl_usd=arrondie($st_cl_usd+$rda_mt_usd);
							$st_cl_cdf=arrondie($st_cl_cdf+$rda_mt_cdf);
							$st_cl_usd_tva=arrondie($st_cl_usd+$rda_mt_tva_usd);
							$st_cl_cdf_tva=arrondie($st_cl_cdf+$rda_mt_tva_cdf);
							$st_cl_usd_tt=arrondie($st_cl_usd+$rda_mt_tt_usd);
							$st_cl_cdf_tt=arrondie($st_cl_cdf+$rda_mt_tt_cdf);
						}
					//===========================================================
				$r_rda[]=array("n"=>$n_rda,
						"id"=>$t_rda['Id_rda'],
						"nom"=>$t_rda['Nom_cli'],
						"num_rda"=>$t_rda['Num_long'],
						"rda_mt_cdf"=>arrondie($rda_mt_cdf),
						"rda_mt_tva_cdf"=>arrondie($rda_mt_tva_cdf),
						"rda_mt_tt_cdf"=>arrondie($rda_mt_tt_cdf),

						"rda_mt_usd"=>arrondie($rda_mt_usd),
						"rda_mt_tva_usd"=>arrondie($rda_mt_tva_usd),
						"rda_mt_tt_usd"=>arrondie($rda_mt_tt_usd),
						"rda_quittance"=>$t_rda['Quittance'],
						"st_cl_usd"=>$st_cl_usd,
						"st_cl_cdf"=>$st_cl_cdf,
						"st_cl_usd_tva"=>$st_cl_usd_tva,
						"st_cl_cdf_tva"=>$st_cl_cdf_tva,
						"st_cl_usd_tt"=>$st_cl_usd_tt,
						"st_cl_cdf_tt"=>$st_cl_cdf_tt,
						"st"=>st_cl_rda($t_rda['Client_rda'],$t_rda['Date_rda'],$bdd)
				);

			}while($t_rda=mysqli_fetch_array($e_rda));

		}
	// ================= IDF FRET ==================
		$s_idf="select * from idf where Date_enr='$dt' and Valide='V'";
		$e_idf=mysqli_query($bdd,$s_idf);
		$n_idf=mysqli_num_rows($e_idf);
		$t_idf=mysqli_fetch_array($e_idf);
		$r_idf=array();
		$st_idf=0;
		if($n_idf==0)
		{
			$r_idf[]=array("n"=>0);
		}else
		{
			do
			{
				$st_idf=$st_idf+$t_idf['Mt'];
				//$r_idf[]=array()
			}while($t_idf=mysqli_fetch_array($e_idf));
			$r_idf[]=array("n"=>1,"mt"=>arrondie($st_idf));
		}
	//================== TOTAL ===================== 
		$t_usd=$st_acc_usd+$st_rda_usd+$st_idf;
		$t_tva_usd=$st_acc_tva_usd+$st_rda_tva_usd;
		$t_tt_usd=$st_acc_tt_usd+$st_rda_tt_usd+$st_idf;
		$t_cdf=$st_acc_cdf+$st_rda_cdf;
		$t_tva_cdf=$st_acc_tva_cdf+$st_rda_tva_cdf;
		$t_tt_cdf=$st_acc_tt_cdf+$st_rda_tt_cdf;
	//================= TABLEAU RETOUR 
		$resultat=array("acc"=>$r_acc,
				"st_acc_usd"=>arrondie($st_acc_usd),
				"st_acc_tva_usd"=>arrondie($st_acc_tva_usd),
				"st_acc_tt_usd"=>arrondie($st_acc_tt_usd),
				"st_acc_cdf"=>arrondie($st_acc_cdf),
				"st_acc_tva_cdf"=>arrondie($st_acc_tva_cdf),
				"st_acc_tt_cdf"=>arrondie($st_acc_tt_cdf),

				"rda"=>$r_rda,
				"st_rda_usd"=>arrondie($st_rda_usd),
				"st_rda_tva_usd"=>arrondie($st_rda_tva_usd),
				"st_rda_tt_usd"=>arrondie($st_rda_tt_usd),
				"st_rda_cdf"=>arrondie($st_rda_cdf),
				"st_rda_tva_cdf"=>arrondie($st_rda_tva_cdf),
				"st_rda_tt_cdf"=>arrondie($st_rda_tt_cdf),

				"t_usd"=>arrondie($t_usd),
				"t_tva_usd"=>arrondie($t_tva_usd),
				"t_tt_usd"=>arrondie($t_tt_usd),
				"t_cdf"=>arrondie($t_cdf),
				"t_tva_cdf"=>arrondie($t_tva_cdf),
				"t_tt_cdf"=>arrondie($t_tt_cdf),

				"idf"=>$r_idf				
		);
		return (($resultat));
		//echo (json_encode(array("n"=>2)));	
}
function st_cl_rda($cl,$dt,$bdd)
{
	$s="select * from rda where Client_rda='$cl' and Date_rda='$dt'"; 
	$e=mysqli_query($bdd,$s); $t=mysqli_fetch_array($e);
	$st=array();
	$mt_usd=0;
	$mt_cdf=0;
	do
	{
		if($t['Monn_rda']=='USD')
		{
			$mt_usd=$mt_usd+$t['Mt_rda'];
		}else
		{
			$mt_cdf=$mt_cdf+$t['Mt_rda'];
		}
	}while($t=mysqli_fetch_array($e));

	$st[]=array(
		"mt_usd"=>arrondie($mt_usd),
		"mt_cdf"=>arrondie($mt_cdf),
		"mt_usd_tva"=>arrondie(($mt_usd*16)/100),
		"mt_cdf_tva"=>arrondie(($mt_cdf*16)/100),
		"mt_usd_tt"=>(($mt_usd*16)/100)+$mt_usd,
		"mt_cdf_tt"=>(($mt_cdf*16)/100)+$mt_cdf
	);
	return ($st);
}
function num_fact($mouv,$bdd)
{
	$s="select * from facture_imprime where Mouv='$mouv'";
	$e=mysqli_query($bdd,$s);
	$t=mysqli_fetch_array($e);
	$n=mysqli_num_rows($e);
	if($n==0)
	{
		$r=0;
	}else
	{
		$r=$t["Num_facture"];
	}
	return $r;
}
function num_quittance($mouv,$bdd)
{
	$s="select * from paiement_facture where Mouv='$mouv'";
	$e=mysqli_query($bdd,$s);
	$t=mysqli_fetch_array($e);
	$n=mysqli_num_rows($e);
	if($n==0)
	{
		$r=0;
	}else
	{
		$r=$t["Quittance"];
	}
	return $r;
}
function handling_facture($id,$bdd)
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
	$e=mysqli_query($bdd,$s);
	$t=mysqli_fetch_array($e);
	$n=mysqli_num_rows($e);
	if($t['Poids']<150)
	{
		if($t['AA']=="O")
		{
			$AA_prix=31;
		}else
		{
			$AA_prix=0;
		}

		if($t['TA']=="O")
		{
			$TA_prix=21;
		}else
		{
			$TA_prix=0;
		}

		if($t['FA']=="O")
		{
			$FA_prix=42;
		}else
		{
			$FA_prix=0;
		}
	}else
	{
		if($t['AA']=="O")
		{
			$AA_prix=37;
		}else
		{
			$AA_prix=0;
		}

		if($t['TA']=="O")
		{
			$TA_prix=54;
		}else
		{
			$TA_prix=0;
		}

		if($t['FA']=="O")
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
	//================================
	$user=user($t['Id_us'],$bdd);
	$r=array("id_fact"=>$id,
			"dt_fact"=>Datemysqltofr($t['Date_fact']),
			"imm"=>$t["Code_imm"],
			"poids"=>$t['Poids'],
			"type_av"=>$t["Libelle_typ"],
			"heure"=>$t["Heure_fact"],
			"handleur"=>$t['Nom_hand'],
			"handleur_code"=>$t['Code_hand'],
			"handleur_nationalite"=>$t['Nationalite'],
			"client"=>$t['Nom_cli'],
			"adresse_handleur"=>$t['Adresse_hand'],
			"ville_handleur"=>$t['Ville_hand'],
			"dt_fact"=>Datemysqltofr($t["Date_fact"]),
			"heure_arr"=>$t["Heure_arr"],
			"dt_arr"=>Datemysqltofr($t["Date_arr"]),
			"heure_dep"=>$t["Heure_dep"],
			"dt_dep"=>Datemysqltofr($t["Date_dep"]),
			"handleur"=>$t['Nom_hand'],
			"aa"=>$t["AA"],
			"ta"=>$t["TA"],
			"fa"=>$t["FA"],
			"aa_prix"=>$AA_prix,
			"ta_prix"=>$TA_prix,
			"fa_prix"=>$FA_prix,
			"mht"=>$prix_fact,
			"tva"=>tva($prix_fact),
			"mttc"=>ceil($prix_fact+tva($prix_fact)),
			"touche"=>$touche,
			"user"=>$user
		);
	return $r;
}
function handling_detail_ass($txt)
{
	if($txt=="AA")
	{
		$t="Auto assistance";
	}else if($txt=="FA")
	{
		$t="Full assistance";
	}else
	{
		$t="Assistance administrative";
	}
	return $t;
}
function paie_handling_detail($fact,$bdd)
{
	$s="select * from handling_num_fact where Id_fact='$fact'";
	$e=mysqli_query($bdd,$s);
	$t=mysqli_fetch_array($e);

	$s2="select * from handling_paiement where Fact_paie='$fact'";
	$e2=mysqli_query($bdd,$s2);
	$t2=mysqli_fetch_array($e2);

	$s3="select * from handling_num_fact where Id_fact='$fact'";
	$e3=mysqli_query($bdd,$s3);
	$t3=mysqli_fetch_array($e3);

	$user=user($t2['Id_us'],$bdd);
	$detail_fact=handling_facture($fact,$bdd);
	@$r=array(
		"dt_fact"=>Datemysqltofr($t['Date_fact']),
		"dt_paie"=>Datemysqltofr($t2['Date_paie']),
		"num_fact"=>$t3['Num_fact_long'],
		"percepteur"=>$user['nom'],
		"mht"=>$t2['Mht'],
		"tva"=>$t2['Tva'],
		"mttc"=>$t2['Mttc'],
		"quittance"=>format_nbre($t2['Id_paie']),
		"detail"=>$detail_fact
		);

	return $r;
}
function handling_num_fact($mouv,$bdd)
{
	$s="select * from handling_num_fact where Id_fact='$mouv'";
	$e=mysqli_query($bdd,$s);
	$t=mysqli_fetch_array($e);
	return $t["Num_fact_long"];
}

function dernier_enreg($table,$id,$bdd)
{
	$s="select * from $table order by $id desc";
	$e=mysqli_query($bdd,$s);
	$n=mysqli_num_rows($e);
	$t=mysqli_fetch_array($e);
	if($n==0)
	{
		$r=0;
	}else
	{
		$r=$t[$id];
	}
	return $r;
}
?>