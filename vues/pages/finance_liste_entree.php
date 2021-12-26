<div class="panel panel-primary">
	 <div class="panel-heading center bold fs-2">RAPPORT DES ENTREES</div>
     <div class="panel-body">
     	<div>
        	<ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#ent_date" aria-controls="home" role="tab" data-toggle="tab">Par Date</a>
                </li>
                <li role="presentation">
                    <a href="#ent_per" aria-controls="profile" role="tab" data-toggle="tab">Par periode</a>
                </li>                    
            </ul>
        </div>
        <div class="tab-content pt-1" align="left">
			<div role="tabpanel" class="tab-pane active" id="ent_date">
                <div align="left"><label>Entrer Date</label></div>
            	<div class="row">
                	<form onSubmit="rapp_ent_d(); return false"><div class="col s12 m2">
                		<input type="date" class="browser-default form-control" id="dt_v">
                    </div>
                    <div class="col s12 m3">
                    	<button class="btn btn-success"><i class="fa fa-search"></i> Visualiser</button>
                    </div>
                    </form>
               </div>
                <div id="resultat_dt">
        	
        		</div>
        	</div>
            <div role="tabpanel" class="tab-pane" id="ent_per">
            	<div align="left"></div>
            	<div class="row">
                	<form onSubmit="rapp_ent_p_d(); return false">
                        <div class="col s12 m2 input-group">
                            <label class="input-group-addon">Entrer Date</label>
                            <input type="date" class="browser-default form-control" id="dt_v1">
                        </div>
                        <div class="col s12 m2 input-group">
                            <label class="input-group-addon">Entrer Date</label>
                            <input type="date" class="browser-default form-control" id="dt_v2">
                        </div>
                        <div class="col s12 m3">
                            <button class="btn btn-success"><i class="fa fa-search"></i> Visualiser</button>
                        </div>
                    </form>
               </div>
                <div id="resultat_p">
        			
        		</div>
        	</div>
        </div>
     </div>
</div>