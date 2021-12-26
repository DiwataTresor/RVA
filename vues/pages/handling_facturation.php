<script language="javascript" type="application/javascript">
	$(document).ready(function(){
		facturation_handling_handleur();
		facturation_handling_imm();
	});
</script>
<div class="panel panel-default">
	<div class="panel-heading">FACTURATION</div>
    <div class="panel-body">
    	<div>
        	<form onsubmit="ajout_fact_hand(); return false">
            	<div class="row">
                    <div class="input-group col s12 m6">
                        <label class="input-group-addon">Operateur Handling</label>
                        <select class="form-control browser-default" id="fact_handleur" required>
                        
                        </select>
                        <span id="loading" class="input-group-addon"><img src="images/gif/ajax-rond.gif" /></span>
                    </div>
                    <div class="input-group col s12 m6">
                        <label class="input-group-addon">Immatriculation&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <select class="form-control browser-default" id="fact_imm" required>
                        
                        </select>
                        <span id="loading2" class="input-group-addon"><img src="images/gif/ajax-rond.gif" /></span>
                    </div>
                </div>
                <div class="row pl-05 pt-05">
                	<div class="col s12 m6">
                    	<div class=" panel panel-default">
                            <div class="panel-heading">Arrivée</div>
                            <div class="panel-body">
                            	<div class="row">
                                	<div class="col s12 m6 input-group">
                                    	<span class="input-group-addon">Date arrivée</span>
                                    	<input type="date" class="form-control browser-default" id="fact_dt_arr" required />
                                    </div>
                                    <div class="col s12 m6 input-group">
                                    	<span class="input-group-addon">Heure arrivée</span>
                                    	<input type="time" class="form-control browser-default" id="fact_heure_arr" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6">
                    	<div class=" panel panel-default">
                            <div class="panel-heading">Depart</div>
                            <div class="panel-body">
                            	<div class="row">
                                	<div class="col s12 m6 input-group">
                                    	<span class="input-group-addon">Date depart</span>
                                    	<input type="date" class="form-control browser-default" id="fact_dt_dep" required />
                                    </div>
                                    <div class="col s12 m6 input-group">
                                    	<span class="input-group-addon">Heure depart</span>
                                    	<input type="time" class="form-control browser-default" id="fact_heure_dep" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                	<div class="panel-heading">Nature touchée</div>
                    <div class="panel-body w-25">
                    	<div class="row ml-1 w3-round p-05 pb-0">
                        	<div class="col s12 m10">Auto assistance</div>
                            <div class="col s12 m2" id="aa" onclick="selection_touche('aa');"><i class="fa fa-minus-square"></i></div>
                        </div>
                        <div class="row ml-1 w3-round p-05 pb-0">
                        	<div class="col s12 m10">Touché administrative</div>
                            <div class="col s12 m2" id="ta" onclick="selection_touche('ta');">
                            	<span><i class="fa fa-minus-square"></i></span>
                            </div>
                        </div>
                        <div class="row ml-1 w3-round p-05">
                        	<div class="col s12 m10">Full assistance</div>
                            <div class="col s12 m2" id="fa" onclick="selection_touche('fa');">
                            	<span><i class="fa fa-minus-square"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="center">
                	<button class="btn green white-text">Enregistrer</button>
                </p>
            </form>
        </div>
    </div>
</div>