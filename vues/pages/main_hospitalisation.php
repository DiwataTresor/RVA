<script type="application/javascript">
	$(document).ready(function(data){
		$('.collapsible').collapsible();
		$('.tabs').tabs();
		$('.sidenav').sidenav();
		$('.modal').modal();
		$('select').formSelect();
		liste_patient_hospitalises();
		liste_patient_att_hospitalisation();
	});
</script>
<div id="fenetre_contenu">
<div class="breadcrumb indigo-text bold" align="left">
    <i class="fa fa-folder-open"></i>&nbsp;HOSPITALISATION
</div>
<div class="card w3-round-large">
	<div class="card-content">
    	<div class="row">
        	<div class="w3-half">
            	<span class="">
                	Patient en attente d'Hospitalisation
                </span>
            </div>
            
            <div class="w3-half">
            	
            </div>
        </div>
        <div class="row">
            <div class="left">
              <ul class="tabs">
                <li class="tab"><a href="#pat_hosp" class="active">LISTE PATIENTS HOSPITALISES</a></li>
                <li class="tab"><a href="#liste_pat">FIL D'ATTENTE</a></li>
              </ul>
            </div>  
        </div>
    	<div class="row">
        	<div class="col s12 m12 breadcrumb grey-text" id="pat_hosp">
              Chargement des données en cours
            </div>  
            <div class="col s12 m12" id="liste_pat">
            	<div class="col s12 m12 container left" id="pat">
                	<div class="breadcrumb w3-text-green">
                    	<span><i class="fa fa-plus-circle"></i>&nbsp;Donn&eacute;es hospitalisation
                    </div>
                    <div class="w3-borders w3-padding fs-15" id="consultation_compl">
                    	<button class="browser-default btn btn-primary mb-1" onClick="consultation('plaintes'); return false"><i class=""></i>&nbsp;Suivie medical</button>
                        <button class="browser-default btn btn-primary mb-1" onClick="consultation('antecedents'); return false">Surveillance infirm</button>
                        <button class="browser-default btn btn-primary mb-1" onClick="$('#popup_blocoperatoire').show(); return false">Bloc operatoire</button>
                        <button class="browser-default btn btn-primary mb-1" onClick="consultation('anamneses'); return false">Prescrition med</button>
                        <button class="browser-default btn btn-primary mb-1" onClick="consultation('observation'); return false">Ajout act</button>
                        <button class="browser-default btn btn-primary mb-1" onClick="consultation('diagnostic'); return false">Diagnostic</button>
                        <button class="browser-default btn btn-primary mb-1" onClick="consultation('examenphysique'); return false">Examen Physique</button>
                        <button class="browser-default btn btn-primary mb-1" onClick="prescription(); return false">Prescription</button>
                        <button class="browser-default btn btn-primary mb-1" onClick="consultation('resultatimagerie'); return false">Resultat imagerie</button>
                        <button class="browser-default btn btn-primary mb-1" onClick="consultation('rapport'); return false">Rapport médical</button>
                    </div>
                    <div id="consultation_doss" class="w3-padding fs-15">
                    	
                    </div>
                </div>
                
            </div>         
         </div>
    </div>
</div>	
</div>