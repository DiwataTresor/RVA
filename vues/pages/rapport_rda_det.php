
<script type="application/javascript">
	$(document).ready(function(){
		rapp_red_cl();
	});
</script>
<div class="panel panel-default">
	<div class="panel-heading center bold indigo-text">RAPPORT RDA /REDEVANCES DETAILLE</div>
    <div class="panel-body">
    	<div class="row">
        	<div class="col s12 m12">
            	<div class="panel panel-default">
                	<div class="panel-heading"><label></label></div>
                    <div class="panel-body">
                    	<ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                            	Recettes ventill&eacute;es</a></li>
                             <li role="presentation"><a href="#ventillation" aria-controls="home" role="tab" data-toggle="tab">
                            	Ventillation production</a></li>
                            <li role="presentation">
                            	<a href="#periodique" aria-controls="profile" role="tab" data-toggle="tab">Recettes extra-aer</a></li>
                             <!--<li role="presentation">
                            	<a href="#client" aria-controls="profile" role="tab" data-toggle="tab">Par client</a></li>-->
                        </ul>
                        
                          <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active p-1" id="home">
                              <div class="w-50">
                               <form onSubmit="rapp_red_det(); return false">
                               		<div class="row">
                                    	<div class="col s12 input-group">
                                        	<label class="input-group-addon">Exploitant</label>
                                            <select class="browser-default form-control" required id="rapp1_cl">
                                            </select>
                                        </div>
                                    </div>
                               		<div class="row">
                                    	<div class="col s12 m6 input-group">
                                        	<label class="input-group-addon">Du</label>
                                            <input type="date" class="browser-default form-control" required id="rapp1_dt" />
                                        </div>
                                        <div class="col s12 m6 input-group">
                                        	<label class="input-group-addon">Au</label>
                                            <input type="date" class="browser-default form-control" required id="rapp1_dt2" />
                                        </div>
                                    </div>
                                    <div class="center pt-1">
                                    	<button class="btn btn-success">Visualiser</button>
                                    </div>
                                </form>
                              </div>
                              	<div class="row pt-1">
                                    <div class="panel panel-default">
                                        <div class="panel-heading center">RESULTAT</div>
                                        <div class="panel-body" id="resultat">
                                            
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
                                                <option value="handling">HANDLING</option>
												 <option value="autre">AUTRES</option>
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
                            <div role="tabpanel" class="tab-pane p-1" id="ventillation">
                             <div class="w-50">
                               <form onSubmit="rapp_vent_det(); return false">
                               		<div class="row">
                                    	<div class="col s12 input-group">
                                        	<label class="input-group-addon">Exploitant</label>
                                            <select class="browser-default form-control" required id="ventil_expl">
                                            </select>
                                        </div>
                                    </div>
                               		<div class="row">
                                    	<div class="col s12 m6 input-group">
                                        	<label class="input-group-addon">Du</label>
                                            <input type="date" class="browser-default form-control" required id="ventil_dt" />
                                        </div>
                                        <div class="col s12 m6 input-group">
                                        	<label class="input-group-addon">Au</label>
                                            <input type="date" class="browser-default form-control" required id="ventil_dt2" />
                                        </div>
                                    </div>
                                    <div class="center pt-1">
                                    	<button class="btn btn-success">Visualiser</button>
                                    </div>
                                </form>
                              </div>
                              	<div class="row pt-1">
                                    <div class="panel panel-default">
                                        <div class="panel-heading center">RESULTAT</div>
                                        <div class="panel-body" id="resultat_vent">
                                            
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