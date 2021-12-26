<style>
	label{font-size:15px}
</style>
<script type="application/javascript">
$(function(){
	admin_liste_convention();
});
</script>
<div class="panel panel-primary">
	<div class="panel-heading" align="left">GESTION DES CONVENTIONS</div>
    <div class="panel-body">
        <div class="row w3-align-left">
            <div class="col s12 m4" align="left">
            	<div class="panel panel-default">
                	<div class="panel-heading">Ajouter</div>
                    <div class="panel-body">
                        <form onSubmit="ajout('convention'); return false">
                            <p class="">
                            	<input type="hidden" id="id_acte" value="" />
                                <label>Nom société</label>
                                <input type="text" id="convention_nom" class="browser-default form-control" />
                            </p>
                            <p class="">
                                <label>Contact</label>
                                <input type="text" id="convention_contact" class="browser-default form-control" />
                            </p>
							<p class="">
                                <label>Detail</label>
                                <textarea type="text" id="convention_detail" class="browser-default form-control">
                                
                                </textarea>
                            </p>                             
                            <p>
                                <button class="btn green" type="submit"><i class="fa fa-check-circle"></i>&nbsp;Enregistrer</button>
                                <button class="btn green hide" type="button"><i class="fa fa-check-circle"></i>&nbsp;Modifier</button>
                            </p>
                        </form>
                     </div>
                </div>
            </div>
            <div class="col s12 m8">
            	<div class="w3-borde w3-round">
                	<div class="panel panel-default">
                    	<div class="panel-heading">SOCIETES ENREGISTREES</div>
                        <div class="panel-body">
                        	<table width="536" border="0" class="table table-stripped">
                              <tr class="w3-blue">
                                <td width="160">Nom</td>
                                <td width="137">Contact</td>
                                <td width="177">Detail</td>
                                <td>Option</td>
                              </tr>
                              
                             </table
                        ></div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>