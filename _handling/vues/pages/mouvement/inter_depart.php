<script type="application/javascript">
	$(document).ready(function(){
		
	});
</script>
<form onsubmit="vol_int_dep(); return false">
<div class="w3-border-left" style="border-top:0px" id="national_arrive">
	<div class=" bold red-text p-05">Sens : International depart</div>
    <div class="row p-05 m-05">
    	<div class="col s12 m2 input-group">
        	<span class="input-group-addon">Temps</span>
        	<select class="browser-default form-control" id="int_dep_temps">
            	<option value="B">Bon</option>
                <option value="M">Mauvais</option>
            </select>
        </div>
        <div class="col s12 m4 input-group">
        	<span class="input-group-addon">Categorie vol</span>
        	<select class="browser-default form-control" required id="int_dep_categ">
            	<option value="">selectionner categorie</option>
                <option value="P">Priv&eacute;e</option>
                <option value="C">Commercial</option>
                <option value="M">Militaire</option>
                <option value="H">Humanitaire</option>
            </select>
        </div>
        <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Compt Enre</span>
            <input type="number" value="3" class="browser-default form-control" id="int_dep_compt_enr" />
        </div>
         <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Form</span>
            <input type="number" value="4" class='browser-default form-control' id="int_dep_form" />
        </div>
        <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Niv Vol</span>
        	<input type="text" class="browser-default form-control right" required id="int_dep_niv"/>
        </div>
        <div class="col s12 m3 input-group">
        	<span class="input-group-addon">Station</span>
        	<select class="browser-default form-control" required id="int_dep_stat">
            	<option value="N">Pas stat.</option>
                <option value="T">Tarmac</option>
                <option value="G">Garage</option>
            </select>
        </div>
        
         <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Date dep</span>
        	<input type="date" class="browser-default form-control right" required id="int_dep_dt"/>
        </div>
        <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Heure dep</span>
        	<input type="time" class="browser-default form-control right" required id="int_dep_heure"/>
        </div>
        <div class="col s12 m2 input-group">
        	<span class="input-group-addon">Ass. Anti-inc</span>
        	<select  class="browser-default form-control right" required id="int_dep_anti_inc">
            	<option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
    </div>
	<div class="row w3-border w3-round p-05 m-05">
        <div class="row bold pl-2" align="left">1e Escale</div>
        <div class="col s12 m2 input-group">
        <span class="input-group-addon">Ville</span>
        	<select class="browser-default form-control ville_pro" required id="inter_dep_ville">
            	
            </select>
        </div>
        <div class="col s12 m2 input-group">
        <span class="input-group-addon">Pt sort</span>
        	<select class="browser-default form-control" required id="inter_dep_pt">
            	
            </select>
        </div>
                
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">AD</span>
            <input type="text" class="browser-default form-control right" required id="inter_dep_ad" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">CH</span>
            <input type="text" class="browser-default form-controlright" required id="inter_dep_ch" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">INF</span>
            <input type="text" class="browser-default form-control right" required id="inter_dep_inf" />
        </div>
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">TRA</span>
            <input type="text" class="browser-default form-control right" required id="inter_dep_tra" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">PEC</span>
            <input type="text" class="browser-default form-control right" required id="inter_dep_pec" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">LOC</span>
            <input type="text" class="browser-default form-control right" required id="inter_dep_loc" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">TRAT</span>
            <input type="text" class="browser-default form-control right" required id="inter_dep_trat" />
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">PTT</span>
            <input type="text" class="browser-default form-control right" required id="inter_dep_ptt" />
        </div>
    </div>
    
    <div class="row w3-border w3-round p-05 m-05 couleur-grise-faible">
        <div class="row bold p-1 pl-2" align="left">EXONERATION </div>
        <div class="col s12 m2 input-group">
            <span class="input-group-addon">ATT</span>
            <select class="browser-default form-control" id="ex_att_int_dep">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon">STT</span>
            <select class="browser-default form-control" id="ex_stt_int_dep">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon">STG</span>
            <select class="browser-default form-control" id="ex_stg_int_dep">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">BAL</span>
            <select class="browser-default form-control" id="ex_bal_int_dep">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">PAX</span>
            <select class="browser-default form-control" id="ex_pax_int_dep">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">FRET</span>
            <select class="browser-default form-control" id="ex_fret_int_dep">
                <option value="N">Non</option>
                <option value="O">Oui</option>
            </select>
        </div>
        <div class="col s12 m2 input-group">
            <span class="input-group-addon w3-small">ROUTE</span>
            <select class="browser-default form-control" id="ex_route_int_dep">
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