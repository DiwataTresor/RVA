<?php
	$id_mouv=$_REQUEST['p'];
	$num_mouv=$_REQUEST['p2'];
	include('../../manager/bd/cnx.php');
	class m extends main{}
	$m=new m();
	$mouvement=$m->mouv($num_mouv);
	$quittance=$m->format_nbre(($m->dernier_enreg('facture_paye_imprime','Quittance'))+1);
	$s="select * from rva_facturation2.facture_paye_imprime order by Id_impr desc"; 
	$e=$m->cnx->query($s); 
	$t=$e->fetchAll();
	$n=count($t);
	if($n==0)
	{ 
		$quittance=1; 
	}else
	{ 
		$quittance=$m->format_nbre(intval($t[0]['Quittance'])+1); 
	}
	
		
	
	$s="select * from rva_facturation2.escale,rva_facturation2.pt_emplacement where escale.Prov_dest=Pt_emplacement.Id_pt and Sens='A' and Id_mouv='$num_mouv'"; 
	$e=$m->cnx->query($s); 
	$t=($e->fetchAll());
	
	$sd="select * from rva_facturation2.escale,rva_facturation2.pt_emplacement where escale.Pt_ent=Pt_emplacement.Id_pt and Sens='D' and Id_mouv='$num_mouv'"; 
	$ed=$m->cnx->query($sd); $td=($ed->fetchAll());
	
	$mouv=$mouvement['ta'][0]['Num_mouv'];
	$s_num_fact="select * from rva_facturation2.num_facture where Mouv='$mouv'"; 
	$e_num_fact=$m->cnx->query($s_num_fact); 
	$t_num_fact=$e_num_fact->fetchAll();
	//$num_fact=$t_num_fact['Num_long'];
	$num_fact=0;
?>
<div class="panel panel-default w-50">
	<div class="panel-heading center">PAIEMENT FACTURE CASH</div>
    <div class="panel-body">
    	<div class="blue lighten-4 p-1 center bold white-text">
        	<?php echo $mouvement['nom_cli']; ?>
        </div>
        <p class="mt-1">
        <b>Date</b> : <?php echo $m->Datemysqltofr($mouvement['ta'][0]['Date_mouv']); ?>
        </p>
        <div>
        	<b>Mouvement</b> : <?php echo $t[0]['Code_pt']." - ".$td[0]['Code_pt']; ?>
        </div>
        <div>
        	<b>Montant à payer</b> : <?php echo ("USD : ".$mouvement['tot_avec_tva']); ?>
        </div>
        <hr />
       <?php
           $scheck="select * from rva_facturation2.paiement_facture where Mouv='$num_mouv'";
            $echeck=$m->cnx->query($scheck); 
            $tcheck=$echeck->fetchAll();
			$ncheck=count($tcheck);
            if($ncheck!==0)
            {
                echo("<div class='alert alert-warning center bold'>Cette facture a déjà été payée</div>");
            }else
            {
				if(trim($mouvement['ta'][0]['Type_cl'])=='A')
				{
					echo("<div class='alert alert-warning center bold'>Ce client paye à la banque</div>");
				}else
				{
       ?>
            <form onsubmit="paiement_fact('<?php echo $num_mouv; ?>'); return false ">
            	<div class="row w-50 pl-1">
                <input type="hidden" id="client" value="<?php echo ($mouvement['ta'][0]['Id_cl']); ?>" />
                <input type="hidden" id="num_mouv" value="<?php echo ($mouvement['ta'][0]['Id_cl']); ?>" />
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
                
                <div class="row">
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <div class="input-group">
                            <div class="input-group-addon">Mode paiement</div>
                            <div>
                                <select name="" id="modePaie" class="form-control" onchange="select_mode_paie();" required="required">
                                    <option value="C">Cash</option>
                                    <option value="B">Banque</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                        <div class="input-group" id="idDetailbord">
                            <div class="input-group-addon">N° bordereau/cheque</div>
                            <div>
                                <input type="text" name="" id="Detailbord" class="form-control browser-default" value="" title="">
                            </div>
                        </div>  
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
<script>
    select_mode_paie();
</script>