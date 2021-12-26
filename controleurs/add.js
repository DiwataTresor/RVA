var mainUrlAjout=mainUrl+"modeles/add.php";
function ajout(v,v2,v3) {
	fermer_modal();
	popup_loading();
	var sens="";
	var num_fic=0;
	switch(v)
	{
		case "client":
			$.ajax({
				url:mainUrlAjout,
				type:'POST',
				data:
				{
					"ent":"client",
					"id":$("#cli_id").val(),
					"nom":$("#cli_nom").val(),
					"tel":$("#cli_tel").val(),
					"adr":$("#cli_adr").val(),
					"ville":$("#cli_ville").val(),
					"boite_post":$("#cli_boite_post").val(),
					"type_cl":$("#cli_type_cl").val(),
					"code_nat":$("#cli_code_nat").val(),
				},
				error:function(data)
				{
					connexion_serveur();
				},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success'><h4><i class='fa fa-check'></i>&nbsp;Client bien enregistré</h4></div>");
						$("input [type='text']").val("");
					}else if(data==3)
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Ces données sont déjà enregistrées</h4></div>");	
					}else
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Echec d'enregistrement</h4></div>");
					}
				},
			});
		break;
		case "type_av":
		
			$.ajax({
				url:mainUrlAjout,
				type:'POST',
				data:
				{
					"ent":"type_av",
					"typeav_type":$("#typeav_type").val(),
					"typeav_mtow":$("#typeav_mtow").val(),
					"typeav_nbrmoteur":$("#typeav_nbrmoteur").val(),
					"typeav_maxipayload":$("#typeav_maxipayload").val(),
					"typeav_version":$("#typeav_version").val(),
					"typeav_plmin":$("#typeav_plmin").val(),
					"typeav_plmax":$("#typeav_plmax").val(),
				},
				error:function(data)
				{
					connexion_serveur();
				},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success'><h4><i class='fa fa-check'></i>&nbsp;Type avion bien enregistré</h4></div>");
						$("input [type='text']").val("");
					}else
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Echec d'enregistrement</h4></div>");
					}
				},
			});
		break;
		case "immatriculation":
		
			$.ajax({
				url:mainUrlAjout,
				type:'POST',
				data:
				{
					"ent":"immatriculation",
					"imm_code":$("#imm_code").val(),
					"imm_pr":$("#imm_pr").val(),
					"imm_typeav":$("#imm_typeav").val(),
					"imm_tonn":$("#imm_tonn").val(),
					"imm_siege":$("#imm_siege").val(),
				},
				error:function(data)
				{
					connexion_serveur();
				},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success'><h4><i class='fa fa-check'></i>&nbsp;Immatriculation bien enregistrée</h4></div>");
						$("input[type='text']").val("");
						immatriculation_liste();
					}else if(data==3)
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Ces données sont déjà enregistrées</h4></div>");	
					}else
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Echec d'enregistrement</h4></div>");
					}
				},
			});
		break;
		case "route":		
			$.ajax({
				url:mainUrlAjout,
				type:'POST',
				data:
				{
					"ent":"route",
					"route_prov":$("#route_prov").val(),
					"route_dest":$("#route_dest").val(),
					"route_trajet":$("#route_trajet").val(),
					"route_libelle":$("#route_libelle").val(),
				},
				error:function(data)
				{
					connexion_serveur();
				},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success'><h4><i class='fa fa-check'></i>&nbsp;Route bien crééé</h4></div>");
						$("input").val("");
						route_pt_liste();
					}else
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Echec d'enregistrement</h4></div>");
					}
				},
			});
		break;
		case "taux":			
				$.ajax({
					url:mainUrlAjout,
					type:"POST",
					data:{"ent":"taux","dt":$("#dt").val(),"fc_usd":$("#fc_usd").val(),"usd_fc":$("#usd_fc").val()},
					error:function(data){connexion_serveur();},
					success:function(data)
					{
						fermer_modal();
						if(data==1)
						{
							ouvrir_modal("<div class='alert alert-success'><h4><i class='fa fa-check'></i>&nbsp;Taux mise à jour</h4></div>");
							$("#vl").val("");
							dernier_taux();
							$("#fc_usd").val("");
							$("#usd_fc").val("");
						}else
						{
							ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Echec de mise à jour</h4></div>");
						}
					},
				});
		break;
		case "tarif_red":
			$.ajax({
		        url:mainUrlAjout,
		        type:"POST",
		        data:{
		            "ent":"tarif_red",
		            "tva":$("#tva").val(),
		            "cpt_enr":$("#cpt_enr").val(),
		            "redbal":$("#redbal").val(),
		            "redsec":$("#redsec").val(),
		            "assantinc":$("#assantinc").val(),
		            "redsur":$("#redsur").val(),
		            "redsur_form":$("#redsur_form").val(),
		            "redsur_aero":$("#redsur_aero").val(),
		            "redsur_int":$("#redsur_int").val(),
		            "resdsur_nat":$("#resdsur_nat").val(),
		            "redfr_int":$("#redfr_int").val(),
		            "redfr_nat":$("#redfr_nat").val(),
		            "redfr_int_idf_emb":$("#redfr_int_idf_emb").val(),
		            "redfr_int_idf_deb":$("#redfr_int_idf_deb").val(),
		            "redfr_nat_idf_emb":$("#redfr_nat_idf_emb").val(),
		            "redfr_nat_idf_deb":$("#redfr_nat_idf_deb").val(),
		            "redpass_pascorri":$("#redpass_pascorri").val(),
		            "redpass_rdom":$("#redpass_rdom").val(),
		            "redpass_int":$("#redpass_int").val(),
		            "redpass_int_idf":$("#redpass_int_idf").val(),
		            "redpass_nat":$("#redpass_nat").val(),
		            "redpass_nat_idf":$("#redpass_nat_idf").val(),
		            "redrou_sup_245":$("#redrou_sup_245").val(),
		            "redrou_inf_245":$("#redrou_inf_245").val(),
		            "redrou_vol_int":$("#redrou_vol_int").val(),
		            "redstat_tarmac":$("#redstat_tarmac").val(),
		            "redstat_garage":$("#redstat_garage").val(),
		            "redatt_1_25_int":$("#redatt_1_25_int").val(),
		            "redatt_1_25_nat":$("#redatt_1_25_nat").val(),
		            "redatt_26_75_int":$("#redatt_26_75_int").val(),
		            "redatt_26_75_nat":$("#redatt_26_75_nat").val(),
		            "redatt_sup_75_int":$("#redatt_sup_75_int").val(),
		            "redatt_sup_75_nat":$("#redatt_sup_75_nat").val(),
		            "redatt_ton_min_int":$("#redatt_ton_min_int").val(),
		            "redatt_ton_min_nat":$("#redatt_ton_min_nat").val()
		        },
		        error:function(data){connexion_serveur()},
		        success:function(data)
		        {
		        	fermer_modal();
		        	if(data==1)
		        	{
		        		ouvrir_modal("<div class='alert alert-success'><i class='fa fa-check'></i>&nbsp;Bien modifi&eacute;</div>");
		        		tarif_redevance();
		        	}else
		        	{
		        		ouvrir_modal("<div class='alert alert-warning'><i class='fa fa-check'></i>Eche de modification</div>");
		        	}
		        },
    		});
		break;
		case "point_entree":
			$.ajax({
				url:mainUrlAjout,
				type:"POST",
				data:{"ent":"pt",
					"t":"P",
					"libelle":$("#pt_libelle").val(),
					"code":$("#pt_code").val(),
					"distance":$("#pt_distance").val(),
					"gere":"N"
				},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success'><h4><i class='fa fa-check'></i>&nbsp;Enregistrement correct</h4></div>");
						$("input").val("");
					}else if(data==3)
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Ce Point existe deja</h4></div>");
						route_pt_liste();
					}else
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Echec d'enregistrement</h4></div>");
					}
				},
			});
		break;
		case "emplacement":
			$.ajax({
				url:mainUrlAjout,
				type:"POST",
				data:{"ent":"pt",
					"t":"E",
					"libelle":$("#empl_libelle").val(),
					"code":$("#empl_code").val(),
					"distance":$("#empl_distance").val(),
					"gere":$("#gere").val()
				},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success'><h4><i class='fa fa-check'></i>&nbsp;Enregistrement correct</h4></div>");
						$("input[type='text']").val("");
					}else if(data==3)
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Ce Point existe deja</h4></div>");
					}else
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Echec d'enregistrement</h4></div>");
					}
				},
			});
		break;
		case "ville":
			$.ajax({
				url:mainUrlAjout,
				type:"POST",
				data:{"ent":"ville",
					"code":$("#code_ville").val(),
					"ville":$("#libelle_ville").val(),
					"gere":"N"
				},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success'><h4><i class='fa fa-check'></i>&nbsp;Enregistrement correct</h4></div>");
						$("input[type='text']").val("");
					}else if(data==3)
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Ce Point existe deja</h4></div>");
					}else
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Echec d'enregistrement</h4></div>");
					}
				},
			});
		break;
		case "type_acces":
			$code_acces=$("#code_acces").val();
			$designation_acces=$("#designation_acces").val();
			$.ajax({
				url:mainUrlAjout,
				type:"POST",
				data:{"ent":"type_acces","code_acces":$code_acces,"designation_acces":$designation_acces},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success'><h4><i class='fa fa-check'></i>&nbsp;Enregistrement bien &eacute;ffectu&eacute;</h4></div>");
						$("input[type='text']").val("");
						acces_liste();
					}else if(data==3)
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Cet accès existe deja</h4></div>");
					}else
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Echec d'enregistrement</h4></div>");
					}
				},
			});
		break;
		case "acces":
			$.ajax({
				url:mainUrlAjout,
				type:"POST",
				data:{"ent":"acces",
					"type_acces":$("#acces_liste").val(),
					"dt":$("#dt").val(),
					"heure":$("#heure").val(),
					"mt":$("#mt").val(),
					"monnaie":$("#monnaie").val(),
					"quittance":$("#quittance").val(),
					"tva":$("#tva").val()
				},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success'><h4><i class='fa fa-check'></i>&nbsp;Enregistrement bien &eacute;ffectu&eacute;</h4></div>");
						$("input[type='text']").val("");	
						$("select").val("");
					}else
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Echec d'enregistrement</h4></div>");
					}
				},
			});
		break;
		case "rda":
			$.ajax({
				url:mainUrlAjout,
				type:"POST",
				data:{"ent":"rda",
					"client":$("#client").val(),
					"dt":$("#dt").val(),
					"heure":$("#heure").val(),
					"mt":$("#mt").val(),
					"monnaie":$("#monnaie").val(),
					"quittance":$("#quittance").val()
				},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success'><h4><i class='fa fa-check'></i>&nbsp;Enregistrement bien &eacute;ffectu&eacute;</h4></div>");
						$("input[type='text']").val("");	
						$("select").val("");
					}else
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Echec d'enregistrement</h4></div>");
					}
				},
			});
		break;
		case "supp_rda":
			$.ajax({
				url:mainUrlAjout,
				type:"POST",
				data:{"ent":"supp_rda",
					"facture":$("#facture").val(),
					"mt":$("#mt").val(),
					"monnaie":$("#monnaie").val(),
					"motif":$("#motif").val(),
					"quittance":$("#quittance").val()
				},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success'><h4><i class='fa fa-check'></i>&nbsp;Enregistrement bien &eacute;ffectu&eacute;</h4></div>");
						$("input[type='text']").val("");	
						$("select").val("");
					}else
					{
						ouvrir_modal("<div class='alert alert-warning'><h4><i class='fa fa-warning'></i>&nbsp;Echec d'enregistrement</h4></div>");
					}
				},
			});
		break;
		case "mouvement":
			fermer_modal();
			ouvrir_modal("<div class='bold fs-15 center'>Voulez-vous vraiment enregistrer ce mouvement ?</div>"+
					"<p class='center mt-1'>"+
						'<button class="blue btn waves waves-effect" onclick="ajout('+"'"+"mouvement_conf"+"'"+');"><i class="fa fa-check-circle"></i>&nbsp;Enregistrer</button>&nbsp;'+
						"<button class='blue btn waves waves-effect' onclick='fermer_modal();'><i class='fa fa-check-circle'></i>&nbsp;Annuler</button>&nbsp;"+
					"</p>");
		break;
		case "mouvement_conf":
			$.ajax({
				url:mainUrlAjout,
				type:"POST",
				data:
				{
					"ent":"mouvement",
					"sens":$("#sens").val(),
					"dt_mouv":$("#dt_mouv").val(),
					"heure_mouv":$("#heure_mouv").val(),
					"imm":$("#imm").val(),
					"temps":$("#temps").val(),
					"categ":$("#categ").val(),
					"nv_vol":$("#nv_vol").val(),
					"esc1_aero":$("#esc1_aero").val(),
					"esc1_esc":$("#esc1_esc").val(),
					"esc1_pt_ent":$("#esc1_pt_ent").val(),
					"esc1_ad":$("#esc1_ad").val(),
					"esc1_ch":$("#esc1_ch").val(),
					"esc1_inf":$("#esc1_inf").val(),
					"esc1_tra":$("#esc1_tra").val(),
					"esc1_pec":$("#esc1_pec").val(),
					"esc1_loc":$("#esc1_loc").val(),
					"esc1_trat":$("#esc1_trat").val(),
					"esc1_ptt":$("#esc1_ptt").val(),

					"esc2_aero":$("#esc2_aero").val(),
					"esc2_esc":$("#esc2_esc").val(),
					"esc2_pt_ent":$("#esc2_pt_ent").val(),
					"esc2_ad":$("#esc2_ad").val(),
					"esc2_ch":$("#esc2_ch").val(),
					"esc2_inf":$("#esc2_inf").val(),
					"esc2_tra":$("#esc2_tra").val(),
					"esc2_pec":$("#esc2_pec").val(),
					"esc2_loc":$("#esc2_loc").val(),
					"esc2_trat":$("#esc2_trat").val(),
					"esc2_ptt":$("#esc2_ptt").val(),

					"esc3_aero":$("#esc3_aero").val(),
					"esc3_escale":0,
					"esc3_pt_ent":$("#esc3_pt_ent").val(),
					"esc3_ad":$("#esc3_ad").val(),
					"esc3_ch":$("#esc3_ch").val(),
					"esc3_inf":$("#esc3_inf").val(),
					"esc3_tra":$("#esc3_tra").val(),
					"esc3_pec":$("#esc3_pec").val(),
					"esc3_loc":$("#esc3_loc").val(),
					"esc3_trat":$("#esc3_trat").val(),
					"esc3_ptt":$("#esc3_ptt").val(),

					"esc4_aero":$("#esc4_aero").val(),
					"esc4_esc":$("#esc4_esc").val(),
					"esc4_pt_ent":$("#esc4_pt_ent").val(),
					"esc4_ad":$("#esc4_ad").val(),
					"esc4_ch":$("#esc4_ch").val(),
					"esc4_inf":$("#esc4_inf").val(),
					"esc4_tra":$("#esc4_tra").val(),
					"esc4_pec":$("#esc4_pec").val(),
					"esc4_loc":$("#esc4_loc").val(),
					"esc4_trat":$("#esc4_trat").val(),
					"esc4_ptt":$("#esc4_ptt").val(),

					"esc5_aero":$("#esc5_aero").val(),
					"esc5_esc":$("#esc5_esc").val(),
					"esc5_pt_ent":$("#esc5_pt_ent").val(),
					"esc5_ad":$("#esc5_ad").val(),
					"esc5_ch":$("#esc5_ch").val(),
					"esc5_inf":$("#esc5_inf").val(),
					"esc5_tra":$("#esc5_tra").val(),
					"esc5_pec":$("#esc5_pec").val(),
					"esc5_loc":$("#esc5_loc").val(),
					"esc5_trat":$("#esc5_trat").val(),
					"esc5_ptt":$("#esc5_ptt").val(),

					"ex_att":$("#ex_att").val(),
					"ex_stt":$("#ex_stt").val(),
					"ex_stg":$("#ex_stg").val(),
					"ex_bal":$("#ex_bal").val(),
					"ex_pax":$("#ex_pax").val(),
					"ex_fret":$("#ex_fret").val(),
					"ex_route":$("#ex_route").val()
				},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success fs-15'>enregistrement bien effectu&eacute;</div>");
						$("input [type='text']").val(0);
					}else if(data==0)
					{
						ouvrir_modal("<div class='alert alert-warning'><i class='fa fa-warning'></i>&nbsp;Echec d'enregistrement</div>");
					}else if(data==3)
					{
						ouvrir_modal("<div class='alert alert-danger'>Ce mouvement existe d&eacute;ja</div>");
					}
				},
			});
		break;
		case "vol_nat_arr":
			localStorage.setItem("sens","A");
			//localStorage.setItem("num_fich",$("#num_fic").val());
			$.ajax({
				url:mainUrlAjout,
				type:'POST',
				data:{'ent':'vol_nat_arr',
					"client":$("#client").val(),
					"num_form":$("#num_form").val(),
					"num_fic":$("#num_fic").val(),
					"sens":localStorage.getItem("sens"),

					"type_vol":'N',
					"temps":$("#nat_arr_temps").val(),
					"categ_vol":$("#nat_arr_categ").val(),
					"compt_enr":0,
					"formu":0,
					"niv":$("#nat_arr_niv").val(),
					"stat":0,
					"anti_inc":'N',					
					"dt":$("#nat_arr_dt").val(),
					"heure":$("#nat_arr_heure").val(),

					"pt":$("#esc1_ville").val(),
					"ad":$("#esc1_ad").val(),
					"ch":$("#esc1_ch").val(),
					"inf":$("#esc1_inf").val(),
					"tra":$("#esc1_tra").val(),
					"pec":$("#esc1_pec").val(),
					"loc":$("#esc1_loc").val(),
					"ptt":$("#esc1_ptt").val(),
					"trat":$("#esc1_trat").val(),

					"ex_att_nat_arr":$("#ex_att_nat_arr").val(),
					"ex_stt_nat_arr":$("#ex_stt_nat_arr").val(),
					"ex_stg_nat_arr":$("#ex_stg_nat_arr").val(),
					"ex_bal_nat_arr":$("#ex_bal_nat_arr").val(),
					"ex_pax_nat_arr":$("#ex_pax_nat_arr").val(),
					"ex_fret_nat_arr":$("#ex_fret_nat_arr").val(),
					"ex_route_nat_arr":$("#ex_route_nat_arr").val(),
				},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						$("#esc2_sens").val("A");
						$("#esc2_num_fic").val($("#num_fic").val());
						ouvrir_modal("<div>"+
						"<div class='alert alert-success center fs-15'>Bien enregistr&eacute;</div>"+
						"<p class=' center fs-15'>Voulez-vous saisir encore une escale</p>"+
						'<p class="center"><button class="btn btn-success" onclick="ajout_esc('+"'"+"A"+"'"+","+"'"+$("#num_fic").val()+"'"+')">Oui</button>&nbsp;'+
						'<button class="btn btn-warning" onclick="fermer_modal();">Non</button></p>'+
						"</div>");
					}else if(data==3)
					{
						ouvrir_modal("<div class='alert alert-danger center fs-2'><i class='glyphicon glyphicon-remove-circle'></i> Ce mouvement est suspect ce vol est déjà enregistré</div>");
					}else
					{
						ouvrir_modal("<div class='alert alert-danger fs-2'><i class='fa fa-times-circle'></i> "+data+"</div>");
					}
				},
			});
		break;
		case "vol_nat_dep":
			
			localStorage.setItem("sens","D");
			//localStorage.setItem("num_fich",$("#num_fic").val());
			$.ajax({
				url:mainUrlAjout,
				type:'POST',
				data:{'ent':'vol_nat_dep',
					"client":$("#client").val(),
					"num_fic":$("#num_fic").val(),
					"num_form":$("#num_form").val(),
					"sens":localStorage.getItem("sens"),

					"type_vol":'N',
					"temps":$("#nat_dep_temps").val(),
					"categ_vol":$("#nat_dep_categ").val(),
					"compt_enr":$("#nat_dep_compt_enr").val(),
					"formu":$("#nat_dep_form").val(),
					"niv":$("#nat_dep_niv").val(),
					"stat":$("#nat_dep_stat").val(),
					"anti_inc":$("#nat_dep_anti_inc").val(),
					
					"dt":$("#nat_dep_dt").val(),
					"heure":$("#nat_dep_heure").val(),

					"dt_arr":$("#nat_arr_dt").val(),
					"heure_arr":$("#nat_arr_heure").val(),

					"pt":$("#esc1dep_ville").val(),
					"ad":$("#esc1dep_ad").val(),
					"ch":$("#esc1dep_ch").val(),
					"inf":$("#esc1dep_inf").val(),
					"tra":$("#esc1dep_tra").val(),
					"pec":$("#esc1dep_pec").val(),
					"loc":$("#esc1dep_loc").val(),
					"ptt":$("#esc1dep_ptt").val(),
					"trat":$("#esc1dep_trat").val(),

					"ex_att_nat_arr":$("#ex_att_nat_dep").val(),
					"ex_stt_nat_arr":$("#ex_stt_nat_dep").val(),
					"ex_stg_nat_arr":$("#ex_stg_nat_dep").val(),
					"ex_bal_nat_arr":$("#ex_bal_nat_dep").val(),
					"ex_pax_nat_arr":$("#ex_pax_nat_dep").val(),
					"ex_fret_nat_arr":$("#ex_fret_nat_dep").val(),
					"ex_route_nat_arr":$("#ex_route_nat_dep").val(),
				},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						$("#esc2_sens").val("D");
						$("#esc2_num_fic").val($("#num_fic").val());
						ouvrir_modal("<div>"+
						"<div class='alert alert-success center fs-15'>Bien enregistr&eacute;</div>"+
						"<p class=' center fs-15'>Voulez-vous saisir encore une escale</p>"+
						'<p class="center"><button class="btn btn-success" onclick="ajout_esc('+"'"+"A"+"'"+","+"'"+$("#num_fic").val()+"'"+')">Oui</button>&nbsp;'+
						'<button class="btn btn-warning" onclick="fermer_modal();">Non</button></p>'+
						"</div>");
					}else if(data==3)
					{
						ouvrir_modal("<div class='alert alert-danger center fs-2'><i class='glyphicon glyphicon-remove-circle'></i> Ce mouvement est suspect ce vol est déjà enregistré</div>");
					}else
					{
						ouvrir_modal("<div class='alert alert-danger fs-2'><i class='fa fa-times-circle'></i> "+data+"</div>");
					}
				},
			});
		break;
		case "vol_int_arr":
			localStorage.setItem("sens","A");
			//localStorage.setItem("num_fich",$("#num_fic").val());
			$.ajax({
				url:mainUrlAjout,
				type:'POST',
				data:{'ent':'vol_int_arr',
					"client":$("#client").val(),
					"num_fic":$("#num_fic").val(),
					"num_form":$("#num_form").val(),
					"sens":localStorage.getItem("sens"),

					"type_vol":'I',
					"temps":$("#int_arr_temps").val(),
					"categ_vol":$("#int_arr_categ").val(),
					"compt_enr":0,
					"formu":0,
					"niv":$("#int_arr_niv").val(),
					"stat":0,
					"anti_inc":"N",
					
					"dt":$("#int_arr_dt").val(),
					"heure":$("#int_arr_heure").val(),

					"ville":$("#inter_arr_ville").val(),
					"pt":$("#inter_arr_pt").val(),
					"ad":$("#inter_arr_ad").val(),
					"ch":$("#inter_arr_ch").val(),
					"inf":$("#inter_arr_inf").val(),
					"tra":$("#inter_arr_tra").val(),
					"pec":$("#inter_arr_pec").val(),
					"loc":$("#inter_arr_loc").val(),
					"ptt":$("#inter_arr_ptt").val(),
					"trat":$("#inter_arr_trat").val(),

					"ex_att_int_arr":$("#ex_att_int_arr").val(),
					"ex_stt_int_arr":$("#ex_stt_int_arr").val(),
					"ex_stg_int_arr":$("#ex_stg_int_arr").val(),
					"ex_bal_int_arr":$("#ex_bal_int_arr").val(),
					"ex_pax_int_arr":$("#ex_pax_int_arr").val(),
					"ex_fret_int_arr":$("#ex_fret_int_arr").val(),
					"ex_route_int_arr":$("#ex_route_int_arr").val(),
				},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
					
						ouvrir_modal("<div>"+
						"<div class='alert alert-success center fs-15'>Bien enregistr&eacute;</div>"+
						"<p class=' center fs-15'>Voulez-vous saisir encore une escale</p>"+
						'<p class="center"><button class="btn btn-success" onclick="ajout_esc('+"'"+"A"+"'"+","+"'"+$("#num_fic").val()+"'"+')">Oui</button>&nbsp;'+
						'<button class="btn btn-warning" onclick="fermer_modal();">Non</button></p>'+
						"</div>");
					}else if(data==3)
					{
						ouvrir_modal("<div class='alert alert-danger center fs-2'><i class='glyphicon glyphicon-remove-circle'></i> Ce mouvement est suspect, ce vol est déjà enregistré</div>");
					}else
					{
						ouvrir_modal("<div class='alert alert-danger fs-2'><i class='fa fa-times-circle'></i> "+data+"</div>");
					}
				},
			});
		break;
		case "vol_int_dep":
			localStorage.setItem("sens","D");
			//localStorage.setItem("num_fich",$("#num_fic").val());
			$.ajax({
				url:mainUrlAjout,
				type:'POST',
				data:{'ent':'vol_int_arr',
					"client":$("#client").val(),
					"num_fic":$("#num_fic").val(),
					"num_form":$("#num_form").val(),
					"sens":localStorage.getItem("sens"),

					"type_vol":'I',
					"temps":$("#int_dep_temps").val(),
					"categ_vol":$("#int_dep_categ").val(),
					"compt_enr":$("#int_dep_compt_enr").val(),
					"formu":$("#int_dep_form").val(),
					"niv":$("#int_dep_niv").val(),
					"stat":$("#int_dep_stat").val(),
					"anti_inc":$("#int_dep_anti_inc").val(),
					
					"dt":$("#int_dep_dt").val(),
					"heure":$("#int_dep_heure").val(),

					"ville":$("#inter_dep_ville").val(),
					"pt":$("#inter_dep_pt").val(),
					"ad":$("#inter_dep_ad").val(),
					"ch":$("#inter_dep_ch").val(),
					"inf":$("#inter_dep_inf").val(),
					"tra":$("#inter_dep_tra").val(),
					"pec":$("#inter_dep_pec").val(),
					"loc":$("#inter_dep_loc").val(),
					"ptt":$("#inter_dep_ptt").val(),
					"trat":$("#inter_dep_trat").val(),

					"ex_att_int_arr":$("#ex_att_int_dep").val(),
					"ex_stt_int_arr":$("#ex_stt_int_dep").val(),
					"ex_stg_int_arr":$("#ex_stg_int_dep").val(),
					"ex_bal_int_arr":$("#ex_bal_int_dep").val(),
					"ex_pax_int_arr":$("#ex_pax_int_dep").val(),
					"ex_fret_int_arr":$("#ex_fret_int_dep").val(),
					"ex_route_int_arr":$("#ex_route_int_dep").val(),
				},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
					
						ouvrir_modal("<div>"+
						"<div class='alert alert-success center fs-15'>Bien enregistr&eacute;</div>"+
						"<p class=' center fs-15'>Voulez-vous saisir encore une escale</p>"+
						'<p class="center"><button class="btn btn-success" onclick="ajout_esc('+"'"+"A"+"'"+","+"'"+$("#num_fic").val()+"'"+')">Oui</button>&nbsp;'+
						'<button class="btn btn-warning" onclick="fermer_modal();">Non</button></p>'+
						"</div>");
					}else if(data==3)
					{
						ouvrir_modal("<div class='alert alert-danger center fs-2'><i class='glyphicon glyphicon-remove-circle'></i> Ce mouvement est suspect ce vol est déjà enregistré</div>");
					}else
					{
						ouvrir_modal("<div class='alert alert-danger fs-2'><i class='fa fa-times-circle'></i> "+data+"</div>");
					}
				},
			});
		break;
		case "escale":
			$.ajax({
				url:mainUrlAjout,
				type:'POST',
				data:{'ent':'escale',					
					"num_fic":localStorage.getItem("num_fic"),
					"sens":localStorage.getItem("sens"),
					"pt":$("#escajout_ville").val(),
					"ad":$("#escajout_ad").val(),
					"ch":$("#escajout_ch").val(),
					"inf":$("#escajout_inf").val(),
					"tra":$("#escajout_tra").val(),
					"pec":$("#escajout_pec").val(),
					"loc":$("#escajout_loc").val(),
					"ptt":$("#escajout_ptt").val(),
					"trat":$("#escajout_trat").val()
				},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{	
						$("#popup_esc input").val("");
						$("#popup_esc select").val("");

						ouvrir_modal("<div>"+
						"<p class='alert alert-succes center fs-15'>Bien enregistr&eacute;</p>"+
						"<p class=' center fs-15'>Voulez-vous saisir encore une escale</p>"+
						'<p class="center"><button class="btn btn-success" onclick="ajout_esc('+"'"+$("#esc2_sens").val()+"'"+","+"'"+$("#esc2_num_fic").val()+"'"+')">Oui</button>&nbsp;'+
						'<button class="btn btn-warning" onclick="fermer_modal();">Non</button></p>'+
						"</div>");
					}else
					{
						ouvrir_modal("<div class='alert alert-warning fs-15'>Echec d'enregistrement, veuillez reesayer</div>");
					}
				},
			});
		break;
		case "user":
			if($("#mdp").val()==$("#mdp2").val())
			{
				$.ajax({
					url:mainUrlAjout,
					type:"POST",
					data:{"ent":"user",
						"nom":$("#nom").val(),
						"matr":$("#matr").val(),
						"priv":$("#priv").val(),
						"login":$("#login").val(),
						"mdp":$("#mdp").val(),
					},
					error:function(data){connexion_serveur()},
					success:function(data)
					{
						alert(data);
						fermer_modal();
						if (data==1) {
							ouvrir_modal("<div class='alert alert-success fs-15 bold center'><i class='fa fa-check'></i> Nouvel utilisateur bien cr&eacute;é</div>");
							$("form").reset();
						}else if(data==3)
						{
							ouvrir_modal("<div class='alert alert-warning fs-15 bold center'>Ce login d'utilisateur existe d&eacuteja</div>");
						}else
						{
							ouvrir_modal("<div class='alert alert-danger fs-15 bold center'>Echec d'ajout veuillez contacter l'administrateur</div>");
						}
					},
				});
			}else
			{
				fermer_modal();
				ouvrir_modal("<div class='alert alert-warning fs-15 bold center'>Les 2 mots de passe ne correspondent pas</div>");
			}
		break;
		case "idf":
			$.ajax({
				url:mainUrlAjout,
				type:"POST",
				data:{"ent":"idf",
					"dt":$("#dt").val(),
					'client':$("#client").val(),
					"mt":$("#mt").val(),
					"monn":$("#monn").val(),
					"quittance":$("#quittance").val()
				},
				error:function(data){connexion_serveur()},
				success:function(data){
					fermer_modal();
					ouvrir_modal("<div class='alert alert-success center bold fs-15'>IDF bien enregistr&eacute;</div>");
					$("input").val("");
				},
			});
		break;
	//================= FINANCE ============
		case "depense":
			$motif=$("#motif_dep").val();
			$mt=$("#mt_dep").val();
			$monn=$("#monn_dep").val();
			$.ajax({
				url:mainUrlAjout,
				type:'POST',
				data:{"ent":"depense","motif":$motif,"mt":$mt,"monn":$monn},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success center bold fs-15'>D&eacute;pense bien enregistr&eacute;</div>");
						$("#motif_dep").val("");
						$("#mt_dep").val("");
						user_dep_jour();
					}else
					{
						ouvrir_modal("<div class='alert alert-warning center bold fs-15'>Echec d'enregistrement</div>");
					}
				},
			});
		break;
		case "entree":
			$dt_ent=$("#dt").val();
			$type_ent=$("#type_ent").val();
			$mt=$("#mt_ent").val();
			$monn=$("#monn_ent").val();
			$observation=$("#observation_ent").val();
			$.ajax({
				url:mainUrlAjout,
				type:'POST',
				data:{"ent":"entree",
					"dt_ent":$dt_ent,
					"type_ent":$type_ent,
					"mt":$mt,
					"monn":$monn,
					"observation":$observation},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success center bold fs-15'><i class='fa fa-check-circle'></i> Entr&eacute;e bien enregistr&eacute;</div>");
						$("#motif_dep").val("");
						$("#mt_dep").val("");
						//user_entree_jour();
					}else
					{
						ouvrir_modal("<div class='alert alert-warning center bold fs-15'>Echec d'enregistrement</div>");
					}
				},
			});
		break;
		case "recouvrement":
			$dt_recouv=$("#dt_recouv").val();
			$client_recouv=$("#client_recouv").val();
			$mt=$("#mt_recouv").val();
			$monn=$("#monn_recouv").val();
			$observation=$("#observation_recouv").val();
			$.ajax({
				url:mainUrlAjout,
				type:'POST',
				data:{"ent":"recouvrement",
					"dt_recouv":$dt_recouv,
					"client_recouv":$client_recouv,
					"mt":$mt,
					"monn":$monn,
					"observation":$observation},
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success center bold fs-15'><i class='fa fa-check-circle'></i> Entr&eacute;e bien enregistr&eacute;</div>");
						$("input[type='text']").val("");
						$("select").val("");
						//user_entree_jour();
					}else
					{
						ouvrir_modal("<div class='alert alert-warning center bold fs-15'>Echec d'enregistrement</div>");
					}
				},
			});
		break;
	//===============  HANDLING =======================
		case "handleur":
			$nom=$('#handleur_nom').val();
			$code_hand=$('#handleur_code').val();
			$adresse=$('#handleur_adresse').val();
			$ville=$('#handleur_ville').val();
			$telephone=$('#handleur_telephone').val();
			$type_paie=$('#handleur_type_paie').val();
			$nationalite=$('#handleur_nationalite').val();
			$.ajax({
				url:mainUrlAjout,
				data:{"ent":"handleur","code_hand":$code_hand,"nom":$nom,"adresse":$adresse,'ville':$ville,"telephone":$telephone,"type_paie":$type_paie,"nationalite":$nationalite},
				type:"POST",
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success'><h4><i class='fa fa-check'></i>&nbsp;Handleur bien enregistré</h4></div>");
						$("input[type='text']").val("");
						handleur_liste();
					}else
					{
						ouvrir_modal("<div class='alert alert-danger'><h4><i class='fa fa-check'></i>&nbsp;Echec d'enregistrement</h4></div>");
					}
				},
			});
		break;
		case "handling_paiement":
			$fact=$("#fact").val();
			$poids=$("#poids").val();
			$mht=$("#mht").val();
			$tva=$("#tva").val();
			$mttc=$("#mttc").val();
			$.ajax({
				url:mainUrlAjout,
				type:"POST",
				data:{"ent":"handling_paiement","fact":$fact,"poids":$poids,"mht":$mht,"tva":$tva,"mttc":$mttc},
				error:function(data){notification_error("Pas de connexion au serveur")},
				success:function(data)
				{
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success'><h4><i class='fa fa-check'></i>&nbsp;Paiement bien éfféctué</h4></div>");
						ouvrir('handling_paiement_liste_fact');
						handling_facture($fact);
						

					}else
					{
						ouvrir_modal("<div class='alert alert-danger'><h4><i class='fa fa-check'></i>&nbsp;Echec de paiement</h4></div>");
					}
				
				}
			});
		break;
		case "signataire":
			$cmd=$('#cmd').val();
			$division=$('#division').val();
			$facturation=$('#facturation').val();
			$.ajax({
				url:mainUrlAjout,
				data:{"ent":"signataire","cmd":$cmd,"division":$division,'facturation':$facturation},
				type:"POST",
				error:function(data){connexion_serveur()},
				success:function(data)
				{
					fermer_modal();
					if(data==1)
					{
						ouvrir_modal("<div class='alert alert-success center bold fs-2'><i class='fa fa-check'></i> MISE A JOUR REUSSI</div>");
						signataire_liste();
					}else
					{
						ouvrir_modal("<div class='alert alert-danger center bold fs-2'>Echec de mise à jour</div>");
					}
				},
			});
		break;
		default:
			alert("rien");
		break;
	}
}

