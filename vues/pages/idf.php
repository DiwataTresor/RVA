<script type="application/javascript">
	idf_liste_cli();
	
</script>
<div class="panel panel-primary">
	<div class="panel-heading center bold fs-2">AJOUT IDF</div>
    <div class="panel-body">
    	<div class="row">
        	<div class="col s12 m4">
            	<div class="panel panel-primary">
                	<div class="panel-heading">ENREGISTREMENT</div>
                    <div class="panel-body">
                        <form onsubmit="ajout_idf();return false">
                            <div class="row m-1">
                                <div class="col s12 m6">
                                    <label>Date</label>
                                    <input type="date" class="browser-default form-control" id="dt"required />
                                </div>
                            </div>
                            <p class="m-1">
                            <label>CLIENT</label>
                            <select class="browser-default form-control" id="client" required>
                                <option value="">--selectionner client</option>
                            </select>
                            </p>
                            <div class="row m-1">
                            <div class="col s12 m7">
                                <label>MONTANT</label>
                                <input type="text" class="form-control browser-default" id="mt" required />
                            </div>
                            <div class="col s12 m5">
                                <label>&nbsp;</label>
                                <select class="form-control browser-default" id="monn">
                                    <option value="USD">USD</option>
                                    <option value="CDF">CDF</option>
                                </select>
                             </div>
                            </div>
                             <label>QUITTANCE</label>
                            <input type="text" class="browser-default form-control" id="quittance" required />
                            </p>
                            <p class="center">
                            	<button class="btn btn-success" id="btn_enreg" type="submit">Enregistrer</button>
                                <button class="btn btn-success hide" type='button' id="btn_modif">Modifier</button>
                                <button class="btn btn-success hide" type="button" id="btn_annuler">Annuler</button>
                             </p>
                        </form>
                    </div>
               	</div>
            </div>
            <div class="col s12 m8">
            	 <div class="panel panel-default">
            	<div class="panel-heading center bold">LISTE</div>
                <div class="panel-body">
                	<div class="row">
                    	<div class="col s12 m4">
                        	<label>Du</label>
                            <input type="hidden" id="id" />
                            <input type="date" class="browser-default form-control" id="acces_dt1" required />
                        </div>
                        <div class="col s12 m4">
                        	<label>Au</label>
                            <input type="date" class="browser-default form-control" id="acces_dt2" required />
                        </div>
                        <div class="col s12 m4">
                        	<label>&nbsp;</label>
                        	<div>
                            	<button class="btn btn-success" id="" onclick="rapport_idf_liste();">Visualiser</button>
                             </div>
                        </div>
                    </div>
                    <div class="" id="resultat">
                    
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>