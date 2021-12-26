// JavaScript Document
function admin(r)
{
	popup_loading();
	$("#fenetre_admin").load("vues/admin/"+r,function(data){
		fermer_modal();
		
	});
}