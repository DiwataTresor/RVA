<style>
	label{font-size:15px}
</style>
<script type="application/javascript">
$(function(){
	dernier_taux();
});
</script>
<div class="panel panel-primary">
	<div class="panel-heading" align="left">GESTION TAUX</div>
    <div class="panel-body">
        <div class="row w3-align-left">
            <div class="col s12 m7" align="left">
            	<div class="panel panel-default">
                	<div class="panel-heading">Ajouter</div>
                    <div class="panel-body">
                        <form onSubmit="ajout('taux'); return false">
                        	<div class="row">
                            	<div class="input-group">
                                  <span class="input-group-addon" id="sizing-addon2">Date</span>
                                  <input type="date" value="<?php echo (date('Y-m-d')); ?>" class="browser-default form-control" placeholder="Username" aria-describedby="sizing-addon2" id="dt">
                                </div>
                            </div>
                            <div class="row">
                            	<div class="input-group">
                                  <span class="input-group-addon" id="sizing-addon2">FC</span>
                                  <input type="text" value="" class="browser-default form-control right" aria-describedby="sizing-addon2" id="fc_usd">
                                  <span class="input-group-addon">USD</span>
                                </div>
                            </div>
                            <div class="row">
                            	<div class="input-group">
                                  <span class="input-group-addon" id="sizing-addon2">USD</span>
                                  <input type="text" value="" class="browser-default form-control right" required aria-describedby="sizing-addon2" id="usd_fc">
                                  <span class="input-group-addon">FC</span>
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
                    	<div class="panel-heading">DERNIER TAUX</div>
                        <div class="panel-body fs-2">
                        	<div class="bold">Dernier taux</div>
                            <div id="dernier_taux">
                            
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>