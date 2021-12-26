
<script type="application/javascript" language="javascript">
	$(document).ready(function(){
		//user_dep_jour();
	});
</script>
<style>
.m7{font-weight:bold}
</style>
<div class="panel panel-primary">
	<div class="panel-heading center bold fs-2">SAISIE D'UNE ENTREE</div>
    <div class="panel-body">
    	<div class="row">
        	<div class="col s12 m4">
            	<div class="panel panel-default">
                	<div class="panel-heading"><i class="fa fa-plus-circle"></i>&nbsp;AJOUTER</div>
                    <div class="panel-body">
                    	<form onsubmit="ajout_entree();">
                        	<p class="input-group">
                            	<span class="input-group-addon">Date</span>
                                <input type="date" class="form-control browser-default" id="dt" required />
                            </p>
                        	<p class="input-group">
                            	<span class="input-group-addon">Type entr&eacute;e</span>
                                <select type="text" class="browser-default form-control" id="type_ent" required>
                                	<option value="">--Selectionner--</option>
                                    <option value="AE">AERONAUTIQUE</option>
                                    <option value="AP">ACCES PONCTUELS</option>
                                    <option value="AK">ACCES PARKING</option>
                                </select>
                            </p>
                            <p class="input-group">
                            	<span class="input-group-addon">Montant</span>
                                <input type="text" class="browser-default form-control right" id="mt_ent" required />
                                <select class="browser-default form-control" id="monn_ent" required>
                                	<option value="">--Monnaie--</option>
                                    <option value="USD">USD</option>
                                    <option value="FC">FC</option>
                                </select>
                            </p>
                            <p class="input-group">
                            	<span class="input-group-addon">Observation</span>
                                <input type="text" class="form-control browser-default" id="observation_ent" />
                            </p>
                            <p>
                            	<button class="btn green waves waves-effect" type="submit"><i class="fa fa-check"></i>&nbsp;Enregistrer</button>
                            </p>	
                        </form>
                    </div>
                </div>
            </div>
            <div class="col s12 m8">
            	<div class="panel panel-default">
                	<div class="panel-heading bold"></div>
                    <div class="panel-body" id="liste_dep">
                    	
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>