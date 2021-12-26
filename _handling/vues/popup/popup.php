<div id="popup_facture_cash" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-round fs-1" style="width:99%; min-height:500px; top:10px; text-align:left">

      <div class="w3-center">
      	 <div class="card-action p-1" align="right">
      		<button class="btn btn-flat w3-border w3-hover-blue-grey waves waves-effect" onclick="$('#popup_facture_cash').hide()">Fermer</button>
      	</div>
      </div>
      <hr />
      <div id="detail_facture_cash" class="fs-12 p-05">
      	<div class="fs-15 center"><img src="images/gif/ajax-rond3.gif" /> Chargement des donn&eacute;es en cours...</div>
      </div>
    </div>
  </div>

<div id="releve_cl" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-round fs-1" style="width:99%; min-height:500px; top:10px; text-align:left">

      <div class="w3-center">
      	 <div class="card-action p-1" align="right">
      		<button class="btn btn-flat w3-border w3-hover-blue-grey waves waves-effect" onclick="$('#popup_facture_cash').hide()">Fermer</button>
      	</div>
      </div>
      <hr />
      <div id="detail_facture_cash" class="fs-12 p-05">
      	<div class="fs-15 center"><img src="images/gif/ajax-rond3.gif" /> Chargement des donn&eacute;es en cours...</div>
      </div>
    </div>
  </div>


<!-------------------- POPUP----------->
    
  <div id="popup" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-round" style="max-width:550px;  text-align:left; top:70px">
      <div class="card">
      	<div class='browser-default couleur-grise card-heading'>
      		<div class='grey lighten-2 p-1' styl="height:40px">
      			<span class='col s12 m1'>
      				<i class='fa fa-pencil'></i>
      			</span>
      			<span class='col s12 m8 pl-1' id="popup_entete">
					Entete
      			</span>
      			<span class='col s12 m2 right'>
      				<button class="btn btn-flat w3-small w3-hover-red waves waves-effect" onclick="$('#popup').hide()">x
      				</button>
      			</span>
      		</div>
			
      	</div>
	    <div id="popup_contenu" class="card-content clearfix">
	        
	    </div>
	  </div>
    </div>
  </div>
	<!-------------------- LOADING----------->
    
  <div id="popup_loading" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-round" style="max-width:200px; min-height:100px; text-align:left; top:200px">
      <div id="popup_loading_d" class="p-10 center">
      	<img src="images/gif/ajax-rond2.gif" />
        <div class="fs-1">Chargement en cours...</div>
      </div>
    </div>
  </div>
  <!----------------------- IMPRESSION --------------->
   <div id="popup_impression" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-round" style="max-width:600px; min-width:600px; min-height:100px; text-align:left; top:0px">
      <div class="couleur-grise-faible bold p-1 pb-2 rounded">
      	<i class="fa fa-print"></i> IMPRESSION
        <span class="w3-btn red right white-text w3-small w3-round" onclick="fermer_modal()">x</span>
      </div>
      <div id="popup_loading_d" class="p-10 center">
      	<div><span id="titre" class="purple-text fs-15"></span></div>
      	<input type="hidden" id="t" />      	
        <div class="fs-1 contenu">
        	<div class="fs-15 bold p-1 blue-grey-text" align="left">
            	<div class="row">
                	<div class="col s12 m1">Tout</div>
					<button class="btn btn-success col s12 m3" onclick="impression_generale_t()">Toute la liste</button>
                </div>
            </div>
        	
        </div><hr  />
        <div>
            <div class="row center pl-1" align="center">
            	<div class="col s12 m2 fs-15 bold p-1 blue-grey-text" align="left">Par p&eacute;riode</div>
            	<div class="col s12 m1">Du</div>
                <div class="col s12 m3"><input type="date" class="browser-default form-control" /></div>
                <div class="col s12 m1 center">Au</div>
                <div class="col s12 m3"><input type="date" class="browser-default form-control" /></div>
                <div class="col s12 m2"><button class="btn btn-success">Voir</button></div>
            </div
        ></div>
      </div>
    </div>
    </div>
  </div>
 <!----------------------------------------- POPUP GLOBAL------------------------->
	<div id="popup_global" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-round fs-1" style="max-width:400px; text-align:left">

      <div class="w3-center">
      </div>
      <div id="popup_global_contenu" class="p-10">
      	
      </div>
      <hr />
      <div class="card-action p-1" align="right">
      	<button class="btn btn-flat w3-border w3-hover-blue-grey waves waves-effect" onclick="$('#popup_global').hide()">Fermer</button>
      </div>
    </div>
  </div>

  <!-------------------- POPUP BLOC OPERATOIRE----------->
    
  <div id="popup_esc" class="w3-modal">
    <form onsubmit="ajout('escale'); return false">
      <div class="w3-modal-content w3-card-4 w3-round" style="width:70%;  text-align:left; top:20px">
        <div class="card">
        	<div class='browser-default couleur-grise card-heading'>
        		<div class='grey lighten-2 p-1' styl="height:40px">
        			<span class='col s12 m1'>
        				<i class='fa fa-pencil'></i>
        			</span>
        			<span class='col s12 m8 pl-1 blue-text bold'>
  					   AJOUT D'UN ESCALE
        			</span>
        			<span class='col s12 m2 right'>
        				<button class="btn btn-flat w3-small w3-hover-red waves waves-effect" onclick="$('#popup_esc').hide()">x
        				</button>
        			</span>
        		</div>
  			
        	</div>
  	    	<div id="popup_esc_contenu" class="card-content clearfix">
  	        <div class="row w3-border w3-round p-05 m-05">
                <div class="row bold pl-2" align="left">Escale</div>
                <div class="row pl-1">  
                  <div class="col s12 m2 input-group">
                  	<input type="hidden" id="esc2_sens" />
                    <input type="hidden" id="esc2_num_fic" />
                  <span class="input-group-addon">Ville</span>                  	
                      <select class="browser-default form-control ville_pro" required id="escajout_ville">
                         
                      </select>
                  </div>
                          
                  <div class="col s12 m2 input-group">
                      <span class="input-group-addon w3-small">AD</span>
                      <input type="text" class="browser-default form-control right" required id="escajout_ad" />
                  </div>
                  
                  <div class="col s12 m2 input-group">
                      <span class="input-group-addon w3-small">CH</span>
                      <input type="text" class="browser-default form-controlright" required id="escajout_ch" />
                  </div>
                  
                  <div class="col s12 m2 input-group">
                      <span class="input-group-addon w3-small">INF</span>
                      <input type="text" class="browser-default form-control right" required id="escajout_inf" />
                  </div>
                  <div class="col s12 m2 input-group">
                      <span class="input-group-addon w3-small">TRA</span>
                      <input type="text" class="browser-default form-control right" required id="escajout_tra" />
                  </div>
                  
                  <div class="col s12 m2 input-group">
                      <span class="input-group-addon w3-small">PEC</span>
                      <input type="text" class="browser-default form-control right" required id="escajout_pec" />
                  </div>
                  
                  <div class="col s12 m2 input-group">
                      <span class="input-group-addon w3-small">LOC</span>
                      <input type="text" class="browser-default form-control right" required id="escajout_loc" />
                  </div>
                  
                  <div class="col s12 m2 input-group">
                      <span class="input-group-addon w3-small">TRAT</span>
                      <input type="text" class="browser-default form-control right" required id="escajout_trat" />
                  </div>
                  
                  <div class="col s12 m2 input-group">
                      <span class="input-group-addon w3-small">PTT</span>
                      <input type="text" class="browser-default form-control right" required id="escajout_ptt" />
                  </div>
              </div>
              <div class="row mt-1 ml-1">
              	<button class="btn bt-success" type="submit">Ajouter</button>
              </div>
  	    </div>
  	  </div>
    </form>
    </div>

  </div>
  