<script type="application/javascript">
	$(document).ready(function(){
		handling_releve_liste_handleur();
	});
</script>
<div class="panel panel-success">
	<div class="panel-heading center bold">FACTURE ET RELEVE MENSUELS CLIENT</div>
    <div class="panel-body">
    	<form onSubmit="handling_releve_mensuel(); return false">
    	<div class="input-group w-25">
        	<label class="input-group-addon">Handleur</label>
            <select id="handleur" class="form-control browser-default" required></select>
            <span class="input-group-addon" id="loading"><img src="images/gif/ajax-rond.gif" /></span>
        </div>
        <div class="input-group w-25 mt-05">
        	<label class="input-group-addon">N° Facture</label>
            <input type="text" id="num_fact" class="form-control browser-default" />
        </div>
        <div class="row pt-1">
        	<div class="col s12 m4 input-group pl-1">
            	<label class="input-group-addon">Du</label>
                <input type="date" id="du" class="browser-default form-control" required />
            </div>
            <div class="col s12 m4 input-group pl-1">
            	<label class="input-group-addon">Au</label>
                <input type="date" id="au" class="browser-default form-control" required />
            </div>
            <div class="col s12 m4">
                <button class="btn green" type="submit">Visualiser</button>
            </div>
        </div>
        </form>
    </div>
</div>
<div class="panel panel-default mt-1">
	<div class="center bold panel-heading">RESULTAT</div>
    <div class="panel-body">
    	<div class="alert alert-primary center fs-15">Relevé mensuel des clients handleurs</div>
    </div>
</div>