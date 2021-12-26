<script type="application/javascript">
	acces_liste_acces();
</script>
<div class="panel panel-default">
	<div class="panel-heading center bold fs-12">RAPPORT DES ACCES</div>
    <div class="panel-body">
    	<div class="">        	
            <div class="w-50">
                <form onsubmit="rapport('acces'); return false">
                <p>
                    <label>Type accès</label>
                   <div class="input-group"> 
                        <span class="input-group-addon"><img src="images/gif/ajax-rond.gif" /></span>
                       <select class="browser-default form-control" required id="acces_liste">
                       </select>
                    </div>
                </p>
                <div class="row">
                    <div class="col s12 m6">
                        <label>Date</label>
                        <input type="date" class="browser-default form-control" required value="<?php echo date('Y-m-d'); ?>" id="dt1" />
                    </div>
                    <div class="col s12 m6">
                        <label>Date</label>
                        <input type="date" class="browser-default form-control" required value="<?php echo date('Y-m-d'); ?>" id="dt2" />
                    </div>
                </div>    
                
                <p class="center">
                    <button class="btn btn-success" id="btn_enreg" type="submit">visualiser</button>
                </p>
              </form>
            </div>
            
            <div class="col s12 m8">
            <div class="panel panel-default">
            	<div class="panel-heading center bold">RESULTAT</div>
                <div class="panel-body">
                    <div class="" id="resultat">
                    
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>