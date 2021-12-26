<?php
	include('../../manager/bd/cnx.php');
	class m extends main{}
	$m=new m();
?>
<script type="application/javascript">
	$(document).ready(function(){

	});
</script>
<div class="panel panel-default">
	<div class="panel-heading center bold indigo-text">TABLEAU DE BORD</div>
    <div class="panel-body">
    	<div class="row">
        	<div class="col s12 m12">
            	<div class="panel panel-default">
                	<div class="panel-heading"><label>Parametres</label></div>
                    <div class="panel-body">
                    	<ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                            	Journalier</a></li>
                            <li role="presentation">
                            	<a href="#periodique" aria-controls="profile" role="tab" data-toggle="tab">Graphique</a></li>
                          </ul>
                        
                          <!-- Tab panes -->
                          <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active p-1" id="home">
                              <div class="w-50">
                               <form onSubmit="return false">
                                    <div>
										<div class="input-group w-50 left">
											<label class="input-group-addon">DU</label>
											<input type="date" class="browser-default form-control" required id="dt" />
										</div>
										<div class="input-group w-50 left pl-2">
											<label class="input-group-addon">AU</label>
											<input type="date" class="browser-default form-control" required id="dt2" />
										</div>
									</div>
                                    <div class="center pt-1 mt-3 clearfx">
										<p>&nbsp;</p>
										<button class="btn btn-success" onclick="tableau_bord($('#dt').val(),$('#dt2').val());">Visualiser</button>
									</div>
                                </form>
                              </div>
                              	<div class="row pt-1">
                                    <div class="panel panel-default">
                                        <div class="panel-heading center">RESULTAT</div>
                                        <div class="panel-body" id="resultat">
                                         	<?php 
												$datejour=date("Y-m-d", strtotime("-1 day"));
												//$datejour=date("Y-m-d");
												echo '<div class="blue w3-round p-1 mb-1 white-text bold"><i class="fa fa-calendar"></i> '.$m->jrSemaine($datejour)." ".$m->Datemysqltofr($datejour).'</div>'; 
												$tableau_de_bord=$m->tableau_de_bord($datejour,$datejour);
											?>
												<div class="row">
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading center">RDA</div>
															<div class="panel-body">
																<div><kbd>USD </kbd></div>
																	<div>MHT : <?php echo ($tableau_de_bord["rda_mht"]); ?></div>
																	<div>TVA : <?php echo ($tableau_de_bord["rda_tva"]); ?></div>
																	<div>TTC : <?php echo ($tableau_de_bord["rda_ttc"]); ?></div>
																<hr  />
																<div><kbd class="orange">CDF</kbd></div>
																	<div>MHT : <?php echo ($tableau_de_bord["rda_mht_fc"]); ?></div>
																	<div>TVA : <?php echo ($tableau_de_bord["rda_tva_fc"]); ?></div>
																	<div>TTC : <?php echo ($tableau_de_bord["rda_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
													
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading center">IDF</div>
															<div class="panel-body">
																<div><kbd>USD </kbd></div>
																	<div>MHT : <?php echo ($tableau_de_bord["idf_mht"]); ?></div>
																	<div>TVA : <?php echo ($tableau_de_bord["idf_tva"]); ?></div>
																	<div>TTC : <?php echo ($tableau_de_bord["idf_ttc"]); ?></div>
																<hr  />
																<div><kbd class="orange">CDF</kbd></div>
																	<div>MHT : <?php echo ($tableau_de_bord["idf_mht_fc"]); ?></div>
																	<div>TVA : <?php echo ($tableau_de_bord["idf_tva_fc"]); ?></div>
																	<div>TTC : <?php echo ($tableau_de_bord["idf_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading center">ACCES</div>
															<div class="panel-body">
																<div><kbd>USD </kbd></div>
																	<div>MHT : <?php echo ($tableau_de_bord["acces_mht"]); ?></div>
																	<div>TVA : <?php echo ($tableau_de_bord["acces_tva"]); ?></div>
																	<div>TTC : <?php echo ($tableau_de_bord["acces_ttc"]); ?></div>
																<hr  />
																<div><kbd class="orange">CDF</kbd></div>
																	<div>MHT : <?php echo ($tableau_de_bord["acces_mht_fc"]); ?></div>
																	<div>TVA : <?php echo ($tableau_de_bord["acces_tva_fc"]); ?></div>
																	<div>TTC : <?php echo ($tableau_de_bord["acces_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading center">PARKING</div>
															<div class="panel-body">
																<div><kbd>USD </kbd></div>
																	<div>MHT : <?php echo ($tableau_de_bord["parking_mht"]); ?></div>
																	<div>TVA : <?php echo ($tableau_de_bord["parking_tva"]); ?></div>
																	<div>TTC : <?php echo ($tableau_de_bord["parking_ttc"]); ?></div>
																<hr  />
																<div><kbd class="orange">CDF</kbd></div>
																	<div>MHT : <?php echo ($tableau_de_bord["parking_mht_fc"]); ?></div>
																	<div>TVA : <?php echo ($tableau_de_bord["parking_tva_fc"]); ?></div>
																	<div>TTC : <?php echo ($tableau_de_bord["parking_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading center">HANDLING</div>
															<div class="panel-body">
																<div><kbd>USD </kbd></div>
																	<div>MHT : <?php echo ($tableau_de_bord["hand_mht"]); ?></div>
																	<div>TVA : <?php echo ($tableau_de_bord["hand_tva"]); ?></div>
																	<div>TTC : <?php echo ($tableau_de_bord["hand_ttc"]); ?></div>
																<hr  />
																<div><kbd class="orange">CDF</kbd></div>
																	<div>MHT : <?php echo ($tableau_de_bord["hand_mht_fc"]); ?></div>
																	<div>TVA : <?php echo ($tableau_de_bord["hand_tva_fc"]); ?></div>
																	<div>TTC : <?php echo ($tableau_de_bord["hand_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
                                                    <div class="col-md-2">
														<div class="panel panel-danger">
															<div class="panel-heading center">TOTAL</div>
															<div class="panel-body">
																<div><kbd class="green">USD </kbd></div>
																	<div>MHT : <?php echo ($tableau_de_bord["tot_mht"]); ?></div>
																	<div>TVA : <?php echo ($tableau_de_bord["tot_tva"]); ?></div>
																	<div>TTC : <?php echo ($tableau_de_bord["tot_ttc"]); ?></div>
																<hr  />
																<div><kbd class="red">CDF</kbd></div>
																	<div>MHT : <?php echo ($tableau_de_bord["tot_mht_fc"]); ?></div>
																	<div>TVA : <?php echo ($tableau_de_bord["tot_tva_fc"]); ?></div>
																	<div>TTC : <?php echo ($tableau_de_bord["tot_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
												</div>   
                                        </div>
                                    </div>
                                </div>
                            </div>
              <!--======================= CONTENU DU TABS 2====================================-->
                            <div role="tabpanel" class="tab-pane p-1" id="periodique">
                              <div class="w-50">
                               <form onSubmit="bordereau_par_per(); return false">
                               		<div class="row">
                                    	<div class="col s12 input-group">
                                        	<label class="input-group-addon">Type de redevance</label>
                                            <select class="browser-default form-control" required id="redevance_type">
                                                <option value="acces">ACCES</option>
                                                <option value="parking">PARKING</option>                                                
                                            </select>
                                        </div>
                                    </div>
                               		<div class="row">
                                    	<div class="col s12 m6 input-group">
                                        	<label class="input-group-addon">Du</label>
                                            <input type="date" class="browser-default form-control" required id="per_dt" />
                                        </div>
                                        <div class="col s12 m6 input-group">
                                        	<label class="input-group-addon">Au</label>
                                            <input type="date" class="browser-default form-control" required id="per_dt2" />
                                        </div>
                                    </div>
                                    <div class="center pt-1">
                                    	<button class="btn btn-success">Visualiser</button>
                                    </div>
                                </form>
                              </div>
                              	<div class="row pt-1">
                                    <div class="panel panel-default">
                                        <div class="panel-heading center">BORDEREAU / REDEVANCE</div>
                                        <div class="panel-body" id="resultat2">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
              <!--===============================================================================-->
              <!--======================= CONTENU DU TABS 2 ====================================-->
                            <div role="tabpanel" class="tab-pane p-1" id="client">
                              <div class="w-50">
                               <form onSubmit="bordereau_par_cl(); return false">
                               		<div class="row">
                                    	<div class="col s12 input-group">
                                        	<label class="input-group-addon">Type de redevance</label>
                                            <select class="browser-default form-control" required id="client_l">
                                            </select>
                                        </div>
                                    </div>
                               		<div class="row">
                                    	<div class="col s12 m6 input-group">
                                        	<label class="input-group-addon">Du</label>
                                            <input type="date" class="browser-default form-control" required id="bord_dt" />
                                        </div>
                                        <div class="col s12 m6 input-group">
                                        	<label class="input-group-addon">Au</label>
                                            <input type="date" class="browser-default form-control" required id="bord_dt2" />
                                        </div>
                                    </div>
                                    <div class="center pt-1">
                                    	<button class="btn btn-success">Visualiser</button>
                                    </div>
                                </form>
                              </div>
                              	<div class="row pt-1">
                                    <div class="panel panel-default">
                                        <div class="panel-heading center">BORDEREAU PAR CLIENT</div>
                                        <div class="panel-body" id="resultat3">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
              <!--===============================================================================-->
              <!--======================= CONTENU DU TABS 2 ====================================-->
                            <div role="tabpanel" class="tab-pane p-1" id="client_red">
                              <div class="w-50">
                               <form onSubmit="bordereau_par_cl_red(); return false">
                               		<div class="row">
                                    	<div class="col s12 input-group">
                                        	<label class="input-group-addon">Type de redevance</label>
                                            <select class="browser-default form-control" required id="client_red_liste">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                    	<div class="col s12 m6 input-group">
                                        	<label class="input-group-addon">Du</label>
                                            <select class="browser-default form-control" required id="redevance">
                                            	<option value="route">ROUTE</option>
                                                <option value="atter">ATTERISSAGE</option>
                                                <option value="balis">BALISAGE</option>
                                                <option value="fret">FRET</option>
                                                <option value="pass">PASSAGER</option>
                                                <option value="pec">PEC</option>
                                                <option value="stat">STATIONNEMENT</option>
                                                <option value="compt">COMPT</option>
                                                <option value="formul">FORMULAIRE </option>
                                                <option value="ass">ASS. ANTI INC</option>
                                                <option value="surete">SURETE</option>
                                                <option value="secur">SECURITE</option>
                                            </select>
                                        </div>
                                    </div>
                               		<div class="row">
                                    	<div class="col s12 m6 input-group">
                                        	<label class="input-group-addon">Du</label>
                                            <input type="date" class="browser-default form-control" required id="bord_red_dt" />
                                        </div>
                                        <div class="col s12 m6 input-group">
                                        	<label class="input-group-addon">Au</label>
                                            <input type="date" class="browser-default form-control" required id="bord_red_dt2" />
                                        </div>
                                    </div>
                                    <div class="center pt-1">
                                    	<button class="btn btn-success">Visualiser</button>
                                    </div>
                                </form>
                              </div>
                              	<div class="row pt-1">
                                    <div class="panel panel-default">
                                        <div class="panel-heading center">BORDEREAU PAR CLIENT & REDEVANCE</div>
                                        <div class="panel-body" id="resultat4">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
              <!--===============================================================================-->
                         </div>
                         <!--========== FIN TABS====================-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>