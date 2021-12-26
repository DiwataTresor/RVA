<style>
.input-group{margin-bottom:10px; }
input[type='text'],select{font-size:12px}
</style>
<script type="application/javascript">
	mouv_imm();
	mouv_route();
</script>
<div class="panel panel-default">
	<div class="panel-heading">ENREGISTRER</div>
    <div class="panel-body">
    	<form onSubmit="ajout('mouvement')">
            <div class="row m-05 p-05">
              <div class="col s12 m2 input-group">
              	<span class="input-group-addon">Sens</span>
                <select class="browser-default form-control" id="sens">
                	<option value="A">Arriv&eacute;e</option>
                    <option value="D">Depart</option>
                </select>
              </div> 
              <div class="col s12 m2 input-group">
              	<span class="input-group-addon">Date</span>
                <input type="date" class="browser-default form-control" value="<?php echo date('Y-m-d'); ?>" required id="dt_mouv" />
              </div> 
              <div class="col s12 m2 input-group">
              	<span class="input-group-addon">Heure</span>
                <input type="time" class="browser-default form-control" value="<?php echo date('H:i:s'); ?>" required id="heure_mouv" />
              </div> 
              <div class="col s12 m2 input-group">
           	  <span class="input-group-addon">Client</span>
           	  <select name="imm" class="browser-default form-control" required id="imm">
              </select>
              </div> 
              <div class="col s12 m2 input-group">
           	  <span class="input-group-addon">Temps</span>
           	  <select name="temps" class="browser-default form-control" id="temps">
                <option value='B'>Bon</option>
                <option value='M'>Mauvais</option>
              </select>
              </div> 
              <div class="col s12 m2 input-group">
              	<span class="input-group-addon">Cat. Vol</span>
                <select class="browser-default form-control" id="categ">
                	<option value='P'>Priv&eacute;é</option>
                    <option value='C'>Commercial</option>
                    <option value='M'>Militaire</option>
                </select>
              </div>  
            </div>
            <div class="row w3-border w3-round p-05 m-05">
            	<div class="input-group col s12 m3">
                	<span class="input-group-addon">Nv Vol</span>
                    <input type="text" class="browser-default form-control" required id="nv_vol" />
                </div>
            </div>
            <div class="row w3-border w3-round p-05 m-05">
            	<div class="row bold p-1 pl-2" align="left">1er Escale <hr /></div>
            	<div class="col s12 m2 input-group">
                	<span class="input-group-addon">Aero</span>
                    <input type="text" class="browser-default form-control" id="esc1_aero" value="FZQA" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon">Escal</span>
                    <select class="browser-default form-control escale" id="esc1_esc">
                    	
                    </select>
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon">Pt ent</span>
                    <input type="text" class="browser-default form-control" id="esc1_pt_ent" />
                </div>
                
                <div class="col s12 m2 input-group">
               	<span class="input-group-addon w3-small">AD</span>
               	<input type="text" class="browser-default form-control" id="esc1_ad" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">CH</span>
                    <input type="text" class="browser-default form-control" id="esc1_ch" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">INF</span>
                    <input type="text" class="browser-default form-control" id="esc1_inf" />
                </div>
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">TRA</span>
                    <input type="text" class="browser-default form-control" id="esc1_tra" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">PEC</span>
                    <input type="text" class="browser-default form-control" id="esc1_pec" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">LOC</span>
                    <input type="text" class="browser-default form-control" id="esc1_loc" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">TRAT</span>
                    <input type="text" class="browser-default form-control" id="esc1_trat" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">PTT</span>
                    <input type="text" class="browser-default form-control" id="esc1_ptt" />
                </div>
            </div>
            
           <div class="row w3-border w3-round p-05 m-05">
            	<div class="row bold p-1 pl-2" align="left">2e Escale <hr /></div>
            	<div class="col s12 m2 input-group">
               	<span class="input-group-addon">Aero</span>
               	<input type="text" class="browser-default form-control" id="esc2_aero" value="FZAQ" />
            	</div>
                
  				<div class="col s12 m2 input-group">
                	<span class="input-group-addon">Escal</span>
                    <select class="browser-default form-control escale" id="esc2_esc"></select>
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon">Pt ent</span>
                    <input type="text" class="browser-default form-control" id="esc2_pt_ent" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">AD</span>
                    <input type="text" class="browser-default form-control" id="esc2_ad" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">CH</span>
                    <input type="text" class="browser-default form-control" id="esc2_ch" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">INF</span>
                    <input type="text" class="browser-default form-control" id="esc2_inf" />
                </div>
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">TRA</span>
                    <input type="text" class="browser-default form-control" id="esc2_tra" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">PEC</span>
                    <input type="text" class="browser-default form-control" id="esc2_pec" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">LOC</span>
                    <input type="text" class="browser-default form-control" id="esc2_loc" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">TRAT</span>
                    <input type="text" class="browser-default form-control" id="esc2_trat" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">PTT</span>
                    <input type="text" class="browser-default form-control" id="esc2_ptt" />
                </div>
            </div>
            
            <div class="row w3-border w3-round p-05 m-05">
                <div class="row bold p-1 pl-2" align="left">3e Escale <hr /></div>
                <div class="col s12 m2 input-group">
                <span class="input-group-addon">Aero</span>
                <input type="text" class="browser-default form-control" id="esc3_aero" value="FZAQ" />
                </div>
                
                <div class="col s12 m2 input-group">
                    <span class="input-group-addon">Escal</span>
                   
                </div>
                
                <div class="col s12 m2 input-group">
                    <span class="input-group-addon">Pt ent</span>
                    <input type="text" class="browser-default form-control" id="esc3_pt_ent" />
                </div>
                
                <div class="col s12 m2 input-group">
                    <span class="input-group-addon w3-small">AD</span>
                    <input type="text" class="browser-default form-control" id="esc3_ad" />
                </div>
                
                <div class="col s12 m2 input-group">
                    <span class="input-group-addon w3-small">CH</span>
                    <input type="text" class="browser-default form-control" id="esc3_ch" />
                </div>
                
                <div class="col s12 m2 input-group">
                    <span class="input-group-addon w3-small">INF</span>
                    <input type="text" class="browser-default form-control" id="esc3_inf" />
                </div>
                <div class="col s12 m2 input-group">
                    <span class="input-group-addon w3-small">TRA</span>
                    <input type="text" class="browser-default form-control" id="esc3_tra" />
                </div>
                
                <div class="col s12 m2 input-group">
                    <span class="input-group-addon w3-small">PEC</span>
                    <input type="text" class="browser-default form-control" id="esc3_pec" />
                </div>
                
                <div class="col s12 m2 input-group">
                    <span class="input-group-addon w3-small">LOC</span>
                    <input type="text" class="browser-default form-control" id="esc3_loc" />
                </div>
                
                <div class="col s12 m2 input-group">
                    <span class="input-group-addon w3-small">TRAT</span>
                    <input type="text" class="browser-default form-control" id="esc3_trat" />
                </div>
                
                <div class="col s12 m2 input-group">
                    <span class="input-group-addon w3-small">PTT</span>
                    <input type="text" class="browser-default form-control" id="esc3_ptt" />
                </div>
            </div>
            
            <div class="row w3-border w3-round p-05 m-05">
            	<div class="row bold p-1 pl-2" align="left">4e Escale <hr /></div>
            	<div class="col s12 m2 input-group">
               	<span class="input-group-addon">Aero</span>
               	<input type="text" class="browser-default form-control" id="esc4_aero" value="FZQA" />
            	</div>
                
          		<div class="col s12 m2 input-group">
                	<span class="input-group-addon">Escal</span>
                    <select class="browser-default form-control escale" id="esc4_esc">
                    </select>
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon">Pt ent</span>
                    <input type="text" class="browser-default form-control" id="esc4_pt_ent" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">AD</span>
                    <input type="text" class="browser-default form-control" id="esc4_ad" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">CH</span>
                    <input type="text" class="browser-default form-control" id="esc4_ch" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">INF</span>
                    <input type="text" class="browser-default form-control" id="esc4_inf" />
                </div>
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">TRA</span>
                    <input type="text" class="browser-default form-control" id="esc4_tra" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">PEC</span>
                    <input type="text" class="browser-default form-control" id="esc4_pec" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">LOC</span>
                    <input type="text" class="browser-default form-control" id="esc4_loc" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">TRAT</span>
                    <input type="text" class="browser-default form-control" id="esc4_trat" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">PTT</span>
                    <input type="text" class="browser-default form-control" id="esc4_ptt" />
                </div>
            </div>
            
            <div class="row w3-border w3-round p-05 m-05">
            	<div class="row bold p-1 pl-2" align="left">5e Escale <hr /></div>
            	<div class="col s12 m2 input-group">
               	<span class="input-group-addon">Aero</span>
               	<input type="text" class="browser-default form-control" id="esc5_aero" value="FZQA" />
            	</div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon">Escal</span>
                    <select class="browser-default form-control escale" id="esc5_esc"></select>
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon">Pt ent</span>
                    <input type="text" class="browser-default form-control" id="esc5_pt_ent" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">AD</span>
                    <input type="text" class="browser-default form-control" id="esc5_ad" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">CH</span>
                    <input type="text" class="browser-default form-control" id="esc5_ch" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">INF</span>
                    <input type="text" class="browser-default form-control" id="esc5_inf" />
                </div>
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">TRA</span>
                    <input type="text" class="browser-default form-control" id="esc5_tra" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">PEC</span>
                    <input type="text" class="browser-default form-control" id="esc5_pec" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">LOC</span>
                    <input type="text" class="browser-default form-control" id="esc5_loc" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">TRAT</span>
                    <input type="text" class="browser-default form-control" id="esc5_trat" />
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">PTT</span>
                    <input type="text" class="browser-default form-control" id="esc5_ptt" />
                </div>
            </div>
            
            <div class="row w3-border w3-round p-05 m-05 couleur-grise-faible">
            	<div class="row bold p-1 pl-2" align="left">EXONERATION <hr /></div>
            	<div class="col s12 m2 input-group">
                	<span class="input-group-addon">ATT</span>
                    <select class="browser-default form-control" id="ex_att">
                    	<option value="N">Non</option>
                        <option value="O">Oui</option>
                    </select>
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon">STT</span>
                    <select class="browser-default form-control" id="ex_stt">
                    	<option value="N">Non</option>
                        <option value="O">Oui</option>
                    </select>
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon">STG</span>
                    <select class="browser-default form-control" id="ex_stg">
                    	<option value="N">Non</option>
                        <option value="O">Oui</option>
                    </select>
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">BAL</span>
                    <select class="browser-default form-control" id="ex_bal">
                    	<option value="N">Non</option>
                        <option value="O">Oui</option>
                    </select>
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">PAX</span>
                    <select class="browser-default form-control" id="ex_pax">
                    	<option value="N">Non</option>
                        <option value="O">Oui</option>
                    </select>
                </div>
                
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">FRET</span>
                    <select class="browser-default form-control" id="ex_fret">
                    	<option value="N">Non</option>
                        <option value="O">Oui</option>
                    </select>
                </div>
                <div class="col s12 m2 input-group">
                	<span class="input-group-addon w3-small">ROUTE</span>
                    <select class="browser-default form-control" id="ex_route">
                    	<option value="N">Non</option>
                        <option value="O">Oui</option>
                    </select>
                </div>
            </div>
            
            <div class="center row m-05 p-05">
            	<button type="submit" class="btn blue">Enregistrer</button>
            </div>
        </form>
    </div>
</div>