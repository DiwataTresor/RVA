<script type="application/javascript">
	$(document).ready(function(){
		liste_facture();
	});
</script>
<div class="panel panel-primary">
	<div class="panel-heading center bold fs-2">LISTE DES FACTURES</div>
    <div class="panel-body">
    	<form onsubmit="liste_facture_dt(); return false">
        <div class="row">
        	<div class="col-md-2">
            	<div class="input-group">
                	<label class="input-group-addon">Du</label> 
                	<input type="date" class="form-control browser-default" value="<?php echo(Date('Y-m-d')); ?>" id="dt1" required />
                </div>
            </div>
            <div class="col-md-2">
            	<div class="input-group">
                	<label class="input-group-addon">Au</label> 
                	<input type="date" class="form-control browser-default" value="<?php echo(Date('Y-m-d')); ?>" id="dt2" required />
                </div>
            </div>
            <div class="col-md-4"><button type="submit" class="btn btn-success">Visualiser</button> </div>
        </div>
        </form>
    	<div id="resultat" class="center"><img src="images/gif/ajax-rond.gif"> chargement en cours...</div>
    	<?php
		
		?>
    </div>
</div>