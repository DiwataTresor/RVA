<style>
	label{font-size:15px}
</style>
<script type="application/javascript">
$(function(){
	maj_imm_cl();
	maj_imm_typeav();
	immatriculation_liste();
});
</script>
<div class="panel panel-primary">
	<div class="panel-heading center bold fs-2">GESTION IMMATRICULATION</div>
    <div class="panel-body">
        <div class="row w3-align-left">
            <div class="col s12 m4" align="left">
            	<div class="panel panel-default">
                	<div class="panel-heading">Ajouter</div>
                    <div class="panel-body">
                        <form onSubmit="ajout('immatriculation'); return false">
                        	<input type="hidden" id="id" />
                            <p class="">
                                <label>Code immatr</label>
                                <input type="text" id="imm_code" required class="browser-default form-control">
                            </p>
                            <p class="">
                                <label>Code propr <span id="loading_cl"></span></label>
                                <select id="imm_pr" class="browser-default form-control" required>
                                
                                </select>
                            </p>
                            <p class="">
                                <label>Type avion <span id="loading_type"></span></label>
                                <select id="imm_typeav" class="browser-default form-control">
                                
                                </select>
                            </p>
                             <p class="">
                                <label>Tonnage</label>
                                <input type="text" id="imm_tonn" class="browser-default form-control">
                            </p>
                            <p class="">
                                <label>Nbre siege</label>
                                <input type="text" id="imm_siege" class="browser-default form-control">
                            </p>
                            <p>
                                <button class="btn green" type="submit" id="btn_enreg">
                                	<i class="fa fa-check-circle"></i>&nbsp;Enregistrer</button>
                                <button class="btn green hide" type="button" id="btn_modif"><i class="fa fa-check-circle"></i>&nbsp;Modifier</button>
                                <button class="btn btn_warning hide" type="button" id="btn_annuler"><i class="fa fa-times-circle"></i>&nbsp;Annuler</button>
                            </p>
                        </form>
                     </div>
                </div>
            </div>
            <div class="col s12 m8">
            	<div class="w3-borde w3-round">
                	<div class="panel panel-default">
                    	<div class="panel-heading">IMMATRICULATIONS DEJA ENREGISTRES</div>
                        <div class="panel-body" id="liste">
                        	<img src="images/gif/ajax-rond.gif" /> chargement en cours...
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>