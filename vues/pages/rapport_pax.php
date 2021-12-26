<script type="application/javascript">
	$(document).ready(function(){
        rapport_pax_liste_cli();
        rap_pax_select_client();
        $("#immatriculation").prop("disabled",true);
	});
</script>
<div class="panel panel-default">
	
                	<div class="panel-heading center bold fs-2"><label class="fs-2 blue-text">RAPPORT PAX</label></div>
                    <div class="panel-body">
                           <!-- Tab panes -->
                          <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active p-1" id="home">
                              <div class="w-50">
                               <form onSubmit="rapport_pax(); return false">
                               	    
                                       <div class="row">
                                           <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                               <div class="input-group">
                                                   <span class="input-group-addon">Client</span>
                                                   <select name="" id="client" onchange="rap_pax_select_client();" class="form-control" required="required">
                                                    </select>
                                               </div>
                                           </div>
                                           
                                           <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <div class="input-group">
                                                   <span class="input-group-addon">Immatriculation</span>
                                                   <select name="" id="immatriculation" disabled class="form-control" required="required">
                                                    </select>
                                               </div>
                                           </div>
                                           
                                       </div>
                                       	
                                   <div class="row">
                                        <div class="col s12 m5 input-group">
                                            <label class="input-group-addon">Du</label>
                                            <input type="date" class="browser-default form-control" required id="dt1" />
                                        </div>
                                        <div class="col s12 m5 input-group">
                                            <label class="input-group-addon">Au</label>
                                            <input type="date" class="browser-default form-control" required id="dt2" />
                                        </div>
                                        <div class="col s12 m2 ">
                                            <div class="center pt-0"><button class="btn btn-success" type="submit">Visualiser</button></div>
                                        </div>
                                   </div> 
                                </form>
                              </div>
                              	<div class="row pt-1">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">RESULTAT</div>
                                        <div class="panel-body" id="resultat">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
              <!--======================= CONTENU DU TABS 2====================================-->

              <!--===============================================================================-->
                         </div>
                         <!--========== FIN TABS====================-->
                    </div>
                 </div>
            </div>
</div>