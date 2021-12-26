<script type="application/javascript">
	$(document).ready(function(){
		handleur_liste_handleur();
	});
</script>
<div>
    <div class="row">
    	<div class="col s12 m4">
           <form onSubmit="ajout_handleur();return false">
        	<div class="panel panel-default">
                <div class="panel-heading center bold green-text fs-2">MISE A JOUR HANDLEUR</div>
                <div class="panel-body">
                	<input type="hidden" id="id" />
                    <label>Nom</label>	
                    <input type="text" class="form-control browser-default" id="handleur_nom" required />
                    <label>Code</label>	
                    <input type="text" class="form-control browser-default" id="handleur_code" required />
                    <label>Adresse</label>	
                    <input type="text" class="form-control browser-default" id="handleur_adresse" required />
                    <label>Ville</label>	
                    <input type="text" class="form-control browser-default" id="handleur_ville" />
                    <label>Telephone</label>	
                    <input type="text" class="form-control browser-default" id="handleur_telephone" />
                    <label>Type paiement</label>	
                    <select class="form-control browser-default" id="handleur_type_paie" required>
                        <option value="C">Cash</option>
                        <option value="M">Mensuel</option>
                    </select>
                    <label>Nationalit&eacute;</label>	
                    <select class="form-control browser-default" id="handleur_nationalite" required>
                        <option value="L">Local</option>
                        <option value="E">Etranger</option>
                    </select>
                </div>
                <div class="panel-footer pt-2 center">
                        <button class="btn green white-text bold" id="btn_enreg" type="submit">Enregitrer</button>
                        <button class="btn btn-primary hide" id="btn_modif" type="button"><i class="fa fa-check"></i>&nbsp;Modifier</button>
                        <button class="btn btn-warning hide" id="btn_annuler" type="button"><i class="fa fa-check"></i>&nbsp;Annuler</button>
                </div>
             </div>
            </form>
         </div>
         <div class="col s12 m8 pl-3" style="padding-left:40px">
         	<div class="panel panel-default">
                <div class="center panel-heading">LISTE DES HANDLEURS ENREGISTRES</div>
                <div class="panel-body" id="detail_liste_handleur">
                
                </div>
         </div>
    </div>
</div>