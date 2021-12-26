<script type="application/javascript">
	$(document).ready(function(){
		ventillation_client();
	});
</script>
<div class="panel panel-primary">
	<div class="panel-heading center fs-2 bold">FACTURES NON REGLEES</div>
    <div class="panel-body">
    	<div class="row">
        	<form onSubmit="liste_facture_non_regle(); return false">
        	<div class="col s12 m3 input-group">
            	<label class="input-group-addon">Client</label>
                <select class="form-control brwser-default" id="client" required>
					<option value="">Selectionner client</option>
					<option value="tout">Tous</option>
				</select>
            </div>
            <div class="col s12 m3 input-group">
            	<label class="input-group-addon">DU</label>
                <input type="date" class="form-control browser-default" id="dt" required>
            </div>
            <div class="col s12 m3 input-group">
            	<label class="input-group-addon">AU</label>
                <input type="date" class="form-control browser-default" id="dt2" required>
            </div>
            <div class="col s12 m3">
            	<button type="submit" class="btn btn-success">Visualiser</button>
            </div>
            </form>
        </div>
        <div class="" id="resultat">
        
        </div>
    </div>
</div>