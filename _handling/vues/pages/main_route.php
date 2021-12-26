<style>
	label{font-size:15px}
</style>
<script type="application/javascript">
$(function(){
	admin_liste_route();
});
</script>
<div class="panel panel-primary">
	<div class="panel-heading" align="left">GESTION DES ROUTES</div>
    <div class="panel-body">
        <div class="row w3-align-left">
            <div class="col s12 m4" align="left">
            	<div class="panel panel-default">
                	<div class="panel-heading">Ajouter</div>
                    <div class="panel-body">
                        <form onSubmit="ajout('route'); return false">
                            <p class="mb-1">
                                <label>Provenance</label>
                                <input type="text" id="route_prov" required class="browser-default form-control" />
                            </p>
                            <p class="mb-1">
                                <label>Destination</label>
                                <input type="text" id="route_dest" required class="browser-default form-control" />
                            </p>
                             <p class="mb-1">
                                <label>Distance trajet</label>
                                <input type="text" id="route_trajet" required class="browser-default form-control" />
                            </p>
                            <p class="mb-1">
                                <label>Libell&eacute;</label>
                                <input type="text" id="route_libelle" required class="browser-default form-control" />
                            </p>
                            
                            <p>
                                <button class="btn green" type="submit"><i class="fa fa-check-circle"></i>&nbsp;Enregistrer</button>
                                <button class="btn green hide" type="button"><i class="fa fa-check-circle"></i>&nbsp;Modifier</button>
                            </p>
                        </form>
                     </div>
                </div>
            </div>
            <div class="col s12 m8">
            	<div class="w3-borde w3-round">
                	<div class="panel panel-default">
                    	<div class="panel-heading">ROUTES DEJA ENREGISTREES</div>
                        <div class="panel-body">
                        	<table width="536" border="0" class="table table-stripped">
                              <tr class="w3-blue">
                                <td width="44" height="27">&nbsp;</td>
                                <td width="160">Libelle Acte</td>
                                <td width="137">Prix</td>
                                <td width="177">Option</td>
                              </tr>
                              
                             </table
                        ></div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>