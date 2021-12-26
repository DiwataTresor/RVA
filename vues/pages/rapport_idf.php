<script type="application/javascript" defer>
	$(document).ready(function(){
        rapport_idf_liste_client();
        $("#immatriculation").val("T");
	});
</script>
<div class="panel panel-default">
	
                	<div class="panel-heading center bold fs-2"><label class="fs-2 blue-text">RAPPORT IDF</label></div>
                    <div class="panel-body">
                           <!-- Tab panes -->
                         
                         <!--========== FIN TABS====================-->

                         <!-- Attention -->
                         <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                            	Production IDF</a></li>
                             <li role="presentation"><a href="#paiement" aria-controls="home" role="tab" data-toggle="tab">
                            	Paiement IDF</a></li>
                        </ul>
                        
                          <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active p-1" id="home">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active p-1" id="paiements1">
                                    <div class="w-50">
                                    <form onSubmit="rapport_idf_production(); return false">
                                            <div class="row">
                                            <div class="input-group pl-1">
                                                <div class="input-group-addon">Compagnie</div>
                                                <select name="" id="client0" class="form-control" required="required">
                                                </select>
                                            </div>
                                            </div>
                                        <div class="row">
                                                <div class="col s12 m5 input-group">
                                                    <label class="input-group-addon">Du</label>
                                                    <input type="date" class="browser-default form-control" required id="dt1Prod" />
                                                </div>
                                                <div class="col s12 m5 input-group">
                                                    <label class="input-group-addon">Au</label>
                                                    <input type="date" class="browser-default form-control" required id="dt2Prod" />
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
                                                <div class="panel-body" id="resultat0">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--======================= CONTENU DU TABS 2====================================-->

                                    <!--===============================================================================-->
                                </div>                              	
                            </div>
                            <!--======================= CONTENU DU TABS 2====================================-->
                            <div role="tabpanel" class="tab-pane p-1" id="paiement">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active p-1" id="paiements">
                                    <div class="w-50">
                                    <form onSubmit="rapport_idf(); return false">
                                            <div class="row">
                                            <div class="input-group pl-1">
                                                <div class="input-group-addon">Compagnie</div>
                                                <select name="" id="client" class="form-control" required="required">
                                                </select>
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
                            </div>
                            <!--===============================================================================-->
                         </div>
                         <!-- Attention -->
                    </div>
                 </div>
            </div>
</div>