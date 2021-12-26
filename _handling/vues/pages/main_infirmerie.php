<script type="application/javascript">
	$(document).ready(function(data){
		$('.collapsible').collapsible();
		$('.tabs').tabs();
		$('.sidenav').sidenav();
		$('.modal').modal();
		$('select').formSelect();
        $('#form-contenu').hide();
        liste_med();
		liste_patient_att_infirmerie();
	});
</script>
<div id="fenetre_contenu">
<div class="breadcrumb indigo-text bold" align="left">
    <i class="fa fa-folder-open"></i>&nbsp;INFIRMERIE
</div>
<div class="card w3-round-large">
	<div class="card-title couleur-grise grey lighten-4 w3-round">
    	<div class="row p-1">
        	<div class="col s12 m2 fs-12">
            	<span class="pt-05 valign-wrapper"><a href="#" class=""><i class="fa fa-list-ul"></i>&nbsp;Liste des patients</a></span>
            </div>
        	<div class="col s12 m2"><span class="fs-2 blue-text">Patient</span></div>
            <div class="col s12 m4">
            	<select class="browser-default form-control" onchange="infirmerie();" id="patient">
					
                </select>
            </div>
            <div class="col s12 m1">&nbsp;</div>
            <div class="col s12 m3">
            	<span class="fs-12 pt-05 valign-wrapper">
                	<i class="fa fa-pause"></i>&nbsp;&nbsp;&nbsp;En attente
                	<a href="#"><span class="badge w3-red hoverable">1</span></a>
                </span>
            </div>
        </div>
    </div>
	<div class="card-content">
        <div class="row" id="attente">
            Infirmerie
        </div>
    	<div class="row" id="form-contenu">
        	<div class="left">
              <ul class="tabs">
                <li class="tab"><a href="#pat" class="active">SIGNES VITAUX (Patient)</a></li>
                <li class="tab"><a href="#liste_pat">FIL D'ATTENTE</a></li>
                <li class="tab"><a href="#liste_pat">LISTE PATIENT / JOUR</a></li>
              </ul>
            </div>  
            <div class="row">
            	<div class="col s12 m12 container left" id="pat">
                	<div class="breadcrumb w3-text-green">
                    	<i class="fa fa-plus-circle"></i>&nbsp;Ajout signes vitaux
                    </div>
                    <div class="w3-borders w3-padding fs-15">
                    	<form onsubmit="ajout('signes_vitaux'); return false">
                        	<p class="row mb-1">
                            	<div class="col s12 m6 mb-3">
                                	<label class="fs-15">Motif</label>
                                	<input type="text" class="browser-default form-control" id="motif" />
                                </div>
                            </p>
							<p class="row mt-1">
                            	<div class="col s12 m4">
                                	<label class="fs-15">Ann&eacute; naiss</label>
                                    <input type="text" class="form-control browser-default mb-1" id="pat_annee_naiss">
                                </div>
                                <div class="col s12 m4">
                                    <label class="fs-15">Poids</label>
                                    <input type="text" class="form-control browser-default mb-1" id="pat_poids">
                                </div>
                                <div class="col s12 m4">
                                    <label class="fs-15">Taille</label>
                                    <input type="text" class="form-control browser-default mb-1" id="pat_taille">
                                </div>
                                  <div class="col s12 m4 clearfix">
                                        <label class="fs-15">Groupe sanguin</label>
                                        <input type="text" class="form-control browser-default mb-1" id="pat_gs">
                                  </div>
                                  <div class="col s12 m4">
                                    <label class="fs-15">Temperature</label>
                                    <input type="text" class="form-control browser-default mb-1" id="pat_temperature">
                                </div>
                                
                                <div class="col s12 m4">
                                    <label class="fs-15">TA</label>
                                    <input type="text" class="form-control browser-default mb-1" id="pat_ta">
                                </div>
                                <div class="col s12 m4">
                                    <label class="fs-15">FC</label>
                                    <input type="text" class="form-control browser-default mb-1" id="pat_fc">
                                </div>
                                <div class="col s12 m4">
                                    <label class="fs-15">FR</label>
                                    <input type="text" class="form-control browser-default mb-1" id="pat_fr">
                                </div>
                                <div class="col s12 m4">
                                    <label class="fs-15">SA</label>
                                    <input type="text" class="form-control browser-default mb-1" id="pat_sa">
                                </div>
                                <p class="clearfix">
                                	<div class="col s12 m6">
                                    	<label class="fs-15">Observation</label>
                                    	<textarea class="form-control browser-default mb-1" id="pat_observation" rows="4" required>
                                        </textarea>
                                    </div>
                                </p>
                            </p>
                            <p class="clearfix">&nbsp;<hr /></p>
                            <p class="row mt-1">
                            	<div class="col s12 m6">
                                	<label class="fs-15">Envoyer &agrave; la consultation ?</label>
                                    <select class="browser-default form-control" id="option_consultation">
                                    	<option value="O">Oui</option>
                                        <option value="N">Non</option>
                                    </select>
                                </div>
                                <div class="col s12 m6">
                                	<label class="fs-15">Medecin</label>
                                    <select class="browser-default form-control" id="liste_med">
                                    	<option value=""></option>
                                        
                                    </select>
                                </div>
                            </p>
                            
                          <p class="clearfix">&nbsp;</p>
						   <div class="card-footer"></div>
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