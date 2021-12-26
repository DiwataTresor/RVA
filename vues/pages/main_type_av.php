<style>
	label{font-size:15px}
</style>
<script type="application/javascript">
$(function(){
	type_avion_liste();
});
</script>
<div class="panel panel-primary">
	<div class="panel-heading center bold fs-2">GESTION DES TYPES AVIONS</div>
    <div class="panel-body">
        <div class="row w3-align-left">
            <div class="col s12 m4" align="left">
            	<div class="panel panel-default">
                	<div class="panel-heading">Ajouter</div>
                    <div class="panel-body">
                        <form onSubmit="ajout('type_av'); return false">
                        	<input type="hidden" id="id" />
                            <p class="mb-1">
                            	<input type="hidden" id="id_acte" value="" />
                                <label>Type avion</label>
                                <input type="text" id="typeav_type" class="browser-default form-control" />
                            </p>
                            <p class="mb-1">
                                <label>MTOW</label>
                                <input type="text" id="typeav_mtow" class="browser-default form-control" />
                            </p>
                             <p class="mb-1">
                                <label>Nombre moteur</label>
                                <input type="number" value="1" id="typeav_nbrmoteur" class="browser-default form-control" />
                            </p>
                            <p class="mb-1">
                                <label>Maxi payload</label>
                                <input type="text" id="typeav_maxipayload" class="browser-default form-control" />
                            </p>
                            <p class="mb-1">
                                <label>Version</label>
                                <input type="text" id="typeav_version" class="browser-default form-control" />
                            </p>
                            <p class="mb-1">
                                <label>PL MIN</label>
                                <input type="text" id="typeav_plmin" class="browser-default form-control" />
                            </p>
                            <p class="mb-1">
                                <label>PL MAX</label>
                                <input type="text" id="typeav_plmax" class="browser-default form-control" />
                            </p>
                            <p>
                                <button class="btn green" type="submit" id="btn_enreg"><i class="fa fa-check-circle"></i>&nbsp;Enregistrer</button>
                                <button class="btn green hide" type="button" id="btn_modif">
                                <i class="fa fa-check-circle"></i>&nbsp;Modifier</button>
                                <button class="btn btn-warning hide" type="button" id="btn_annuler">
                                <i class="fa fa-check-circle" id=""></i>&nbsp;Annuler</button>
                            </p>
                        </form>
                     </div>
                </div>
            </div>
            <div class="col s12 m8">
            	<div class="w3-borde w3-round">
                	<div class="panel panel-default">
                    	<div class="panel-heading center">LISTE DE TYPES D'AVIONS</div>
                        <div class="panel-body" id="liste">
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