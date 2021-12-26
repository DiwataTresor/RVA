<script type="application/javascript">
	$(document).ready(function(){
		releve_client_liste_client();
	});
</script>
<div class="panel panel-primary">
	<div class="panel-heading center bold fs-2">RELEVES DES MOUVEMENTS / CLIENT</div>
    <div class="panel-body">
    	<div class="row">
        	<form onsubmit="releve_client();">
        	<div class="col s12 m3 input-group">
            	<label class="input-group-addon">CLIENT</label>
                <select class="browser-default form-control" id="client" required></select>
                <label class="input-group-addon" id="loading_cl"><img src="images/gif/ajax-rond.gif"></label>
            </div>
            <div class="col s12 m3 input-group">
            	<label class="input-group-addon">DU</label>
                <input type="date" class="browser-default form-control" required id="dt1" />
            </div>
            <div class="col s12 m3 input-group">
            	<label class="input-group-addon">AU</label>
                <input type="date" class="browser-default form-control" required id="dt2" />
            </div>
            <div class="col s12 m3">
            	<button class="btn btn-success">VISUALISER</button>
            </div>
            </form>
        </div>
        <div class="" id="resultat">
        	
        </div>
    </div>
</div>