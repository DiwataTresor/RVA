var mainUrlUpd=mainUrl+"modeles/upd.php";
function upd(v,vid,v1,v2,v3,v4,v5,v6,v7,v8,v9,v10)
{
	switch(v)
	{
		case "client":
			$("#id").val(vid);
			$("#cli_id").val(v1);
			$("#cli_nom").val(v2);
			$("#cli_tel").val(v3);
			$("#cli_adr").val(v4);
			$("#cli_ville").val(v5);
			$("#cli_boite_post").val(v6);
			$("#cli_type_cl").val(v7);
			$("#cli_code_nat").val(v8);
			
			$("#btn_enreg").hide();
			$("#btn_enreg").addClass('hide').show();
			$("#btn_modif").removeClass("hide");
			$("#btn_annuler").removeClass("hide");

			$("#btn_annuler").removeClass("hide").click(function(){
				$("#btn_enreg").removeClass('hide').show();
				$("#btn_modif").addClass("hide");
				$("#btn_annuler").addClass("hide");
				$("input").val("");
			});

			$("#btn_modif").removeClass("hide").show().click(function(){
				$id=$("#id").val();
				$code=$("#cli_id").val();
				$nom=$("#cli_nom").val();
				$tel=$("#cli_tel").val();
				$adr=$("#cli_adr").val();
				$ville=$("#cli_ville").val();
				$boite=$("#cli_boite_post").val();
				$type_cl=$("#cli_type_cl").val();
				$code_nat=$("#cli_code_nat").val();
				if($id!=="" && $code_nat!=="")
				{
					popup_loading();
					$.ajax({
						url:mainUrlUpd,
						type:"POST",
						data:{"ent":"client",
							"id":$id,
							"code":$code,
							"nom":$nom,
							"tel":$tel,
							"adr":$adr,
							"ville":$ville,
							"boite":$boite,
							"type_cl":$type_cl,
							"code_nat":$code_nat
						},
						error:function(data)
						{
							fermer_modal();
						},
						success:function(data)
						{
							
							fermer_modal();
							if(data==1)
							{
								$("input[type='text']").val("");
								ouvrir_modal("<h4 class='alert alert-success'><i class='fa fa-check'></i>&nbsp;Acte bien modifié</h4>");
								client_liste_cl();
							}else
							{
								ouvrir_modal("<h4 class='alert alert-warning'><i class='fa fa-times'></i>&nbsp;Echec de modification</h4>");
							}
						}
					});
				}else
				{

				}
			});	
		break;
		case "handleur":
			$("#id").val(vid);
			$("#handleur_nom").val(v1);
			$("#handleur_code").val(v2);
			$("#handleur_adresse").val(v3);
			$("#handleur_ville").val(v4);
			$("#handleur_telephone").val(v5);
			$("#handleur_type_paie").val(v6);
			$("#handleur_nationalite").val(v7);
			
			$("#btn_enreg").hide();
			$("#btn_enreg").addClass('hide').show();
			$("#btn_modif").removeClass("hide");
			$("#btn_annuler").removeClass("hide");

			$("#btn_annuler").removeClass("hide").click(function(){
				$("#btn_enreg").removeClass('hide').show();
				$("#btn_modif").addClass("hide");
				$("#btn_annuler").addClass("hide");
				$("input").val("");
			});

			$("#btn_modif").removeClass("hide").show().click(function(){
				$id=$("#id").val();
				$code=$("#handleur_code").val();
				$nom=$("#handleur_nom").val();
				$telephone=$("#handleur_telephone").val();
				$adresse=$("#handleur_adresse").val();
				$ville=$("#handleur_ville").val();
				$type_paie=$("#handleur_type_paie").val();
				$nationalite=$("#handleur_nationalite").val();
				if($id!=="" && $nationalite!=="" && $code!=="" && $nom!=="" && $type_paie!=="")
				{
					popup_loading();
					$.ajax({
						url:mainUrlUpd,
						type:"POST",
						data:{"ent":"handleur",
							"id":$id,
							"code":$code,
							"nom":$nom,
							"telephone":$telephone,
							"adresse":$adresse,
							"ville":$ville,
							"type_paie":$type_paie,
							"nationalite":$nationalite
						},
						error:function(data)
						{
							notification_warning("Pas de connexion au serveur");
						},
						success:function(data)
						{
							fermer_modal();
							if(data==1)
							{
								$("input[type='text']").val("");
								ouvrir_modal("<h4 class='alert alert-success'><i class='fa fa-check'></i>&nbsp;Handleur bien modifié</h4>");
								ouvrir("handleur");
							}else
							{
								notification_warning("Echec de modification handleur");
							}
						}
					});
				}else
				{

				}
			});	
		break;
		case "pt":
			location.href="#body";
			$("#pt_id").val(vid);
			$("#pt_libelle").val(v1);
			$("#pt_code").val(v2);
			$("#pt_distance").val(v3);
			$("#btn_enreg").hide();

			$("#btn_enreg").addClass('hide').show();
			$("#btn_modif").removeClass("hide");
			$("#btn_annuler").removeClass("hide");

			$("#btn_annuler").removeClass("hide").click(function(){
				$("#btn_enreg").removeClass('hide').show();
				$("#btn_modif").addClass("hide");
				$("#btn_annuler").addClass("hide");
				$("input").val("");
			});

			$("#btn_modif").removeClass("hide").show().click(function(){
				$id=$("#pt_id").val();
				$libelle=$("#pt_libelle").val();
				$code=$("#pt_code").val();
				$distance=$("#pt_distance").val();
				if($id!=="" && $libelle!=="" && $code!=="" && $distance!=="")
				{
					popup_loading();
					$.ajax({
						url:mainUrlUpd,
						type:"POST",
						data:{"ent":"pt",
							"id":$id,
							"libelle":$libelle,
							"code":$code,
							"distance":$distance
						},
						error:function(data)
						{
							fermer_modal();
						},
						success:function(data)
						{
							fermer_modal();
							if(data==1)
							{
								$("input[type='text']").val("");
								ouvrir_modal("<h4 class='alert alert-success'><i class='fa fa-check'></i>&nbsp;Acte bien modifié</h4>");
								route_pt_liste();
							}else
							{
								ouvrir_modal("<h4 class='alert alert-warning'><i class='fa fa-times'></i>&nbsp;Echec de modification</h4>");
							}
						}
					});
				}else
				{

				}
			});
		break;
		case "empl":
			location.href="#body";
			$("#empl_id").val(vid);
			$("#empl_libelle").val(v1);
			$("#empl_code").val(v2);
			$("#empl_distance").val(v3);
			$("#btn_enreg2").hide();

			$("#btn_enreg2").addClass('hide').show();
			$("#btn_modif2").removeClass("hide");
			$("#btn_annuler2").removeClass("hide");

			$("#btn_annuler2").removeClass("hide").click(function(){
				$("#btn_enreg2").removeClass('hide').show();
				$("#btn_modif2").addClass("hide");
				$("#btn_annuler2").addClass("hide");
				$("input").val("");
			});

			$("#btn_modif2").removeClass("hide").show().click(function(){
				$id=$("#empl_id").val();
				$libelle=$("#empl_libelle").val();
				$code=$("#empl_code").val();
				$distance=$("#empl_distance").val();
				$gere=$("#gere").val();
				if($id!=="" && $libelle!=="" && $code!=="" && $gere)
				{
					popup_loading();
					$.ajax({
						url:mainUrlUpd,
						type:"POST",
						data:{"ent":"empl",
							"id":$id,
							"libelle":$libelle,
							"code":$code,
							"distance":$distance,
							"gere":$gere
						},
						error:function(data)
						{
							fermer_modal();
						},
						success:function(data)
						{
							fermer_modal();
							if(data==1)
							{
								$("input[type='text']").val("");
								ouvrir_modal("<h4 class='alert alert-success'><i class='fa fa-check'></i>&nbsp;Acte bien modifié</h4>");
								route_empl_liste();
							}else
							{
								ouvrir_modal("<h4 class='alert alert-warning'><i class='fa fa-times'></i>&nbsp;Echec de modification</h4>");
							}
						}
					});
				}else
				{

				}
			});
		break;
		case "ville":
			location.href="#body";
			$("#ville_id").val(vid);
			$("#code_ville").val(v1);
			$("#libelle_ville").val(v2);
			
			$("#btn_enreg3").hide();
			$("#btn_enreg3").addClass('hide').show();
			$("#btn_modif3").removeClass("hide");
			$("#btn_annuler3").removeClass("hide");

			$("#btn_annuler3").removeClass("hide").click(function(){
				$("#btn_enreg3").removeClass('hide').show();
				$("#btn_modif3").addClass("hide");
				$("#btn_annuler3").addClass("hide");
				$("input").val("");
			});

			$("#btn_modif3").removeClass("hide").show().click(function(){
				$id=$("#ville_id").val();
				$ville=$("#libelle_ville").val();
				$code=$("#code_ville").val();
				if($id!=="" && $code!=="" && $ville!=="")
				{
					popup_loading();
					$.ajax({
						url:mainUrlUpd,
						type:"POST",
						data:{"ent":"ville",
							"id":$id,
							"ville":$ville,
							"code":$code
						},
						error:function(data)
						{
							fermer_modal();
						},
						success:function(data)
						{
							fermer_modal();
							if(data==1)
							{
								$("input[type='text']").val("");
								ouvrir_modal("<h4 class='alert alert-success'><i class='fa fa-check'></i>&nbsp;Acte bien modifié</h4>");
								route_ville_liste();
							}else
							{
								ouvrir_modal("<h4 class='alert alert-warning'><i class='fa fa-times'></i>&nbsp;Echec de modification</h4>");
							}
						}
					});
				}else
				{

				}
			});	
		break;
		case "typeavion":
			location.href="#body";
			$("#id").val(vid);
			$("#typeav_type").val(v1);
			$("#typeav_mtow").val(v2);
			$("#typeav_nbrmoteur").val(v3);
			$("#typeav_maxipayload").val(v4);
			$("#typeav_version").val(v5);
			$("#typeav_plmin").val(v6);
			$("#typeav_plmax").val(v7);
			
			$("#btn_enreg").hide();
			$("#btn_enreg").addClass('hide').show();
			$("#btn_modif").removeClass("hide");
			$("#btn_annuler").removeClass("hide");

			$("#btn_annuler").removeClass("hide").click(function(){
				$("#btn_enreg").removeClass('hide').show();
				$("#btn_modif").addClass("hide");
				$("#btn_annuler").addClass("hide");
				$("input").val("");
			});

			$("#btn_modif").removeClass("hide").show().click(function(){
				$id=$("#id").val();
				$typeav=$("#typeav_type").val();
				$mtow=$("#typeav_mtow").val();
				$moteur=$("#typeav_nbrmoteur").val();
				$maxipayload=$("#typeav_maxipayload").val();
				$version=$("#typeav_version").val();
				$plmin=$("#typeav_plmin").val();
				$plmax=$("#typeav_plmax").val();
				if($id!=="" && $mtow!=="")
				{
					popup_loading();
					$.ajax({
						url:mainUrlUpd,
						type:"POST",
						data:{"ent":"typeavion",
							"typeav":$typeav,
							"id":$id,
							"mtow":$mtow,
							"moteur":$moteur,
							"maxipayload":$maxipayload,
							"version":$version,
							"plmax":$plmax,
							"plmin":$plmin
						},
						error:function(data)
						{
							fermer_modal();
						},
						success:function(data)
						{
							
							fermer_modal();
							if(data==1)
							{
								$("input[type='text']").val("");
								ouvrir_modal("<h4 class='alert alert-success'><i class='fa fa-check'></i>&nbsp;Acte bien modifié</h4>");
								type_avion_liste();
							}else
							{
								ouvrir_modal("<h4 class='alert alert-warning'><i class='fa fa-times'></i>&nbsp;Echec de modification</h4>");
							}
						}
					});
				}else
				{

				}
			});	
		break;
		case "immatriculation":
			location.href="#body";
			$("#id").val(vid);
			$("#imm_code").val(v1);
			$("#imm_pr").val(v2);
			$("#imm_typeav").val(v3);
			$("#imm_tonn").val(v4);
			$("#imm_siege").val(v5);
			
			$("#btn_enreg").hide();
			$("#btn_enreg").addClass('hide').show();
			$("#btn_modif").removeClass("hide");
			$("#btn_annuler").removeClass("hide");

			$("#btn_annuler").removeClass("hide").click(function(){
				$("#btn_enreg").removeClass('hide').show();
				$("#btn_modif").addClass("hide");
				$("#btn_annuler").addClass("hide");
				$("input").val("");
			});

			$("#btn_modif").removeClass("hide").show().click(function(){
				$id=$("#id").val();
				$code=$("#imm_code").val();
				$pr=$("#imm_pr").val();
				$type_av=$("#imm_typeav").val();
				$poids=$("#imm_tonn").val();
				$siege=$("#imm_siege").val();
				
				if($id!=="" && $code!=="")
				{
					popup_loading();
					$.ajax({
						url:mainUrlUpd,
						type:"POST",
						data:{"ent":"immatriculation",
							"id":$id,
							"code":$code,
							"pr":$pr,
							"type_av":$type_av,
							"poids":$poids,
							"siege":$siege
						},
						error:function(data)
						{
							fermer_modal();
						},
						success:function(data)
						{
							fermer_modal();
							if(data==1)
							{
								$("input[type='text']").val("");
								ouvrir_modal("<h4 class='alert alert-success'><i class='fa fa-check'></i>&nbsp;Immatriculation bien modifié</h4>");
								immatriculation_liste();
							}else
							{
								ouvrir_modal("<h4 class='alert alert-warning'><i class='fa fa-times'></i>&nbsp;Echec de modification</h4>");
							}
						}
					});
				}else
				{

				}
			});	
		break;
		case "acces":

			$("#id").val(vid);
			$("#dt").val(v1);
			$("#heure").val(v2);
			$("#acces_liste").val(v3);
			$("#quittance").val(v4);
			$("#mt").val(v5);
			$("#monnaie").val(v6);
			$("#tva").val(v7);
						
			$("#btn_enreg").hide();
			$("#btn_enreg").addClass('hide').show();
			$("#btn_modif").removeClass("hide");
			$("#btn_annuler").removeClass("hide");

			$("#btn_annuler").removeClass("hide").click(function(){
				$("#btn_enreg").removeClass('hide').show();
				$("#btn_modif").addClass("hide");
				$("#btn_annuler").addClass("hide");
				$("input").val("");
			});

			$("#btn_modif").removeClass("hide").show().click(function(){
				$id=$("#id").val();
				$dt=$("#dt").val();
				$heure=$("#heure").val();
				$acces_liste=$("#acces_liste").val();
				$quittance=$("#quittance").val();
				$mt=$("#mt").val();
				$monnaie=$("#monnaie").val();
				$tva=$("#tva").val();
				if($id!=="" && $dt!=="" && $heure!=="" && $mt!=="" && $quittance!=="")
				{
					popup_loading();
					$.ajax({
						url:mainUrlUpd,
						type:"POST",
						data:{"ent":"acces",
							"id":$id,
							"dt":$dt,
							"heure":$heure,
							"acces_liste":$acces_liste,
							"quittance":$quittance,
							"mt":$mt,
							"monnaie":$monnaie,
							"tva":$tva							
						},
						error:function(data)
						{
							fermer_modal();
						},
						success:function(data)
						{
							fermer_modal();
							if(data==1)
							{
								$("input[type='text']").val("");
								ouvrir_modal("<h4 class='alert alert-success'><i class='fa fa-check'></i>&nbsp;Bien modifié</h4>");
								acces_liste_acces();
							}else
							{
								ouvrir_modal("<h4 class='alert alert-warning'><i class='fa fa-times'></i>&nbsp;Echec de modification</h4>");
							}
						}
					});
				}else
				{

				}
			});	
		break;
		case "idf":
			$("#id").val(vid);
			$("#dt").val(v1);
			$("#client").val(v2);
			$("#mt").val(v3);
			$("#monn").val(v4);
			$("#quittance").val(v5);
						
			$("#btn_enreg").hide();
			$("#btn_enreg").addClass('hide').show();
			$("#btn_modif").removeClass("hide");
			$("#btn_annuler").removeClass("hide");

			$("#btn_annuler").removeClass("hide").click(function(){
				$("#btn_enreg").removeClass('hide').show();
				$("#btn_modif").addClass("hide");
				$("#btn_annuler").addClass("hide");
				$("input").val("");
			});

			$("#btn_modif").removeClass("hide").show().click(function(){
				$id=$("#id").val();
				$dt=$("#dt").val();
				$client=$("#client").val();
				$mt=$("#mt").val();
				$monn=$("#monn").val();
				$quittance=$("#quittance").val();
				if($id!=="" && $dt!=="" && $client!=="" && $mt!=="" && $quittance!=="")
				{
					fermer_modal();
					popup_loading();
					$.ajax({
						url:mainUrlUpd,
						type:"POST",
						data:{"ent":"idf",
							"id":$id,
							"dt":$dt,
							"client":$client,
							"mt":$mt,
							"quittance":$quittance,
							"monn":$monn					
						},
						error:function(data)
						{
							fermer_modal();
						},
						success:function(data)
						{
							fermer_modal();
							if(data==1)
							{
								$("input[type='text']").val("");
								ouvrir_modal("<h4 class='alert alert-success'><i class='fa fa-check'></i>&nbsp;Bien modifié</h4>");
								rapport_idf();
							}else
							{
								ouvrir_modal("<h4 class='alert alert-warning'><i class='fa fa-times'></i>&nbsp;Echec de modification</h4>");
							}
						}
					});
				}else
				{

				}
			});	
		break;
		case "user":
			location.href="#body";
			$("#id").val(vid);
			$("#nom").val(v1);
			$("#matr").val(v2);
			$("#priv").val(v3);
			$("#login").val(v4);
			$("#mdp").val(v5);
			$("#mdp2").val(v6);
			$("#statut").val(v7);
			$("#btn_enreg").hide();

			$("#btn_enreg").addClass('hide').show();
			$("#btn_modif").removeClass("hide");
			$("#btn_annuler").removeClass("hide");

			$("#btn_annuler").removeClass("hide").click(function(){
				$("#btn_enreg").removeClass('hide').show();
				$("#btn_modif").addClass("hide");
				$("#btn_annuler").addClass("hide");
				$("input").val("");
			});

			$("#btn_modif").removeClass("hide").show().click(function(){
				if($("#mdp").val()=="" || $("#mdp2").val()=="")
				{
					$(".loading").html("<div class='text-danger bold center'><i class='fa fa-warning'></i> Saisissez le mot de passe</div>");
				}else
				{
					if($("#mdp").val()==$("#mdp2").val())
					{
						popup_loading();
						$.ajax({
							url:mainUrlUpd,
							type:"POST",
							data:{"ent":"user",
								"id":$("#id").val(),
								"nom":$("#nom").val(),
								"login":$("#login").val(),
								"mdp":$("#mdp").val(),
								"priv":$("#priv").val(),
								"matr":$("#matr").val(),
								"statut":$("#statut").val(),
							},
							error:function(data){connexion_serveur()},
							success:function(data)
							{
								if(data==1)
								{
									$("input[type='text']").val("");
									$("input[type='password']").val("");
									user_liste_user();
									ouvrir_modal("<div class='alert alert-success fs-15 center'><i class='fa fa-check-circle'></i> Utilisateur bien Modifié</div>");
									fermer_modal();
								}else
								{
									fermer_modal();
									ouvrir_modal("<div class='alert alert-warning fs-15 center'>Echec d'enregistrement</div>");
								}
							},
						});
					}else
					{
						$(".loading").html("<div class='text-danger bold center'>Les 2 mot de passe ne correspondent pas</div>");
					}
				}
			});
		break;
	}
}
function modif_mouv_arr(id)
{
	
	ouvrir_modal("<div class='fs-2 center bold'>Voulez-vous vriament modifier cet mouvement</div>"+
		"<p class='center'>"+
			'<button class="btn btn-success" onclick="modif_mouv_arr_conf('+"'"+id+"'"+')"><i class="fa fa-check"></i> Modifier</button>&nbsp;&nbsp;'+
			"<button class='btn btn-danger' onclick='fermer_modal()'><i class='fa fa-times'></i> Annuler</button>"+
		"</p>"
	);
}
function modif_mouv_arr_conf(id)
{
	fermer_modal();
	popup_loading();
	
	$.ajax({		
		url:mainUrlUpd,
		type:"POST",
		data:
		{
			"ent":"modif_mouv_nat_arr",
			"id_mouv":id,
			"dt":$("#dt").val(),
			"heure":$("#heure").val(),
			"nature_vol":$("#nature_vol").val(),
			"num_form":$("#num_form").val(),
			"temps":$("#temps").val(),
			"niv_vol":$("#niv_vol").val()
		},
		error:function(data){connexxion_serveur()},
		success:function(data)
		{
			fermer_modal();
			if(data==1)
			{
				ouvrir_modal("<div class='alert alert-success fs-15 bold center'>Données bien modifiées</div>");
			}else
			{
				ouvrir_modal("<div class='alert alert-danger fs-15 bold center'>Echec de modification</div>");
			}
		}
	});
}

function modif_esc_nat_arr(ligne)
{
	ouvrir_modal("<div class='fs-2 center bold'>Voulez-vous vriament modifier cet escale</div>"+
		"<p class='center'>"+
			'<button class="btn btn-success" onclick="modif_esc_nat_arr_conf('+"'"+ligne+"'"+')"><i class="fa fa-check"></i> Modifier</button>&nbsp;&nbsp;'+
			"<button class='btn btn-danger' onclick='fermer_modal()'><i class='fa fa-times'></i> Annuler</button>"+
		"</p>"
	);
	//alert($(prov).val());
}

function modif_esc_nat_arr_conf(ligne)
{
	fermer_modal();
	popup_loading();
	var id_esc="#"+ligne+" "+".id_esc";
	var prov="#"+ligne+" "+".prov";
	var ad="#"+ligne+" "+".ad";
	var ch="#"+ligne+" "+".ch";
	var inf="#"+ligne+" "+".inf";
	var tra="#"+ligne+" "+".tra";
	var pec="#"+ligne+" "+".pec";
	var loc="#"+ligne+" "+".loc";
	var trat="#"+ligne+" "+".trat";
	var ptt="#"+ligne+" "+".ptt";
	$.ajax({		
		url:mainUrlUpd,
		type:"POST",
		data:
		{
			"ent":"modif_esc_nat",
			"id_esc":$(id_esc).val(),
			"prov":$(prov).val(),
			"ad":$(ad).val(),
			"ch":$(ch).val(),
			"inf":$(inf).val(),
			"tra":$(tra).val(),
			"pec":$(pec).val(),
			"loc":$(loc).val(),
			"trat":$(trat).val(),
			"ptt":$(ptt).val()
		},
		error:function(data){connexxion_serveur()},
		success:function(data)
		{
			fermer_modal();
			if(data==1)
			{
				ouvrir_modal("<div class='alert alert-success fs-15 bold center'>Données bien modifiées</div>");
			}else
			{
				ouvrir_modal("<div class='alert alert-danger fs-15 bold center'>Echec de modification</div>");
			}
		}
	});
}
function modif_esc_int_arr(ligne)
{
	ouvrir_modal("<div class='fs-2 center bold'>Voulez-vous vriament modifier cet escale</div>"+
		"<p class='center'>"+
			'<button class="btn btn-success" onclick="modif_esc_int_arr_conf('+"'"+ligne+"'"+')"><i class="fa fa-check"></i> Modifier</button>&nbsp;&nbsp;'+
			"<button class='btn btn-danger' onclick='fermer_modal()'><i class='fa fa-times'></i> Annuler</button>"+
		"</p>"
	);
	//alert($(prov).val());
}

function modif_esc_int_arr_conf(ligne)
{
	fermer_modal();
	popup_loading();
	var id_esc="#"+ligne+" "+".id_esc";
	var prov="#"+ligne+" "+".prov";
	var pt="#"+ligne+" "+".pt";
	var ad="#"+ligne+" "+".ad";
	var ch="#"+ligne+" "+".ch";
	var inf="#"+ligne+" "+".inf";
	var tra="#"+ligne+" "+".tra";
	var pec="#"+ligne+" "+".pec";
	var loc="#"+ligne+" "+".loc";
	var trat="#"+ligne+" "+".trat";
	var ptt="#"+ligne+" "+".ptt";
	//alert($("#dt").val());

	$.ajax({		
		url:mainUrlUpd,
		type:"POST",
		data:
		{
			"ent":"modif_esc_int",
			"id_esc":$(id_esc).val(),
			"prov":$(prov).val(),
			"pt":$(pt).val(),
			"ad":$(ad).val(),
			"ch":$(ch).val(),
			"inf":$(inf).val(),
			"tra":$(tra).val(),
			"pec":$(pec).val(),
			"loc":$(loc).val(),
			"trat":$(trat).val(),
			"ptt":$(ptt).val()
		},
		error:function(data){connexxion_serveur()},
		success:function(data)
		{
			fermer_modal();
			if(data==1)
			{
				ouvrir_modal("<div class='alert alert-success fs-15 bold center'>Données bien modifiées</div>");
			}else
			{
				ouvrir_modal("<div class='alert alert-danger fs-15 bold center'>Echec de modification</div>");
			}
		}
	});
}

function modif_esc_int_dep(ligne)
{
	ouvrir_modal("<div class='fs-2 center bold'>Voulez-vous vriament modifier cet escale</div>"+
		"<p class='center'>"+
			'<button class="btn btn-success" onclick="modif_esc_int_dep_conf('+"'"+ligne+"'"+')"><i class="fa fa-check"></i> Modifier</button>&nbsp;&nbsp;'+
			"<button class='btn btn-danger' onclick='fermer_modal()'><i class='fa fa-times'></i> Annuler</button>"+
		"</p>"
	);
	//alert($(prov).val());
}

function modif_esc_int_dep_conf(ligne)
{
	fermer_modal();
	popup_loading();
	var id_esc="#"+ligne+" "+".id_esc";
	var prov="#"+ligne+" "+".prov";
	var pt="#"+ligne+" "+".pt";
	var ad="#"+ligne+" "+".ad";
	var ch="#"+ligne+" "+".ch";
	var inf="#"+ligne+" "+".inf";
	var tra="#"+ligne+" "+".tra";
	var pec="#"+ligne+" "+".pec";
	var loc="#"+ligne+" "+".loc";
	var trat="#"+ligne+" "+".trat";
	var ptt="#"+ligne+" "+".ptt";

	$.ajax({		
		url:mainUrlUpd,
		type:"POST",
		data:
		{
			"ent":"modif_esc_int",
			"id_esc":$(id_esc).val(),
			"prov":$(prov).val(),
			"pt":$(pt).val(),
			"ad":$(ad).val(),
			"ch":$(ch).val(),
			"inf":$(inf).val(),
			"tra":$(tra).val(),
			"pec":$(pec).val(),
			"loc":$(loc).val(),
			"trat":$(trat).val(),
			"ptt":$(ptt).val()
		},
		error:function(data){connexxion_serveur()},
		success:function(data)
		{
			fermer_modal();
			if(data==1)
			{
				ouvrir_modal("<div class='alert alert-success fs-15 bold center'>Données bien modifiées</div>");
			}else
			{
				ouvrir_modal("<div class='alert alert-danger fs-15 bold center'>Echec de modification</div>");
			}
		}
	});
}


function modif_exon_arr(id)
{
	ouvrir_modal("<div class='fs-2 center bold'>Voulez-vous vriament modifier ces exonerations</div>"+
		"<p class='center'>"+
			'<button class="btn btn-success" onclick="modif_exon_arr_conf('+"'"+id+"'"+')"><i class="fa fa-check"></i> Modifier</button>&nbsp;&nbsp;'+
			"<button class='btn btn-danger' onclick='fermer_modal()'><i class='fa fa-times'></i> Annuler</button>"+
		"</p>"
	);
}
function modif_exon_arr_conf(id)
{
	fermer_modal();
	popup_loading();
	
	$.ajax({		
		url:mainUrlUpd,
		type:"POST",
		data:
		{
			"ent":"modif_exon_arr",
			"id_mouv":id,
			"ex_att_nat_arr":$("#ex_att_nat_arr").val(),
			"ex_stt_nat_arr":$("#ex_stt_nat_arr").val(),
			"ex_stg_nat_arr":$("#ex_stg_nat_arr").val(),
			"ex_bal_nat_arr":$("#ex_bal_nat_arr").val(),
			"ex_pax_nat_arr":$("#ex_pax_nat_arr").val(),
			"ex_fret_nat_arr":$("#ex_fret_nat_arr").val(),
			"ex_route_nat_arr":$("#ex_route_nat_arr").val()
		},
		error:function(data){connexxion_serveur()},
		success:function(data)
		{
			fermer_modal();
			if(data==1)
			{
				ouvrir_modal("<div class='alert alert-success fs-15 bold center'>Données bien modifiées</div>");
			}else
			{
				ouvrir_modal("<div class='alert alert-danger fs-15 bold center'>Echec de modification</div>");
			}
		}
	});
}

//=========== MODIF MOUV DEP===
function modif_mouv_dep(id)
{
	
	ouvrir_modal("<div class='fs-2 center bold'>Voulez-vous vriament modifier cet mouvement</div>"+
		"<p class='center'>"+
			'<button class="btn btn-success" onclick="modif_mouv_dep_conf('+"'"+id+"'"+')"><i class="fa fa-check"></i> Modifier</button>&nbsp;&nbsp;'+
			"<button class='btn btn-danger' onclick='fermer_modal()'><i class='fa fa-times'></i> Annuler</button>"+
		"</p>"
	);
}
function modif_mouv_dep_conf(id)
{
	fermer_modal();
	popup_loading();
	
	$.ajax({		
		url:mainUrlUpd,
		type:"POST",
		data:
		{
			"ent":"modif_mouv_nat_dep",
			"id_mouv":id,
			"dt":$("#dt_dep").val(),
			"heure":$("#heure_dep").val(),
			"nature_vol":$("#nature_vol_dep").val(),
			"num_form":$("#num_form_dep").val(),
			"temps":$("#temps_dep").val(),
			"niv_vol":$("#niv_vol_dep").val(),
			"stat":$("#stat").val(),
			"compt":$("#compt_enr").val(),
			"formulaire":$("#formulaire").val(),
			"anti_inc":$("#anti_inc").val()
		},
		error:function(data){connexxion_serveur()},
		success:function(data)
		{
			fermer_modal();
			if(data==1)
			{
				ouvrir_modal("<div class='alert alert-success fs-15 bold center'>Données bien modifiées</div>");
			}else
			{
				ouvrir_modal("<div class='alert alert-danger fs-15 bold center'>Echec de modification</div>");
			}
		}
	});
}
function modif_exon_dep(id)
{
	ouvrir_modal("<div class='fs-2 center bold'>Voulez-vous vriament modifier ces exonerations</div>"+
		"<p class='center'>"+
			'<button class="btn btn-success" onclick="modif_exon_dep_conf('+"'"+id+"'"+')"><i class="fa fa-check"></i> Modifier</button>&nbsp;&nbsp;'+
			"<button class='btn btn-danger' onclick='fermer_modal()'><i class='fa fa-times'></i> Annuler</button>"+
		"</p>"
	);
}
function modif_exon_dep_conf(id)
{
	fermer_modal();
	popup_loading();
	
	$.ajax({		
		url:mainUrlUpd,
		type:"POST",
		data:
		{
			"ent":"modif_exon_arr",
			"id_mouv":id,
			"ex_att_nat_arr":$("#ex_att_nat_dep").val(),
			"ex_stt_nat_arr":$("#ex_stt_nat_dep").val(),
			"ex_stg_nat_arr":$("#ex_stg_nat_dep").val(),
			"ex_bal_nat_arr":$("#ex_bal_nat_dep").val(),
			"ex_pax_nat_arr":$("#ex_pax_nat_dep").val(),
			"ex_fret_nat_arr":$("#ex_fret_nat_dep").val(),
			"ex_route_nat_arr":$("#ex_route_nat_dep").val()
		},
		error:function(data){connexxion_serveur()},
		success:function(data)
		{
			fermer_modal();
			if(data==1)
			{
				ouvrir_modal("<div class='alert alert-success fs-15 bold center'>Données bien modifiées</div>");
			}else
			{
				ouvrir_modal("<div class='alert alert-danger fs-15 bold center'>Echec de modification</div>");
			}
		}
	});
}
