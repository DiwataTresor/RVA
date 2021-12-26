<?php
class main
{
	public $cnx;
	public $dt;
	public $heure;
	public $id_us;
	public $couleur;
	public $etat;

	
	
	function journal_insert($us,$type_op,$detail_op)
	{
		$dt2=date("Y-m-d");
		$heure2=date('H:i:s');
		$s="insert into rva_facturation2.journal 
			(Date_jrn,Heure_jrn,Id_us,Type_op,Detail_op)
			values(
			'$dt2',
			'$heure2',
			'$us',
			'$type_op',
			'$detail_op'
		)";

		$this->cnx->exec($s);
	}
	function sexe($t)
	{
		if($t=='F')
		{
			return "Femme";
		}else
		{
			return "Homme";
		}
	}
	function existe_il($table,$col,$v)
	{
		$s="select * from $table where $col='$v'";
		$e=$this->cnx->query($s);
		$t=$e->fetchAll();
		$n=count($t);
		if($n==0)
		{
			$r=false;
		}else
		{
			$r=true;
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
		return (utf8_decode(addslashes($text)));
		//return htmlspecialchars(utf8_decode(htmlspecialchars(mysql_escape_string(addslashes(ucfirst($text))))));

		//return htmlspecialchars(utf8_decode(htmlspecialchars(addslashes(ucfirst($text)))));
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
		return (ucfirst(ltrim(utf8_encode(stripslashes($text)))));
	}
	function nombre_simple($n)
	{
		return (number_format($n,0,'',''));
		//return 
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
		return (substr($h, 0,8));
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
	function mouv($num_mouv)
	{		
		//========= TARIF=====================
			$tarif="select * from rva_facturation2.tarif_red";
			 $etarif=$this->cnx->query($tarif); 
			 $ttarif=$etarif->fetchAll();
		//========= TAUX======================
			$s_taux="select * from rva_facturation2.taux order by Id_taux desc"; 
			$e_taux=$this->cnx->query($s_taux); 
			$taux=$e_taux->fetchAll();
		//========= Arrive===================
			$sa="select *, format(Date_mouv,'%d/%m/%Y') as dt_mouv 
				from 
					rva_facturation2.mouvement2,rva_facturation2.pt_emplacement,rva_facturation2.immatriculation,rva_facturation2.type_avion,rva_facturation2.client 
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
			$ea=$this->cnx->query($sa);
			$ta=$ea->fetchAll();
			$escale_a="select * from rva_facturation2.escale,rva_facturation2.pt_emplacement 
			where 
				escale.Id_mouv='$num_mouv' 
			and 
				escale.Pt_ent=pt_emplacement.Id_pt 
			and 
				escale.Sens='A'"; 
			$e_escale_a=$this->cnx->query($escale_a); 
			$tescale_a=$e_escale_a->fetchAll();
			$escalesA=array();
			foreach($tescale_a as $row)
			{
				$escalesA[]=($row);
			}
		//=====================================
		//========== DEPART ===================
			$sd="select *,format(Date_mouv,'%d/%m/%Y') as dt_mouv 
				from 
					rva_facturation2.mouvement2,rva_facturation2.pt_emplacement,rva_facturation2.immatriculation,rva_facturation2.client 
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
			$ed=$this->cnx->query($sd);
			$td=$ed->fetchAll();
			$escale_d="select * from rva_facturation2.escale,rva_facturation2.pt_emplacement 
				where 
					escale.Id_mouv='$num_mouv' and escale.Pt_ent=pt_emplacement.Id_pt and Sens='D'"; 
			$e_escale_d=$this->cnx->query($escale_d); 
			$tescale_d=($e_escale_d->fetchAll()); 
			$nescale_d=count($tescale_d);
			$escalesD=array();
			foreach($tescale_d as $row)
			{
				$escalesD[]=array($row);
			}
		//=====================================
		//========= TOTAL PASSAGER ============
			$tot_pax_a=$tescale_a[0]['Ad']+$tescale_a[0]['Ch']+$tescale_a[0]['Inf'];

			$tot_pax_d=0;
			foreach($tescale_d as $row)
			{
				//$tot_pax_d=$tot_pax_d+($row['Ad']+$row['Ch']+$row['Inf']);
			}
			

			$spass="select * 
				from 
					rva_facturation2.escale 
				where 
					Id_mouv='$num_mouv' and sens='D'";
			$epass=$this->cnx->query($spass); 
			$tpass=($epass->fetchAll());
			foreach($tpass as $row)
			{
				$tot_pax_d+=($row['Ad']+$row['Ch']+$row['Inf']);
			}
			
		//=====================================
		//========= BALISAGE===================
			if($ta[0]['Temps']=="B")
			{
				$balisage_a="N";
			}else
			{
				$balisage_a="O";
			}
			
			if($td[0]['Temps']=="B")
			{
				$balisage_d="N";
			}else
			{
				$balisage_d="O";
			}
		//====================================
		//============== STATIONNEMENT =================
			$stationement=$td[0]['Stat'];
			//
		// =============== CALCUL REDEVANCES ========================

		// RED ROUTE A
			if($ta[0]['Distance']<300){$distance_a=300;}else{$distance_a=$ta[0]['Distance'];}
			if($td[0]['Distance']<300){$distance_d=300;}else{$distance_d=$td[0]['Distance'];}

			if($ta[0]['Type_mouv']=="N")
			{
				if($ta[0]['Nv_vol']<245)
				{
					$route_d=0;
					$route_a=(($ttarif[0]['Redrou_esp_inf_245'])*($distance_a/100)*(sqrt($ta[0]['Poids']/50)));
				}else
				{
					$route_a=0;
					$route_a=(($ttarif[0]['Redrou_esp_sup_245'])*($distance_a/100)*(sqrt($ta[0]['Poids']/50)));
					$route_d=(($ttarif[0]['Redrou_esp_sup_245'])*($distance_d/100)*(sqrt($td[0]['Poids']/50)));
				}
			}else
			{
				if($ta[0]['Nv_vol']<245)
				{
					$route_a=(($ttarif[0]['Redrou_esp_inf_245'])*($distance_a/100)*(sqrt($ta[0]['Poids']/50)));
					$route_d=(($ttarif[0]['Redrou_esp_inf_245'])*($distance_d/100)*(sqrt($ta[0]['Poids']/50)));	
				}else
				{
					$route_a=(($ttarif[0]['Redrou_esp_sup_245'])*($distance_a/100)*(sqrt($ta[0]['Poids']/50)));
					$route_d=(($ttarif[0]['Redrou_esp_sup_245'])*($distance_d/100)*(sqrt($ta[0]['Poids']/50)));
				}
			}

			if($td[0]['Type_mouv']=="N")
			{
				if($td[0]['Type_gestion']=='G')
				{
					$route_d=0;
				}else
				{
					if($td[0]['Nv_vol']<245)
					{
						
						$route_d=(($ttarif[0]['Redrou_esp_inf_245'])*($distance_d/100)*(sqrt($ta[0]['Poids']/50)));
					}else
					{
						$route_d=(($ttarif[0]['Redrou_esp_sup_245'])*($distance_d/100)*(sqrt($ta[0]['Poids']/50)));
					}
				}
			}else
			{
				if($td[0]['Nv_vol']<245)
				{
					$route_d=(($ttarif[0]['Redrou_esp_inf_245'])*($distance_d/100)*(sqrt($ta[0]['Poids']/50)));	
				}else
				{
					$route_d=(($ttarif[0]['Redrou_esp_sup_245'])*($distance_d/100)*(sqrt($ta[0]['Poids']/50)));
				}
			}
			if($ta[0]["Ex_rout"]=='O' || $td[0]['Ex_rout']=='O'){$route_a=0; $route_d=0;}
			//$route_a=$ta['Nv_vol'];
			//$route_d=$td['Nv_vol'];
		// RED ROUTE D
		//===BALISAGE 
			if($balisage_a=="O")
			{
				if($ta[0]['Ex_bal']=='N')
				{
					$red_bal_a=$ttarif[0]['Redbal'];
				}else
				{
					$red_bal_a=0;
				}
			}else{
				$red_bal_a=0;
			}

			if(trim($balisage_d)=="O")
			{
				if($td[0]['Ex_bal']=='N')
				{
					$red_bal_d=$ttarif[0]['Redbal'];
				}else
				{
					$red_bal_d=0;
				}
			}else{
				$red_bal_d=0;
			}
			if($ta[0]["Ex_bal"]=='O' || $td[0]['Ex_bal']=='O'){$red_bal_a=0;$red_bal_d=0;}

		//=== RED ATTERISSAGE
			if($ta[0]['Type_mouv']=='N')
			{
				if($ta[0]['Poids']<4)
				{
					$red_att_a=5;
					$red_att_d=0;
				}else if($ta[0]['Poids']>=4 && $ta[0]['Poids']<26)
				{
					$red_att_a=$ta[0]['Poids']*$ttarif[0]['Redatt_1_25_nat'];
					$red_att_d=0;
				}else if($ta[0]['Poids']>25 && $ta[0]['Poids']<76)
				{
					$red_att_a=40+($ta[0]['Poids']-25)*$ttarif[0]['Redatt_26_75_nat'];
					$red_att_d=0;
				}else if($ta[0]['Poids']>75)
				{
					$red_att_a=200+($ta[0]['Poids']-75)*$ttarif[0]['Redatt_sur_75_nat'];
					$red_att_d=0;
				}
			}else
			{
				if($ta[0]['Poids']<4)
				{
					$red_att_a=12.5;
					$red_att_d=0;
				}else if($ta[0]['Poids']>=4 && $ta[0]['Poids']<26)
				{
					$red_att_a=$ta[0]['Poids']*$ttarif[0]['Redatt_1_25_inter'];
					$red_att_d=0;
				}else if($ta[0]['Poids']>25 && $ta[0]['Poids']<76)
				{
					$red_att_a=100+($ta[0]['Poids']-25)*$ttarif[0]['Redatt_26_75_inter'];
					$red_att_d=0;
				}else if($ta[0]['Poids']>75)
				{
					$red_att_a=500+($ta[0]['Poids']-75)*$ttarif[0]['Redatt_sup_75_inter'];
					$red_att_d=0;
				}
			}
			if($ta[0]["Ex_att"]=='O' || $td[0]['Ex_att']=='O'){$red_att_a=0; $red_att_d=0;}
		//== RED FRET
			if($ta[0]['Type_mouv']=='N')
			{
				
				$red_fret_a=0;	
			}else
			{
				$sfreta="select * from rva_facturation2.escale where Id_mouv='$num_mouv' and Sens='A'";
				$efreta=$this->cnx->query($sfreta);
				$tfreta=$efreta->fetchAll();
				$somme=0;
				foreach ($tfreta as $row) {
					$somme+=$row["Loc"];
				}
				$red_fret_a=$somme*$ttarif[0]['Redfr_res_int'];
			}

			if($td[0]['Type_mouv']=='N')
			{
				$sfretd="select * from rva_facturation2.escale where Id_mouv='$num_mouv' and Sens='D'";
				$efretd=$this->cnx->query($sfretd);
				$tfretd=$efretd->fetchAll();
				$somme=0;
				foreach($tfretd as $row)
				{
					$somme+=$row['Loc'];
				}
				$red_fret_d=$somme*$ttarif[0]['Redfr_res_nat'];
				//$red_fret_d=($ttarif['Redfr_res_nat']*($tescale_d['Loc']+$tescale_d['Trat']+$tescale_d['Ptt']));	
			}else
			{
				$sfretd="select *  from rva_facturation2.escale where Id_mouv='$num_mouv' and Sens='D'";
				$efretd=$this->cnx->query($sfretd);
				$tfretd=$efretd->fetchAll();
				$somme=0;
				foreach ($tfretd as $row) {
					$somme+=$row["Loc"];
				}
				$red_fret_d=$somme*$ttarif[0]['Redfr_res_int'];	
			}
			if($ta[0]["Ex_fret"]=='O' || $td[0]['Ex_fret']=='O'){$red_fret_a=0; $red_fret_d=0;}

		//==RED PASSGER 
			if($ta[0]['Type_mouv']=='N')
			{
				$red_pass_a=0;
				$red_pass_d=$tot_pax_d*$ttarif[0]['Redpass_res_nat'];
			}else
			{
				//$spassager="select * from escale 
				$red_pass_a=0;
				$red_pass_d=$ttarif[0]['Redpass_res_int']*$tot_pax_d;
			}
			if($td[0]['Type_mouv']=='N')
			{
				$red_pass_d=$tot_pax_d*$ttarif[0]['Redpass_res_nat'];
			}else
			{
				//$spassager="select * from escale 
				$red_pass_d=$ttarif[0]['Redpass_res_int']*$tot_pax_d;
			}
			if($ta[0]["Ex_pax"]=='O' || $td[0]['Ex_pax']=='O'){$red_pass_a=0; $red_pass_d=0;}
		//==PEC
				$s_pec_d="select * from rva_facturation2.escale where escale.Id_mouv='$num_mouv' and escale.Sens='D'"; 
				$e_pec_d=$this->cnx->query($s_pec_d);
				$t_pec_d=$e_pec_d->fetchAll();
				if($td[0]['Type_mouv']=='N')
				{
					//$red_pec=($tescale_d['Pec']*(($ttarif['Redpass_res_nat']*10)/100));
					$red_pec=($t_pec_d[0]['Pec']*(($ttarif[0]['Redpass_res_nat']*10)/100));
				}else
				{
				//$red_pec=($tescale_d['Pec']*(($ttarif['Redpass_res_int']*10)/100));
					$red_pec=($t_pec_d[0]['Pec']*(($ttarif[0]['Redpass_res_int']*10)/100));
				}	
				if($ta[0]["Ex_pax"]=='O' || $td[0]['Ex_pax']=='O'){$red_pec=0;}
		//==RED COMPT ENREG
			$red_compt_a=$ta[0]['Compt_enr']*$ttarif[0]['Cptenreg'];
			$red_compt_d=$td[0]['Compt_enr']*$ttarif[0]['Cptenreg'];
		//== RED FORM
			$red_formu_a=$ta[0]['Formu'];
			$red_formu_d=$td[0]['Formu'];
		//==ANTI INC
			if($td[0]['Anti_inc']=="N")
			{
				$red_assantinc_d=0;
				$red_assantinc=0;
			}else
			{
				$red_assantinc_d=$ttarif[0]['Assantinc'];
				$red_assantinc=$ttarif[0]['Assantinc'];
			}
			if($ta[0]['Anti_inc']=="N")
			{
				$red_assantinc_a=0;
			}else
			{
				$red_assantinc_a=$ttarif[0]['Assantinc'];
			}
			
		//== RED SURETE
			if($ta[0]['Type_mouv']=='N')
			{
				$red_sur_a=0;
				$red_sur_d=($ttarif[0]['Redsur_nat']*($tot_pax_d));
			}else
			{
				$red_sur_a=0;
				$red_sur_d=($ttarif[0]['Redsur_inter']*($tot_pax_d));
			}
			if($td[0]['Type_mouv']=='N')
			{
				$red_sur_d=($ttarif[0]['Redsur_nat']*($tot_pax_d));
			}else
			{
				
				$red_sur_d=($ttarif[0]['Redsur_inter']*($tot_pax_d));
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

			if($ta[0]['Type_mouv']=='N')
			{
				$red_sec_a=0;
				if($tot_pax_d<20)
				{
					$red_sec_d=0;
					
				}else
				{
					$red_sec_d=($ttarif[0]['Redsecurite']*($tot_pax_d));
				}
				
			}else
			{
				$red_sec_a=0;
				$red_sec_d=0;
			}
			if($td[0]['Type_mouv']=='N')
			{
				
				if($tot_pax_d<20)
				{
					$red_sec_d=0;
					if($ta[0]['Nbre_siege']<20)
					{
					
					}else
					{
						$red_sec_d=($ttarif[0]['Redsecurite']*($tot_pax_d));
					}
				}else
				{
					$red_sec_d=($ttarif[0]['Redsecurite']*($tot_pax_d));
				}
				
			}else
			{
				$red_sec_d=0;
			}
		//== RED STATIONNMENT 
			$dt_arr=$ta[0]['Date_mouv'];
			$heure_arr=$ta[0]['Heure_mouv'];
			$dt_dep=$td[0]['Date_mouv'];
			$heure_dep=$td[0]['Heure_mouv'];
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
			if(trim($td[0]['Code_nat'])=='Z')
			{
				$heure=$heure-2;
				
				if($heure>3)
				{
					$red_stat=$td[0]['Poids']*$ttarif[0]['Redstat_tarmac']*$heure;
				}
				else if($heure<1)
				{
					$red_stat=0;
					
				}else if($heure==1)
				{
					$red_stat=$td[0]['Poids']*$ttarif[0]['Redstat_tarmac'];
				}else
				{
					if($td[0]['Stat']=='T')
					{
						$red_stat=$td[0]['Poids']*$ttarif[0]['Redstat_tarmac']*$heure;
					}else if($td[0]['Stat']=='G')
					{
						$red_stat=$td[0]['Poids']*$ttarif[0]['Redstat_garage']*$heure;
					}else
					{
						$red_stat=0;
					}
				}
				if($td[0]['Stat']=='N' || $td[0]['Stat']=="0" || $td[0]["Stat"]=="O")
				{
					$red_stat=0;
					//$red_stat=$td['Stat'];
				}
				
			}else
			{
				if($td[0]['Stat']=='T')
				{
					$red_stat=$ta[0]['Poids']*$ttarif[0]['Redstat_tarmac']*$heure;
				}else if($td[0]['Stat']=='G')
				{
					$red_stat=$ta[0]['Poids']*$ttarif[0]['Redstat_garage']*$heure;
				}else
				{
					$red_stat=0;
				}
			}
			if($ta[0]["Ex_stt"]=='O' || $td[0]['Ex_stt']=='O'){$red_stat=0;}
			if($ta[0]["Ex_stg"]=='O' || $td[0]['Ex_stg']=='O'){$red_stat=0;}
		//== VILLE ARRIVEE OU DE DESTINATION
		$sville_arr="select * from rva_facturation2.escale, rva_facturation2.pt_emplacement where Prov_dest=pt_emplacement.Id_pt and escale.Id_mouv='$num_mouv' and Sens='A'";
		$eville_arr=$this->cnx->query($sville_arr);
		$tville_arr=$eville_arr->fetchAll();
		$ville_arr=$tville_arr[0]['Code_pt'];

		$sville_dep="select * from rva_facturation2.escale, rva_facturation2.pt_emplacement where Prov_dest=pt_emplacement.Id_pt and escale.Id_mouv='$num_mouv' and Sens='D'";
		$eville_dep=$this->cnx->query($sville_dep);
		$tville_dep=$eville_dep->fetchAll();
		@$ville_dep=$tville_dep[0]['Code_pt'];

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
			$tot_sans_tva_fc=$tot_sans_tva*$taux[0]['Usd_fc'];

		//======= DONNEES RETOURNEES ===============
			if(trim($ta[0]['Code_nat'])!=='Z')
			{
				$tva=0;
			}else
			{
				$tva=(($tot_sans_tva*16)/100);
			}
			$total_avec_tva=ceil($tot_sans_tva+$tva);
			$total_avec_tva_fc=$total_avec_tva*$taux[0]["Usd_fc"];

			@$r=array("ttarif"=>$ttarif,
				"dt_saisie"=>$this->Datemysqltofr($ta['Dt']),
				"taux"=>$taux,
				"ta"=>$ta,
				"td"=>$td,	
				"ville_arr"=>$ville_arr,
				"ville_dep"=>$ville_dep,
				"nom_cli"=>$ta[0]['Nom_cli'],
				"code_imm"=>$ta[0]['Code_imm'],
				"num_form"=>$ta[0]['Num_form'],
				"type_av"=>$ta[0]['Libelle_typ'],
				"poids"=>$ta[0]['Poids'],			
				"heure_stat"=>$heure,			
				"escalesA"=>$escalesA,
				"escalesD"=>array($escalesD),
				"tescale_a"=>$tescale_a,
				"balisage_a"=>$balisage_a,
				"balisage_d"=>$balisage_d,
				"stat_a"=>$ta[0]['Stat'],
				"stat_d"=>$td[0]['Stat'],
				"tot_pax_a"=>$tot_pax_a,
				"tot_pax_d"=>$tpass[0]['tot_pax_d'],
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
				"tva_fc"=>(($tva)*$taux[0]['Usd_fc']),
				
				"tot_avec_tva"=>(($total_avec_tva)),
				"tot_avec_tva_fc"=>(($total_avec_tva_fc))
				//"tot_avec_tva_fc"=>ceil($tot_sans_tva_fc)+((($tva)*$taux['Usd_fc']))
				);
		//===============================
		return $r;
	}
	function facture_cash_nv($num_mouv)
	{
			$s="select * from rva_facturation2.num_facture order by Id_num desc"; 
			$e=$this->cnx->query($s);
			$t=$e->fetchAll();
			$n=count($t);
			
			if($n==0){$n1=0; }else { $n1=$t[0]['Num']+1; }

			$dt=date("Y-m-d");
			$s1="insert into rva_facturation2.num_facture (Date_impr,Heure,Num,Num_long,Num_mouv,Mouv,Statut_fact)
			 values(
			 	'$dt','','$n1','','','$num_mouv','')";
			$this->cnx->exec($s1);

			return $n1;
	}
	function st_cl_rda($cl,$dt)
	{
		$s="select * from rva_facturation2.rda where Client_rda='$cl' and Date_rda='$dt'"; 
		$e=$this->cnx->query($s); 
		$t=($e->fetchAll());
		$st=array();
		$mt_usd=0;
		$mt_cdf=0;
		foreach($t as $row)
		{
			if($row['Monn_rda']=='USD')
			{
				$mt_usd=$mt_usd+$row['Mt_rda'];
			}else
			{
				$mt_cdf=$mt_cdf+$row['Mt_rda'];
			}
		}

		$st[]=array(
			"mt_usd"=>$this->arrondie($mt_usd),
			"mt_cdf"=>$this->arrondie($mt_cdf),
			"mt_usd_tva"=>$this->arrondie(($mt_usd*16)/100),
			"mt_cdf_tva"=>$this->arrondie(($mt_cdf*16)/100),
			"mt_usd_tt"=>(($mt_usd*16)/100)+$mt_usd,
			"mt_cdf_tt"=>(($mt_cdf*16)/100)+$mt_cdf
		);
		return ($st);
	}
	function num_fact($mouv)
	{
		$s="select * from rva_facturation2.facture_imprime where Mouv='$mouv'";
		$e=$this->cnx->query($s);
		$t=$e->fetchAll();
		$n=count($t);
		if($n==0)
		{
			$r=0;
		}else
		{
			$r=$t[0]["Num_facture"];
		}
		return $r;
	}
	function detail_fact_par_num_fact($fact)
	{
		$s="select * from 
				rva_facturation2.facture_imprime
			where 
				Num_facture='$fact'";
		$e=$this->cnx->query($s);
		$t=$e->fetchAll();
		@$mouv=$this->mouv($t[0]["Mouv"]);
		return $mouv;
	}
	function num_quittance($mouv)
	{
		$s="select * from rva_facturation2.paiement_facture where Mouv='$mouv'";
		$e=$this->cnx->query($s);
		$t=$e->fetchAll();
		$n=count($t);
		if($n==0)
		{
			$r=0;
		}else
		{
			$r=$t[0]["Quittance"];
		}
		return $r;
	}
	function bordereau($dt)
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
			$s_acc="select * from rva_facturation2.acces,rva_facturation2.type_acces where acces.Type_acc=type_acces.Id_acc and acces.Date_perc='$dt'";
			$e_acc=$this->cnx->query($s_acc); 
			$t_acc=$e_acc->fetchAll(); 
			$n_acc=count($t_acc);
			$r_acc=array();
			if($n_acc==0)
			{
				$r_acc[]=array("n"=>0);
			}else
			{
				foreach($t_acc as $row)
				{
					if($row['Monn_acc']=='USD')
					{
						$tva=$this->tva($row['Mt_acc']);
						$acc_mt_usd=$row['Mt_acc']-$tva;

						$acc_mt_tva_usd=$tva;
						$acc_mt_tt_usd=$row['Mt_acc'];

						$acc_mt_cdf=0;
						$acc_mt_tva_cdf=0;
						$acc_mt_tt_cdf=0;	

						//========================= CALCUL SOUS TOTAL 
						$st_acc_usd=$st_acc_usd+$acc_mt_usd;
						$st_acc_tva_usd=$st_acc_tva_usd+$acc_mt_tva_usd;
						$st_acc_tt_usd=$acc_mt_tt_usd+$acc_mt_tt_usd;
						
					}else
					{
						$tva=$this->tva($row['Mt_acc']);
						$acc_mt_cdf=$row['Mt_acc']-$tva;
						$acc_mt_tva_cdf=(($acc_mt_cdf*16)/100);
						$acc_mt_tt_cdf=$row['Mt_acc'];	

						$acc_mt_usd=0;
						$acc_mt_tva_usd=0;
						$acc_mt_tt_usd=0;
						//========================= CALCUL SOUS TOTAL 
						$st_acc_cdf=$st_acc_cdf+$acc_mt_cdf;
						$st_acc_tva_cdf=$st_acc_tva_cdf+$acc_mt_tva_cdf;
						$st_acc_tt_cdf=$st_acc_cdf+$st_acc_tva_cdf;	
					}
					$r_acc[]=array("n"=>$n_acc,
							"id"=>$row['Id_acc'],
							"num_acc"=>$row['Num_long'],
							"acc_mt_cdf"=>$this->arrondie($acc_mt_cdf),
							"acc_mt_tva_cdf"=>$this->arrondie($acc_mt_tva_cdf),
							"acc_mt_tt_cdf"=>$this->arrondie($acc_mt_tt_cdf),

							"acc_mt_usd"=>$this->arrondie($acc_mt_usd),
							"acc_mt_tva_usd"=>$this->arrondie($acc_mt_tva_usd),
							"acc_mt_tt_usd"=>$this->arrondie($acc_mt_tt_usd),
							"acc_quittance"=>$row['Quittance']
					);
				};

			}
		//================== RDA========================
			$s_rda="select * from rva_facturation2.rda,rva_facturation2.client where rda.Client_rda=client.Id_cl and rda.Date_rda='$dt'";
			$e_rda=$this->cnx->query($s_rda); 
			$t_rda=$e_rda->fetchAll(); 
			$n_rda=count($t_rda);
			$r_rda=array();
			if($n_rda==0)
			{
				$r_rda[]=array("n"=>0);
			}else
			{
				$nom=$t_rda[0]['Nom_cli'];
				$st_cl_usd=0;
				$st_cl_cdf=0;
				$st_cl_usd_tva=0;
				$st_cl_cdf_tva=0;
				$st_cl_usd_tt=0;
				$st_cl_cdf_tt=0;
				foreach($t_rda as $row)
				{
					
					if($row['Monn_rda']=='USD')
					{
						$tva=$this->tva($row['Mt_rda']);

						$rda_mt_usd=floatval($row['Mt_rda']-$tva);
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
						$tva=$this->tva($row['Mt_rda']);

						$rda_mt_cdf=floatval($row['Mt_rda'])-$tva;
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
							if($nom==$row['Nom_cli'])
							{
								$st_cl_usd=$this->arrondie($st_cl_usd+$rda_mt_usd);
								$st_cl_cdf=$this->arrondie($st_cl_cdf+$rda_mt_cdf);
								$st_cl_usd_tva=$this->arrondie($st_cl_usd+$rda_mt_tva_usd);
								$st_cl_cdf_tva=$this->arrondie($st_cl_cdf+$rda_mt_tva_cdf);
								$st_cl_usd_tt=$this->arrondie($st_cl_usd+$rda_mt_tt_usd);
								$st_cl_cdf_tt=$this->arrondie($st_cl_cdf+$rda_mt_tt_cdf);
							}else
							{
								$nom=$row['Nom_cli'];
								$st_cl_usd=0;
								$st_cl_cdf=0;
								$st_cl_usd_tva=0;
								$st_cl_cdf_tva=0;
								$st_cl_usd_tt=0;
								$st_cl_usd_tt=0;
								$st_cl_usd=$this->arrondie($st_cl_usd+$rda_mt_usd);
								$st_cl_cdf=$this->arrondie($st_cl_cdf+$rda_mt_cdf);
								$st_cl_usd_tva=$this->arrondie($st_cl_usd+$rda_mt_tva_usd);
								$st_cl_cdf_tva=$this->arrondie($st_cl_cdf+$rda_mt_tva_cdf);
								$st_cl_usd_tt=$this->arrondie($st_cl_usd+$rda_mt_tt_usd);
								$st_cl_cdf_tt=$this->arrondie($st_cl_cdf+$rda_mt_tt_cdf);
							}
						//===========================================================
					$r_rda[]=array("n"=>$n_rda,
							"id"=>$row['Id_rda'],
							"nom"=>$row['Nom_cli'],
							"num_rda"=>$row['Num_long'],
							"rda_mt_cdf"=>$this->arrondie($rda_mt_cdf),
							"rda_mt_tva_cdf"=>$this->arrondie($rda_mt_tva_cdf),
							"rda_mt_tt_cdf"=>$this->arrondie($rda_mt_tt_cdf),

							"rda_mt_usd"=>$this->arrondie($rda_mt_usd),
							"rda_mt_tva_usd"=>$this->arrondie($rda_mt_tva_usd),
							"rda_mt_tt_usd"=>$this->arrondie($rda_mt_tt_usd),
							"rda_quittance"=>$row['Quittance'],
							"st_cl_usd"=>$st_cl_usd,
							"st_cl_cdf"=>$st_cl_cdf,
							"st_cl_usd_tva"=>$st_cl_usd_tva,
							"st_cl_cdf_tva"=>$st_cl_cdf_tva,
							"st_cl_usd_tt"=>$st_cl_usd_tt,
							"st_cl_cdf_tt"=>$st_cl_cdf_tt,
							"st"=>$this->st_cl_rda($row['Client_rda'],$row['Date_rda'])
					);

				}

			}
		// ================= IDF FRET ==================
			$s_idf="select * from rva_facturation2.idf where Date_enr='$dt' and Valide='V'";
			$e_idf=$this->cnx->query($s_idf);

			$t_idf=$e_idf->fetchAll();
			$n_idf=count($t_idf);
			$r_idf=array();
			$st_idf=0;
			if($n_idf==0)
			{
				$r_idf[]=array("n"=>0);
			}else
			{
				foreach($t_idf as $row)
				{
					$st_idf=$st_idf+$row['Mt'];
					//$r_idf[]=array()
				}
				$r_idf[]=array("n"=>1,"mt"=>$this->arrondie($st_idf));
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
					"st_acc_usd"=>$this->arrondie($st_acc_usd),
					"st_acc_tva_usd"=>$this->arrondie($st_acc_tva_usd),
					"st_acc_tt_usd"=>$this->arrondie($st_acc_tt_usd),
					"st_acc_cdf"=>$this->arrondie($st_acc_cdf),
					"st_acc_tva_cdf"=>$this->arrondie($st_acc_tva_cdf),
					"st_acc_tt_cdf"=>$this->arrondie($st_acc_tt_cdf),

					"rda"=>$r_rda,
					"st_rda_usd"=>$this->arrondie($st_rda_usd),
					"st_rda_tva_usd"=>$this->arrondie($st_rda_tva_usd),
					"st_rda_tt_usd"=>$this->arrondie($st_rda_tt_usd),
					"st_rda_cdf"=>$this->arrondie($st_rda_cdf),
					"st_rda_tva_cdf"=>$this->arrondie($st_rda_tva_cdf),
					"st_rda_tt_cdf"=>$this->arrondie($st_rda_tt_cdf),

					"t_usd"=>$this->arrondie($t_usd),
					"t_tva_usd"=>$this->arrondie($t_tva_usd),
					"t_tt_usd"=>$this->arrondie($t_tt_usd),
					"t_cdf"=>$this->arrondie($t_cdf),
					"t_tva_cdf"=>$this->arrondie($t_tva_cdf),
					"t_tt_cdf"=>$this->arrondie($t_tt_cdf),

					"idf"=>$r_idf				
			);
			return (($resultat));
			//echo (json_encode(array("n"=>2)));	
	}
	function client($id)
	{
		$s="select * from rva_facturation2.client where Id_cl='$id'"; 
		$e=$this->cnx->query($s); 
		$t=$e->fetchAll();
		$r=array("code_cl"=>$t[0]['Code_cl'],"nom_cl"=>$t[0]['Nom_cli'],"adresse"=>$t[0]['Adresse_cl'],"type_cl"=>$t[0]['Type_cl'],"code_nat"=>$t[0]['Code_nat']);
		return $r;
	}
	function exploitant($id)
	{
		$s="select * from rva_facturation2.client where Id_cl='$id'"; 
		$e=$this->cnx->query($s);
		$t=$e->fetchAll();
		$r=array("code"=>$t[0]['Code_cl'],
				"nom"=>$this->afficher_text($t[0]['Nom_cli']),
				"adresse"=>$t[0]['Adresse_cl'],
				"type_cl"=>$t[0]['Type_cl']);
		return $r;	
	}
	function signataire()
	{
		$s="select * from rva_facturation2.signataire";
		$e=$this->cnx->query($s);
		$t=$e->fetchAll();
		$r=array("cmd"=>$t[0]["Cmd"],"division"=>$t[0]['Division'],"facturation"=>$t[0]['Facturation']);
		return $r;
	}
	function user($id)
	{
		
		$priv = array('perc' =>"Percepteur/Taxateur/Facturateur",
		"agent_handl"=>"Agent Handling",
		"ch_serv"=>"Chef de service",
		"ch_bur"=>"Chef de bureau",
		"ut"=>"Utilisateur",
		"adm"=>"Administrateur");
		$s="select * from rva_facturation2.utilisateur where Id_us='$id'"; 
		$e=$this->cnx->query($s);
		$t=$e->fetchAll();
		@$r=array(
			"matr"=>$t[0]['Matricule'],
			"nom"=>$this->afficher_text($t[0]['Nom_complet']),
			"login"=>$t[0]['Login'],
			"priv"=>$t[0]['Priv']);

		return $r;
	}

	//=============== HANDLING===============
	function handling_facture($id)
	{
		$s="select * from 
				rva_facturation2.handling_facturation,rva_facturation2.immatriculation,rva_facturation2.handling_handleur,rva_facturation2.client,rva_facturation2.type_avion
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
		$e=$this->cnx->query($s);
		@$t=($e->fetchAll());
		$n=count($t);
		if($t[0]['Poids']<150)
		{
			if(trim($t[0]['AA'])!="N")
			{
				$AA_prix=31;
			}else
			{
				$AA_prix=0;
			}

			
			if(trim($t[0]['TA'])=="O")
			{
				$TA_prix=21;
			}else
			{
				$TA_prix=0;
			}

			if(trim($t[0]['FA'])=="O")
			{
				$FA_prix=42;
			}else
			{
				$FA_prix=0;
			}
		}else
		{
			if(trim($t[0]['AA'])!="N")
			{
				$AA_prix=37;
			}else
			{
				$AA_prix=0;
			}

			if(trim($t[0]['TA'])=="O")
			{
				$TA_prix=27;
			}else
			{
				$TA_prix=0;
			}

			if(trim($t[0]['FA'])=="O")
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
			if(trim($t[0]['TA'])=="O")
			{
				$touche=$touche." TA ";
			}
			if(trim($t[0]['AA'])!="N")
			{
				$touche=$touche." ".$t[0]["AA"]." ";
			}else if(trim($t[0]['AA'])=="N")
			{
				$touche=$touche." ";
			}
			if(trim($t[0]['FA'])=="O")
			{
				$touche=$touche." FA ";
			}
			//if($t[0]["AA"]=="N"){$t[0]["AA"]=""}
		//================================
		@$user=$this->user($t[0]['Id_us']);
		@$r=array("id_fact"=>$id,
				"dt_fact"=>$this->Datemysqltofr($t[0]['Date_fact']),
				"imm"=>$t[0]["Code_imm"],
				"poids"=>$t[0]['Poids'],
				"type_av"=>$t[0]["Libelle_typ"],
				"heure"=>$t[0]["Heure_fact"],
				"handleur"=>$t[0]['Nom_hand'],
				"handleur_type_paie"=>$t[0]['Type_paie'],
				"handleur_code"=>$t[0]['Code_hand'],
				"handleur_nationalite"=>$t[0]['Nationalite'],
				"client"=>$t[0]['Nom_cli'],
				"adresse_handleur"=>$t[0]['Adresse_hand'],
				"ville_handleur"=>$t[0]['Ville_hand'],
				"dt_fact"=>$this->Datemysqltofr($t[0]["Date_fact"]),
				"heure_arr"=>$t[0]["Heure_arr"],
				"dt_arr"=>$this->Datemysqltofr($t[0]["Date_arr"]),
				"heure_dep"=>$t[0]["Heure_dep"],
				"dt_dep"=>$this->Datemysqltofr($t[0]["Date_dep"]),
				"handleur"=>$t[0]['Nom_hand'],
				"aa"=>$t[0]["AA"],
				"ta"=>$t[0]["TA"],
				"fa"=>$t[0]["FA"],
				"aa_prix"=>$AA_prix,
				"ta_prix"=>$TA_prix,
				"fa_prix"=>$FA_prix,
				"mht"=>$prix_fact,
				"tva"=>$this->tva($prix_fact),
				"mttc"=>ceil($prix_fact+$this->tva($prix_fact)),
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
		}else if($txt=="AE")
		{
			$t="Assistance Engin";
		}else if($txt=="TT")
		{
			$t="Touchée Technique";
		}else if($txt=="FA")
		{
			$t="Full assistance";
		}else
		{
			$t="Assistance administrative";
		}
		return $t;
	}
	function paie_handling_detail($fact)
	{
		$s="select * from rva_facturation2.handling_num_fact where Id_fact='$fact'";
		$e=$this->cnx->query($s);
		$t=($e->fetchAll());

		$s2="select * from rva_facturation2.handling_paiement where Fact_paie='$fact'";
		$e2=$this->cnx->query($s2);
		$t2=($e2->fetchAll());

		$s3="select * from rva_facturation2.handling_num_fact where Id_fact='$fact'";
		$e3=$this->cnx->query($s3);
		$t3=($e3->fetchAll());

		$user=$this->user($t2[0]['Id_us']);
		$detail_fact=$this->handling_facture($fact);
		@$r=array(
			"dt_fact"=>$this->Datemysqltofr($t[0]['Date_fact']),
			"dt_paie"=>$this->Datemysqltofr($t2[0]['Date_paie']),
			"num_fact"=>$t3[0]['Num_fact_long'],
			"percepteur"=>$user['nom'],
			"mht"=>$t2[0]['Mht'],
			"tva"=>$t2[0]['Tva'],
			"mttc"=>$t2[0]['Mttc'],
			"quittance"=>$this->format_nbre($t2[0]['Id_paie']),
			"detail"=>$detail_fact
			);

		return $r;
	}
	function handling_num_fact($mouv)
	{
		$s="select * from handling_num_fact where Id_fact='$mouv'";
		$e=mysqli_query($bdd,$s);
		$t=mysqli_fetch_array($e);
		return $t["Num_fact_long"];
	}
	function __construct()
	{
		if(date("Y-m-d")<"2020-05-18")
		{
			$this->cnx=new PDO("sqlsrv:Server=localhost;Database=rva_facturation2", "", "");
		}
			//$this->cnx=new PDO("mysql:host=localhost;dbname=rva_facturation2","root","");
			$this->dt=date("Y-m-d");
			$this->heure=date("H:i:s");
			$this->id_us=1;

			$couleur=array("green","red","blue","indigo","brown","teal","cyan","light-blue","yellow","black","purple","lime","deep-orange","pink","pink accent-4");
			 $etat=array("N"=>"Neuf",
					"B"=>utf8_decode("Bon &eacute;tat"),
					"P"=>"Panne",
					"D"=>htmlentities("Declass&eacute;")
			);     
	}
	//================== TABLEAU DE BORD =========
	function tableau_de_bord($dt)
	{
		$rda_mht=0;
		$rda_tva=0;
		$rva_ttc=0;

		$s="select * from rva_facturation2.paiement_facture where Date_paie='$dt'";
		$e=$this->cnx->query($s);
		$t=$e->fetchAll();
		$n=count($t);
		if($n==0)
		{
			$n_rda=0;
			$rda_mht=0;
			$rda_mht_fc=0;
			$rda_tva=0;
			$rda_tva_fc=0;
			$rda_ttc=0;
			$rda_ttc_fc=0;
		}else
		{
			$n_rda=0;
			$rda_mht=0;
			$rda_mht_fc=0;
			$rda_tva=0;
			$rda_tva_fc=0;
			$rda_ttc=0;
			$rda_ttc_fc=0;	
			$n_rda=$n;
			foreach ($t as $row) 
			{
				$mouv=$this->mouv($row['Mouv']);
				if($row['Monnaie']=="USD")
				{
					$rda_mht+=$mouv["tot_sans_tva"];
					$rda_tva+=$mouv["tva"];
					$rda_ttc+=$mouv["tot_avec_tva"];
				}else
				{
					$rda_mht_fc+=$mouv["tot_sans_tva_fc"];
					$rda_tva_fc+=$mouv["tva_fc"];				
					$rda_ttc_fc+=$mouv["tot_avec_tva_fc"];
				}
				
			}

		}
			$s_rda_supp="select * from rva_facturation2.rda_suppl where Date_paie='$dt'";
			$e_rda_supp=$this->cnx->query($s_rda_supp);
			$t_rda_supp=$e_rda_supp->fetchAll();
			$n_rda_supp=count($t_rda_supp);
			if($n_rda_supp!==0)
			{
				foreach ($t_rda_supp as $row) {
					$mouvv=$this->detail_fact_par_num_fact($row["Facture"]);
					
					if(trim($mouvv['ta'][0]['Code_nat'])=="E")
					{
						$tva="N";
					}else
					{
						$tva="O";
					}

					
					if($row['Monn']=="USD")
					{
						if($tva=="O")
						{
							$rda_mht+=($row['Montant']-$this->tva($row['Montant']));
							$rda_tva+=$this->tva($row["Montant"]);
							$rda_ttc+=$row["Montant"];
						}else
						{
							$rda_ttc+=$row['Montant'];
						}
						
					}else
					{
								
						if($tva=="O")
						{
							$rda_mht_fc+=$row['Montant']-$this->tva($row['Montant']);
							$rda_tva_fc+=$this->tva($row["Montant"]);
							$rda_ttc_fc+=$row["Montant"];
						}else
						{
							$rda_ttc_fc+=$row['Montant'];
						}
					}
				}
				
			}
			
		//================= 	IDF ==============================
		$sidf="select * from rva_facturation2.idf_paiement where idf_paiement.Date_enr='$dt'";
		$eidf=$this->cnx->query($sidf);
		$rowidf=$eidf->fetchAll();
		$n_idf=0;
		$idf_mht=0;
		$idf_mht_fc=0;
		$idf_tva=0;
		$idf_tva_fc=0;
		$idf_ttc=0;
		$idf_ttc_fc=0;
		foreach($rowidf as $t)
		{
			$client=$this->client($t['Client']);
			if($t["Monn"]=="USD")
			{

				$idf_mht+=$t['Mt'];
				$idf_mht_fc=0;
				$idf_tva_fc=0;
				
				$idf_tva+=0;
				$idf_ttc+=ceil($t['Mt']);
				$idf_ttc_fc=0;
				
				//$arrondieusd=$mttusd-($mhtusd+$tvausd);
				//$arrondiecdf=0;
			}else
			{
				$idf_mht_fc+=$t['Mt'];
				$idf_mht=0;
				$idf_tva=0;
				
				$idf_tva_fc+=0;

				$idf_ttc_fc+=($t['Mt']);
				
				$mttusd=0;
				//$arrondiecdf=0;
				//$arrondieusd=0;
			}
		}
		//================= ACCES  =================================
		$sacces="select * from rva_facturation2.acces where Date_perc='$dt' and Type_acc!=1";
		$eacces=$this->cnx->query($sacces);
		$tacces=$eacces->fetchAll();
		$nacces=count($tacces);
		
		$n_acces=$nacces;
		$acces_mht=0;
		$acces_mht_fc=0;
		$acces_tva=0;
		$acces_tva_fc=0;
		$acces_ttc=0;
		$acces_ttc_fc=0;
		foreach ($tacces as $row) {
			if($row["Tva"]!="N")
			{
				if($row["Monn_acc"]=="USD")
				{
					$acces_mht+=$row["Mt_acc"];
					$acces_tva+=$this->tva($row["Mt_acc"]);
					$acces_ttc+=$row["Mt_acc"]+$this->tva($row["Mt_acc"]);
				}else
				{
					$acces_mht_fc+=$row["Mt_acc"];
					$acces_tva_fc+=$this->tva($row["Mt_acc"]);
					$acces_ttc_fc+=$row["Mt_acc"]+$this->tva($row["Mt_acc"]);
				}
			}else
			{
				if($row["Monn_acc"]=="USD")
				{
					$acces_mht+=$row["Mt_acc"];
					$acces_ttc+=$row["Mt_acc"];
				}else
				{
					$acces_mht_fc+=$row["Mt_acc"];
					$acces_ttc_fc+=$row["Mt_acc"];
				}
			}
		}
		//================= PARKING  =================================
		$sparking="select * from rva_facturation2.acces where Date_perc='$dt' and Type_acc=1";
		$eparking=$this->cnx->query($sparking);
		$tparking=$eparking->fetchAll();
		$nparking=count($tparking);
		
		$n_parking=$nparking;
		$parking_mht=0;
		$parking_mht_fc=0;
		$parking_tva=0;
		$parking_tva_fc=0;
		$parking_ttc=0;
		$parking_ttc_fc=0;
		foreach ($tparking as $row) {
			if(trim($row["Tva"])=="O")
			{
				if($row["Monn_acc"]=="USD")
				{
					$parking_mht+=$row["Mt_acc"];
					$parking_tva+=$this->tva($row["Mt_acc"]);
					$parking_ttc+=ceil($row["Mt_acc"]+$this->tva($row["Mt_acc"]));
				}else
				{
					$parking_mht_fc+=$row["Mt_acc"];
					$parking_tva_fc+=$this->tva($row["Mt_acc"]);
					$parking_ttc_fc+=ceil($row["Mt_acc"]+$this->tva($row["Mt_acc"]));
				}
			}else
			{
				$parking_tva=0;
				if($row["Monn_acc"]=="USD")
				{
					$parking_mht+=$row["Mt_acc"];
					$parking_ttc+=ceil($row["Mt_acc"]);
				}else
				{
					$parking_mht_fc+=$row["Mt_acc"];
					$parking_ttc_fc+=($row["Mt_acc"]);
				}
			}
		}
		//================= HANDLING  =================================
		$shand="select * from rva_facturation2.handling_paiement where Date_paie='$dt'";
		$ehand=$this->cnx->query($shand);
		$thand=$ehand->fetchAll();
		$nhand=count($thand);
		
		$n_hand=$nhand;
		$hand_mht=0;
		$hand_mht_fc=0;
		$hand_tva=0;
		$hand_tva_fc=0;
		$hand_ttc=0;
		$hand_ttc_fc=0;
		if($nhand==0)
		{

		}else
		{
			foreach ($thand as $row) {
				$hand_mht+=$row["Mht"];
				$hand_tva+=$row["Tva"];
				$hand_ttc+=$row["Mttc"];
			}
		}

		$resultat=array(
			"n_rda"=>$n_rda,
			"rda_mht"=>$this->arrondie($rda_mht),
			"rda_mht_fc"=>$this->arrondie($rda_mht_fc),
			"rda_tva"=>$this->arrondie($rda_tva),
			"rda_tva_fc"=>$this->arrondie($rda_tva_fc),
			"rda_ttc"=>$this->arrondie($rda_ttc),
			"rda_ttc_fc"=>$this->arrondie($rda_ttc_fc),

			"n_idf"=>$n_idf,
			"idf_mht"=>$this->arrondie($idf_mht),
			"idf_mht_fc"=>$this->arrondie($idf_mht_fc),
			"idf_tva"=>$this->arrondie($idf_tva),
			"idf_tva_fc"=>$this->arrondie($idf_tva_fc),
			"idf_ttc"=>$this->arrondie($idf_ttc),
			"idf_ttc_fc"=>$this->arrondie($idf_ttc_fc),

			"n_acces"=>$n_acces,
			"acces_mht"=>$this->arrondie($acces_mht),
			"acces_mht_fc"=>$this->arrondie($acces_mht_fc),
			"acces_tva"=>$this->arrondie($acces_tva),
			"acces_tva_fc"=>$this->arrondie($acces_tva_fc),
			"acces_ttc"=>$this->arrondie($acces_ttc),
			"acces_ttc_fc"=>$this->arrondie($acces_ttc_fc),

			"n_parking"=>$n_parking,
			"parking_mht"=>$this->arrondie($parking_mht),
			"parking_mht_fc"=>$this->arrondie($parking_mht_fc),
			"parking_tva"=>$this->arrondie($parking_tva),
			"parking_tva_fc"=>$this->arrondie($parking_tva_fc),
			"parking_ttc"=>$this->arrondie($parking_ttc),
			//"parking_ttc"=>$tparking[3]['Tva'],
			"parking_ttc_fc"=>$this->arrondie($parking_ttc_fc),

			"n_hand"=>$n_hand,
			"hand_mht"=>$this->arrondie($hand_mht),
			"hand_mht_fc"=>$this->arrondie($hand_mht_fc),
			"hand_tva"=>$this->arrondie($hand_tva),
			"hand_tva_fc"=>$this->arrondie($hand_tva_fc),
			"hand_ttc"=>$this->arrondie($hand_ttc),
			"hand_ttc_fc"=>$this->arrondie($hand_ttc_fc),

			"tot_mht"=>$this->arrondie($hand_mht+$parking_mht+$acces_mht+$idf_mht+$rda_mht),
			"tot_mht_fc"=>$this->arrondie($hand_mht_fc+$parking_mht_fc+$acces_mht_fc+$idf_mht_fc+$rda_mht_fc),
			"tot_tva"=>$this->arrondie($hand_tva+$parking_tva+$acces_tva+$idf_tva+$rda_tva),
			"tot_tva_fc"=>$this->arrondie($hand_tva_fc+$parking_tva_fc+$acces_tva_fc+$idf_tva_fc+$rda_tva_fc),
			//"tot_ttc"=>$this->arrondie(ceil($hand_mht+$parking_mht+$acces_mht+$idf_mht+$rda_mht)+($hand_tva+$parking_tva+$acces_tva+$idf_tva+$rda_tva)),
			"tot_ttc"=>$this->arrondie($hand_ttc+$parking_ttc+$acces_ttc+$idf_ttc+$rda_ttc),
			"tot_ttc_fc"=>$this->arrondie(ceil($hand_mht_fc+$parking_mht_fc+$acces_mht_fc+$idf_mht_fc+$rda_mht_fc)+($hand_tva_fc+$parking_tva_fc+$acces_tva_fc+$idf_tva_fc+$rda_tva_fc)),
		);
		return($resultat);
	}
	function dernier_enreg($tables,$ids)
	{
		$s="select * from rva_facturation2.$tables order by $ids desc";
		$e=$this->cnx->query($s);
		$t=$e->fetchAll();
		$n=count($t);
		if($n==0)
		{
			$r=0;
		}else
		{
			$r=$t[0][$ids];
		}
		return $r;
	}
}
?>