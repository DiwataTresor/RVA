<script type="application/javascript">
	supp_liste_expl();
</script>
<div class="panel panel-default">
	<div class="panel-heading center">PAIEMENT SUPPLEMENT RDA</div>
    <div class="panel-body">
    	<div class="row">
        	<div class="col s12 m7">
            	<div class="panel panel-default">
                	<div class="panel-heading">FORMULAIRE</div>
                    <div class="panel-body">
                    	<form onSubmit="ajout_supp_rda(); return false">
                        	<div class="input-group">
                            	<label class="input-group-addon">Exploitant</label>
                                <select class="form-control" id="expl" required>
                                	<option>Exploitant</option>
                                </select>
                            </div>
                            <div class="row mt-2">
                            	<div class="col s12 m5">
                                	<div class="input-group">
                                        <label class="input-group-addon">Du</label>
                                        <input type="date" class="browser-default form-control" required id="dt">
                                    </div>
                                </div>
                                <div class="col s12 m5">
                                	<div class="input-group">
                                        <label class="input-group-addon">Au</label>
                                        <input type="date" class="browser-default form-control"  required id="dt2">
                                    </div>
                                </div>
                                <div class="col s12 m2">
                                	<button type="button" class="btn btn-success w-100" onclick="supp_liste_facture();"><i class="fa fa-search"></i> </button>
                                </div>
                            </div>
                            <div class="row">
                            	<div class="col s12 m8 input-group">
                                    <label class="input-group-addon">Montant</label>
                                    <input type="text" class="browser-default form-control right"  required id="mt">
                                </div>
                                <div class="col s12 m4">
                                		<select class="form-control browser-default" id="monnaie">
                                    		<option value="USD">USD</option>
                                            <option value="CDF">CDF</option>
                                    	</select>
                            	</div>
                            </div>
                            <div class="mt-2">
                            	<div class="input-group">
                            		<label class="input-group-addon">Facture</label>
                                	<input disabled type="text" class="browser-default form-control"  required id="facture">
                            	</div>
                            </div>
                             <div class="mt-2">
                            	<div class="input-group">
                            		<label class="input-group-addon">Motif</label>
                                	<input type="text" class="browser-default form-control"  required id="motif">
                            	</div>
                            </div>
                            <div class="mt-2">
                            	<div class="input-group">
                            		<label class="input-group-addon">Quittance</label>
                                	<input type="text" class="browser-default form-control"  required id="quittance">
                            	</div>
                            </div>
                            <div class="mt-2 center">
                            	<button type="submit" class="btn btn-success">Enregistrer</button>
                            </div>
                        </form>
                    </div>
            	</div>
            </div>
            <div class="col s12 m5">
            	<div class="panel panel-default">
                	<div class="panel-heading">RESULTAT</div>
                    <div class="panel-body">
                    	<div id="liste_facture">
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>