<div class="panel panel-primary">
	<div class="panel-heading center">SUPPRESSION D'UNE FACTURE</div>
    <div class="panel-body">
    	<form onsubmit="supprimer_mouv(); return false">
    	<p>
        	<label>ENTREZ LE N° DU FORMULAIRE</label>
            <div class="w-25">
            	<input type="text" class="browser-default form-control" id="formulaire" required />
            </div>
        </p>
        <p>
        	<label>ENTREZ L'IMMATRICULATION DE L'AVION</label>
            <div class="w-25">
            	<input type="text" class="browser-default form-control" id="imm" required />
            </div>
        </p>
        <p>
        	<label>MOTIF DE SUPPRESSION</label>
           <div class="w-25">
            	<input type="text" class="browser-default form-control" id="motif" required />
            </div> 
        </p>
        <p><button type="submit" class="btn btn-success"><i class="fa fa-trash"></i> Suppression</button></p>
        </form>
        <hr />
        <div class="resultat">
        	
        </div>
    </div>
</div>