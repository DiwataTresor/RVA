//var mainUrl="http://localhost/root/rva_serveur/_handling/";
var mainUrl="http://10.160.120.200:8888/rva/_handling/";
//var mainUrl="http://localhost/root/rva_serveur/_handling/";
function popup_loading()
{
	$("#popup_loading").show();
}

function fermer_modal()
{
	$(".w3-modal").hide();
}

function ouvrir_modal(txt)
{
	$("#popup_global").show();
	$("#popup_global_contenu").html(txt);
}
function popup(entete,e)
{
	$("#popup_contenu").html(e);
	$("#popup_entete").html(entete).addClass("blue-text bold fs-2");
	$("#popup").show();
}
function popup_loading()
{
	$("#popup_loading").show();
}
function notification_info(message)
{
	fermer_modal();
	Lobibox.notify('info', {
			position:'bottom right',
			sound:"sound4",
            size: 'mini',
            rounded: false,
	        delayIndicator: false,
            msg: message
    });
}
function notification_success(message)
{
	fermer_modal();
	Lobibox.notify('success', {
			position:'bottom center',
			sound:"sound4",
            size: 'mini',
            rounded: true,
	        delayIndicator: false,
            msg: message
    });
}
function notification_error(message)
{
	fermer_modal();
	Lobibox.notify('error', {
			position:'bottom center',
			sound:"sound4",
            size: 'mini',
            rounded: true,
	        delayIndicator: false,
            msg: message
    });
}
function notification_warning(message)
{
	fermer_modal();
	Lobibox.notify('warning', {
			position:'bottom center',
			sound:"sound4",
            size: 'mini',
            rounded: true,
	        delayIndicator: false,
            msg: message
    });
}
function ouvrir(page,p,p2,p3)
{	
	//$(".centrale").html("<div class='loading'><img src='images/loading2.gif' height=70 width=70 /><br />Veuillez patienter...</div>");
	popup_loading();
	$("#fenetre_contenu").load("vues/pages/" + page + ".php",{"p":p,"p2":p2,"p3":p3},function(data){
		fermer_modal();
	});
}
function connexion_serveur()
{
	ouvrir_modal("<h4 class='alert alert-warning'><i class='fa fa-warning'></i>&nbsp;Pas de connexion au serveur</h4>");
}
function ouvrir_fenetre(page,p,p2)
{
	popup_loading();
	
	$("#container_fenetre").load("vues/pages/" + page + ".php",{"p":p,"p2":p2},function(data){
		fermer_modal();
	});	
}
function connexion()
{
	$login=$("#login").val();
	$mdp=$("#mdp").val();
	//alert($login);
	$(".loading").html("<img src='images/gif/ajax-rond.gif'>&nbsp;Connexion en cours");
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"connexion","login":$login,"mdp":$mdp},
		error:function(data)
		{
			connexion_serveur();
		},
		success:function(data)
		{
			
			if(data==1)
			{
				location.href='FACTURATION';
			}else
			{
				$(".loading").html("<div class='alert alert-danger'><i class='fa fa-times-circle'></i>&nbsp;Echec de connexion</div>");
			}
		},
	});
}
function mouvement()
{
	$("#national_arrive").hide();
	$("#national_depart").hide();
	$("#inter_arrive").hide();
	$("#inter_depart").hide();
	$nature_vol=$("#nature_vol").val();
	if($nature_vol=="I")
	{
		$("#national_arrive").hide();
		$("#national_depart").hide();
		$("#inter_arrive").show();
		$("#inter_depart").show();
	}else if($nature_vol=="N")
	{
		$("#national_arrive").show();
		$("#national_depart").show();
		$("#inter_arrive").hide();
		$("#inter_depart").hide();
	}else
	{

	}
}
function client_liste_cl()
{
	$("input").val("");
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"client"},
		success:function(data)
		{
			var r=JSON.parse(data);
			$("#detail")
			.html("<table class='table w3-small w3-table-all'>"+
					"<thead class='w3-blue-grey black-text bold'><tr>"+
						'<td>Code</td>'+
						'<td>Nom</td>'+
						'<td>Adresse</td>'+
						'<td>Ville</td>'+
						'<td>Type_cl</td>'+
						'<td>Code Nat</td>'+
						'<td>Telephone</td>'+
						'<td>Nationalité</td>'+
						'<td>OPTION</td>'+
					"</tr></thead>"+
				"</table");
			for(var a=0;a<r.length;a++)
			{
				$("table")
				.append("<tr>"+
						'<td>'+r[a]["code"]+'</td>'+
						'<td>'+r[a]["nom_cl"]+'</td>'+
						'<td>'+r[a]["adresse"]+'</td>'+
						'<td>'+r[a]["ville"]+'</td>'+
						'<td>'+r[a]["typ"]+'</td>'+
						'<td>'+r[a]["code"]+'</td>'+
						'<td>'+r[a]["telephone"]+'</td>'+
						'<td>'+r[a]["nat"]+'</td>'+
						'<td>'+
							'<button title="modifier" class="w3-small" onclick="upd('+"'"+"client"+"'"+","+"'"+r[a]["id_cl"]+"'"+","+"'"+r[a]['code']+"'"+","+"'"+r[a]['nom_cl']+"'"+","+"'"+r[a]['telephone']+"'"+","+"'"+r[a]['adresse']+"'"+","+"'"+r[a]['ville']+"'"+","+"'"+r[a]['boite']+"'"+","+"'"+r[a]['typ']+"'"+","+"'"+r[a]['nat']+"'"+');"><i class="fa fa-edit"></i></button>&nbsp;'+
							'<button title="supprimer" class="w3-small" onclick="del('+"'"+'client'+"'"+","+"'"+"Id_cl"+"'"+","+"'"+r[a]['id_cl']+"'"+","+"'"+r[a]['nom_cl']+"'"+","+"'"+"client"+"'"+');"><i class="fa fa-trash"></i></button>'+
						'</td>'+
					"</tr>");
			}
			$("#detail")
			.append("<a class='btn btn-success' href='vues/pages/impression/liste_client.php'>Imprimer</a>");
		}
	});
}
function acces_liste()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"liste_type_acces"},
		success:function(data)
		{
			var r=JSON.parse(data);
			$("#liste")
			.html("<table class='table w3-small w3-table-all'>"+
					"<thead class=''><tr class='blue-grey white-text bold'>"+
						'<td>CODE</td>'+
						'<td>LIBELLE</td>'+					
						'<td>OPTION</td>'+
					"</tr></thead>"+
				"</table");
			for(var a=0;a<r.length;a++)
			{
				$("#liste table")
				.append("<tr>"+
						'<td>'+r[a]["code_acc"]+'</td>'+
						'<td>'+r[a]["designation_acc"]+'</td>'+
						'<td>'+
							'<button title="modifier" class="w3-small" onclick="upd('+"'"+"pt"+"'"+","+"'"+r[a]["id"]+"'"+","+"'"+r[a]['libelle']+"'"+","+"'"+r[a]['code']+"'"+","+"'"+r[a]['distance']+"'"+');"><i class="fa fa-edit"></i></button>&nbsp;'+
							'<button title="supprimer" class="w3-small" onclick="del('+"'"+' pt_emplacement'+"'"+","+"'"+"Id_pt"+"'"+","+"'"+r[a]['id']+"'"+","+"'"+r[a]['libelle']+"'"+","+"'"+"pt"+"'"+');"><i class="fa fa-trash"></i></button>'+
						'</td>'+
					"</tr>");
			}
		}
	});
	$("input").val("");
}
function route_pt_liste()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"liste_pt"},
		success:function(data)
		{
			var r=JSON.parse(data);
			$("#pt_liste")
			.html("<table class='table w3-small w3-table-all'>"+
					"<thead class='w3-blue-grey black-text bold'><tr>"+
						'<td onclick="w3.sortHTML('+"'"+"table"+"'"+","+"'"+".item"+"'"+","+"'"+"td:nth-child(1)"+"'"+')" title="Trier par code"><a href="#"><i class="fa fa-sort"></i> CODE</a></td>'+
						'<td onclick="w3.sortHTML('+"'"+"table"+"'"+","+"'"+".item"+"'"+","+"'"+"td:nth-child(2)"+"'"+')" title="Trier par Libelé"><a href="#"><i class="fa  fa-sort-alpha-desc"></i> LIBELLE</a></td>'+
						'<td>DISTANCE</td>'+						
						'<td>OPTION</td>'+
					"</tr></thead>"+
				"</table");
			for(var a=0;a<r.length;a++)
			{
				$("#pt_liste table")
				.append("<tr class='item'>"+
						'<td>'+r[a]["code"]+'</td>'+
						'<td>'+r[a]["libelle"]+'</td>'+
						'<td>'+r[a]["distance"]+" Km"+'</td>'+
						'<td>'+
							'<button title="modifier" class="w3-small" onclick="upd('+"'"+"pt"+"'"+","+"'"+r[a]["id"]+"'"+","+"'"+r[a]['libelle']+"'"+","+"'"+r[a]['code']+"'"+","+"'"+r[a]['distance']+"'"+');"><i class="fa fa-edit"></i></button>&nbsp;'+
							'<button title="supprimer" class="w3-small" onclick="del('+"'"+' pt_emplacement'+"'"+","+"'"+"Id_pt"+"'"+","+"'"+r[a]['id']+"'"+","+"'"+r[a]['libelle']+"'"+","+"'"+"pt"+"'"+');"><i class="fa fa-trash"></i></button>'+
						'</td>'+
					"</tr>");
			}
			$("#pt_liste")
			.append("<a target='_blank' href='vues/pages/impression/liste_pt.php?t=P' class='btn btn-success'>Imprimer</a>");
		}
	});
	$("input").val("");
}
function route_ville_liste()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"liste_ville"},
		success:function(data)
		{
			var r=JSON.parse(data);
			$("#ville_liste")
			.html("<table class='table w3-small w3-table-all'>"+
					"<thead class='w3-blue-grey black-text bold'><tr>"+
						'<td>CODE</td>'+
						'<td>LIBELLE</td>'+						
						'<td>OPTION</td>'+
					"</tr></thead>"+
				"</table");
			for(var a=0;a<r.length;a++)
			{
				$("#ville_liste table")
				.append("<tr>"+
						'<td>'+r[a]["code_ville"]+'</td>'+
						'<td>'+r[a]["libelle"]+'</td>'+
						'<td>'+
							'<button title="modifier" class="w3-small" onclick="upd('+"'"+"ville"+"'"+","+"'"+r[a]["id"]+"'"+","+"'"+r[a]['code_ville']+"'"+","+"'"+r[a]['libelle']+"'"+');"><i class="fa fa-edit"></i></button>&nbsp;'+
							'<button title="supprimer" class="w3-small" onclick="del('+"'"+' pt_emplacement'+"'"+","+"'"+"Id_pt"+"'"+","+"'"+r[a]['id']+"'"+","+"'"+r[a]['libelle']+"'"+","+"'"+"pt"+"'"+');"><i class="fa fa-trash"></i></button>'+
						'</td>'+
					"</tr>");
			}
		}
	});
	$("input").val("");
}
function route_empl_liste()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"liste_emplacement"},
		success:function(data)
		{
			var r=JSON.parse(data);
			$("#empl_liste")
			.html("<table class='table w3-small w3-table-all'>"+
					"<thead class='w3-blue-grey black-text bold'><tr>"+
						'<td onclick="w3.sortHTML('+"'"+"table"+"'"+","+"'"+".item"+"'"+","+"'"+"td:nth-child(1)"+"'"+')"><a href="#"><i class="fa fa-sort"></i> CODE</a></td>'+
						'<td onclick="w3.sortHTML('+"'"+"table"+"'"+","+"'"+".item"+"'"+","+"'"+"td:nth-child(2)"+"'"+')"><a href="#"><i class="fa fa-sort-alpha-desc"></i> LIBELLE</a></td>'+
						'<td>DISTANCE</td>'+
						'<td>GERE PAR LA RVA</td>'+						
						'<td>OPTION</td>'+
					"</tr></thead>"+
				"</table");
			for(var a=0;a<r.length;a++)
			{
				$("#empl_liste table")
				.append("<tr class='item'>"+
						'<td>'+r[a]["code_ville"]+'</td>'+
						'<td>'+r[a]["libelle"]+'</td>'+
						'<td>'+r[a]["distance"]+" Km"+'</td>'+
						'<td>'+r[a]["gere"]+'</td>'+
						'<td>'+
							'<button title="modifier" class="w3-small" onclick="upd('+"'"+"empl"+"'"+","+"'"+r[a]["id"]+"'"+","+"'"+r[a]['libelle']+"'"+","+"'"+r[a]['code_ville']+"'"+","+"'"+r[a]['distance']+"'"+","+"'"+r[a]['gere']+"'"+');"><i class="fa fa-edit"></i></button>&nbsp;'+
							'<button title="supprimer" class="w3-small" onclick="del('+"'"+' pt_emplacement'+"'"+","+"'"+"Id_pt"+"'"+","+"'"+r[a]['id']+"'"+","+"'"+r[a]['libelle']+"'"+","+"'"+"pt"+"'"+');"><i class="fa fa-trash"></i></button>'+
						'</td>'+
					"</tr>");
			}
			$("#empl_liste")
			.append("<a target='_blank' href='vues/pages/impression/liste_pt.php?t=E' class='btn btn-success'>Imprimer</a>");
		}
	});
	$("input").val("");
}
function type_avion_liste()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"liste_typeav"},
		success:function(data)
		{
			var r=JSON.parse(data);
			$("#liste")
			.html("<table class='table w3-small w3-table-all'>"+
					"<thead class='w3-blue-grey black-text bold'><tr>"+
						'<td>TYPE</td>'+
						'<td>MTOW</td>'+
						'<td>MOTEUR</td>'+
						'<td>MAX PAYLOAD</td>'+	
						'<td>VERSION</td>'+	
						'<td>PL MIN</td>'+	
						'<td>PL MAX</td>'+			
						'<td>OPTION</td>'+
					"</tr></thead>"+
				"</table");
			for(var a=0;a<r.length;a++)
			{
				$("#liste table")
				.append("<tr>"+
						'<td>'+r[a]["libelle"]+'</td>'+
						'<td>'+r[a]["mtow"]+'</td>'+
						'<td>'+r[a]["nbremot"]+'</td>'+
						'<td>'+r[a]["maxpaylaod"]+'</td>'+
						'<td>'+r[a]["version"]+'</td>'+
						'<td>'+r[a]["plmin"]+'</td>'+
						'<td>'+r[a]["plmax"]+'</td>'+
						'<td>'+
							'<button title="modifier" class="w3-small" onclick="upd('+"'"+"typeavion"+"'"+","+"'"+r[a]["id_type"]+"'"+","+"'"+r[a]['libelle']+"'"+","+"'"+r[a]['mtow']+"'"+","+"'"+r[a]['nbremot']+"'"+","+"'"+r[a]['maxpaylaod']+"'"+","+"'"+r[a]['version']+"'"+","+"'"+r[a]['plmin']+"'"+","+"'"+r[a]['plmax']+"'"+');"><i class="fa fa-edit"></i></button>&nbsp;'+
							'<button title="supprimer" class="w3-small" onclick="del('+"'"+' typeavion'+"'"+","+"'"+"Id_pt"+"'"+","+"'"+r[a]['id']+"'"+","+"'"+r[a]['libelle']+"'"+","+"'"+"pt"+"'"+');"><i class="fa fa-trash"></i></button>'+
						'</td>'+
					"</tr>");
			}
		}
	});
	$("input").val("");
}
function immatriculation_liste()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"liste_imm"},
		success:function(data)
		{
			var r=JSON.parse(data);
			$("#liste")
			.html("<table class='table w3-small w3-table-all'>"+
					"<thead class='w3-blue-grey black-text bold'><tr>"+
						'<td onclick="w3.sortHTML('+"'"+"table"+"'"+","+"'"+".item"+"'"+","+"'"+"td:nth-child(1)"+"'"+')" title="Trier par code"><a href="#"><i class="fa fa-sort"></i> CODE IMM</a></td>'+
						'<td onclick="w3.sortHTML('+"'"+"table"+"'"+","+"'"+".item"+"'"+","+"'"+"td:nth-child(2)"+"'"+')" title="Trier par code"><a href="#"><i class="fa  fa-sort-alpha-desc"></i> PROPRIETAIRE</a></td>'+
						'<td onclick="w3.sortHTML('+"'"+"table"+"'"+","+"'"+".item"+"'"+","+"'"+"td:nth-child(3)"+"'"+')" title="Trier par code"><a href="#"><i class="fa  fa-sort"></i> TYPE AV</a></td>'+
						'<td>POIDS</td>'+
						'<td>NBRE SIEGE</td>'+			
						'<td>OPTION</td>'+
					"</tr></thead>"+
				"</table");
			$("#liste")
				.append('<a href="vues/pages/impression/liste_immatriculation.Php" target="_blank" class="btn btn-success">Imprimer</div>');
			for(var a=0;a<r.length;a++)
			{
				$("#liste table")
				.append("<tr class='item'>"+
						'<td>'+r[a]["code_imm"]+'</td>'+
						'<td>'+r[a]["proprietaire"]+'</td>'+
						'<td>'+r[a]["type_av"]+'</td>'+
						'<td>'+r[a]["poids"]+'</td>'+
						'<td>'+r[a]["nbre_siege"]+'</td>'+
						'<td>'+
							'<button title="modifier" class="w3-small" onclick="upd('+"'"+"immatriculation"+"'"+","+"'"+r[a]["id"]+"'"+","+"'"+r[a]['code_imm']+"'"+","+"'"+r[a]['id_proprietaire']+"'"+","+"'"+r[a]['idtype_av']+"'"+","+"'"+r[a]['poids']+"'"+","+"'"+r[a]['nbre_siege']+"'"+');"><i class="fa fa-edit"></i></button>&nbsp;'+
							'<button title="supprimer" class="w3-small" onclick="del('+"'"+'immatriculation'+"'"+","+"'"+"Id_imm"+"'"+","+"'"+r[a]['id']+"'"+","+"'"+r[a]['code_imm']+"'"+","+"'"+"pt"+"'"+');"><i class="fa fa-trash"></i></button>'+
						'</td>'+
					"</tr>");
			}

		}
	});
	$("input").val("");
}

function maj_imm_cl()
{
	$("#loading_cl").html('<img src="images/gif/ajax-rond3.gif" />');
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:'POST',
		data:{"ent":"client"},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$("#loading_cl").html("<small class='text-warning'>Aucun client enregistré</small>");
			}else
			{
				$("#loading_cl").html("");
				$("#imm_pr")
				.html("<option value=''>--Selectionner--</option>");
				for(var a=0;a<r.length;a++)
				{
					$("#imm_pr")
					.append("<option value='"+r[a]["id_cl"]+"'>"+r[a]["nom_cl"]+"</option>");
				}
			}
		},
	});
}
function maj_imm_typeav()
{
	$("#loading_type").html('<img src="images/gif/ajax-rond3.gif" />');
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:'POST',
		data:{"ent":"liste_typeav"},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			//alert(data);
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$("#loading_type").html("<small class='text-warning'>Aucun type avion enregistré</small>");
			}else
			{
				$("#loading_type").html("");
				$("#imm_typeav")
				.html("<option value=''>--Selectionner type avion--</option>");
				for(var a=0;a<r.length;a++)
				{
					$("#imm_typeav")
					.append("<option value='"+r[a]["id_typ"]+"'>"+r[a]["libelle"]+"</option>");
				}
			}
		},
	});
}
function dernier_taux()
{
	$("#dernier_taux").html("<img src='images/gif/ajax-rond.gif'>&nbsp;chargement en cours...");
	/*$.ajax({
		url:mainUrl+"modeles/main.php";
		type:'POST',
		data:{"ent":"dernier_taux"},

	});*/
}

function tarif_redevance()
{
	popup_loading();
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"tarif_redevance"},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			fermer_modal();
			var r=JSON.parse(data);
			$("#tva").val(r[0]["Tva"]);
		    $("#cpt_enr").val(r[0]["Cptenreg"]);
		    $("#redbal").val(r[0]["Redbal"]);
		    $("#redsec").val(r[0]["Redsecurite"]);
		    $("#assantinc").val(r[0]["Assantinc"]);
		    $("#redsur").val(r[0]["Redsur_vol_int"]);
		    $("#redsur_form").val(r[0]["Redsur_form"]);
		    $("#redsur_aero").val(r[0]["Redsur_aeronongere"]);
		    $("#redsur_int").val(r[0]["Redsur_inter"]);
		    $("#resdsur_nat").val(r[0]["Redsur_nat"]);
		    $("#redfr_int").val(r[0]["Redfr_res_int"]);
		    $("#redfr_nat").val(r[0]["Redfr_res_nat"]);
		    $("#redfr_int_idf_emb").val(r[0]["Redfr_res_int_idf_emb"]);
		    $("#redfr_int_idf_deb").val(r[0]["Redfr_res_int_idf_deb"]);
		    $("#redfr_nat_idf_emb").val(r[0]["Redfr_res_nat_idf_emb"]);
		    $("#redfr_nat_idf_deb").val(r[0]["Redfr_res_nat_idf_deb"]);
		    $("#redpass_pascorri").val(r[0]["Redpass_pasencorri"]);
		    $("#redpass_rdom").val(r[0]["Redpass_rdom"]);
		    $("#redpass_int").val(r[0]["Redpass_res_int"]);
		    $("#redpass_int_idf").val(r[0]["Redpass_res_int_idf"]);
		    $("#redpass_nat").val(r[0]["Redpass_res_nat"]);
		    $("#redpass_nat_idf").val(r[0]["Redpass_res_nat_idf"]);
		    $("#redrou_sup_245").val(r[0]["Redrou_esp_sup_245"]);
		    $("#redrou_inf_245").val(r[0]["Redrou_esp_inf_245"]);
		    $("#redrou_vol_int").val(r[0]["Redrou_vol_int"]);
		    $("#redstat_tarmac").val(r[0]["Redstat_tarmac"]);
		    $("#redstat_garage").val(r[0]["Redstat_garage"]);
		    $("#redatt_1_25_int").val(r[0]["Redatt_1_25_inter"]);
		    $("#redatt_1_25_nat").val(r[0]["Redatt_1_25_nat"]);
		    $("#redatt_26_75_int").val(r[0]["Redatt_26_75_inter"]);
		    $("#redatt_26_75_nat").val(r[0]["Redatt_26_75_nat"]);
		    $("#redatt_sup_75_int").val(r[0]["Redatt_sup_75_inter"]);
		    $("#redatt_sup_75_nat").val(r[0]["Redatt_sur_75_nat"]);
		    $("#redatt_ton_min_int").val(r[0]["Redatt_ton_min_inter"]);
		    $("#redatt_ton_min_nat").val(r[0]["Redatt_ton_min_nat"])
		},
	});
}
function acces_liste_acces()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:'POST',
		data:{"ent":"liste_type_acces"},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$(".input-group-addon").html("");
			}else
			{
				$(".input-group-addon").html("");
				$("#acces_liste")
				.html("<option value=''>Selectionner acces</option>");
				for(var a=0;a<r.length;a++)
				{
					$("#acces_liste")
					.append("<option value='"+r[a]["id"]+"'>"+r[a]["designation_acc"]+"</option>");
				}
			}
		},
	});	
}
function user_liste_user()
	{
		$.ajax({
			url:mainUrl+"modeles/main.php",
			type:"POST",
			data:{"ent":"liste_user"},
			error:function(data)
			{
				connexion_serveur();
			},
			success:function(data)
			{
				$("#liste")
				.html("<table id='tableau' class='w3-table-all w3-small'>"+
					"<tr class='blue-grey white-text'>"+
						"<td>NOM</td>"+
						"<td>MATR.</td>"+
						"<td>LOGIN</td>"+
						"<td>MDP</td>"+
						"<td>PRIV</td>"+
						"<td>STATUT</td>"+
						"<td>OPTION</td>"+
					"</tr>"+
				"</table>");
				var r=JSON.parse(data);
				if(r[0]["n"]==0)
				{

				}else
				{
					//$("table").html("");
					for(a=0;a<r.length;a++)
					{
						
						$("#liste table")
						.append('<tr>'+
	                        '<td>'+r[a]['nom']+'</td>'+
	                        '<td>'+r[a]['matricule']+'</td>'+
	                        '<td>'+r[a]['login']+'</td>'+
	                        '<td>'+r[a]['mdp']+'</td>'+
	                        '<td>'+r[a]['priv']+'</td>'+
	                        '<td>'+r[a]['statut']+'</td>'+
	                        '<td>'+
	                        	'<button class="w3-btn blue w3-small" onclick="upd('+"'"+"user"+"'"+","+"'"+r[a]['id']+"'"+","+"'"+r[a]["nom"]+"'"+","+"'"+r[a]["matricule"]+"'"+","+"'"+r[a]["priv"]+"'"+","+"'"+r[a]["login"]+"'"+","+"'"+r[a]["mdp"]+"'"+","+"'"+r[a]["mdp"]+"'"+","+"'"+r[a]['statut']+"'"+');" alt="Modifier"><i class="fa fa-edit"></i></button>'+
	                        	'<button class="w3-btn w3-small red" onclick="del('+"'"+"user"+"'"+","+"'"+"Id_us"+"'"+","+"'"+r[a]["id"]+"'"+","+"'"+r[a]["nom"]+"'"+","+"'"+"user_liste_user"+"'"+');" alt="Supprimer"><i class="fa fa-trash"></i></button>'+
	                        '</td>'+
	                    '</tr>');
					}
				}
			},
		});
	}
function mouv_imm()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:'POST',
		data:{"ent":"liste_imm"},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$("#imm")
				.html("<option>--Aucun client enregistr&eacute;</option>");
			}else
			{
				$("#imm")
				.html("<option>Selectionner client</option>");
				for(var a=0;a<r[0]["n"];a++)
				{
					$('#imm')
					.append('<option value="'+r[a]["id"]+'">'+r[a]['code_imm']+'</option>');
				}
			}
		},
	});
}
//	============= RAPPORT =======
	function rapport(p)
	{
		switch(p)
		{
			case "acces":
				$("#resultat").html("<div class='center'><img src='images/gif/ajax-rond3.gif' > Chargement en cours...</div>");
				/*$.ajax({
					url:mainUrl+"modeles/main.php",
					type:"POST",
					data:{"ent":"rapport",
						"p":"acces",
						"acces":$("#acces_liste").val(),
						"dt1":$("#dt1").val(),
						"dt2":$("#dt2").val()
					},
					error:function(data){$("#resultat").html("<div class='center alert alert-warning'>Pas de connexion au serveur</div>")},
					success:function(data)
					{
						alert(data);
					},
				});*/
				$("#resultat")
				.html('<iframe src="vues/pages/impression/rapport_acces.php?acces='+$("#acces_liste").val()+"&dt1="+$("#dt1").val()+"&dt2="+$("#dt2").val()+'" style="width:100%; min-height:500px"></iframe>');

			break; 
		}
	}
//============ FINANCE ==========

//==============================


function num_fiche_rec()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:'POST',
		data:{"ent":"num_fiche_rec"},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			
			$("#num_fic").val(data);
			localStorage.setItem("num_fic",data);
		},
	});
}

function select_monn_a_paye()
{
	var mt_usd=$("#mt_usd").val();
	var mt_cdf=$("#mt_cdf").val();
	if($("#monn_paye").val()=='USD')
	{
		$("#mt_paye").val(mt_usd);
	}else
	{
		$("#mt_paye").val(mt_cdf);
	}
}
function paiement_fact(mouv)
{
	ouvrir_modal("<div class='fs-2 bold center'><i class='glyphicon glyphicon-question-sign'></i> Confirmez-vous la validation de ce paiement ?</div>"+
		"<p class='center pt-1'>"+
			'<button class="btn btn-success" onclick="paiement_fact_conf('+"'"+mouv+"'"+');">Valider</button>&nbsp;&nbsp;'+
			'<button class="btn btn-danger" onclick="fermer_modal();">Annuler</button>&nbsp;&nbsp;'+
		"</p>"
	);
}
function paiement_fact_conf(mouv)
{
	fermer_modal();
	popup_loading();

	$.ajax({
		url:mainUrl+"modeles/add.php",
		type:"POST",
		data:{"ent":"paiement_fact",
			"mouv":mouv,
			"client":$("#client").val(),
			"num_facture":$("#num_long").val(),
			"mt_paye":$("#mt_paye").val(),
			"monn_paye":$("#monn_paye").val(),
			"quittance":$("#quittance").val()},
		error:function(data){connexion_serveur();},
		success:function(data)
		{
			fermer_modal();
			if(data==1)
			{
				fermer_modal();
				ouvrir('mouvement_liste');
				window.open("vues/pages/impression/facture_paye.php?id_mouv="+0+"&num_mouv="+mouv,"PopUp","width=800,height=650,location=no,status=no,toolbar=no,scrollbars=no");

			}else
			{

			}
		}
	});
}
function bordereau()
{
	$dt=$("#dt").val();
	$("#resultat").html("<img src='images/gif/ajax-rond.gif'> chargement en cours...");
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:'POST',
		data:{"ent":"bordereau","dt":$dt},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			var r=JSON.parse(data);
			//alert(data);
			$("#resultat")
			.html("<table class='w3-small w3-table-all'>"+
				"<tr class='blue-grey white-text bold'>"+
					"<td>EXPLOITANT + FACT</td>"+
					"<td>MT HT $US</td>"+
					"<td>MT HT FC</td>"+
					"<td>MT TVA US</td>"+
					"<td>MT TVA FC</td>"+
					"<td>MT TTC $US</td>"+
					"<td>MT TTC FC</td>"+
					"<td>N° QUITTANCE</td>"+
					"<td>OBSERVATION</td>"+
				"</tr>"+
			"</table>");
			
			var acces=r["acc"];
			var rda=r["rda"];
			var st_acc_usd=r["st_acc_usd"];
			var st_acc_tva_usd=r["st_acc_tva_usd"];
			var st_acc_tt_usd=r["st_acc_tt_usd"];
			var st_acc_cdf=r["st_acc_cdf"];
			var st_acc_tva_cdf=r["st_acc_tva_cdf"];
			var st_acc_tt_cdf=r["st_acc_tt_cdf"];

			var st_rda_usd=r["st_rda_usd"];
			var st_rda_tva_usd=r["st_rda_tva_usd"];
			var st_rda_tt_usd=r["st_rda_tt_usd"];
			var st_rda_cdf=r["st_rda_cdf"];
			var st_rda_tva_cdf=r["st_rda_tva_cdf"];
			var st_rda_tt_cdf=r["st_rda_tt_cdf"];

			var t_usd=r["t_usd"];
			var t_tva_usd=r["t_tva_usd"];
			var t_tt_usd=r["t_tt_usd"];
			var t_cdf=r["t_cdf"];
			var t_tva_cdf=r["t_tva_cdf"];
			var t_tt_cdf=r["t_tt_cdf"];

			var idf=r["idf"];
			
	//==================== PARTIE DU TABLEAU POUR REDEVANCES
			$("table")
			.append("<tr class='bold fs-15'><td colspan='9'>LES ACCES PONCTUELS</td></tr>");
			if(acces[0]["n"]==0)
			{
				$("table")
				.append("<tr><td colspan='9'>Aucun acces enregistr&eacute;</td></tr>");
			}else
			{
				
					$("table")
					.append("<tr>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>PERCUS</td>"+
					"</tr>");
				$("table")
					.append("<tr class='purple white-text'>"+
						"<td>Sous-total</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td></td>"+
						"<td></td>"+
					"</tr>");
			}
	//====================== PARTIE DU TABLEAU POUR RDA
			$("table")
			.append("<tr class='bold fs-15'><td colspan='9'>RDA</td></tr>");
			if(rda[0]['n']==0)
			{
				$("table")
				.append("<tr><td colspan='9'>Aucun acces enregistr&eacute;</td></tr>");
			}else
			{
				
					$("table")
					.append("<tr>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>TOTALITE</td>"+
					"</tr>");
				
				$("table")
					.append("<tr class='purple white-text'>"+
						"<td>Sous-total</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td>0</td>"+
						"<td></td>"+
						"<td></td>"+
					"</tr>");
			}
	//===================== PARTIE DU TABLEAU POUR IDF
			$("table")
			.append("<tr class='bold fs-15'><td colspan='9'>IDF FRET</td></tr>");
			if(idf[0]['n']==0)
			{
				$("table")
				.append("<tr><td colspan='9'>Aucun idf fret</td></tr>");
			}else
			{
				
					$("table")
					.append("<tr>"+
						"<td></td>"+
						"<td>0</td>"+
						"<td></td>"+
						"<td></td>"+
						"<td></td>"+
						"<td>0</td>"+
						"<td></td>"+
						"<td></td>"+
						"<td>TOTALITE</td>"+
					"</tr>");
				/*$("table")
					.append("<tr class='purple white-text'>"+
						"<td>Sous-total</td>"+
						"<td>"+st_rda_usd+"</td>"+
						"<td>"+st_rda_cdf+"</td>"+
						"<td>"+st_rda_tva_usd+"</td>"+
						"<td>"+st_rda_tva_cdf+"</td>"+
						"<td>"+st_rda_tt_usd+"</td>"+
						"<td>"+st_rda_tt_cdf+"</td>"+
						"<td></td>"+
						"<td></td>"+
					"</tr>");*/
			}
	//======================== PARTIE DU TABLEAU POUR LE TOTAL GENERAL
			$("table")
			.append("<tr class='black white-text'>"+
				"<td>Total</td>"+
				"<td>0</td>"+
				"<td>0</td>"+
				"<td>0</td>"+
				"<td>0</td>"+
				"<td>0</td>"+
				"<td>0</td>"+
				"<td></td>"+
				"<td></td>"+
			"</tr>");

			//$("table")
			//.append("<tr><td colspan='9' class='center' align='center'><button class='btn btn-success'>Imprimer</i> </td></tr>");
	//===================================================================
			$("#resultat")
			.append("<p class='mt-1 pt-1 center'>"+
				'<button class="btn btn-success" onclick="impression_bordereau('+"'"+$dt+"'"+')"><i class="fa fa-print"></i> Imprimer</button>&nbsp;'+
				'<button class="btn btn-success" onclick="impression_bordereau('+"'"+$dt+"'"+')"><i class="fa fa-table"></i> Exporter vers Excel</button>'+
				'</p>');	
		}, 
	});
}


function bordereau_cl()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"liste_client_tout"},
		error:function(data){},
		success:function(data)
		{
			var r=JSON.parse(data);
			$("#client_l")
			.append('<option value="">--Selectionner client--</option>');
			for(var a=0;a<r.length;a++)
			{
				$("#client_l")
				.append('<option value="'+r[a]['id']+'">'+r[a]['nom_cli']+'</option>');
			}
		},
	});
}
function bordereau_acces()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"liste_type_acces"},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			var r=JSON.parse(data);
			for(var a=0;a<r.length;a++)
			{
				$("#type_acces")
				.append('<option value="'+r[a]['id']+'">'+r[a]['designation_acc']+'</option>');
			}
		},
	});
}
function bordereau_par_cl()
{
	$("#resultat3")
	.html('<iframe src="vues/pages/impression/bordereau_cl.php?client='+$("#client_l").val()+"&dt="+$("#bord_dt").val()+"&dt2="+$("#bord_dt2").val()+'" style="width:100%; min-height:500px"></iframe>');
}
function bordereau_par_per()
{
	switch($("#type_acces").val())
	{
		case "RDA":
			$("#resultat2")
			.html("Chargement des données en cours...");
			$("#resultat2")
			.html('<iframe src="vues/pages/impression/bordereau_per.php?dt='+$("#per_dt").val()+"&dt2="+$("#per_dt2").val()+'" style="width:100%; min-height:500px"></iframe>');
		break;
		case "IDF":
			$("#resultat2")
			.html("Chargement des données en cours...");
			$("#resultat2")
			.html('<iframe src="vues/pages/impression/bordereau_per_idf.php?dt='+$("#per_dt").val()+"&dt2="+$("#per_dt2").val()+'" style="width:100%; min-height:500px"></iframe>');
		break;
		case "HANDLING":
			$("#resultat2")
			.html("Chargement des données en cours...");
			$("#resultat2")
			.html('<iframe src="vues/pages/impression/bordereau_per_handling.php?dt='+$("#per_dt").val()+"&dt2="+$("#per_dt2").val()+'" style="width:100%; min-height:500px"></iframe>');
		break;
		default:
			$("#resultat2")
			.html("Chargement des données en cours...");
			$("#resultat2")
			.html('<iframe src="vues/pages/impression/bordereau_per_acces.php?dt='+$("#per_dt").val()+"&type_acces="+$('#type_acces').val()+"&dt2="+$("#per_dt2").val()+'" style="width:100%; min-height:500px"></iframe>');
		break;
	}
}
function ventillation()
{
	$dt1=$("#dt1").val();
	$client=$("#client").val();
	$dt2=$("#dt2").val();
	/*popup_loading();
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"ventillation","dt1":$dt1,"dt2":$dt2},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			fermer_modal();
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$("#resultat").html("<div class='alert alert-warning fs-15 bold center'>Pas de facture imprim&eacutees à cette date</div>");
			}else
			{
				$("#resultat")
					.html("<div>Total :"+""+r[0]["n"]+""+"</div>"+
						"<table class='w3-small w3-table-all'>"+
						"<tr class='blue-grey white-text bold'>"+
							"<td>DATE</td>"+
							"<td>HEURE</td>"+
							"<td>CLIENT</td>"+
							"<td>IMMATR</td>"+
						"</tr>"+
					"</table>");
				for(var a=0;a<r[0]['n'];a++)
				{
					$("table")
					.append("<tr class=''>"+
						"<td>"+r[0]['resultat'][a]['dt']+"</td>"+
						"<td>"+r[0]['resultat'][a]['heure']+"</td>"+
						"<td>"+r[0]['resultat'][a]['client']+"</td>"+
						"<td>"+r[0]['resultat'][a]['imm']+"</td>"+
					"</tr>");
				}
				$("#resultat")
				.append("<div class='center pt-1'>"+
							'<button class="btn btn-success" onclick="impression_ventillation('+"'"+$dt1+"'"+","+"'"+$dt2+"'"+')">Imprimer</button>'+
						"</div>");
			}
		},
	});*/
	fermer_modal();
	if($client=='tout')
	{
		$("#resultat")
		.html('<iframe src="vues/pages/impression/ventillation_jr.php?dt='+$dt1+'&dt2='+$dt2+'"'+' style="width:100%; height:700px">'+
			"</iframe>");
	}else
	{
		$("#resultat")
		.html('<iframe src="vues/pages/impression/ventillation.php?client='+$client+'&dt='+$dt1+'&dt2='+$dt2+'"'+' style="width:100%; height:700px">'+
			"</iframe>");
	}
}
function ventillation_client()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"liste_client_tout"},
		error:function(data){},
		success:function(data)
		{
			var r=JSON.parse(data);
			for(var a=0;a<r.length;a++)
			{
				$("select")
				.append('<option value="'+r[a]['id']+'">'+r[a]['nom_cli']+'</option>');
			}
		},
	});
}

function mouvement_liste_mouvement()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"mouvement_liste"},
		error:function(data){connexion_serveur(); $(".panel-body").html("<div class='alert alert-danger'>Pas de connexion au service</div>")},
		success:function(data)
		{
			var r=JSON.parse(data);
			$(".panel-body")
			.html("<table class='w3-table-all w3-small table'>"+
					"<tr class='blue-grey bold white-text'>"+
						"<td>DATE MOUV</td>"+
						"<td>N° FORM</td>"+
						"<td>IMMATR</td>"+
						"<td>CLIENT</td>"+
						"<td>ETAT FACT.</td>"+
						"<td>OPTION</td>"+
					"</tr>"+
				"</table");
			for(var a=0;a<r.length;a++)
			{
				$("table")
				.append("<tr>"+
					"<td>"+r[a]["dt_mouv"]+"</td>"+
					"<td>"+r[a]["Num_form"]+"</td>"+
					"<td>"+r[a]["Code_imm"]+"</td>"+
					"<td>"+r[a]["Nom_cli"]+"</td>"+
					'<td style="font-weight:bold" class='+"'"+r[a]["classe"]+"'"+'>'+r[a]["statut"]+"</td>"+
					"<td>"+
						//'<a href="#" onclick="ouvrir('+"'"+"mouvement_apercu2"+"'"+","+"'"+r[a]["Id_mouv"]+"'"+","+"'"+r[a]['Num_mouv']+"'"+');"><i class="fa fa-print"></i>&nbsp;Apercu</a>&nbsp;&nbsp&nbsp&nbsp;&nbsp;&nbsp;&nbsp;'+
						'<a href="#" onclick="ouvrir('+"'"+"paiement_cash"+"'"+","+"'"+r[a]["Id_mouv"]+"'"+","+"'"+r[a]['Num_mouv']+"'"+');"><i class="glyphicon glyphicon-check"></i>&nbsp;Valider paiement</a>'+
					"</td>"+
				"</tr>");
			}
		}
	});
}
function mouvement_facture()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"mouvement_facture"},
		error:function(data){connexion_serveur(); $(".panel-body").html("<div class='alert alert-danger'>Pas de connexion au service</div>")},
		success:function(data)
		{
			var r=JSON.parse(data);
			$(".panel-body")
			.html("<table class='w3-table-all w3-small table'>"+
					"<tr class='blue-grey bold white-text'>"+
						"<td>DATE MOUV</td>"+
						"<td>N° FORM</td>"+
						"<td>IMMATR</td>"+
						"<td>CLIENT</td>"+
						"<td>ETAT FACT.</td>"+
						"<td>OPTION</td>"+
					"</tr>"+
				"</table");
			for(var a=0;a<r.length;a++)
			{
				$("table")
				.append("<tr>"+
					"<td>"+r[a]["dt_mouv"]+"</td>"+
					"<td>"+r[a]["Num_form"]+"</td>"+
					"<td>"+r[a]["Code_imm"]+"</td>"+
					"<td>"+r[a]["Nom_cli"]+"</td>"+
					'<td style="font-weight:bold" class='+"'"+r[a]["classe"]+"'"+'>'+r[a]["statut"]+"</td>"+
					"<td>"+
						//'<a href="#" onclick="ouvrir('+"'"+"mouvement_apercu2"+"'"+","+"'"+r[a]["Id_mouv"]+"'"+","+"'"+r[a]['Num_mouv']+"'"+');"><i class="fa fa-print"></i>&nbsp;Apercu</a>&nbsp;&nbsp&nbsp&nbsp;&nbsp;&nbsp;&nbsp;'+
						'<a href="#" onclick="ouvrir('+"'"+"paiement_cash"+"'"+","+"'"+r[a]["Id_mouv"]+"'"+","+"'"+r[a]['Num_mouv']+"'"+');"><i class="glyphicon glyphicon-check"></i>&nbsp;Valider paiement</a>'+
					"</td>"+
				"</tr>");
			}
			$(".panel-body")
			.append("<div class='grey center blue-text fs-2 p-1' id='chargement'><input type='hidden' id='chargement_val' value='151'><a onclick='charger_plus();'>Charger plus</a></div>");
		}
	});	
}
function charger_plus()
{
	var v=parseInt($("#chargement_val").val());
	$("#chargement").html('<div class="center"><img src="images/gif/ajax-rond.gif" /> chargement en cours...</div>');
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"mouvement_facture_suite","v":v},
		error:function(data){connexion_serveur(); $(".panel-body").html("<div class='alert alert-danger'>Pas de connexion au service</div>")},
		success:function(data)
		{
			$("#chargement").remove();
			var r=JSON.parse(data);			
			for(var a=0;a<r.length;a++)
			{
				$("table")
				.append("<tr>"+
					"<td>"+r[a]["dt_mouv"]+"</td>"+
					"<td>"+r[a]["Num_form"]+"</td>"+
					"<td>"+r[a]["Code_imm"]+"</td>"+
					"<td>"+r[a]["Nom_cli"]+"</td>"+
					'<td style="font-weight:bold" class='+"'"+r[a]["classe"]+"'"+'>'+r[a]["statut"]+"</td>"+
					"<td>"+
						//'<a href="#" onclick="ouvrir('+"'"+"mouvement_apercu2"+"'"+","+"'"+r[a]["Id_mouv"]+"'"+","+"'"+r[a]['Num_mouv']+"'"+');"><i class="fa fa-print"></i>&nbsp;Apercu</a>&nbsp;&nbsp&nbsp&nbsp;&nbsp;&nbsp;&nbsp;'+
						'<a href="#" onclick="ouvrir('+"'"+"paiement_cash"+"'"+","+"'"+r[a]["Id_mouv"]+"'"+","+"'"+r[a]['Num_mouv']+"'"+');"><i class="glyphicon glyphicon-check"></i>&nbsp;Valider paiement</a>'+
					"</td>"+
				"</tr>");
			}
			$(".panel-body")
			.append("<div class='grey center blue-text fs-2 p-1' id='chargement'><input type='hidden' id='chargement_val' value='351'><a href='#chargement_val' onclick='charger_plus();'>Charger plus</a></div>");
			v=v+150;
			$("#chargement_val").val(v);
		}
	});	
}
function releve_client_liste_client()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:'POST',
		data:{"ent":"client"},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$("#loading_cl").html("<small class='text-warning'>Aucun client enregistré</small>");
			}else
			{
				$("#loading_cl").html("");
				$("#client")
				.html("<option value=''>--Selectionner--</option>");

				$("#client")
				.append("<option value='t'>Tous</option>");
				for(var a=0;a<r.length;a++)
				{
					$("#client")
					.append("<option value='"+r[a]["id_cl"]+"'>"+r[a]["nom_cl"]+"</option>");
				}
			}
		},
	});		
}
function releve_client()
{
	$("#resultat").html("<div class='center'><img src='images/gif/ajax-rond.gif' /> chargement en cours...");
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"releve_client",
			"client":$("#client").val(),
			"dt1":$("#dt1").val(),
			"dt2":$("#dt2").val()
		},
		error:function(data){connexion_serveur();},
		success:function(data)
		{
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$("#resultat")
				.html("<div class='alert alert-warning center bold fs-2'>Aucun mouvement trouvé</div>");
			}else
			{
				var dernier_total=r.length-1
				$("#resultat")
				.html("<div class='fs-2 w3-border w3-round p-1' align='left'>"+
					"<i class='fa fa-check'></i> Total mouvement : "+r[0]["n"]+"<br />"+
					"<i class='fa fa-dollar'></i> Montant global : "+r[dernier_total]["total"]+" USD<br />"+
				"</div>");

				$("#resultat")
				.append("<table class='w3-table-all w3-table'>"+
				"<tr class='blue-grey bold white-text'>"+
					'<td onclick="w3.sortHTML('+"'"+"table"+"'"+","+"'"+".item"+"'"+","+"'"+"td:nth-child(1)"+"'"+')" title="Trier par immatriculation"><i class="fa fa-sort"></i> IMMATR</td>'+
					'<td onclick="w3.sortHTML('+"'"+"table"+"'"+","+"'"+".item"+"'"+","+"'"+"td:nth-child(2)"+"'"+')" title="Trier par immatriculation"><i class="fa fa-sort"></i> DATE MOUV</td>'+
					"<td>HEURE</td>"+
					'<td onclick="w3.sortHTML('+"'"+"table"+"'"+","+"'"+".item"+"'"+","+"'"+"td:nth-child(4)"+"'"+')" title="Trier par n° formulaire "><i class="fa fa-sort"></i> N° FORM</td>'+
					"<td>MONTANT</td>"+
					"<td>OPTION</td>"+
				"</tr></table>");
				for(var a=0;a<r.length;a++)
				{
					$("#resultat table")
					.append("<tr class='item w3-hover-grey'>"+
						"<td>"+r[a]["mouv"]["ta"]["Code_imm"]+"</td>"+
						"<td>"+r[a]["date_arr"]+" - "+r[a]["date_dep"]+"</td>"+
						"<td>"+r[a]["mouv"]["ta"]["Heure_mouv"]+" - "+r[a]["mouv"]["td"]["Heure_mouv"]+"</td>"+
						"<td>"+r[a]["mouv"]["ta"]["Num_form"]+"</td>"+
						"<td>"+r[a]["mouv"]["tot_avec_tva"]+" USD</td>"+
						"<td>"+
							'<a href="#" onclick="ouvrir('+"'"+"mouvement_apercu2"+"'"+","+"'"+r[a]["mouv"]["ta"]["Id_mouv"]+"'"+","+"'"+r[a]["mouv"]["ta"]['Num_mouv']+"'"+');">Visualiser</a> | '+
							'<a href="#" onclick="ouvrir('+"'"+"mouvement_modif_detail"+"'"+","+"'"+r[a]["mouv"]["ta"]["Id_mouv"]+"'"+","+"'"+r[a]["mouv"]["ta"]['Num_mouv']+"'"+');">Modifier</a> | '+
							'<a href="#" onclick="suppression_mouv_relevement('+"'"+r[a]["mouv"]["ta"]['Num_mouv']+"'"+');">supprimer</a>'+
						'</td>'+
					"</tr>");
				}
			}
		},
	});
}

function liste_facture()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"liste_facture_non_imprime"},
		error:function(data){connexion_serveur(); $(".panel-body").html("<div class='alert alert-danger'>Pas de connexion au service</div>")},
		success:function(data)
		{
			var r=JSON.parse(data);
			$(".panel-body")
			.html("<table class='w3-table-all w3-small table'>"+
					"<tr class='blue-grey bold white-text'>"+
						'<td onclick="w3.sortHTML('+"'"+"table"+"'"+","+"'"+".item"+"'"+","+"'"+"td:nth-child(1)"+"'"+')" title="Trier par code"><a href="#" class="white-text"><i class="fa fa-sort"></i> DATE SAISIE</a></td>'+
						'<td onclick="w3.sortHTML('+"'"+"table"+"'"+","+"'"+".item"+"'"+","+"'"+"td:nth-child(2)"+"'"+')" title="Trier par code"><a href="#" class="white-text"><i class="fa fa-sort"></i> DATES MOUV</a></td>'+
						'<td onclick="w3.sortHTML('+"'"+"table"+"'"+","+"'"+".item"+"'"+","+"'"+"td:nth-child(3)"+"'"+')" title="Trier par code"><a href="#" class="white-text"><i class="fa fa-sort" ></i> N° FORM</a></td>'+
						"<td>IMMATR</td>"+
						'<td onclick="w3.sortHTML('+"'"+"table"+"'"+","+"'"+".item"+"'"+","+"'"+"td:nth-child(5)"+"'"+')" title="Trier par code"><a href="#" class="white-text"><i class="fa fa-sort"></i> CLIENT</a></td>'+
						"<td>ETAT FACT.</td>"+
						"<td>OPTION</td>"+
					"</tr>"+
				"</table");
			for(var a=0;a<r.length;a++)
			{
				$("table")
				.append("<tr class='w3-hover-grey item'>"+
					"<td>"+r[a]["dt_saisie"]+"</td>"+
					"<td>"+r[a]["dt_mouv"]+"</td>"+
					"<td>"+r[a]["Num_form"]+"</td>"+
					"<td>"+r[a]["Code_imm"]+"</td>"+
					"<td>"+r[a]["Nom_cli"]+"</td>"+
					'<td style="font-weight:bold" class='+"'"+r[a]["classe"]+"'"+'>'+r[a]["statut"]+"</td>"+
					"<td>"+
						'<a href="#" onclick="ouvrir('+"'"+"mouvement_apercu2"+"'"+","+"'"+r[a]["Id_mouv"]+"'"+","+"'"+r[a]['Num_mouv']+"'"+');"><i class="fa fa-print"></i>&nbsp;Apercu</a>&nbsp;&nbsp&nbsp&nbsp;&nbsp;&nbsp;&nbsp;'+
						//'<a href="#" onclick="ouvrir('+"'"+"paiement_cash"+"'"+","+"'"+r[a]["Id_mouv"]+"'"+","+"'"+r[a]['Num_mouv']+"'"+');"><i class="glyphicon glyphicon-check"></i>&nbsp;Valider paiement</a>'+
					"</td>"+
				"</tr>");
			}
		}
	});
}
function liste_facture_suite()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"liste_facture_non_imprime_suite"},
		error:function(data){connexion_serveur(); $(".panel-body").html("<div class='alert alert-danger'>Pas de connexion au service</div>")},
		success:function(data)
		{
			var r=JSON.parse(data);
			for(var a=0;a<r.length;a++)
			{
				$("table")
				.append("<tr class='w3-hover-grey item'>"+
					"<td>"+r[a]["dt_saisie"]+"</td>"+
					"<td>"+r[a]["dt_mouv"]+"</td>"+
					"<td>"+r[a]["Num_form"]+"</td>"+
					"<td>"+r[a]["Code_imm"]+"</td>"+
					"<td>"+r[a]["Nom_cli"]+"</td>"+
					'<td style="font-weight:bold" class='+"'"+r[a]["classe"]+"'"+'>'+r[a]["statut"]+"</td>"+
					"<td>"+
						'<a href="#" onclick="ouvrir('+"'"+"mouvement_apercu2"+"'"+","+"'"+r[a]["Id_mouv"]+"'"+","+"'"+r[a]['Num_mouv']+"'"+');"><i class="fa fa-print"></i>&nbsp;Apercu</a>&nbsp;&nbsp&nbsp&nbsp;&nbsp;&nbsp;&nbsp;'+
						//'<a href="#" onclick="ouvrir('+"'"+"paiement_cash"+"'"+","+"'"+r[a]["Id_mouv"]+"'"+","+"'"+r[a]['Num_mouv']+"'"+');"><i class="glyphicon glyphicon-check"></i>&nbsp;Valider paiement</a>'+
					"</td>"+
				"</tr>");
			}
			$(".panel-body")
			.append("<div class='grey center blue-text fs-2 p-1' id='chargement'><input type='hidden' id='chargement_val' value='151'><a onclick='charger_plus();'>Charger plus</a></div>");
		}
	});
}
function liste_facture_non_regle()
{
	$("#resultat").html("<img src='images/gif/ajax-rond.gif' /> Resultat en cours de traitement...");
	$.ajax({
		url:mainUrl+'modeles/main.php',
		type:"POST",
		data:{"ent":"liste_facture_non_regle","client":$("#client").val(),"dt":$("#dt").val(),"dt2":$("#dt2").val()},
		error:function(data){$("#resultat").html("<div class='alert alert-warning center bold fs-2'>Pas de connexion au serveur</div>");},
		success:function(data)
		{
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$("#resultat").html("<img src='images/gif/ajax-rond.gif' /> Resultat en cours de traitement...");
			}else
			{
				$("#resultat")
				.html("<table class='w3-table-all w3-table'><tr class='blue-grey bold white-text'>"+
					"<td>Date fact</td>"+
					"<td>Formulaire</td>"+
					"<td>N° Facture</td>"+
					"<td>Client</td>"+
					"<td>Montant</td>"+
				"</tr></table>");
				for(var a=0;a<r.length;a++)
				{
					$("#resultat table")
					.append("<tr>"+
						"<td>"+r[a]['dt']+"</td>"+
						"<td>"+r[a]['formulaire']+"</td>"+
						"<td>"+r[a]['facture']+"</td>"+
						"<td>"+r[a]['client']+"</td>"+
						"<td>"+r[a]['montant']+"</td>"+
					"</tr>");
				}
			}
			
		},
	});
}
function modif_liste_mouvement()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"mouvement_liste_tout"},
		error:function(data){connexion_serveur(); $(".panel-body").html("<div class='alert alert-danger'>Pas de connexion au service</div>")},
		success:function(data)
		{
			var r=JSON.parse(data);
			$(".panel-body")
			.html("<table class='w3-table-all w3-small table'>"+
					"<tr class='blue-grey bold white-text'>"+
						"<td>DATE MOUV</td>"+
						"<td>N° FORM</td>"+
						"<td>MOUV</td>"+
						"<td>IMMATR</td>"+
						"<td>CLIENT</td>"+
						"<td>OPTION</td>"+
					"</tr>"+
				"</table");
			for(var a=0;a<r.length;a++)
			{
				$("table")
				.append("<tr>"+
					"<td>"+r[a]["dt_mouv"]+"</td>"+
					"<td>"+r[a]["Num_form"]+"</td>"+
					"<td>"+r[a]["mouv"]["ville_arr"]+" - "+r[a]["mouv"]["ville_dep"]+"</td>"+
					"<td>"+r[a]["Code_imm"]+"</td>"+
					"<td>"+r[a]["Nom_cli"]+"</td>"+
					"<td>"+
						'<a href="#" onclick="ouvrir('+"'"+"mouvement_modif_detail"+"'"+","+"'"+r[a]["Id_mouv"]+"'"+","+"'"+r[a]['Num_mouv']+"'"+');"><i class="fa fa-edit"></i>&nbsp;Modifier</a>&nbsp;&nbsp&nbsp&nbsp;&nbsp;&nbsp;&nbsp;'+
						//'<a href="#" onclick="ouvrir('+"'"+"paiement_cash"+"'"+","+"'"+r[a]["Id_mouv"]+"'"+","+"'"+r[a]['Num_mouv']+"'"+');"><i class="fa fa-trash"></i>&nbsp;Supprimer</a>'+
					"</td>"+
				"</tr>");
			}
		}
	});
}
function modif_ville_nat()
{

	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:'POST',
		data:{"ent":"liste_ville_nat"},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$("#esc1dep_ville")
				.html("<option value=''>--Aucun client enregistr&eacute;</option>");
			}else
			{
				
				for(var a=0;a<r[0]["n"];a++)
				{
					$('#ville_nat')
					.append('<option value="'+r[a]["id"]+'">'+r[a]['code_ville']+'</option>');

					$("#esc1_ville")
					.append('<option value="'+r[a]["id"]+'">'+r[a]['code_ville']+'</option>');
					
				}

			}
		},
	});	
}
function releve_mens_valorise_liste_cl()
{
	
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"liste_client_tout"},
		error:function(data){},
		success:function(data)
		{
			var r=JSON.parse(data);
			$("select")
			.append('<option value="">--Selectionner Client</option>');
			for(var a=0;a<r.length;a++)
			{
				$("select")
				.append('<option value="'+r[a]['id']+'">'+r[a]['nom_cli']+'</option>');
			}
		},
	});	
}
function facture_agree_client()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"liste_client_tout"},
		error:function(data){},
		success:function(data)
		{

			var r=JSON.parse(data);
			for(var a=0;a<r.length;a++)
			{
				$("select")
				.append('<option value="'+r[a]['id']+'">'+r[a]['nom_cli']+'</option>');
			}
		},
	});
}
function facture_agree()
{
	$("#resultat").html("<img src='images/gif/ajax-rond.gif'> Chargement en cours...");
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:'POST',
		data:{"ent":"facture_agree","client":$("#client").val(),"dt1":$("#dt1").val(),"dt2":$("#dt2").val()},
		error:function(data){connexion_serveur()},
		success:function(data)
		{

			var r=JSON.parse(data);
			if(r["n"]==0)
			{
				$("#resultat").html("<div class='alert alert-warning fs-15 bold center'>Aucune donnée trouvée</div>");
			}else
			{
				//alert(r['n']);
				$("#resultat")
				.html("<table class='w3-table-all w-75'>"+
					"<tr class=''>"+
						"<td class='w-75'>DESIGNATION</td>"+
						"<td>MONTANT EN $ US</td>"+
					"</tr>"+
					"<tr>"+
						"<td>ROUTE</td>"+
						"<td>"+r['route']+"</td>"+
					"</tr>"+
					"<tr>"+
						"<td>ATTERISSAGE</td>"+
						"<td>"+r['atterissage']+"</td>"+
					"</tr>"+
					"<tr>"+
						"<td>STATIONNEMENT TARMAC</td>"+
						"<td>"+r['stationnement']+"</td>"+
					"</tr>"+
					"<tr>"+
						"<td>FRET</td>"+
						"<td>"+r['fret']+"</td>"+
					"</tr>"+
					"<tr>"+
						"<td>PASSAGERS</td>"+
						"<td>"+r['passager']+"</td>"+
					"</tr>"+
					"<tr>"+
						"<td>PEC</td>"+
						"<td>"+r['pec']+"</td>"+
					"</tr>"+
					"<tr>"+
						"<td>SURETE</td>"+
						"<td>"+r['surete']+"</td>"+
					"</tr>"+
					"<tr>"+
						"<td>SECURITE</td>"+
						"<td>"+r['securite']+"</td>"+
					"</tr>"+
					"<tr>"+
						"<td>ASSIS ANTI INC</td>"+
						"<td>"+r['ass']+"</td>"+
					"</tr>"+
					"<tr>"+
						"<td>FORMULAIRE</td>"+
						"<td>"+r['formu']+"</td>"+
					"</tr>"+
					"<tr>"+
						"<td>COMPTOIR</td>"+
						"<td>"+r['compt']+"</td>"+
					"</tr>"+
					"<tr class='blue-grey white-text bold'>"+
						"<td>TOTAL</td>"+
						"<td>"+r['tot']+"</td>"+
					"</tr>"+
				"</table>");
				$("#resultat")
				.append("<a href='#' onclick='num_fact_agree();return false' class='btn btn-success mt-1'>Generer fichier impression</a>");
			}

		},
	});
}
function num_fact_agree()
{
	ouvrir_modal("<div><h3>Veuillez entrer le N° de la Facture</h3>"+
		'<div align="center">'+
			'<form onsubmit="print_fact_agr(); return false">'+
				'<input type="text" class="form-control browser-default" id="z_num_fact_agr" required>'+
				'<button class="btn btn-success" type="submit">Enregistrer</button>'+
			'</form>'+
		'</div>'+
	"</div>")	
}
function print_fact_agr()
{
	fermer_modal();
	popup_loading();
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"num_fact_agr","num":$("#z_num_fact_agr").val()},
		success:function(data)
		{
			fermer_modal();
			window.open("vues/pages/impression/facture_agree.php?client="+$("#client").val()+"&dt="+$("#dt1").val()+"&dt2="+$("#dt2").val(),"PopUp","width=800,height=650,location=no,status=no,toolbar=no,scrollbars=no");
			//alert(data);
		},
	});
}
function idf_liste_cli()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"liste_client_tout"},
		error:function(data){},
		success:function(data)
		{
			var r=JSON.parse(data);
			$("#client")
			.html('<option value="">--Selectionner client--</option>');
			for(var a=0;a<r.length;a++)
			{
				$("#client")
				.append('<option value="'+r[a]['id']+'">'+r[a]['nom_cli']+'</option>');
			}
		},
	});	
}
function ajout_idf()
{
	$contenu="<div class='center fs-15'><p>Confirmez-vous cet enregistrement ? <p>"+
					"<p class='center mt-1'>"+
						'<button class="btn green" onclick="ajout('+"'"+"idf"+"'"+'); ;"><i class="fa fa-check-circle"></i>&nbsp;Enregistrer</button>&nbsp;'+
						"<button class='btn red' onclick='fermer_modal();'><i class='fa fa-times'></i>&nbsp;Annuler</button>"+
					"</p>"+
				"</div>";
		popup("Confirmer enregistrement",$contenu);
}
function rapport_idf()
{
	popup_loading();
	$dt1=$("#acces_dt1").val();
	$dt2=$("#acces_dt2").val();
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"rapport_idf","dt1":$dt1,"dt2":$dt2},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			fermer_modal();
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$("#resultat")
				.html("<div class='alert alert-warning center bold fs-2'>Aucun accès trouvé</div>");
			}else
			{
				$("#resultat")
				.html("<table class='w3-table-all w3-table'><tr class='blue-grey white-text bold'>"+
					"<td>OPT</td>"+
					"<td>DATE</td>"+
					"<td>EXPLOITANT</td>"+
					"<td>MONTANT</td>"+
					"<td>QUITTANCE</td>"+
					"<td>OPTION</td>"+
				"</tr></table>");
				for(var a=0;a<r.length;a++)
				{
					$("#resultat table")
					.append("<tr>"+
						'<td><a href="#body" onclick="del('+"'"+"idf_paiement"+"'"+","+"'"+"Id_paie"+"'"+","+"'"+r[a]["id"]+"'"+","+"'"+"Idf"+"'"+')"><i class="fa fa-trash"></i></td>'+
						"<td>"+r[a]['dt']+"</td>"+
						"<td>"+r[a]['exploitant']+"</td>"+
						"<td>"+r[a]["mt"]+" "+r[a]["monn"]+"</td>"+
						"<td>"+r[a]['quittance']+"</td>"+
						'<td>'+
							'<a href="#body" onclick="upd('+"'"+"idf"+"'"+","+"'"+r[a]["id"]+"'"+","+"'"+r[a]['dt']+"'"+","+"'"+r[a]['id_exp']+"'"+","+"'"+r[a]["mt"]+"'"+","+"'"+r[a]['monn']+"'"+","+"'"+r[a]["quittance"]+"'"+')"><i class="fa fa-edit"></i> Modifier</td>'+
						"</tr>");
				}
			}
		},
	});
}
function rapport_access()
{
	popup_loading();
	$dt1=$("#acces_dt1").val();
	$dt2=$("#acces_dt2").val();
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"rapport_acces","dt1":$dt1,"dt2":$dt2},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			fermer_modal();
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$("#resultat")
				.html("<div class='alert alert-warning center bold fs-2'>Aucun accès trouvé</div>");
			}else
			{
				$("#resultat")
				.html("<table class='w3-table-all w3-table'><tr class='blue-grey white-text bold'>"+
					"<td>OPT</td>"+
					"<td>DATE</td>"+
					"<td>N° FACT</td>"+
					"<td>MONTANT</td>"+
					"<td>QUITTANCE</td>"+
					"<td>OPTION</td>"+
				"</tr></table>");
				for(var a=0;a<r.length;a++)
				{
					$("#resultat table")
					.append("<tr>"+
						'<td><a href="#body" onclick="del('+"'"+"acces"+"'"+","+"'"+"Id_acc"+"'"+","+"'"+r[a]["id"]+"'"+","+"'"+"Accès"+"'"+')"><i class="fa fa-trash"></i></td>'+
						"<td>"+r[a]['dt']+"</td>"+
						"<td>"+r[a]['num_fact']+"</td>"+
						"<td>"+r[a]["mt"]+" "+r[a]["monn"]+"</td>"+
						"<td>"+r[a]['quittance']+"</td>"+
						'<td>'+
							'<a href="#body" onclick="upd('+"'"+"acces"+"'"+","+"'"+r[a]["id"]+"'"+","+"'"+r[a]['dt']+"'"+","+"'"+r[a]['heure']+"'"+","+"'"+r[a]["type_acc"]+"'"+","+"'"+r[a]["quittance"]+"'"+","+"'"+r[a]["mt"]+"'"+","+"'"+r[a]["monn"]+"'"+","+"'"+r[a]['tva']+"'"+')"><i class="fa fa-edit"></i> Modifier</td>'+
						"</tr>");
				}
			}
		},
	});
}
function facture_non_paye_liste()
{
	$(".panel-body")
	.html('<div class="center"><img src="images/gif/ajax-rond.gif" /> chargement en cours...</div>');
	popup_loading();
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:'POST',
		data:{"ent":"facture_non_paye"},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			fermer_modal();
			var r=JSON.parse(data);
			$(".panel-body")
			.html("<table class='w3-table w3-table-all'>"+
				"<tr class='blue-grey white-text bold center'>"+
					'<td>Date</td>'+
					'<td>Expl.</td>'+
					'<td>Facture</td>'+
					'<td>Montant</td>'+
					'<td>Taxateur</td>'+
					'<td>Option</td>'+
				"</tr>"+
			"</table>");
			for(var a=0;a<r.length;a++)
			{
				var detail=r[a]['expl']+" ( "+r[a]['fact']+" ) ";
				$("table")
				.append("<tr class='w3-hover-grey'>"+
					'<td>'+r[a]['dt']+'</td>'+
					'<td>'+r[a]['expl']+'</td>'+
					'<td>'+r[a]['fact']+'</td>'+
					'<td>'+r[a]['montant']+' USD</td>'+
					'<td>'+r[a]['taxateur']+'</td>'+
					'<td><a href="#" onclick="suppr_fact('+"'"+r[a]['id']+"'"+","+"'"+detail+"'"+');"><i class="fa fa-trash"></i> Supprimer</a></td>'+
				"</tr>");
			}
		},
	});
}
function facture_paye_liste()
{
	$(".panel-body")
	.html('<div class="center"><img src="images/gif/ajax-rond.gif" /> chargement en cours...</div>');
	popup_loading();
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:'POST',
		data:{"ent":"facture_paye"},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			fermer_modal();
			var r=JSON.parse(data);
			$(".panel-body")
			.html("<table class='w3-table w3-table-all'>"+
				"<tr class='blue-grey white-text bold center'>"+
					'<td>Date</td>'+
					'<td>Expl.</td>'+
					'<td>Facture</td>'+
					'<td>Montant</td>'+
					'<td>Percepteur</td>'+
					'<td>Option</td>'+
				"</tr>"+
			"</table>");
			for(var a=0;a<r.length;a++)
			{
				var detail=r[a]['expl']+" ( "+r[a]['fact']+" ) ";
				$("table")
				.append("<tr class='w3-hover-grey'>"+
					'<td>'+r[a]['dt']+'</td>'+
					'<td>'+r[a]['expl']+'</td>'+
					'<td>'+r[a]['fact']+'</td>'+
					'<td>'+r[a]['montant']+' USD</td>'+
					'<td>'+r[a]['percepteur']+'</td>'+
					'<td><a href="#" onclick="suppr_fact_paye('+"'"+r[a]['fact']+"'"+","+"'"+detail+"'"+');"><i class="fa fa-trash"></i> Supprimer</a></td>'+
				"</tr>");
			}
		},
	});
}

function imprimer_fact_cash(id, mouv)
{
	ouvrir_modal("<div class='center bold mt-1 fs-2'><i class='fa fa-question-circle'></i> Confirmez-vous l'impression de cette facture ?</div>"+
		"<p class='center mt-2'>"+
			'<button class="btn btn-primary" onclick="imprimer_fact_cash_conf('+"'"+id+"'"+","+"'"+mouv+"'"+');"><i class="fa fa-check-circle"></i>&nbsp;Imprimer</button>&nbsp;&nbsp;'+
			"<button class='btn btn-danger' onclick='fermer_modal();'><i class='fa fa-times-circle'></i>&nbsp;Annuler</button>"+
		"</p>"
	);	
}
function imprimer_fact_cash_conf(id, mouv)
{
	fermer_modal();
	window.open("vues/pages/impression/facture_cash.php?id_mouv="+id+"&num_mouv="+mouv,"PopUp","width=800,height=650,location=no,status=no,toolbar=no,scrollbars=no");
}

function reimpression()
{
	ouvrir_modal("<div><h3 class='center'>Selectionner type reimpression</h3>"+
				'<div class="center"><button class="btn btn-success" onclick="fermer_modal(); ouvrir('+"'"+"facture_imprime"+"'"+');">Facturation cash</button>&nbsp;<button class="btn btn-danger" onclick="fermer_modal(); ouvrir('+"'"+"facture_paye_imprime"+"'"+');">Facturation payée</button></div>'+
				"</div>");
}
function rapport_facture()
{
	ouvrir_modal("<div><h3 class='center'>Selectionner type rapport</h3>"+
				'<div class="center"><button class="btn btn-success" onclick="fermer_modal(); ouvrir('+"'"+"rapport_fact_non_paye"+"'"+');">Factures non payées</button>&nbsp;<button class="btn btn-danger" onclick="fermer_modal(); ouvrir('+"'"+"rapport_fact_paye"+"'"+');">Factures payéeS</button></div>'+
				"</div>");
}
function rapport_facture_liste_client()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:'POST',
		data:{"ent":"client"},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$("#loading_cl").html("<small class='text-warning'>Aucun client enregistré</small>");
			}else
			{
				$("#loading_cl").html("");
				$("#client")
				.html("<option value=''>--Selectionner--</option>");
				$("#client_paye")
				.html("<option value=''>--Selectionner--</option>");
				$("#client_rapp_gl")
				.html("<option value=''>--Selectionner--</option>");

				for(var a=0;a<r.length;a++)
				{
					$("#client")
					.append("<option value='"+r[a]["id_cl"]+"'>"+r[a]["nom_cl"]+"</option>");
					$("#client_paye")
					.append("<option value='"+r[a]["id_cl"]+"'>"+r[a]["nom_cl"]+"</option>");
					$("#client_rapp_gl")
					.append("<option value='"+r[a]["id_cl"]+"'>"+r[a]["nom_cl"]+"</option>");
				}
			}
		},
	});		
}
function rapport_fact_non_payees()
{
	$("#resultat").html("<img src='images/gif/ajax-rond.gif' /> Preparation des resultats en cours...")
	$client=$("#client").val();
	$dt=$("#dt1").val();
	$dt2=$("#dt2").val();
	$("#resultat")
	.html('<iframe src="vues/pages/impression/rapport_fact_non_payees.php?client='+$client+'&dt='+$dt+'&dt2='+$dt2+'"'+' style="width:100%; height:700px">'+
		"</iframe>");
}
function rapport_fact_payees()
{
	$("#resultat2").html("<img src='images/gif/ajax-rond.gif' /> Preparation des resultats en cours...")
	$client=$("#client_paye").val();
	$dt=$("#dt3").val();
	$dt2=$("#dt4").val();
	$("#resultat2")
	.html('<iframe src="vues/pages/impression/rapport_fact_payees.php?client='+$client+'&dt='+$dt+'&dt2='+$dt2+'"'+' style="width:100%; height:700px">'+
		"</iframe>");
}
function rapport_global()
{

	$("#resultat3").html("<img src='images/gif/ajax-rond.gif' /> Preparation des resultats en cours...")
	$client=$("#client_rapp_gl").val();
	$dt=$("#dt5").val();
	$dt2=$("#dt6").val();
	$("#resultat3")
	.html('<iframe src="vues/pages/impression/rapport_global.php?client='+$client+'&dt='+$dt+'&dt2='+$dt2+'"'+' style="width:100%; height:700px">'+
		"</iframe>");
}
function reimprimer_fact_cash_conf(mouv)
{
	fermer_modal();
	window.open("vues/pages/impression/facture_cash_re.php?num_mouv="+mouv,"PopUp","width=800,height=650,location=no,status=no,toolbar=no,scrollbars=no");
}
function reimprimer_fact_paye_conf(mouv)
{
	fermer_modal();
	window.open("vues/pages/impression/facture_paye_re.php?num_mouv="+mouv,"PopUp","width=800,height=650,location=no,status=no,toolbar=no,scrollbars=no");
}
function mouvement_recherche()
{
	$("#resultat").html("<div class='center'><img src='images/gif/ajax-rond.gif'> chargement en cours...</div>");
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"mouvement_recherche","formulaire":$("#num_form").val()},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			var r=JSON.parse(data);
			if(r[0]["n1"]==0)
			{
				$("#resultat")
				.html("<div class='alert alert-warning center bold fs-2'>Aucun mouvement trouvé avec ce N° formulaire</div>");
			}else
			{
				$("#resultat")
				.html("<table class='w3-table-all w3-table'>"+
					"<tr class='blue-grey white-text bold'>"+
						"<td>Date saisie</td>"+
						"<td>Exploit.</td>"+
						"<td>Date mouv.</td>"+
						"<td>Montant fact</td>"+
						"<td>Taxateur</td>"+
						"<td>OPTION</td>"+
					"</tr>"+
				"</table>");
				for(var a=0;a<r.length;a++)
				{
					$("#resultat table")
					.append("<tr>"+
						"<td>"+r[a]['dt_saisie']+"</td>"+
						"<td>"+r[a]['nom_cli']+" ("+r[a]['ta']['Code_imm']+")</td>"+
						"<td>"+r[a]['dt_arr']+" - "+r[a]['dt_dep']+"</td>"+
						"<td>"+r[a]['tot_avec_tva']+" USD</td>"+
						"<td>"+r[a]['us']+"</td>"+
						'<td><a href="#" onclick="ouvrir('+"'"+"mouvement_apercu2"+"'"+","+"'"+r[a]['mouv']+"'"+","+"'"+r[a]['mouv']+"'"+');">Apercu</a> |'+
							'<a href="#" onclick="ouvrir('+"'"+"mouvement_modif_detail"+"'"+","+"'"+r[a]["Id_mouv"]+"'"+","+"'"+r[a]["mouv"]+"'"+');">Modifier</a> | '+
							'<a href="#" onclick="suppression_mouv_relevement('+"'"+r[a]["mouv"]+"'"+');">supprimer</a>'+
						'</td>'+
					"</tr>");
				}
			}
		}
	});
}

function changer_mdp_conf()
{
		
	$actuel=$("#actuel").val();
	$nouveau=$("#nouveau").val();
	$nouveau2=$("#nouveau2").val();
	if($nouveau!==$nouveau2)
	{
		ouvrir_modal("<div class='alert alert-danger center bold fs-15'>Les 2 nouveaux mot de passe sont differents</div>");
	}else
	{
		popup_loading();
		$.ajax({
			url:mainUrl+"modeles/main.php",
			type:"POST",
			data:{"ent":"changer_mdp","actuel":$actuel,"nouveau":$nouveau},
			error:function(data){connexion_serveur()},
			success:function(data)
			{
				fermer_modal();
				if(data==1)
				{
					ouvrir_modal("<div class='alert alert-success fs-15 bold center'><i class='fa fa-check'></i> Votre mot de passe est bien modifi&eacute;</div>");
					$("input").val("");
				}else
				{
					ouvrir_modal("<div class='alert alert-danger fs-15 bold center'><i class='fa fa-times-circle'></i> "+data+"</div>");
				}
			}
		});
	}
}
function signataire_liste()
{
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"signataire_liste"},
		success:function(data)
		{
			var r=JSON.parse(data);
			$("#resultat").addClass("fs-2 p-1")
			.html("<div class='p-1'>Commandant : "+r['cmd']+"</div>"+
				"<div class='p-1'>Chef de Division : "+r['division']+"</div>"+
				"<div class='p-1'>Chef de facturation : "+r['facturation']+"</div>"
			);
		},
	});
}
function reinitialisation_numerotation()
{
	ouvrir_modal("<div class='red-text center'><h4 class='fs-15 bold'>VEUILLEZ ENTRER LE MOT DE PASS MASTER</h4>"+
		'<div align="center">'+
			'<form onsubmit="cnx_master(); return false">'+
				'<div class="mb-1"><input type="password" class="form-control browser-default" id="mdp" required></div>'+
				'<button class="btn btn-success" type="submit">Connexion</button>'+
			'</form>'+
		'</div>'+
	"</div>");
}
function cnx_master()
{
	fermer_modal();
	popup_loading();
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"cnx_master","mdp":$("#mdp").val()},
		error:function(data){
			connexion_serveur();
		},
		success:function(data)
		{
			fermer_modal();
			if(data==1)
			{
				ouvrir('master');
			}else
			{
				ouvrir_modal("<div class='alert alert-danger'><h4><i class='fa fa-times'></i> Echec de connexion, mot de pass incorrect</h4></div>");
			}
		}
	});
}
function reinitialisation_confirm()
{
	popup_loading();
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"reinitialisation_numerotation_confirm"},
		error:function(data){
			connexion_serveur();
		},
		success:function(data)
		{
			popup_loading();
			fermer_modal();
			if(data==1)
			{
				ouvrir('reinit_ok');
			}else
			{
				ouvrir_modal("<div class='alert alert-warning fs-15'>Echec de reinitialisation, veuillez reesayer</div>");
			}
			
		}
	});

}
function quitter()
{	
	popup_loading();
	$.ajax({
		url:mainUrl+'modeles/main.php',
		type:"POST",
		data:{"ent":"quitter"},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			if(data==1)
			{
				location.href="RVA";
			}			
		},
	});	
}
