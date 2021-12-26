<?php
	$id_mouv=$_REQUEST['p'];
	$num_mouv=$_REQUEST['p2'];
	include('../../manager/bd/cnx.php');
	
	
	$sa="select *,date_format(Date_mouv,'%d/%m/%Y') as dt_mouv from mouvement2,pt_emplacement,immatriculation,client 
		where 
			mouvement2.Pt=pt_emplacement.Id_pt 
		and 
			mouvement2.Immatr=immatriculation.Id_imm
		and
			immatriculation.Code_pr=client.Id_cl
		and
			Sens='A' 
		and 
			Num_mouv='$num_mouv'";
	$ea=mysqli_query($bdd,$sa);
	$ta=mysqli_fetch_array($ea);
	$escale_a="select * from escale,pt_emplacement where escale.Id_mouv='$num_mouv' and escale.Pt_ent=pt_emplacement.Id_pt and escale.Sens='A'"; 
	$e_escale_a=mysqli_query($bdd,$escale_a); $tescale_a=mysqli_fetch_array($e_escale_a);
	
	$tot_pax_a=$tescale_a['Ad']+$tescale_a['Ch']+$tescale_a['Inf'];
	
	if($ta['Temps']=="B")
	{
		$balisage_a="O";
	}else
	{
		$balisage_a="N";
	}
		
	
	$sd="select *,date_format(Date_mouv,'%d/%m/%Y') as dt_mouv from mouvement2,pt_emplacement where mouvement2.Pt=pt_emplacement.Id_pt and Sens='D' and Num_mouv='$num_mouv'";
	$ed=mysqli_query($bdd,$sd);
	$td=mysqli_fetch_array($ed);
	$escale_d="select * from escale,pt_emplacement where escale.Id_mouv='$num_mouv' and escale.Pt_ent=pt_emplacement.Id_pt and escale.Sens='D'"; 
	$e_escale_d=mysqli_query($bdd,$escale_d); $tescale_d=mysqli_fetch_array($e_escale_d);
	
	//===== TOTAL PASSAGER =======================
	$tot_pax_d=0;
	do
	{
		$tot_pax_d=$tot_pax_d+($tescale_d['Ad']+$tescale_d['Ch']+$tescale_d['Inf']);
	}while($tescale_d=mysqli_fetch_array($e_escale_d));
	
	
	if($td['Temps']=="B")
	{
		$balisage_d="N";
	}else
	{
		$balisage_d="O";
	}
	
	if($ta['Temps']=="B")
	{
		$balisage_a="N";
	}else
	{
		$balisage_a="O";
	}
	
	$s_taux="select * from taux order by Id_taux desc"; $e_taux=mysqli_query($bdd,$s_taux); $taux=mysqli_fetch_array($e_taux);
	//============== STATIONNEMENT =================
	$stationement=$td['Stat'];
	
	// =============== CALCUL REDEVANCES ========================
	$tarif="select * from tarif_red"; $etarif=mysqli_query($bdd,$tarif); $ttarif=mysqli_fetch_array($etarif);
	// RED ROUTE A
	if($ta['Type_mouv']=="N")
	{
		if($ta['Nv_vol']<245)
		{
			$route_d=0;
			$route_a=(($ttarif['Redrou_esp_inf_245'])*($ta['Distance']/100)*(sqrt($ta['Poids']/50)));
		}else
		{
			$route_a=0;
			$route_d=(($ttarif['Redrou_esp_sup_245'])*($ta['Distance']/100)*(sqrt($ta['Poids']/50)));
		}
	}else
	{
		$route_a=(($ttarif['Redrou_vol_int'])*($ta['Distance']/100)*(sqrt($ta['Poids']/50)));
		$route_d=(($ttarif['Redrou_vol_int'])*($td['Distance']/100)*(sqrt($ta['Poids']/50)));	
	}
	
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
	
	//=== RED ATTERISSAGE
	if($ta['Type_mouv']=='N')
	{
		if($ta['Poids']<4)
		{
			$red_att_a=5;
			$red_att_d=0;
		}else if($ta['Poids']>4 && $ta['Poids']<26)
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
		}else if($ta['Poids']>4 && $ta['Poids']<26)
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
	//== RED FRET
	if($ta['Type_mouv']=='N')
	{
		$red_fret_a=0;
		$red_fret_d=($ttarif['Redfr_res_nat']*($tescale_d['Loc']+$tescale_d['Trat']+$tescale_d['Ptt']));	
	}else
	{
		$red_fret_a=($ttarif['Redfr_res_nat_idf_deb']*($tescale_a['Loc']+$tescale_a['Trat']+$tescale_a['Ptt']));
		$red_fret_d=($ttarif['Redfr_res_nat_idf_emb']*($tescale_d['Loc']+$tescale_d['Trat']+$tescale_d['Ptt']));
	}
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
	//==PEC
	if($ta['Type_mouv']=='N')
	{
		$red_pec=($tescale_d['Pec']*(($ttarif['Redpass_res_nat']*10)/100));
	}else
	{
		$red_pec=($tescale_d['Pec']*(($ttarif['Redpass_res_int']*10)/100));
	}
	//==RED COMPT ENREG
	$red_compt_a=$ta['Compt_enr']*$ttarif['Cptenreg'];
	$red_compt_d=$td['Compt_enr']*$ttarif['Cptenreg'];
	//== RED FORM
	$red_formu_a=$ta['Formu'];
	$red_formu_d=$td['Formu'];
	//==ANTI INC
	if($td['Anti_inc']=="N")
	{
		$red_assantinc_a=0;
		$red_assantinc_d=0;
	}else
	{
		$red_assantinc_a=0;
		$red_assantinc_d=$ttarif['Assantinc'];
	}
	$red_assantinc=$ttarif["Assantinc"];
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
	//== RED SECURITE
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
	//== RED STATIONNMENT 
		$dt_arr=$ta['Date_mouv'];
		$heure_arr=$ta['Heure_mouv'];
		$dt_dep=$td['Date_mouv'];
		$heure_dep=$td['Heure_mouv'];
		$tps_arr=strtotime($dt_arr." ".$heure_arr);	
		$tps_dep=strtotime($dt_dep." ".$heure_dep);
		$heure=((($tps_dep-$tps_arr)/60)/60);
		$tabl_heure=explode('.',$heure);
		if(isset($tabl_heure[1]))
		{
			$heure=$tabl_heure[0]+1;
		}else
		{
			$heure=$heure;
		}
	if($ta['Type_mouv']=='N')
	{
		$heure=$heure-2;
		if($heure<1)
		{
			$red_stat=0;
		}else if($heure=1)
		{
			$red_stat=$ta['Poids']*$ttarif['Redstat_tarmac'];;
		}else if($heure>3)
		{
			$red_stat=$ta['Poids']*$ttarif['Redstat_tarmac'];
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
?>	
<div class="panel panel-default">
	<div class="panel-heading center bold fs-2">DETAIL FACTURE</div>	
    <div class="panel-body">
    	<p>
        	<div><span>Client : <?php echo $ta['Nom_cli']; ?></span></div>
            <div><span>Immatr : <?php echo $ta['Code_imm']; ?></span></div>
            <div><span>Type vol : <?php echo $ta['Type_mouv']; ?></span></div>
        </p>
    	<table width="1014" cellspacing="0" class="w3-small w3-table-all">
          <tr>
            <td colspan="15">&nbsp;</td>
            </tr>
          <tr class="blue-grey white-text bold center">
            <td width="40" height="68">SENS</td>
            <td width="67">DATE</td>
            <td width="68">HEURE</td>
            <td width="79">ESCALE</td>
            <td width="81">ADULTE</td>
            <td width="65">ENFANT</td>
            <td width="58">BEBE</td>
            <td width="35">PEC</td>
            <td width="71">PAX TRANS</td>
            <td width="66">FRET LOC</td>
            <td width="62">FRET TRA</td>
            <td width="64">FRET PTT</td>
            <td width="90">BALISAGE</td>
            <td width="138">STATIONNEMENT</td>
            </tr>
          <tr class="center">
            <td height="46"><?php echo ($ta['Sens']); ?></td>
            <td><?php echo ($ta['dt_mouv']); ?></td>
            <td><?php echo (substr($ta['Heure_mouv'],0,5)); ?></td>
            <td><?php echo ($ta['Code_pt']); ?></td>
            <td><?php echo ($tescale_a['Ad']); ?></td>
            <td><?php echo ($tescale_a['Ch']); ?></td>
            <td><?php echo ($tescale_a['Inf']); ?></td>
            <td><?php echo ($tescale_a['Pec']); ?></td>
            <td><?php echo ($tescale_a['Tra']); ?></td>
            <td><?php echo ($tescale_a['Loc']); ?></td>
            <td><?php echo ($tescale_a['Trat']); ?></td>
            <td><?php echo ($tescale_a['Ptt']); ?></td>
            <td><?php echo ($balisage_a); ?></td>
            <td>&nbsp;</td>
          </tr>
          <?php
				$a=1;
				do
				{
					if($a==1)
					{
						$a++;
						continue;					
					} ?>
				<tr class="center" align="center">
                    <td height="32"></td>
                    <td><?php  ?></td>
                    <td><?php  ?></td>
                    <td><?php echo ($tescale_a['Code_pt']); ?></td>
                    <td><?php echo ($tescale_a['Ad']); ?></td>
                    <td><?php echo ($tescale_a['Ch']); ?></td>
                    <td><?php echo ($tescale_a['Inf']); ?></td>
                    <td><?php echo ($tescale_a['Pec']); ?></td>
                    <td><?php echo ($tescale_a['Tra']); ?></td>
                    <td><?php echo ($tescale_a['Loc']); ?></td>
                    <td><?php echo ($tescale_a['Trat']); ?></td>
                    <td><?php echo ($tescale_a['Ptt']); ?></td>
                    <td></td>
                    <td><?php ?></td>
                </tr>
				<?php
					$a++;
                }while($tescale_a=mysqli_fetch_array($e_escale_a));
				
				$escale_d="select * from escale,pt_emplacement where escale.Id_mouv='$num_mouv' and escale.Pt_ent=pt_emplacement.Id_pt and escale.Sens='D'"; 
				$e_escale_d=mysqli_query($bdd,$escale_d); $tescale_d=mysqli_fetch_array($e_escale_d);
			?>
          <tr class="center" align="center">
            <td height="32"><?php echo ($td['Sens']); ?></td>
            <td><?php echo ($td['dt_mouv']); ?></td>
            <td><?php echo (substr($td['Heure_mouv'],0,5)); ?></td>
            <td><?php echo ($tescale_d['Code_pt']); ?></td>
            <td><?php echo ($tescale_d['Ad']); ?></td>
            <td><?php echo ($tescale_d['Ch']); ?></td>
            <td><?php echo ($tescale_d['Inf']); ?></td>
            <td><?php echo ($tescale_d['Pec']); ?></td>
            <td><?php echo ($tescale_d['Tra']); ?></td>
            <td><?php echo ($tescale_d['Loc']); ?></td>
            <td><?php echo ($tescale_d['Trat']); ?></td>
            <td><?php echo ($tescale_d['Ptt']); ?></td>
            <td><?php echo ($balisage_d); ?></td>
            <td><?php echo $stationement; ?></td>
            </tr>
            <?php
				$aa=1;
				
				do
				{
					if($aa==1)
					{
						$aa++;
						continue;					
					} ?>
				<tr class="center" align="center">
                    <td height="32"></td>
                    <td></td>
                    <td></td>
                    <td><?php echo ($tescale_d['Code_pt']); ?></td>
                    <td><?php echo ($tescale_d['Ad']); ?></td>
                    <td><?php echo ($tescale_d['Ch']); ?></td>
                    <td><?php echo ($tescale_d['Inf']); ?></td>
                    <td><?php echo ($tescale_d['Pec']); ?></td>
                    <td><?php echo ($tescale_d['Tra']); ?></td>
                    <td><?php echo ($tescale_d['Loc']); ?></td>
                    <td><?php echo ($tescale_d['Trat']); ?></td>
                    <td><?php echo ($tescale_d['Ptt']); ?></td>
                    <td></td>
                    <td></td>
                </tr>
				<?php
					$aa++;
                }while($tescale_d=mysqli_fetch_array($e_escale_d));
			?>
        </table>
  </div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">REDEVANCES A PAYER</div>
    <div class="panel-body">
    <table width="1098" height="104" border="0" cellspacing="0" class="w3-small w3-table-all">
  <tr class="blue-grey">
    <td width="41">SENS</td>
    <td width="123">ROUTE</td>
    <td width="82">ATTER</td>
    <td width="82">BALISAGE</td>
    <td width="82">FRET</td>
    <td width="82">PASSAGER</td>
    <td width="82">PEC</td>
    <td width="82">STATIONNEMENT</td>
    <td width="82">COMPT ENR</td>
    <td width="82">FORM</td>
    <td width="82">ASS ANT</td>
    <td width="82">SURETE</td>
    <td width="88">SECURITE</td>
  </tr>
  <tr>
    <td>A</td>
    <td><?php echo arrondie($route_a); ?></td>
    <td><?php echo arrondie($red_att_a); ?></td>
    <td><?php echo arrondie($red_bal_a); ?></td>
    <td><?php echo arrondie($red_fret_a); ?></td>
    <td><?php echo arrondie($red_pass_a); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo arrondie($red_compt_a); ?></td>
    <td><?php echo arrondie($red_formu_a); ?></td>
    <td>&nbsp;</td>
    <td><?php echo $red_sur_a; ?></td>
    <td><?php echo $red_sec_a; ?></td>
  </tr>
  <tr>
    <td>D</td>
    <td><?php echo arrondie($route_d); ?></td>
    <td><?php echo arrondie($red_att_d); ?></td>
    <td><?php echo arrondie($red_bal_d); ?></td>
    <td><?php echo arrondie($red_fret_d); ?></td>
    <td><?php echo arrondie($red_pass_d); ?></td>
    <td><?php echo arrondie($red_pec); ?></td>
    <td><?php
			echo arrondie($red_stat);
			//echo $heure*$ttarif[''];
		?>    </td>
    <td><?php echo arrondie($red_compt_d); ?></td>
    <td><?php echo arrondie($red_formu_d); ?></td>
    <td><?php echo arrondie($red_assantinc_d); ?></td>
    <td><?php echo arrondie($red_sur_d); ?></td>
    <td><?php echo arrondie($red_sec_d); ?></td>
  </tr>
  <tr class="red lighten-3">
    <td>&nbsp;</td>
    <td><?php $tot_red_rout=($route_a)+($route_d); echo arrondie($tot_red_rout); ?></td>
    <td><?php $tot_red_att=($red_att_a); echo (arrondie($tot_red_att)); ?></td>
    <td><?php $tot_red_bal=($red_bal_a+$red_bal_d); echo (arrondie($tot_red_bal)); ?></td>
    <td><?php $tot_red_fret=($red_fret_a+$red_fret_d); echo (arrondie($tot_red_fret)); ?></td>
    <td><?php $tot_red_pass=($red_pass_a+$red_pass_d); echo (arrondie($tot_red_pass)); ?></td>
    <td><?php $tot_red_pec=($red_pec); echo (arrondie($tot_red_pec)); ?></td>
    <td><?php $tot_red_stat=($red_stat); echo (arrondie($tot_red_stat)); ?></td>
    <td><?php $tot_red_compt=($red_compt_a+$red_compt_d); echo (arrondie($tot_red_compt)); ?></td>
    <td><?php $tot_red_formu=($red_formu_a+$red_formu_d); echo (arrondie($tot_red_formu)); ?></td>
    <td><?php $tot_red_assantinc=($red_assantinc_d); echo (arrondie($tot_red_assantinc)); ?></td>
    <td><?php $tot_red_sur=($red_sur_d); echo (arrondie($tot_red_sur)); ?></td>
    <td><?php $tot_red_sec=($red_sec_d); echo (arrondie($tot_red_sec)); ?></td>
  </tr>
</table>

	<div class="mt-3 bold">
    Au taux de : <?php echo $taux['Usd_fc']; ?>
    </div>
	<div class="row w-75 mt-2 fs-12 panel-body">
    	<div class="col s12 m5 w3-border">
        	<div class="row p-05">
            	<div class="col s12 m7">
                	Montant hors taxe en US:
                </div>
                <div class="col s12 m5">
                  <?php 
					$tot_sans_tva=$tot_red_rout+$tot_red_att+$tot_red_bal+$tot_red_fret+$tot_red_pass+$tot_red_pec+$tot_red_stat+$tot_red_compt+$tot_red_formu+$tot_red_assantinc+$tot_red_sur+$tot_red_sec; echo arrondie($tot_sans_tva); 
					?>
                </div>
          </div>
        </div>
        <div class="col s12 m2 center">
        	EQUIVALENT A 
        </div>
        <div class="col s12 m5 w3-border">
        	<div class="p-05 row">
        	  <?php 
					$tot_sans_tva_fc=$tot_sans_tva*$taux['Usd_fc'];
					echo arrondie($tot_sans_tva*$taux['Usd_fc']); 
				?>
        	</div>
      </div>
    </div>
    <!--============ ESPACE POUR TVA ================-->
    <div class="row w-75 mt-2 fs-12 panel-body">
    	<div class="col s12 m5 w3-border">
        	<div class="row p-05">
            	<div class="col s12 m7">
                	TVA
              </div>
                <div class="col s12 m5">
                  <?php 
						$tva=(($tot_sans_tva*16)/100); 
						$tva_fc=($tva*$taux['Usd_fc']);
						echo arrondie($tva); 
					?>
                </div>
          </div>
        </div>
        <div class="col s12 m2 center">
        	EQUIVALENT A 
        </div>
        <div class="col s12 m5 w3-border">
        	<div class="p-05 row"><?php echo arrondie($tva_fc); ?></div>
        </div>
    </div>
    <!--============ ESPACE TOTAL AVEC TVA ================-->
    <div class="row w-75 mt-2 fs-12 panel-body">
    	<div class="col s12 m5 w3-border">
        	<div class="row p-05">
            	<div class="col s12 m7">
                	MONTANT TOUTES LES TAXES COMPRISES EN US
                </div>
                <div class="col s12 m5">
                	<?php 
						$tot_avec_tva=$tot_sans_tva+$tva;
						$tot_avec_tva_fc=$tot_sans_tva_fc+$tva_fc;
					 	echo arrondie($tot_avec_tva); 
					 ?>
                </div>
            </div>
        </div>
        <div class="col s12 m2 center">
        	EQUIVALENT A 
        </div>
        <div class="col s12 m5 w3-border">
        	<div class="p-05 row"><?php echo (arrondie($tot_avec_tva_fc)); ?></div>
        </div>
    </div>
    
    <div class="center">
    	<button class="btn btn-success" onclick="imprimer_fact_cash('<?php echo $id_mouv; ?>','<?php  echo $num_mouv;?>');">IMPRIMER</button>
    </div>
    
  </div>
</div>