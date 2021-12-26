<style>
	label{margin-top:10px}
</style>
<script type="text/javascript">
   tarif_redevance();
</script>
<form onsubmit="ajout('tarif_red');">
<div class="panel panel-default">
	<div class="panel-heading blue-text bold">GESTION DES TARIFS DES REDEVANCES</div>
    <div class="panel-body">
    	<div class="grey lighten-4">
            	<div class="row pl-2 pr-2 pt-2">
                	<div class="col s12 m2 p-1">
                    	<div class="input-group">
                          <span class="input-group-addon blue-text fs-12" id="basic-addontva">TVA</span>
                          <input type="text" required class="browser-default form-control right" aria-describedby="basic-addontva" id="tva">
                        </div>
                    </div>
                    <div class="col s12 m2 p-1">
                    	<div class="input-group">
                          <span class="input-group-addon blue-text fs-12" id="basic-addon1">Cpt Enreg</span>
                          <input type="text" required class="browser-default form-control right" aria-describedby="basic-addon1" id="cpt_enr">
                        </div>
                    </div>
                    <div class="col s12 m2 p-1">
                    	<div class="input-group">
                          <span class="input-group-addon blue-text fs-12" id="basic-addonredbal">Red Bal </span>
                          <input type="text" required class="browser-default form-control right" aria-describedby="basic-addonredbal" id="redbal">
                        </div>
                    </div>
                    <div class="col s12 m2 p-1">
                    	<div class="input-group">
                          <span class="input-group-addon blue-text fs-12" id="basic-addonredbal">Red sec </span>
                          <input type="text" required class="browser-default form-control right" aria-describedby="basic-addonredbal" id="redsec">
                        </div>
                    </div>
                    <div class="col s12 m2 p-1">
                    	<div class="input-group">
                          <span class="input-group-addon blue-text fs-12" id="basic-addonredbal">Ass Ant-inc </span>
                          <input type="text" required class="browser-default form-control right" aria-describedby="basic-addonredbal" id="assantinc">
                        </div>
                    </div>
                </div>
                <div class="row pl-2 pr-2 pb-2">
                	<div class="p-1 red-text bold">REDEVANCE SURETE</div>
                    <div class="col s12 m2 p-1">
                    	<div class="input-group">
                          <span class="input-group-addon blue-text fs-12" id="basic-addon1">Vol intern</span>
                          <input type="text" required class="browser-default form-control right" aria-describedby="basic-addon1" id="redsur">
                        </div>
                    </div>
                    <div class="col s12 m2 p-1">
                    	<div class="input-group">
                          <span class="input-group-addon blue-text fs-12" id="basic-addonform">Form.</span>
                          <input type="text" required class="browser-default form-control right" aria-describedby="basic-addonform" id="redsur_form">
                        </div>
                    </div>
                    <div class="col s12 m2 p-1">
                    	<div class="input-group">
                          <span class="input-group-addon blue-text fs-12" id="basic-addonform">Aero Non g&eacute;r&eacute;</span>
                          <input type="text" required class="browser-default form-control right" aria-describedby="basic-addonform" id="redsur_aero">
                        </div>
                    </div>
                    <div class="col s12 m2 p-1">
                    	<div class="input-group">
                          <span class="input-group-addon blue-text fs-12" id="basic-addonform">Intern.</span>
                          <input type="text" required class="browser-default form-control right" aria-describedby="basic-addonform" id="redsur_int">
                        </div>
                    </div>
                    <div class="col s12 m2 p-1">
                    	<div class="input-group">
                          <span class="input-group-addon blue-text fs-12" id="basic-addonform">Nat.</span>
                          <input type="text" required class="browser-default form-control right" aria-describedby="basic-addonform" id="resdsur_nat">
                        </div>
                    </div>
                </div>
                <div class="row pl-2 pr-2 pb-2">
                    <div class="row pl-1">
                    	<div class="col s12 m6 w3-right-border grey lighten-2">
                        	<div class="row bold red-text">REDEVANCE FRET</div>
                            <div class="row">
                            	<div class="col s12 m6 ">
                                	<div class="w3-row pl-05 pr-05">
                                        <div class="input-group">
                                          <span class="input-group-addon blue-text fs-12" id="basic-addonredbal">Res Intern </span>
                                          <input type="text" required class="browser-default form-control right" aria-describedby="basic-addonredbal" id="redfr_int">
                                        </div>
                                        <div class="row">
                                        	<div class="col s12 m6">
                                            	<label>IDF Emb</label>
                                            	<input type="text" required class="browser-default form-control" id="redfr_int_idf_emb" />
                                            </div>
                                            <div class="col s12 m6">
                                            	<label>IDF Debarq</label>
                                            	<input type="text" required class="browser-default form-control" id="redfr_int_idf_deb" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6">
                                	<div class="input-group">
                                      <span class="input-group-addon blue-text fs-12" id="basic-addonredbal">Nation</span>
                                      <input type="text" required class="browser-default form-control right" aria-describedby="basic-addonredbal" id="redfr_nat">
                                    </div>
                                    <div class="row">
                                    	<div class="row">
                                        	<div class="col s12 m6">
                                            	<label>IDF Emb</label>
                                            	<input type="text" required class="browser-default form-control" id="redfr_nat_idf_emb" />
                                            </div>
                                            <div class="col s12 m6">
                                            	<label>IDF Debarq</label>
                                            	<input type="text" required class="browser-default form-control" id="redfr_nat_idf_deb" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col s12 m6 grey lighten-3">
                        	<div class="row bold red-text" align="">REDEVANCE PASSAGER</div>
                        	<div class="row"> 
                        		<div class="col s12 m6 input-group">
                        			<span class="input-group-addon blue-text">PAS.COR.RI</span>
                        			<input type="text" required class="form-control browser-default right" name="" id="redpass_pascorri">
                        		</div>
                        		<div class="col s12 m6 input-group">
                        			<span class="input-group-addon blue-text">R.DOM</span>
                        			<input type="text" required class="form-control browser-default right" name="" id="redpass_rdom">
                        		</div>
                        	</div>
                        	<div class="row"> 
                        		<div class="col s12 m6 input-group">
                        			<span class="input-group-addon blue-text">RES.INT</span>
                        			<input type="text" required class="form-control browser-default right" name="" id="redpass_int">
                        		</div>
                        		<div class="col s12 m6 input-group">
                        			<span class="input-group-addon blue-text">IDF</span>
                        			<input type="text" required class="form-control browser-default right" name="" id="redpass_int_idf">
                        		</div>
                        	</div>
                        	<div class="row"> 
                        		<div class="col s12 m6 input-group">
                        			<span class="input-group-addon blue-text">RES.NAT</span>
                        			<input type="text" required class="form-control browser-default right" name="" id="redpass_nat">
                        		</div>
                        		<div class="col s12 m6 input-group">
                        			<span class="input-group-addon blue-text">IDF</span>
                        			<input type="text" required class="form-control browser-default right" name="" id="redpass_nat_idf">
                        		</div>
                        	</div>
                        </div>
                    </div>
                </div>
                <div class="row pl-2 pr-2 pb-1">
                    <div class="row pl-1">
                    	<div class="col s12 m6 w3-right-border grey lighten-2">
                        	<div class="row bold red-text">REDEVANCE ROUTE</div>
                            <div class="row">
                            	<div class="col s12 m4 input-group">
                        			<span class="input-group-addon blue-text">ESP. A(FL>245)</span>
                        			<input type="text" required class="form-control browser-default right" name="" id="redrou_sup_245">
                        		</div>
                        		<div class="col s12 m4 input-group">
                        			<span class="input-group-addon blue-text">ESP. A(FL<245)</span>
                        			<input type="text" required class="form-control browser-default right" name="" id="redrou_inf_245">
                        		</div>
                                <div class="col s12 m4 input-group">
                        			<span class="input-group-addon blue-text">VOL INTER</span>
                        			<input type="text" required class="form-control browser-default right" name="" id="redrou_vol_int">
                        		</div>
                            </div>
                        </div>
                        
                        <div class="col s12 m6 grey lighten-3">
                        	<div class="row bold red-text" align="left">REDEVANCE STATIONNEMENT</div>
                        	<div class="row"> 
                        		<div class="col s12 m6 input-group">
                        			<span class="input-group-addon blue-text">TARMAC</span>
                        			<input type="text" required class="form-control browser-default right" name="" id="redstat_tarmac">
                        		</div>
                        		<div class="col s12 m6 input-group">
                        			<span class="input-group-addon blue-text">GARAGE</span>
                        			<input type="text" required class="form-control browser-default right" name="" id="redstat_garage">
                        		</div>
                        	</div>
                        </div>
                    </div>
                </div>

                <div class="row pl-2 pr-2 pb-1">
                	<div class="center red-text bold row">REDEVANCE ATTERISSAGE</div>
                	<div class="col s12 m3 grey lighten-3">
                		<div class="row center">Poids : de 1T A 25T</div>
                		<div class="row">
                			<div class="col s12 m6 input-group">
                				<span class="input-group-addon blue-text">Intern.</span>
                				<input type="text" required class="browser-default form-control right" name="" id="redatt_1_25_int">
                			</div>
                			<div class="col s12 m6 input-group">
                				<span class="input-group-addon blue-text">Nation.</span>
                				<input type="text" required class="browser-default form-control right" id="redatt_1_25_nat">
                			</div>
                		</div>
                	</div>
                	<div class="col s12 m3 grey lighten-2">
                		<div class="row center">Poids : de 26T A 75T</div>
                		<div class="row">
                			<div class="col s12 m6 input-group">
                				<span class="input-group-addon blue-text">Intern.</span>
                				<input type="text" required class="browser-default form-control right" id="redatt_26_75_int">
                			</div>
                			<div class="col s12 m6 input-group">
                				<span class="input-group-addon blue-text">Nation.</span>
                				<input type="text" required class="browser-default form-control right" id="redatt_26_75_nat">
                			</div>
                		</div>
                	</div>
                	<div class="col s12 m3 grey lighten-3">
                		<div class="row center">Plus de 75T</div>
                		<div class="row">
                			<div class="col s12 m6 input-group">
                				<span class="input-group-addon blue-text">Intern.</span>
                				<input type="text" required class="browser-default form-control" id="redatt_sup_75_int">
                			</div>
                			<div class="col s12 m6 input-group">
                				<span class="input-group-addon blue-text">Nation.</span>
                				<input type="text" required class="browser-default form-control" id="redatt_sup_75_nat">
                			</div>
                		</div>
                	</div>
                	<div class="col s12 m3 grey lighten-2">
                		<div class="row center">Tonnage minimal</div>
                		<div class="row">
                			<div class="col s12 m6 input-group">
                				<span class="input-group-addon blue-text">Intern.</span>
                				<input type="text" required class="browser-default form-control" id="redatt_ton_min_int"">
                			</div>
                			<div class="col s12 m6 input-group">
                				<span class="input-group-addon blue-text">Nation.</span>
                				<input type="text" required class="browser-default form-control" id="redatt_ton_min_nat">
                			</div>
                		</div>
                	</div>
                </div>
        </div>
    </div>
    <div class="panel-footer">
            <button class="btn green waves waves-effect" type="submit">Mettre à jour</button>
    </div>
</div>
</form>