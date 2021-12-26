<style>
	label{font-size:15px}
</style>
<script type="application/javascript">
$(function(){
	liste_aero();
});
</script>
<div class="panel panel-primary">
	<div class="panel-heading" align="left">GESTION DES AEROS</div>
    <div class="panel-body">
        <div class="row w3-align-left">
            <div class="col s12 m7" align="left">
            	<div class="panel panel-default">
                	<div class="panel-heading">Ajouter</div>
                    <div class="panel-body">
                        <form onSubmit="ajout('aero'); return false">
                        	<div class="row">
                            	<div class="input-group">
                                  <label>CODE</label>
                                  <input type="text" class="browser-default form-control" placeholder="Code" id="code_aero">
                                </div>
                            </div>
                           <div class="mb-1 row">
                           		<div class="col s12 m5">
                                	<div class="input-group">
                                    <label class="" id="label-d1">LIBELLE</label>
                                    	<input type="text" class="browser-default form-control" placeholder="Libelle" id="libelle_aero">
                                    </div>
                                </div>
                           </div>
                           
                            <p class="center">
                                <button class="btn green" type="submit"><i class="fa fa-check-circle"></i>&nbsp;Enregistrer</button>
                                <button class="btn green hide" type="button"><i class="fa fa-check-circle"></i>&nbsp;Modifier</button>
                            </p>
                        </form>
                     </div>
                </div>
            </div>
            <div class="col s12 m5">
            	<div class="w3-borde w3-round">
                	<div class="panel panel-default">
                    	<div class="panel-heading">LISTE AERO </div>
                        <div class="panel-body fs-2">
                        	
                            <div id="dernier_taux">
                            
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>