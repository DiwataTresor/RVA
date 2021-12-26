<div class="panel panel-primary">
	<div class="panel-heading center bold fs-2">RECHERCHE</div>
    <div class="panel-body">
    	<div class="row w-50">
        	<form onSubmit="mouvement_recherche(); return false">
        	<div class="col s12 m6">
            	<label>N°formulaire</label>
                <input type="text" class="browser-default form-control" id="num_form" required />
            </div>
            <div class="col s12 m6">
            	<label>&nbsp;</label>
                <div><button class="btn btn-success" type="submit"><i class="fa fa-search"></i> Visualiser</button></div>
            </div>
            </form>
        </div>
        <div id="resultat">
        	
        </div>
    </div>
</div>