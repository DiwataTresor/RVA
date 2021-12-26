<script type="application/javascript">
	$(document).ready(function(){
		route_pt_liste();
		route_empl_liste();
		route_ville_liste();
	});
</script>
<div class="panel panel-primary">
	<div class="panel-heading center bold fs-2">MISE A JOUR DE POINTS D'ENTREES, EMPLACEMENTS ET VILLES</div>
    <div class="panel-body">
        <div>
        </div>
        <div class="mt-1 pt-1">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">POINT ENTRE/SORTIE</a></li>
            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">EMPLACEMENT NATIONAL</a></li>
             <li role="presentation"><a href="#ville" aria-controls="profile" role="tab" data-toggle="tab">VILLE</a></li>
          </ul>
        
          <!-- Tab panes -->
          <div class="tab-content p-1">
            <div role="tabpanel" class="tab-pane active" id="home">
            		<div class="row">
                    	<div class="col s12 m4">
                        	<div class="panel panel-default">
                            	<div class="panel-heading">AJOUT POINT ENTREE/SORTIE</div>
                                <div class="panel-body">
                                	<form onSubmit="ajout('point_entree');">
                                    	 <input type="hidden" id="pt_id" />
                                        <p>
                                        	<label>Libell&eacute;</label>
                                            <input type="text" required class="browser-default form-control" id="pt_libelle" />
                                        </p>
                                        <p>
                                        	<label>Code</label>
                                            <input type="text" required class="browser-default form-control"id="pt_code" />
                                        </p>
                                         	<label>Distance</label>
                                       <p class="input-group">
                                            <input type="text" required class="browser-default form-control right" id="pt_distance" />
                                            <span class="input-group-addon">KM</span>
                                        </p>
                                        <p>
                                            <button class="btn waves waves-effect" id="btn_enreg" type="submit">Enregistrer</button>
                                        </p>
                                        <p>
                                            <button class="btn waves waves-effect hide" id="btn_modif" onclick="upd('route_pt_conf');" type="button">Modifier</button>
                                            <button class="btn btn-warning waves waves-effect hide" id="btn_annuler" type="button">Annuler</button>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m8">
                        	<div class="panel panel-default">
                            	<div class="panel-heading">LISTE</div>
                                <div class="panel-body" id="pt_liste">
                                	<img src="images/gif/ajax-rond.gif" /> chargement en cours...
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="profile">
            	<div class="row">
                    	<div class="col s12 m4">
                        	<div class="panel panel-default">
                            	<div class="panel-heading">EMPLACEMENT NAT</div>
                                <div class="panel-body">
                                	<form onSubmit="ajout('emplacement');">
                                    	<input type="hidden" id="empl_id" />
                                    	<p>
                                        	<label>Libell&eacute;</label>
                                            <input type="text" required class="browser-default form-control" id="empl_libelle" />
                                        </p>
                                        <p>
                                        	<label>Code emplacement</label>
                                            <input type="text" required class="browser-default form-control"id="empl_code" />
                                        </p>
                                        <label>Distance</label>
                                       <p class="input-group">
                                            <input type="text" required class="browser-default form-control right" id="empl_distance" />
                                            <span class="input-group-addon">KM</span>
                                        </p>
                                        <p class="input-group">
                                        	<label class="input-group-addon">GERE PAR LA RVA</label>
                                            <select class="browser-default form-control" id="gere">
                                            	<option value="G">Oui</option>
                                                <option value="N">Non</option>
                                            </select>
                                        </p>
                                       <p>
                                            <button class="btn waves waves-effect" id="btn_enreg2" type="submit">Enregistrer</button>
                                        </p>
                                        <p>
                                            <button class="btn waves waves-effect hide" id="btn_modif2" onclick="upd('route_empl_conf');" type="button">Modifier</button>
                                            <button class="btn btn-warning waves waves-effect hide" id="btn_annuler2" type="button">Annuler</button>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m8">
                        	<div class="panel panel-default">
                            	<div class="panel-heading">LISTE</div>
                                <div class="panel-body" id="empl_liste">
                                	<img src="images/gif/ajax-rond.gif" /> chargement en cours...
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            
            <div role="tabpanel" class="tab-pane" id="ville">
            	<div class="row">
                	<div class="col s12 m4">
                    	<div class="panel panel-default">
                        	<div class="panel-heading">VILLE</div>
                            <div class="panel-body">
                            	<form onsubmit="ajout('ville'); return false">
                                	<input type="hidden" id="ville_id" />
                            		<p>
                                    	<label>Code ville</label>
                                        <input type="text" class="browser-default form-control" required id="code_ville" />
                                    </p>
                                    <p>
                                    	<label>Ville</label>
                                        <input type="text" class="browser-default form-control" required id="libelle_ville" />
                                    </p>	
                                    <p class="center">
                                    	<button class="btn btn-success" type="submit" id="btn_enreg3">Enregistrer</button>
                                        <button class="btn btn-success hide" type="button" id="btn_modif3">Modifier</button>
                                        <button class="btn btn-warning hide" type="button" id="btn_annuler3">Annuler</button>
                                    </p>
                                </form>	
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8">
                    	<div class="panel panel-default">
                            	<div class="panel-heading">LISTE</div>
                                <div class="panel-body" id="ville_liste">
                                	<img src="images/gif/ajax-rond.gif" /> chargement en cours...
                                </div>
                            </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
     </div>
</div>