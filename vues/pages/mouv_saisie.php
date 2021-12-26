<script type="application/javascript">
	$(document).ready(function(){
		mouvement();
		mouvement_nat_ville();
		mouvement_int_pt();
		mouvement_ville_int();
		mouvement_ville_nat();
		num_fiche_rec();
		mouv_type_cli();
		escale_ville();
	});
</script>
<div class="panel panel-default">
	<div class="panel-heading">SAISIE D'UN MOUVEMENT</div>
    <div class="panel-body">
        <div>
            <p class="input-group w-50">
                <label class="input-group-addon bold blue-text fs-15">Nature vol</label>
                <select class="browser-default form-control" id="nature_vol" onchange="mouvement();">
                    <option value="">Selectionner nature vol</option>
                    <option value="I">International</option>
                    <option value="N">National</option>
                </select>
            </p>
            <p class="input-group w-50">
                <label class="input-group-addon bold blue-text fs-15">Immatriculation </label>
                <select class="browser-default form-control" id="client">
                </select>
                <span class="input-group-addon" id="loading"><img src="images/gif/ajax-rond.gif" /></span>
            </p>
            <p class="input-group w-50">
                <label class="input-group-addon bold blue-text fs-15">N&deg; Formulaire</label>
                <input type="text" class="browser-default form-control" id="num_form">
            </p>
             <input type="hidden" disabled="disabled" id="num_fic" />
        </div>
        <div class="mt-1 pt-1">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Arriv&eacute;</a></li>
            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Depart</a></li>
            <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab" onclick="apercu">Option</a></li>
          </ul>
        
          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
            	<div class="" id="national_arrive">
                	<?php include('mouvement/national_arrive.php'); ?>
                </div>
                <div class="" id="inter_arrive">
                	<?php include('mouvement/inter_arrive.php'); ?>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="profile">
            	<div class="" id="national_depart">
                	<?php include('mouvement/national_depart.php'); ?>
                </div>
                <div class="" id="inter_depart">
                	<?php include('mouvement/inter_depart.php'); ?>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="apercu">
            	
            </div>
          </div>
        </div>
     </div>
     <div class="panel-footer">
   
     </div>
</div>