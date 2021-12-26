var mainUrlDel=mainUrl+"modeles/delete.php";
function del(v,v1,v2,v3,v4)
{
	$contenu="<div class='fs-15'>Voulez-vous vraiment supprimer "+ v3+" ?"+
			"<p class='w3-center'>"+
				"<div><input type='hidden' value='"+v2+"' /></div>"+
				"<p class='w3-align-center'>"+
					'<button class="btn blue" onclick="del_conf('+"'"+v+"'"+","+"'"+v1+"'"+","+"'"+v2+"'"+","+"'"+v4+"'"+');">Supprimer</button>'+
				"</p>"+
			"<p></div>";
	ouvrir_modal($contenu);
}
function del_conf(tabl,colone,colone_val,fct_retour)
{
	fermer_modal();
	popup_loading();
	$.ajax({
		url:mainUrlDel,
		type:"POST",
		data:{"ent":"del","tabl":tabl,"colone":colone,"colone_val":colone_val},
		error:function(data)
		{
			ouvrir_modal("<h4 class='alert alert-warning'><i class='fa fa-times'></i> Pas de connexion au serveur</h4>");
		},
		success:function(data)
		{
			fermer_modal();
			if(data==1)
			{
				ouvrir_modal("<h4 class='alert alert-success'><i class='fa fa-check'></i> Bien supprimé</h4>");
			
			}else
			{
				ouvrir_modal("<h4 class='alert alert-danger'><i class='fa fa-times'></i> Echec de suppression</h4>");
			}
		},
	})

}
function supprimer_mouv()
{

	$(".resultat").html("<div class='center fs-2 alert alert-default'><img src='images/gif/ajax-rond.gif' /> Traitement en cours en cours...</div>");
	$.ajax({
		url:mainUrlDel,
		type:"POST",
		data:{"ent":"mouvement",
			"formulaire":$("#formulaire").val(),
			"imm":$("#imm").val()
		},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
	
			var r=JSON.parse(data);
			if(r["n"]==0)
			{
				$(".resultat")
				.html("<div class='alert alert-danger center fs-2'>Ce mouvement ou bien cette immatriculation n'existe pas</div>");
			}else if(r["n"]==3)
			{
				$(".resultat")
				.html("<div class='alert alert-danger center fs-2'>3Cette facture à déjà été imprimée</div>");
			}else
			{
				$(".resultat")
				.html("<div class='w3-border p-1'>"+
						"<div class='p-1'>CLIENT "+r["ta"]['Nom_cli']+"</div>"+
						"<div class='p-1'>SAISI PAR : "+r["nom"]+" DATE : "+r['dt']+"</div>"+
						'<div class="center"><button class="browser-default btn btn-success" onclick="supprimer_mouv_conf('+"'"+r['num_mouv']+"'"+')"><i class="fa fa-check"></i> Confirmer la suppression</button></div>'+
					"</div>");
			}
		}
	});
}
function supprimer_mouv_conf(mouv)
{
	popup_loading();
	$.ajax({
		url:mainUrlDel,
		type:"POST",
		data:{
			"ent":"mouvement_conf",
			"mouv":mouv,
			"motif":$("#motif").val()
		},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			fermer_modal();
			if(data==1)
			{
				ouvrir_modal("<div class='alert alert-success center bold fs-2'><i class='fa fa-check-circle'></i> MOUVEMENT BIEN SUPPRIMER</div>");
				$(".resultat").html("");
				$("input[type='text']").val("");
			}else
			{
				ouvrir_modal("<div class='alert alert-warning center bold fs-2'><i class='fa fa-times'></i> Echec de suppression</div>");
			}
		},
	});
}
function suppression_mouv_relevement(mouv)
{
	ouvrir_modal("<div>"+
				"<p class='center fs-2 bold'>Confirmez-vous la suppression de ce mouvement ?</p>"+
				'<p class="center"><button class="btn btn-success" onclick="suppression_mouv_check('+"'"+mouv+"'"+')">Supprimer</button>&nbsp;'+
				'<button class="btn btn-danger" onclick="fermer_modal();">Annuler</button></p>'+
				"</div>");
}
function suppression_mouv_check(mouv)
{
	fermer_modal();
	popup_loading();
	$.ajax({
		url:mainUrlDel,
		type:'POST',
		data:{"ent":"suppression_mouv_check","mouv":mouv},
		error:function(data){connexion_serveur()},
		success:function(data)
		{
			fermer_modal();
			if(data==1)
			{
				releve_client();
			}else
			{
				ouvrir_modal("<div class='alert alert-danger center fs-2 bold'>Echec de suppression</div>");
			}
		},
	});
}
function suppr_fact(id,detail)
{
	ouvrir_modal('<div class="center"><h3>Confirmez-vous la suppression de la facture '+detail+' ?</h2>'+
		'<div class="center"><button class="btn btn-danger" onclick="fermer_modal();">Annuler</button>&nbsp;&nbsp;<button class="btn btn-success" onclick="suppr_fact_conf('+"'"+id+"'"+')">Supprimer</button></div>'+
	'</div>');
}
function suppr_fact_conf(id)
{
	fermer_modal();
	popup_loading();
	$.ajax({
		url:mainUrlDel,
		type:'POST',
		data:{"ent":"suppr_fact","id":id},
		error:function(data){connexion_serveur()},
		success:function(data){
			fermer_modal();
			facture_non_paye_liste();
		},
	});
}
function suppr_fact_paye(fact,detail)
{
	ouvrir_modal('<div class="center"><h3>Confirmez-vous la suppression de la facture '+detail+' ?</h2>'+
		'<div class="center"><button class="btn btn-danger" onclick="fermer_modal();">Annuler</button>&nbsp;&nbsp;<button class="btn btn-success" onclick="suppr_fact_paye_conf('+"'"+fact+"'"+')">Supprimer</button></div>'+
	'</div>');
}
function suppr_fact_paye_conf(fact)
{
	fermer_modal();
	popup_loading();
	$.ajax({
		url:mainUrlDel,
		type:'POST',
		data:{"ent":"suppr_fact_paye","fact":fact},
		error:function(data){connexion_serveur()},
		success:function(data){
			fermer_modal();
			facture_paye_liste();
		},
	});
}