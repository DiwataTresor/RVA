<?php
	$id_mouv=$_REQUEST['p'];
	$num_mouv=$_REQUEST['p2'];
	include('../../manager/bd/cnx.php');

	$mouvement=mouv($num_mouv,$bdd);
	//$quittance=format_nbre((dernier_enreg('facture_paye_imprime','Quittance',$bdd))+1);
	$s="select * from facture_paye_imprime order by Id_impr desc"; $e=mysqli_query($bdd,$s); $t=mysqli_fetch_array($e);
	$quittance=format_nbre(intval($t['Quittance'])+1);
		
	
	$s="select * from escale,pt_emplacement where escale.Prov_dest=Pt_emplacement.Id_pt and Sens='A' and Id_mouv='$num_mouv'"; 
	$e=mysqli_query($bdd,$s); $t=mysqli_fetch_array($e);
	
	$sd="select * from escale,pt_emplacement where escale.Pt_ent=Pt_emplacement.Id_pt and Sens='D' and Id_mouv='$num_mouv'"; 
	$ed=mysqli_query($bdd,$sd); $td=mysqli_fetch_array($ed);
	
	$mouv=$mouvement['ta']['Num_mouv'];
	$s_num_fact="select * from num_facture where Mouv='$mouv'"; 
	$e_num_fact=mysqli_query($bdd,$s_num_fact); 
	$t_num_fact=mysqli_fetch_array($e_num_fact);
	$num_fact=$t_num_fact['Num_long'];
?>
<div class="panel panel-default w-50">
	<div class="panel-heading center">PAIEMENT FACTURE CASH</div>
    <div class="panel-body">
    	<div class="blue lighten-4 p-1 center bold white-text">
        	<?php echo $mouvement['nom_cli']; ?>
        </div>
        <p class="mt-1">
        <b>Date</b> : <?php echo Datemysqltofr($mouvement['ta']['Date_mouv']); ?>
        </p>
        <div>
        	<b>Mouvement</b> : <?php echo $t['Code_pt']." - ".$td['Code_pt']; ?>
        </div>
        <div>
        	<b>Montant à payer</b> : <?php echo ("USD : ".$mouvement['tot_avec_tva']); ?>
        </div>
        <hr />
       <?php
           $scheck="select * from paiement_facture where Mouv='$num_mouv'";
            $echeck=mysqli_query($bdd,$scheck); 
            $ncheck=mysqli_num_rows($echeck);
            if($ncheck!==0)
            {
                echo("<div class='alert alert-warning center bold'>Cette facture a déjà été payée</div>");
            }else
            {
				if($mouvement['ta']['Type_cl']=='A')
				{
					echo("<div class='alert alert-warning center bold'>Ce client paye à la banque</div>");
				}else
				{
       ?>
            <form onsubmit="paiement_fact('<?php echo $num_mouv; ?>'); return false ">
            	<div class="row w-50 pl-1">
                <input type="hidden" id="client" value="<?php echo ($mouvement['ta']['Id_cl']); ?>" />
                <input type="hidden" id="num_mouv" value="<?php echo ($mouvement['ta']['Id_cl']); ?>" />
                 <input type="hidden" id="num_long" value="<?php echo ($num_fact); ?>" />
                 
                 <input type="hidden" id="mt_usd" class="form-control browser-default" disabled="disabled" value="<?php echo ($mouvement['tot_avec_tva']); ?>" />
                 <input type="hidden" id="mt_cdf" class="form-control browser-default" disabled="disabled" value="<?php echo ($mouvement['tot_avec_tva_fc']); ?>" />
                	
                    <label>N° Quittance</label>
                    <input type="text" class="form-control browser-default right" id="quittance" value="<?php echo $quittance; ?>" readonly="readonly" required />
                </div>
            	<label>Montant payé</label>
                <div class="row">
                    <div class="col s12 m7">            	
                        <input type="text" disabled="disabled" class="browser-default form-control right" id="mt_paye" value="<?php echo ($mouvement['tot_avec_tva']); ?>" required />
                    </div>
                    <div class="col s12 m3">
                        <select class="browser-default form-control" id="monn_paye" onchange="select_monn_a_paye();">
                            <option value="USD">USD</option>
                            <option value="CDF">CDF</option>
                        </select>
                    </div>
                </div>
                <div class="center">
                    <button class="btn btn-success">Enregistrer paiement et Imprimer</button>
                </div>
            </form>
        <?php
				}
            }
        ?>
    </div>
</div>