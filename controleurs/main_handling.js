var main=mainUrl+"modeles/main_handling.php";

function selection_touche(id)
{
	var obj="#"+id;
	var i=obj+" i";
	if($(i).hasClass("fa-minus-square"))
	{
		$(obj).parent().addClass("grey");
		$(i).addClass("fa-check");
		$(i).removeClass("fa-minus-square");
	}else
	{
		$(obj).parent().removeClass("grey");
		$(i).removeClass("fa-check");
		$(i).addClass("fa-minus-square");
	}
}
function ajout_handleur() 
{
	fermer_modal();
	$contenu="<div class='center fs-2'><p>Confirmez-vous cet enregistrement ? <p>"+
				"<p class='center mt-1'>"+
					'<button class="btn green" onclick="ajout('+"'"+"handleur"+"'"+'); ;"><i class="fa fa-check-circle"></i>&nbsp;Enregistrer</button>&nbsp;'+
					"<button class='btn red' onclick='fermer_modal();'><i class='fa fa-times'></i>&nbsp;Annuler</button>"+
				"</p>"+
			"</div>";
	popup("Confirmer enregistrement",$contenu);
	//notification_info("rien");
}
function handleur_liste_handleur()
{

	$("#detail_liste_handleur").html("<div class='center'>chargement de la liste en cours</div>");
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST", 
		data:{"ent":"liste_handleur"},
		success:function(data)
		{
			var r=JSON.parse(data);
			$("#detail_liste_handleur")
			.html("<table class='table w3-small w3-table-all'>"+
					"<thead class='w3-blue-grey black-text bold'><tr class='blue-grey bold white-text'>"+
						'<td>Code</td>'+
						'<td>Nom</td>'+
						'<td>Adresse</td>'+
						'<td>Ville</td>'+
						'<td>Telephone</td>'+
						'<td>Type paiement</td>'+
						'<td>Nationalité</td>'+
						'<td>OPTION</td>'+
					"</tr></thead>"+
				"</table");
			for(var a=0;a<r.length;a++)
			{
				$("table")
				.append("<tr class='w3-hover-grey'>"+
						'<td>'+r[a]["code_hand"]+'</td>'+
						'<td>'+r[a]["nom"]+'</td>'+
						'<td>'+r[a]["adresse"]+'</td>'+
						'<td>'+r[a]["ville"]+'</td>'+
						'<td>'+r[a]["telephone"]+'</td>'+
						'<td>'+r[a]["type_paie"]+'</td>'+
						'<td>'+r[a]["nationalite"]+'</td>'+
						'<td>'+
							'<button title="modifier" class="btn w3-small blue white-text" onclick="upd('+"'"+"handleur"+"'"+","+"'"+r[a]["id"]+"'"+","+"'"+r[a]['nom']+"'"+","+"'"+r[a]['code_hand']+"'"+","+"'"+r[a]['adresse']+"'"+","+"'"+r[a]['ville']+"'"+","+"'"+r[a]['telephone']+"'"+","+"'"+r[a]['type_paie']+"'"+","+"'"+r[a]['nationalite']+"'"+');"><i class="fa fa-edit"></i></button>&nbsp;'+
							'<button title="supprimer" class="btn w3-small red white-text" onclick="del('+"'"+'handling_handleur'+"'"+","+"'"+"Id_hand"+"'"+","+"'"+r[a]['id']+"'"+","+"'"+r[a]['nom']+"'"+","+"'"+"handleur"+"'"+');"><i class="fa fa-trash"></i></button>'+
						'</td>'+
					"</tr>");
			}
			$("#detail")
			.append("<a class='btn btn-success' href='vues/pages/impression/liste_handleur.php'>Imprimer</a>");
		}
	});
}
function ajout_fact_hand() 
{
	fermer_modal();
	$contenu="<div class='center fs-2'><p>Confirmez-vous cet enregistrement ? <p>"+
				"<p class='center mt-1'>"+
					'<button class="btn green" onclick="ajout_fact_hand_conf(); ;"><i class="fa fa-check-circle"></i>&nbsp;Enregistrer</button>&nbsp;'+
					"<button class='btn red' onclick='fermer_modal();'><i class='fa fa-times'></i>&nbsp;Annuler</button>"+
				"</p>"+
			"</div>";
	popup("Confirmer enregistrement",$contenu);
	
}
function ajout_fact_hand_conf()
{
	if($("#aa").val()=="N")
	{
		$aa="N";
	}else
	{
		$aa=$("#aa").val();
	}

	if($("#ta i").hasClass('fa-minus-square'))
	{
		$ta="N";
	}else
	{
		$ta="O";
	}
	if($("#fa i").hasClass('fa-minus-square'))
	{
		$fa="N";
	}else
	{
		$fa="O";
	}

	fermer_modal();

	if($aa=="N" && $ta=="N" && $fa=="N")
	{
		ouvrir_modal("<div class='alert alert-danger'><h4><i class='fa fa-times'></i>&nbsp;Vous devez selecionner au moins une Touché</h4></div>");
	}else
	{
		popup_loading();
		$fact_handleur=$("#fact_handleur").val();
		$fact_imm=$("#fact_imm").val();
		$fact_dt_arr=$("#fact_dt_arr").val();
		$fact_heure_arr=$("#fact_heure_arr").val();
		$fact_dt_dep=$("#fact_dt_dep").val();
		$fact_heure_dep=$("#fact_heure_dep").val();

		$.ajax({
			url:mainUrl+"modeles/add.php",
			type:"POST",
			data:{"ent":"handling_facturation",
					"fact_handleur":$fact_handleur,
					"fact_imm":$fact_imm,
					"fact_dt_arr":$fact_dt_arr,
					"fact_heure_arr":$fact_heure_arr,
					"fact_dt_dep":$fact_dt_dep,
					"fact_heure_dep":$fact_heure_dep,
					"aa":$aa,
					"ta":$ta,
					"fa":$fa
				},
			error:function(data){notification_warning('Pas de connexion au serveur')},
			success:function(data)
			{
				fermer_modal();
				if(data==1)
				{
					alert("Facture bien enregistrée");
					ouvrir("handling_facturation");
				}else
				{
					ouvrir_modal("<div class='alert alert-danger'><h4><i class='fa fa-times'></i>&nbsp;Echec d'enregistrement</h4></div>");
				}
			},
		});
	}
}
function facturation_handling_imm()
{
	$("#loading_cl").html('<img src="images/gif/ajax-rond3.gif" />');
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
				$("#loading2").html("<small class='text-warning'>Aucun client enregistré</small>");
			}else
			{
				$("#loading2").html("");
				$("#fact_imm")
				.html("<option value=''>--Selectionner--</option>");
				for(var a=0;a<r.length;a++)
				{
					$("#fact_imm")
					.append("<option value='"+r[a]["id"]+"'>"+r[a]["code_imm"]+" - "+r[a]['proprietaire']+"</option>");
				}
			}
		},
	});
}
function facturation_handling_handleur()
{
	$("#loading_cl").html('<img src="images/gif/ajax-rond3.gif" />');
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:'POST',
		data:{"ent":"liste_handleur"},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$("#loading").html("<small class='text-warning'>Aucun client enregistré</small>");
			}else
			{
				$("#loading").html("");
				$("#fact_handleur")
				.html("<option value=''>--Selectionner--</option>");
				for(var a=0;a<r.length;a++)
				{
					$("#fact_handleur")
					.append("<option value='"+r[a]["id"]+"'>"+r[a]["nom"]+"</option>");
				}
			}
		},
	});
}
function paiement_liste_fact()
{
	$(".detail")
	.html("<div class='fs-15'><img src='images/gif/ajax-rond.gif'> Chargement en cours</div>");
	$.ajax({
		url:mainUrl+"modeles/main.php",
		type:"POST",
		data:{"ent":"paiement_hand_liste_fact"},
		error:function(data){notification_warning('pas de connexion au serveur')},
		success:function(data)
		{
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$(".detail")
				.html("<div class='center alert-danger'>Aucun mouvement enregistré</div>");
			}else
			{
				$(".detail")
				.html("<table class='w3-table w3-table-all'><tr class='blue-grey white-text bold'>"+
						"<td>Date fact</td>"+
						"<td>Immatriculation</td>"+
						"<td>Handleur</td>"+
						"<td>Date mouv</td>"+
						"<td>Touché(s)</td>"+
						"<td>Saisie par </td>"+
						"<td>Option</td>"+
					"</tr></table>");
				for(var a=0;a<r.length;a++)
				{
					$msg=r[a]["imm"]+" - "+r[a]["client"];
					$(".detail table")
					.append("<tr class='w3-hover-grey w3-hover-white-text'>"+
						"<td>"+r[a]["dt_fact"]+"</td>"+	
						"<td>"+r[a]["imm"]+" - "+r[a]['client']+"</td>"+	
						"<td>"+r[a]["handleur"]+"</td>"+	
						"<td>"+r[a]["dt_arr"]+" - "+r[a]["dt_dep"]+"</td>"+	
						"<td>"+r[a]['touche']+"</td>"+
						"<td>"+r[a]['user']['nom']+"</td>"+
						'<td>'+
							'<a title="paiement" href="#" class="circle green p-05 white-text" onclick="ouvrir('+"'"+"handling_paiement"+"'"+","+"'"+r[a]["id"]+"'"+');"><i class="fa fa-money"></i></a>&nbsp;&nbsp'+
				
						'</td>'+
					"</tr>");
				}
			}
		},
	});
}
function handling_paiement()
{
	ouvrir_modal("<div class='center bold fs-15'>Voulez-vous vraiment Confirmer ce paiement ?</div>"+
		"<div class='mt-1 center'>"+
			'<button class="green w3-btn white-text w3-round fs-15" onclick="ajout('+"'"+"handling_paiement"+"'"+')"><i class="fa fa-check"></i> Oui</button>&nbsp;&nbsp;'+
			"<button class='red w3-btn white-text w3-round fs-15' onclick='fermer_modal();'><i class='fa fa-times'></i> Non</button>"+
		"</div>"
	);
}
function handling_facture(id)
{
	fermer_modal();
	window.open("vues/pages/impression/handling_facture.php?fact="+id,"PopUp","width=800,height=650,location=no,status=no,toolbar=no,scrollbars=no");
}
function liste_facture_handling()
{

	$('.detail').html("<div class='center'><img src='images/gif/ajax-rond.gif' /> chargement de la liste en cours...</div>");
	$.ajax({
		url:main,
		type:"POST",
		data:{"ent":"liste_facture_handling","lim":0},
		error:function(data){notification_error("Pas de connexion au serveur")},
		success:function(data)
		{
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$('.detail').html("<div class='alert alert-danger center'>Aucun paiement trouvé</div>");
			}else
			{
				$(".detail")
				.html("<table class='w3-table w3-table-all'><tr class='blue-grey white-text bold'>"+
					"<td>Date paiement</td>"+
					"<td>Facture</td>"+
					"<td>Immatriculation</td>"+
					"<td>Exploitant</td>"+
					"<td>Handleur</td>"+
					"<td>Montant</td>"+
					"<td>Percepteur</td>"+
					"<td>Option</td>"+
				"</tr></table>");

				for(var a=0;a<r.length;a++)
				{
					$(".detail table")
					.append("<tr class='w3-hover-grey'>"+
						"<td>"+r[a]["dt_paie"]+"</td>"+
						"<td>"+r[a]["detail_paie"]["num_fact"]+"</td>"+
						"<td>"+r[a]["imm"]+"</td>"+
						"<td>"+r[a]["mouv"]["client"]+"</td>"+
						"<td>"+r[a]["mouv"]["handleur"]+"</td>"+
						"<td>"+r[a]["montant"]+" USD"+"</td>"+
						"<td>"+r[a]["user"]['nom']+"</td>"+
						"<td>"+
							'<span class="circle green white-text p-05"><a href="#" class="white-text" title="Ouvrir" onclick="handling_facture('+"'"+r[a]["fact"]+"'"+');"><i class="fa fa-print"></i></a></span>&nbsp;&nbsp;'+
						"</td>"+
					"</tr>");
				}
			}
		},
	});
}
function handling_releve_liste_handleur()
{
	$.ajax({
		url:main,
		type:"POST",
		data:{"ent":"liste_handleur"},
		error:function(data){notification_error("Pas de connexion au serveur")},
		success:function(data)
		{
			$("#loading").html("");
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$("#loading").html("<small class='text-warning'>Aucun handleur enregistré</small>");
			}else
			{
				$("#loading").html("");
				$("#handleur")
				.html("<option value=''>--Selectionner--</option>");
				for(var a=0;a<r.length;a++)
				{
					$("#handleur")
					.append("<option value='"+r[a]["id"]+"'>"+r[a]["nom"]+"</option>");
				}
			}
		},
	});
}
function handling_releve_mensuel()
{
	$handleur=$("#handleur").val();
	$fact=$("#num_fact").val();
	$du=$("#du").val();
	$au=$("#au").val();
	window.open("vues/pages/impression/handling_releve_mens.php?handleur="+$handleur+"&du="+$du+"&au="+$au+"&fact="+$fact,"PopUp","width=800,height=650,location=no,status=no,toolbar=no,scrollbars=no");
}
function hand_rapport_facture_liste_client()
{
	$.ajax({
		url:mainUrl+"modeles/main_handling.php",
		type:'POST',
		data:{"ent":"liste_handleur"},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			var r=JSON.parse(data);
			if(r[0]["n"]==0)
			{
				$(".loading_cl").html("<small class='text-warning'>Aucun client enregistré</small>");
			}else
			{
				$(".loading_cl").html("");

				$("#client1")
				.html("<option value=''>--Selectionner--</option>");
				$("#client2")
				.html("<option value=''>--Selectionner--</option>");
				$("#client3")
				.html("<option value=''>--Selectionner--</option>");
				
				$("#client1")
				.append("<option value='T'>Tous</option>");
				$("#client2")
				.append("<option value='T'>Tous</option>");
				$("#client3")
				.append("<option value='T'>Tous</option>");
				for(var a=0;a<r.length;a++)
				{
					$("#client1")
					.append("<option value='"+r[a]["id"]+"'>"+r[a]["nom"]+"</option>");

					$("#client2")
					.append("<option value='"+r[a]["id"]+"'>"+r[a]["nom"]+"</option>");

					$("#client3")
					.append("<option value='"+r[a]["id"]+"'>"+r[a]["nom"]+"</option>");
				}
			}
		},
	});	
}

function hand_rapport_journ_fact()
{
	$("#resultat")
	.html('<iframe src="vues/pages/impression/hand_rapport_journ_fact.php?client='+$("#client1").val()+"&dt1="+$("#dt1").val()+"&dt2="+$("#dt2").val()+'" style="width:100%; min-height:500px"></iframe>');

}
function hand_rapport_fact_non_payees()
{
	$("#resultat2")
	.html('<iframe src="vues/pages/impression/handling_fact_non_payees.php?client='+$("#client2").val()+"&dt1="+$("#dt3").val()+"&dt2="+$("#dt4").val()+'" style="width:100%; min-height:500px"></iframe>');

}
function hand_rapport_fact_payees()
{
	$("#resultat3")
	.html('<iframe src="vues/pages/impression/handling_fact_payees.php?client='+$("#client3").val()+"&dt1="+$("#dt5").val()+"&dt2="+$("#dt6").val()+'" style="width:100%; min-height:500px"></iframe>');
}
function handling_rapport_paiement()
{
	$("#resultat4")
	.html('<iframe src="vues/pages/impression/handling_rapport_paiement.php?dt1='+$("#dt7").val()+"&dt2="+$("#dt8").val()+'" style="width:100%; min-height:500px"></iframe>');
}
function handling_rapport_paiement()
{
	$("#resultat4")
	.html('<iframe src="vues/pages/impression/handling_rapport_paiement.php?dt1='+$("#dt7").val()+"&dt2="+$("#dt8").val()+'" style="width:100%; min-height:500px"></iframe>');
}
function handling_ventillation()
{
	$("#resultat")
	.html('<iframe src="vues/pages/impression/handling_ventillation.php?dt1='+$("#dt1").val()+"&dt2="+$("#dt2").val()+'" style="width:100%; min-height:500px"></iframe>');
}
function hand_mouv_periode()
{
	$client=$("#client1").val();
	$dt1=$("#dt1").val();
	$dt2=$("#dt2").val();
	$.ajax({
		url:main,
		type:"POST",
		data:{"ent":"hand_mouv_periode","client":$client,"dt1":$dt1,"dt2":$dt2},
		error:function(data){},
		success:function(data)
		{
			var r=JSON.parse(data);
			if(r["n"]==0)
			{
				$("#resultat").html("<div class='alert alert-danger center fs-15'>Aucune donnée trouvée</div>");
			}else
			{
				$("#resultat")
				.html("<table class='w3-table w3-table-all'>"+
						"<tr class='blue white-text bold center'>"+
							"<td>Date mouv </td>"+
							"<td>Handleur</td>"+
							"<td>Immatriculation</td>"+
							"<td>Touché</td>"+
							"<td>Montant</td>"+
							"<td>Option</td>"+
						"</tr>"+
					"</table>");
				for(var a=0;a<r["ligne"].length;a++)
				{
				
					var aa="";
					var ta="";
					var fa="";
					
					if(r["ligne"][a][0]["aa"]=="O"){aa="AA ";}
					if(r["ligne"][a][0]["ta"]=="O"){ta="TA ";}
					if(r["ligne"][a][0]["fa"]=="O"){ta="FA ";}

					var ligne="ligne"+r["ligne"][a][0]["id_fact"];
					$("table")
					.append("<tr id='"+ligne+"' class='w3-hoverable w3-hover-grey w3-hover-text-white'>"+
							"<td class''>"+r["ligne"][a][0]["dt_arr"]+"-"+r["ligne"][a][0]["dt_dep"]+"</td>"+
							"<td>"+r["ligne"][a][0]["handleur"]+"</td>"+
							"<td>"+r["ligne"][a][0]["imm"]+"</td>"+
							"<td>"+aa+ta+fa+"</td>"+
							"<td><b>"+r["ligne"][a][0]["mttc"]+" USD</b></td>"+
							"<td>"+
								'<a href="#" onclick="hand_del('+"'"+"facture"+"'"+","+"'"+r["ligne"][a][0]["id_fact"]+"'"+');">Supprimer</a>'+
							"</td>"+
						"</tr>");
				}
			}
		},
	});
}
function hand_del(e,id,conf)
{
	fermer_modal();
	if(!conf || conf=="")
	{
		$contenu="<div class='fs-15'>Voulez-vous vraiment supprimer ce mouvement ?"+
				"<p class='w3-center'>"+
					"<div><input type='hidden' value='dd' /></div>"+
					"<p class='w3-align-center'>"+
						'<button class="btn blue" onclick="hand_del('+"'"+e+"'"+","+"'"+id+"'"+","+"'"+"conf"+"'"+');">Supprimer</button>'+
					"</p>"+
				"<p></div>";
		ouvrir_modal($contenu);
	}else
	{
		popup_loading();
		$.ajax({
			url:main,
			type:"POST",
			data:{"ent":"hand_del","e":e,"id":id},
			error:function(data){ouvrir_modal("Echec de connexion au serveur");},
			success:function(data)
			{
				fermer_modal();
				if(data==1)
				{
					var ligne="#ligne"+id;
					$(ligne).remove();
				}else if(data==3)
				{
					ouvrir_modal("Vous ne pouvez pas supprimer cette facture, contactez l'administrateur du système");
				}else if(data==0)
				{
					ouvrir_modal("<div class='fs-15'>Echec de suppression</div>");
				}else
				{
					ouvrir_modal("<div class='fs-15'>"+data+"</div>");
				}
			},
		});
	}
}
function hand_quitter()
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
				location.href="../RVA";
			}			
		},
	});	
}