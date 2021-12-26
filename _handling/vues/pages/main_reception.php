<script type="application/javascript">
	$(document).ready(function(data){
		
		$('.collapsible').collapsible();
		 $('.tabs').tabs();
		 $('.sidenav').sidenav();
		 $('.modal').modal();
		 $('select').formSelect();
		 charger_acte();
	});
</script>
<div id="fenetre_contenu">
<div class="breadcrumb indigo-text bold" align="left">
    <i class="fa fa-folder-open"></i>&nbsp;GESTION DE LA RECEPTION
</div>
<div class="card w3-round-large">
	<div class="card-title couleur-grise grey lighten-4 w3-round">
    	&nbsp;
    </div>
	<div class="card-content">
    	<div class="row">
        	<div class="left">
              <ul class="tabs">
                <li class="tab"><a href="#pat" class="active">ENREGISTRER PATIENT</a></li>
                <li class="tab"><a href="#liste_pat">LISTE DES PATIENTS/JOUR</a></li>
              </ul>
            </div>  
            <div class="row">
            	<div class="col s12 m12 container left" id="pat">
                	<div class="breadcrumb w3-text-green">
                    	<i class="fa fa-plus-circle"></i>&nbsp;Ajout Patient
                    </div>
                    <div class="w3-borders w3-padding fs-15 card lighten-2">
                    	<form onsubmit="ajout('patient'); return false">
                        	<p class="row">
                            	<label>Nouveau patient ?</label>
                            	<select class="browser-default form-control mb-2" id="stat_patient">
                                	<option value="">Selectionner</option>
                                	<option value="N">Nouveau</option>
                                    <option value="E">Existant</option>
                                </select>
                            </p>
                        	<p class="row">
                            	<label class="mb-1">Acte <span id="loading_acte"></span></label>
                            	<select class="browser-default form-control mb-2" id="pat_acte">
                                	
                                </select>
                            </p>
							<p class="row pb-1">
							  <div class="col s12 m6">
										<label class="fs-15">Categorie pat.</label>
										<select class="browser-default form-control" id="type_pat" required onchange="type_patient();">
											<option value="">Categorie</option>
                                            <option value="P">Priv&eacute;</option>
                                            <option value="C">Conventionn&eacute;</option>
										</select>
							  </div>
                                <div class="col s12 m6">
                                	<label class="fs-15">Convention <small id="loading_conv"></small></label>
                                	<select class="browser-default form-control" id="pat_conv" disabled>
                                    	
                                    </select>
                                </div>
                            </p>
                            
                            <p class="row">
							  <div class="col s12 m6">
										<label class="fs-15 mt-1">Nom</label>
										<input type="text" class="browser-default form-control" required id="pat_nom">
							  </div>
                                <div class="col s12 m6">
                                	<label class="fs-15 mt-1">Prenom</label>
                        			<input type="text" class="browser-default form-control" required id="pat_prenom">
                                </div>
                            </p>
                            
                            <p class="row mt-1">
                              <div class="col s12 m3 mt-1">
                                        <label class="fs-15">Sexe</label>
                                        <select class="browser-default form-control" id="pat_sexe">
                                            <option value="H">Homme</option>
                                            <option value="F">Femme</option>
                                        </select>
                              </div>
                              <div class="col s12 m9 mt-1">
                                	<label class="fs-15">Adresse</label>
                        			<input type="text" class="browser-default form-control" id="pat_adresse">
                              </div>
                            </p>
                            <p class="row">
                       	  		<div class="col s12 m4 mt-1">
                            	
                                	<label class="fs-15">Télephone</label>

                           			<input type="tel" class="browser-default form-control" id="pat_telephone">
                           		</div>
                                <div class="col s12 m8 mt-1">
                                	<label class="fs-15">Profession </label>
                                	<input type="text" name="profession" class="browser-default form-control" id="pat_profession">
                                </div>
                           </p>
						   <p>&nbsp;</p>
						   <div class="card-actiona"></div>
							<p class="center row clear card-footer" style="margin-top:20px">
								<button class="btn blue" type="submit"><i class="fa fa-check-circle"></i>&nbsp;Enregistrer</button>
							</p>
							
                        </form>
                    </div>
                </div>
                <div class="col s12 m12 left" id="liste_pat">
                	Liste des patients/jour
                </div>
            </div>         
         </div>
    </div>
</div>	
</div>