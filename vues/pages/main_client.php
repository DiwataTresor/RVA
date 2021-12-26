<script type="application/javascript">
	$(document).ready(function(data){
		$('.collapsible').collapsible();
		$('.tabs').tabs();
		$('.sidenav').sidenav();
		$('.modal').modal();
		$('select').formSelect();
        $("#form-contenu").hide();
		client_liste_cl();

	});
</script>
<div id="fenetre_contenu">
    <div class="breadcrumb indigo white-text bold" align="left">
        <i class="fa fa-folder-open"></i>&nbsp;GESTION CLIENT
    </div>
    <div class="row pl-05 pr-05">
        <div class="col s12 m4">
        	<div class="panel panel-default">
            	<div class="panel-heading">FORMULAIRE</div>
                <div class="panel-body">
                	<form onsubmit="ajout('client'); return false">
                    	<input type="hidden" id="id" />
                    	<p class="mb-1">
                        	<label>Identification client <small>(3caracteres)</small></label>
                            <input type="text" required class="browser-default form-control" maxlength="3" id="cli_id" />
                        </p>
                        <p class="mb-1">
                        	<label>Nom </label>
                            <input type="text" required class="browser-default form-control" id="cli_nom" />
                        </p>
                        <p class="mb-1">
                        	<label>Telephone </label>
                            <input type="text" required class="browser-default form-control" id="cli_tel" />
                        </p>
                        <p class="mb-1">
                        	<label>Adresse</label>
                            <input type="text" class="browser-default form-control" id="cli_adr" />
                        </p>
                        <p class="mb-1">
                        	<label>Ville</label>
                            <input type="text" required class="browser-default form-control" id="cli_ville" />
                        </p>
                        <p class="mb-1">
                        	<label>Boite postale</label>
                            <input type="text" class="browser-default form-control" id="cli_boite_post" />
                        </p>
                        <p class="mb-1">
                        	<label>Type client</label>
                            <select class="browser-default form-control" id="cli_type_cl">
                            	<option value="C">Cash</option>
                                <option value="A">Agrée</option>
                            </select>
                        </p>
                         <p class="mb-1">
                        	<label>Code nationalité</label>
                            <select class="browser-default form-control" id="cli_code_nat">
                            	<option value="Z">National</option>
                                <option value="E">Etranger</option>
                            </select>
                        </p>
                        <p class="mb-1">
                        	<button class="btn btn-primary" id="btn_enreg" type="submit"><i class="fa fa-check"></i>&nbsp;Enregistrer</button>
                            <button class="btn btn-primary hide" id="btn_modif" type="button"><i class="fa fa-check"></i>&nbsp;Modifier</button>
                            <button class="btn btn-warning hide" id="btn_annuler" type="button"><i class="fa fa-check"></i>&nbsp;Annuler</button>
                        </p>
                    </form>
                </div>	
            </div>
        </div>
        <div class="col s12 m8">
        	<div class="panel panel-default">
            	<div class="panel-heading">LISTE DES CLIENTS</div>
                <div class="panel-body" id="detail">
                	<img src="images/gif/ajax-rond.gif" /> chargement en cours...
                </div>	
            </div>
        </div>
    </div>	
</div>