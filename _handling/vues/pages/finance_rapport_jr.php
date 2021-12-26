<div class="panel panel-primary">
	 <div class="panel-heading center bold fs-2">RAPPORT JOURNALIER</div>
     <div class="panel-body">
     	<div>
        	<ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#ent_date" aria-controls="home" role="tab" data-toggle="tab">Par Date</a>
                </li>                  
            </ul>
        </div>
        <div class="tab-content pt-1" align="left">
			<div role="tabpanel" class="tab-pane active" id="ent_date">
                <div align="left"><label>Entrer Date</label></div>
            	<div class="row">
                	<form onSubmit="rapp_journ(); return false"><div class="col s12 m2">
                		<input type="date" class="browser-default form-control" id="dt">
                    </div>
                    <div class="col s12 m3">
                    	<button class="btn btn-success"><i class="fa fa-search"></i> Visualiser</button>
                    </div>
                    </form>
               </div>
                <div id="resultat_dt">
        	
        		</div>
        	</div>
        </div>
     </div>
</div>