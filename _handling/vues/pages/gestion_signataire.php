<script language="javascript" type="application/javascript">
	$(document).ready(function(){
		signataire_liste();
	});
</script>
<div class="panel panel-primary">
	<div class="panel-heading center bold fs-2">GESTION DES SIGNATAIRES</div>
    <div class="panel-body">
    	<form onsubmit="ajout('signataire'); return false">
        	<div class="row">
            	<div class="col s12 m4">
                	<div class="panel-default panel">
                    	<div class="panel-heading">MISE A JOUR</div>
                        <div class="panel-body">
                        	<p>
                            	<label>COMMANDANT</label>
                            	<input type="text" class="form-control browser-default" id="cmd" required />	
                            </p>
                            <p>
                            	<label>CHEF DE DIVISION</label>
                            	<input type="text" class="form-control browser-default" id="division" required />	
                            </p>
                            <p>
                            	<label>CHEF DE SERVICE FACTURATION</label>
                            	<input type="text" class="form-control browser-default" id="facturation" required />	
                            </p>
                            <p class="center"> <button class="btn btn-success">ENREGISTRER</button> </p>
                        </div>
                    </div>
                </div>
                <div class="col s12 m8">
                	<div class="panel panel-default">
                    	<div class="panel-heading">DONNEES ACTUELLES</div>
                        <div class="panel-body" id="resultat">
                        	
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>