<script type="application/javascript">
	//acces_liste_acces();
</script>
<div class="panel panel-default">
	<div class="panel-heading center">ENREGISTREMENT D'UNE REDEVANCE AER</div>
    <div class="panel-body">
    	<div class="w-25">
        	<form onsubmit="ajout('rda'); return false">
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
            
           <div class="row input-group p-1"> 
                <span class="input-group-addon">Type accès</span>
               <select class="browser-default form-control" required id="rda_liste">
                <option value="RDA">RDA</option>
               </select>
            </div>
            <div class="row input-group p-1">
            	<label class="input-group-addon">Client</label>
                <input type="text" class="browser-default form-control" id="client" required />
            </div>
            <div class="row input-group p-1">
            	<label class="input-group-addon">Quittance</label>
                <input type="text" class="browser-default form-control" id="quittance" required />
            </div>
            <div class="row">
            	<div class="col s12 m6">
                    <label>Montant</label>
                    <input type="text" class="browser-default form-control right" required id="mt" />
            	</div>
                <div class="col s12 m6">
                <label>Monnaie</label>
                <select class="browser-default form-control" id="monnaie">
					<option value="CDF">CDF</option> 
                    <option value="USD">USD</option>                
                </select>
            	</div>
            </div>
            <p>
            	<button class="btn btn-success" type="submit">Enregistrer</button>
            </p>
          </form>
        </div>
    </div>
</div>