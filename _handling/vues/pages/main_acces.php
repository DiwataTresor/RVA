<style>
	label{font-size:15px}
</style>
<script type="application/javascript">
$(function(){
	acces_liste();
});
</script>
<div class="panel panel-primary">
	<div class="panel-heading fs-2" align="center">GESTION DES ACCES</div>
    <div class="panel-body">
        <div class="row w3-align-left">
            <div class="col s12 m7" align="left">
            	<div class="panel panel-default">
                	<div class="panel-heading center bold">Ajouter</div>
                    <div class="panel-body">
                        <form onSubmit="ajout('type_acces'); return false">
                        	<div class="row">
                            	<div class="col s12 m5">
                                  <label>CODE</label>
                                  <input type="text" class="browser-default form-control" required placeholder="Code" id="code_acces">
                                </div>
                            </div>
                           <div class="mb-1 row">
                           		<div class="col s12 m5">
                                	<div class="">
                                    <label class="" id="label-d1">DESIGNATION</label>
                                    	<input type="text" class="browser-default form-control" required placeholder="Designation" id="designation_acces">
                                    </div>
                                </div>
                           </div>
                           
                            <p class="left">
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
                    	<div class="panel-heading">LISTE DES ACCES </div>
                        <div class="panel-body fs-2">
                        	
                            <div id="liste">
                            
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>