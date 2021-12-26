<?php
@session_start();
?>
<script language="javascript" type="application/javascript">
	$(document).ready(function(){
		hand_rapport_facture_liste_client();
	});
</script>
<div class="panel panel-success">
	<div class="panel-heading center bold fs-15">HANDLING - MOUVEMENTS / PERIODE</div>
    <div class="panel-body detail">
    	<div role="tabpanel" class="tab-pane active" id="rapp_journ_fact">
                <div class="row">
                    <form onsubmit="hand_mouv_periode(); return false">
                    <div class="col s12 m3 input-group">
                        <label class="input-group-addon">HANDLEUR</label>
                        <select class="browser-default form-control" id="client1" required></select>
                        <label class="input-group-addon loading_cl"><img src="images/gif/ajax-rond.gif"></label>
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
               
            </div>
    </div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading center bold fs-15">RESULTAT</div>
    <div class="panel-body detail" id="resultat">
    	
    </div>
</div>