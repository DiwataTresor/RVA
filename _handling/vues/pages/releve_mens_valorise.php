<script type="application/javascript">
	$(document).ready(function(){
		releve_mens_valorise_liste_cl();
	});
</script>
<div class="panel panel-default">
	<div class="panel-heading center">RELEVE MENSUEL DES MOUVEMENTS VALORISES</div>
    <div class="panel-body">
    	<div class="mt-1 pt-1">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#general" aria-controls="home" role="tab" data-toggle="tab">Parametre</a></li>
            <!--<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Depart</a></li>-->
          </ul>
        
          <!-- Tab panes -->
          <div class="tab-content w-50 p-1">
            <div role="tabpanel" class="tab-pane active" id="general">
            	<form onSubmit="impr_fact_mens_valorise(); return false">
                	<p class="input-group">
                    	<label class="input-group-addon">
                        	Client
                        </label>
                        <select class="browser-default form-control" id="client" required></select>
                    </p>
                    <div class="row">
                    	<div class="col s12 m6 input-group">
                        	<label class="input-group-addon">Du</label>
                            <input type="date" class="browser-default form-control" id="dt" required>
                        </div>
                        <div class="col s12 m6 input-group">
                        	<label class="input-group-addon">Au</label>
                            <input type="date" class="browser-default form-control" id="dt2" required>
                        </div>
                    </div>
                    <div class="center p-1">
                    		<button class="btn-success btn">Afficher</button>
                    </div>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="profile">
            	<!--<div class="" id="national_depart">
                	<?php include('mouvement/national_depart.php'); ?>
                </div>
                <div class="" id="inter_depart">
                	<?php include('mouvement/inter_depart.php'); ?>
                </div>-->
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="resultat">
            	
          </div>
        </div>
    </div>
</div>