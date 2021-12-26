
<script type="application/javascript">
	$(document).ready(function(){
		bordereau_cl();
	});
</script>
<div class="panel panel-default">
	<div class="panel-heading center bold indigo-text">IMPRESSION BORDEREAU</div>
    <div class="panel-body">
    	<div class="row">
        	<div class="col s12 m12">
            	<div class="panel panel-default">
                	<div class="panel-heading"><label>Date  des versements</label></div>
                    <div class="panel-body">
                    	<ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                            	Journali&egrave;re</a></li>
                            <li role="presentation">
                            	<a href="#periodique" aria-controls="profile" role="tab" data-toggle="tab">P&eacute;riodique</a></li>
                             <li role="presentation">
                            	<a href="#client" aria-controls="profile" role="tab" data-toggle="tab">Par client</a></li>
                             <li role="presentation">
                            	<a href="#client_red" aria-controls="profile" role="tab" data-toggle="tab">Par client et redevance</a></li>
                          </ul>
                        
                          <!-- Tab panes -->
                          <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active p-1" id="home">
                              <div class="w-25">
                               <form onSubmit="bordereau(); return false">
                                    <div class="input-group">
                                    	<label class="input-group-addon">Date</label>
                                    	<input type="date" class="browser-default form-control" required id="dt" />
                                    </div>
                                    <div class="center pt-1"><button class="btn btn-success">Visualiser</button></div>
                                </form>
                              </div>
                              	<div class="row pt-1">
                                    <div class="panel panel-default">
                                        <div class="panel-heading center">BORDEREAU</div>
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
                                    	<div class="col s12 input-group">
                                        	<label class="input-group-addon">Paiments</label>
                                            <select class="browser-default form-control" required id="client_mode_paie">
                                                <option value="general">GENERAL</option>
                                                <option value="cash">CASH</option>
                                                <option value="banque">BANQUE</option>
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