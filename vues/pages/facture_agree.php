<script type="application/javascript">
	$(document).ready(function(){
		facture_agree_client();
	});
</script>
<div class="panel panel-default">
	<div class="panel-heading center bold indigo-text">FACTURATION DES MOUVEMENTS DES AGREES</div>
    <div class="panel-body">
    	<div class="row">
        	<div class="col s12 m12">
            	<div class="panel panel-default">
                	<div class="panel-heading"><label>Type de ventillation</label></div>
                    <div class="panel-body">
                    	<ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                            	Par client</a></li>
                          </ul>
                           <!-- Tab panes -->
                          <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active p-1" id="home">
                              <div class="w-50">
                               <form onSubmit="facture_agree(); return false">
                               		<div class="row">
                                    	<div class="col s12">
                                        	<label>Client</label>
                                            <select class="browser-default form-control" id="client" required>
                                            	<option value="">Selectionner client</option>
                                                <option value="tout">Tous</option>
                                            </select>
                                        </div>
                                    </div>
                                   <div class="row">
                                     <div class="col s12 m6 input-group">
                                            <label class="input-group-addon">Du</label>
                                            <input type="date" class="browser-default form-control" required id="dt1" />
                                     </div>
                                        <div class="col s12 m6 input-group">
                                            <label class="input-group-addon">Au</label>
                                            <input type="date" class="browser-default form-control" required id="dt2" />
                                        </div>
                                   </div> 
                                    <div class="center pt-1"><button class="btn btn-success" type="submit">Visualiser</button></div>
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
    </div>
</div>