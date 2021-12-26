<form onsubmit="vol_nat_arr(); return false">
<div class="w3-border-left" style="border-top:0px" id="national_arrive">
	<div class=" bold red-text p-05">Sens : National Arriv&eacute;e</div>
    <div class="row p-05 m-05">
    	<div class="col s12 m2 input-group">
        	<span class="input-group-addon">Temps</span>
        	<select class="browser-default form-control" id="nat_arr_temps">
            	<option value="B">Bon</option>
                <option value="M">Mauvais</option>
            </select>
        </div>
        <div class="col s12 m4 input-group">
        	<span class="input-group-addon">Categorie vol</span>
        	<select class="browser-default form-control" required id="nat_arr_categ">
            	<!--<option value="">selectionner categorie</option>-->
                <option value="C">Commercial</option>
                <option value="P">Priv&eacute;e</option>
                <option value="M">Militaire</option>
                <option value="H">Humanitaire</option>
            </select>
        </div>
        <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Niv Vol</span>
        	<input type="text" class="browser-default form-control right" required id="nat_arr_niv"/>
        </div>
               
         <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Date arr</span>
        	<input type="date" class="browser-default form-control right" required id="nat_arr_dt"/>
        </div>
        <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Heure arr</span>
        	<input type="time" class="browser-default form-control right" required id="nat_arr_heure"/>
        </div>
    </div>
	<div class="row w3-border w3-round p-05 m-05">
        <div class="row bold pl-2" align="left">1e Escale</div>
        <div class="col s12 m2 input-group">
        <span class="input-group-addon">Ville</span>
        	<select class="browser-default form-control ville_pro" required id="esc1_ville">
            	
            </select>
        </div>
                
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">AD</span>
            <input type="text" class="browser-default form-control right" required id="esc1_ad" value="0" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">CH</span>
            <input type="text" class="browser-default form-controlright" required id="esc1_ch" value="0" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">INF</span>
            <input type="text" class="browser-default form-control right" required id="esc1_inf" value="0" />
        </div>
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">TRA</span>
            <input type="text" class="browser-default form-control right" required id="esc1_tra" value="0" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">PEC</span>
            <input type="text" class="browser-default form-control right" required id="esc1_pec" value="0" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">LOC</span>
            <input type="text" class="browser-default form-control right" required id="esc1_loc" value="0" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">TRAT</span>
            <input type="text" class="browser-default form-control right" required id="esc1_trat" value="0" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">PTT</span>
            <input type="text" class="browser-default form-control right" required id="esc1_ptt" value="0" />
        </div>
    </div>
    
    <div class="row w3-border w3-round p-05 m-05 couleur-grise-faible">
        <div class="row bold p-1 pl-2" align="left">EXONERATION </div>
        <div class="col s12 m2 input-group">
            <span class="input-group-addon">ATT</span>
            <select class="browser-default form-control" id="ex_att_nat_arr">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon">STT</span>
            <select class="browser-default form-control" id="ex_stt_nat_arr">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon">STG</span>
            <select class="browser-default form-control" id="ex_stg_nat_arr">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">BAL</span>
            <select class="browser-default form-control" id="ex_bal_nat_arr">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">PAX</span>
            <select class="browser-default form-control" id="ex_pax_nat_arr">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">FRET</span>
            <select class="browser-default form-control" id="ex_fret_nat_arr">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">ROUTE</span>
            <select class="browser-default form-control" id="ex_route_nat_arr">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
    </div>  
    <p class="center">
    	<button class="btn btn-success" type="submit">Enregistrer</button>
    </p> 
</div>
</form>