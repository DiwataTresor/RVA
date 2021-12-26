<form onsubmit="vol_nat_dep(); return false">
<div class="w3-border-left" style="border-top:0px" id="national_depart">
	<div class=" bold red-text p-05">Sens : National Depart</div>
    <div class="row p-05 m-05">
    	<div class="col s12 m2 input-group">
        	<span class="input-group-addon">Temps</span>
        	<select class="browser-default form-control" id="nat_dep_temps">
            	<option value="B">Bon</option>
                <option value="M">Mauvais</option>
            </select>
        </div>
        <div class="col s12 m4 input-group">
        	<span class="input-group-addon">Categorie vol</span>
        	<select class="browser-default form-control" required id="nat_dep_categ">
            	<option value="">selectionner categorie</option>
                <option value="P">Priv&eacute;e</option>
                <option value="C">Commercial</option>
                <option value="M">Militaire</option>
                <option value="H">Humanitaire</option>
            </select>
        </div>
        <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Compt Enre</span>
            <input type="number" value="3" class="browser-default form-control" id="nat_dep_compt_enr" />
        </div>
         <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Form</span>
            <input type="number" value="4" class='browser-default form-control' id="nat_dep_form" />
        </div>
        <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Niv Vol</span>
        	<input type="text" class="browser-default form-control right" required id="nat_dep_niv"/>
        </div>
        <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Station</span>
        	<select class="browser-default form-control right" required id="nat_dep_stat">
            	<option value="N">Aucun stat.</option>
                <option value="T">Tarmac</option>
                <option value="G">Garage</option>
            </select>
        </div>
        
         <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Date dep</span>
        	<input type="date" class="browser-default form-control right" required id="nat_dep_dt"/>
        </div>
        <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Heure dep</span>
        	<input type="time" class="browser-default form-control right" required id="nat_dep_heure"/>
        </div>
        <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Ass. Anti-inc</span>
        	<select  class="browser-default form-control right" required id="nat_dep_anti_inc">
            	<option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
    </div>
	<div class="row w3-border w3-round p-05 m-05">
        <div class="row bold pl-2" align="left">1e Escale</div>
        <div class="col s12 m2 input-group">
        <span class="input-group-addon">Ville</span>
        	<select class="browser-default form-control ville_pro" required id="esc1dep_ville">
            	
            </select>
        </div>
                
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">AD</span>
            <input type="text" class="browser-default form-control right" required id="esc1dep_ad" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">CH</span>
            <input type="text" class="browser-default form-controlright" required id="esc1dep_ch" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">INF</span>
            <input type="text" class="browser-default form-control right" required id="esc1dep_inf" />
        </div>
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">TRA</span>
            <input type="text" class="browser-default form-control right" required id="esc1dep_tra" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">PEC</span>
            <input type="text" class="browser-default form-control right" required id="esc1dep_pec" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">LOC</span>
            <input type="text" class="browser-default form-control right" required id="esc1dep_loc" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">TRAT</span>
            <input type="text" class="browser-default form-control right" required id="esc1dep_trat" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">PTT</span>
            <input type="text" class="browser-default form-control right" required id="esc1dep_ptt" />
        </div>
    </div>
    
    <div class="row w3-border w3-round p-05 m-05 couleur-grise-faible">
        <div class="row bold p-1 pl-2" align="left">EXONERATION </div>
        <div class="col s12 m2 input-group">
            <span class="input-group-addon">ATT</span>
            <select class="browser-default form-control" id="ex_att_nat_dep">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon">STT</span>
            <select class="browser-default form-control" id="ex_stt_nat_dep">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon">STG</span>
            <select class="browser-default form-control" id="ex_stg_nat_dep">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">BAL</span>
            <select class="browser-default form-control" id="ex_bal_nat_dep">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">PAX</span>
            <select class="browser-default form-control" id="ex_pax_nat_dep">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">FRET</span>
            <select class="browser-default form-control" id="ex_fret_nat_dep">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">ROUTE</span>
            <select class="browser-default form-control" id="ex_route_nat_dep">
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