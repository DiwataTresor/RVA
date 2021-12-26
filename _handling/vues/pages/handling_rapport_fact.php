<script type="application/javascript">
	$(document).ready(function(){
		hand_rapport_facture_liste_client();
	});
</script>
<div class="panel panel-primary">
	<div class="panel-heading center bold fs-2">RAPPORT DES FACTURES</div>
    <div class="panel-body">
    	<div class="container mb-1 p-1">
         <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#rapp_journ_fact" aria-controls="home" role="tab" data-toggle="tab">RAPPORT JOURN. FACT.</a></li>
            <li role="presentation"><a href="#fact_non_payes" aria-controls="home" role="tab" data-toggle="tab">FACTURES NON PAYEES</a></li>
            <li role="presentation"><a href="#fact_payes" aria-controls="profile" role="tab" data-toggle="tab">FACTURES PAYEES</a></li>
            <li role="presentation"><a href="#rapport_paiement" aria-controls="profile" role="tab" data-toggle="tab">RAPPORT PAIEMENT</a></li>
          </ul>        </div>
         <div class="tab-content p-1">

            <div role="tabpanel" class="tab-pane active" id="rapp_journ_fact">
                <div class="row">
                    <form onsubmit="hand_rapport_journ_fact(); return false">
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
                <div class="" id="resultat">
                    
                </div>
            </div>
             <div role="tabpanel" class="tab-pane" id="fact_non_payes">
                <div class="row">
                    <form onsubmit="hand_rapport_fact_non_payees();return false">
                    <div class="col s12 m3 input-group">
                        <label class="input-group-addon">HANDLEUR</label>
                        <select class="browser-default form-control" id="client2" required></select>
                        <label class="input-group-addon loading_cl"><img src="images/gif/ajax-rond.gif"></label>
                    </div>
                    <div class="col s12 m3 input-group">
                        <label class="input-group-addon">DU</label>
                        <input type="date" class="browser-default form-control" required id="dt3" />
                    </div>
                    <div class="col s12 m3 input-group">
                        <label class="input-group-addon">AU</label>
                        <input type="date" class="browser-default form-control" required id="dt4" />
                    </div>
                    <div class="col s12 m3">
                        <button class="btn btn-success" type="submit">VISUALISER</button>
                    </div>
                    </form>
                </div>
                <div class="" id="resultat2">
                    
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="fact_payes">
                <div class="row">
                    <form onsubmit="hand_rapport_fact_payees(); return false">
                    <div class="col s12 m3 input-group">
                        <label class="input-group-addon">HANDLEUR</label>
                        <select class="browser-default form-control" id="client3" required></select>
                        <label class="input-group-addon loading_cl"><img src="images/gif/ajax-rond.gif"></label>
                    </div>
                    <div class="col s12 m3 input-group">
                        <label class="input-group-addon">DU</label>
                        <input type="date" class="browser-default form-control" required id="dt5" />
                    </div>
                    <div class="col s12 m3 input-group">
                        <label class="input-group-addon">AU</label>
                        <input type="date" class="browser-default form-control" required id="dt6" />
                    </div>
                    <div class="col s12 m3">
                        <button class="btn btn-success" type="submit">VISUALISER</button>
                    </div>
                    </form>
                </div>
                <div class="" id="resultat3">
                    
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="rapport_paiement">
                <div class="row">
                    <form onsubmit="handling_rapport_paiement(); return false">
                    <div class="col s12 m3 input-group">
                        <label class="input-group-addon">DU</label>
                        <input type="date" class="browser-default form-control" required id="dt7" />
                    </div>
                    <div class="col s12 m3 input-group">
                        <label class="input-group-addon">AU</label>
                        <input type="date" class="browser-default form-control" required id="dt8" />
                    </div>
                    <div class="col s12 m3">
                        <button class="btn btn-success" type="submit">VISUALISER</button>
                    </div>
                    </form>
                </div>
                <div class="" id="resultat4">
                    
                </div>
            </div>
         </div>
    </div>
</div>