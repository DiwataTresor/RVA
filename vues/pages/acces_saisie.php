<script type="application/javascript">
	acces_liste_acces();
</script>
<div class="panel panel-default">
	<div class="panel-heading center bold fs-12">ENREGISTREMENT D'UN ACCES</div>
    <div class="panel-body">
    	<div class="row">
        	
            <div class="col s12 m4">
                <form onsubmit="ajout('acces'); return false">
                <input type="hidden" id="id" />
                <div class="row">
                    <div class="col s12 m6">
                        <label>Date</label>
                        <input type="date" class="browser-default form-control" required value="<?php echo date('Y-m-d'); ?>" id="dt" />
                    </div>
                    <div class="col s12 m6">
                        <label>Heure</label>
                        <input type="time" class="browser-default form-control" required value="<?php echo date('H:i:s'); ?>" id="heure" /> 
                    </div>
                </div>    
                <p>
                    <label>Type accès</label>
                   <div class="input-group"> 
                        <span class="input-group-addon"><img src="images/gif/ajax-rond.gif" /></span>
                       <select class="browser-default form-control" required id="acces_liste">
                       </select>
                    </div>
                </p>
                <div class="row p-1">
                    <label>Quittance</label>
                    <input type="text" class="browser-default form-control" id="quittance" required />
                </div>
                <p>
                    <label>Montant Hors taxe</label>
                    <input type="text" class="browser-default form-control right" required id="mt" />
                </p>
                <label class="mt-1">Monnaie</label>
                <p class="input-group pt-1">
                    <select class="browser-default form-control" id="monnaie">
                        <option value="CDF">CDF</option> 
                        <option value="USD">USD</option>                
                    </select>
                </p>
                <label class="mt-1">TVA</label>
                 <p class="input-group pt-1">            	
                    <select class="browser-default form-control" id="tva" required>
                        <option value="">--Selection--</option> 
                        <option value="O">OUI</option> 
                        <option value="N">NON</option>                
                    </select>
                </p>
                <p>
                    <button class="btn btn-success" id="btn_enreg" type="submit">Enregistrer</button>
                    <button class="btn btn-success hide" onclick="" id="btn_modif">Modifier</button>
                    <button class="btn btn-success hide" id="btn_annuler">Annuler</button>
                </p>
              </form>
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
                            	<button class="btn btn-success" id="" onclick="rapport_access();">Visualiser</button>
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