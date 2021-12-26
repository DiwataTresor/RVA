
<script type="application/javascript" language="javascript">
	$(document).ready(function(){
		user_dep_jour();
	});
</script>
<style>
.m7{font-weight:bold}
</style>
<div class="panel panel-primary">
	<div class="panel-heading">SAISIE D'UNE DEPENSE</div>
    <div class="panel-body">
    	<div class="row">
        	<div class="col s12 m4">
            	<div class="panel panel-default">
                	<div class="panel-heading"><i class="fa fa-plus-circle"></i>&nbsp;AJOUTER</div>
                    <div class="panel-body">
                    	<form onsubmit="ajout_depense();">
                        	<p class="input-group">
                            	<span class="input-group-addon">Motif d&eacute;pense</span>
                                <input type="text" class="browser-default form-control" id="motif_dep" required />
                            </p>
                            <p class="input-group">
                            	<span class="input-group-addon">Montant</span>
                                <input type="text" class="browser-default form-control right" id="mt_dep" required />
                                <select class="browser-default form-control" id="monn_dep">
                                	<option value="USD">USD</option>
                                    <option value="FC">FC</option>
                                </select>
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
                	<div class="panel-heading bold">LISTE DES DEPENSES / JOUR</div>
                    <div class="panel-body" id="liste_dep">
                    	
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>