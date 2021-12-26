<?php
	include("../../manager/bd/cnx.php");
	class m extends main{}
	$m=new main();
	$s="select TOP 150 * from rva_facturation2.facture_imprime where Statut='R' and Valide='O' order by Id_fact desc";
	
	$e=$m->cnx->query($s);
	$t=$e->fetchAll();
	$n=count($t);
?>
<div class="panel panel-primary">
	<div class="panel-heading center bold"><h3>LISTE DES FACTURES DEJA IMPRIMEES</h3></div>
    <div class="panel-body">
    	<form onsubmit="reimpression_fact_cash_dt(); return false">
    	<div class="row">
        	<div class="col-md-4">
            	<div class="input-group">
                	<label class="input-group-addon">Du</label>
                    <input type="date" class="form-control browser-default" required id="dt1" />
                </div>
            </div>
            <div class="col-md-4">
            	<div class="input-group">
                	<label class="input-group-addon">Au</label>
                    <input type="date" class="form-control browser-default" required id="dt2">
                </div>
            </div>
            <div class="col-md-4">
            	<button class="btn btn-success" type="submit">Visualiser</button>
            </div>
        </div>
        </form>
    	<table class="w3-table w3-table-all">
        	<tr class="blue-grey white-text bold center">
            	<td class="w-5">#</td>
                <td>DATE</td>
                <td>HEURE</td>
                <td>FORMULAIRE</td>
                <td>IMMATRICULATION</td>
                <td>CLIENT</td>
                <td>FACTURE</td>
                <td>MONTANT</td>
                <td>PAR</td>
                <td>OPTION</td>
            </tr>
    <?php
		foreach($t as $row)
		{ 
			@$mouv=$m->mouv($row['Mouv']);
			$user=$m->user($row['Id_us']);
			?>
			<tr class="w3-hover-grey ligne">
            	<td><?php echo $n;?></td>
            	<td><?php echo ($m->Datemysqltofr($row['Date_impr'])); ?></td>
                <td><?php echo ($m->Heureformat($row['Heure_impr'])); ?></td>
                <td><?php echo ($mouv['ta'][0]['Num_form']); ?></td>
                <td><?php echo ($mouv['ta'][0]['Code_imm']); ?></td>
                <td><?php echo ($mouv['ta'][0]['Nom_cli']); ?></td>
                <td><?php echo ($row['Num_facture']); ?></td>
                <td><?php echo ($mouv['tot_avec_tva']." USD"); ?></td>
                <td><?php echo ($user['nom']); ?></td>
                 <td>
                 	<a href="#" onClick="reimprimer_fact_cash_conf(<?php echo $row['Mouv']; ?>);"><i class="fa fa-print"></i> Imprime</a>&nbsp;
                    <!--<a href="#"><i class="fa fa-print"></i> Imprime</a>&nbsp;-->
                  </td>
            </tr>
		<?php
			$n--;
        }
	?>
    	</table>
    </div>
</div>