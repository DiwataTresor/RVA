<?php
	include("../../manager/bd/cnx.php");
	$s="select * from facture_imprime where Statut='R' and Valide='O' order by Id_fact desc";
	$e=mysqli_query($bdd,$s);
	$t=mysqli_fetch_array($e);
	$n=mysqli_num_rows($e);
?>
<div class="panel panel-primary">
	<div class="panel-heading center bold"><h3>LISTE DES FACTURES DEJA IMPRIMEES</h3></div>
    <div class="panel-body">
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
		do
		{ 
			$mouv=mouv($t['Mouv'],$bdd);
			$user=user($t['Id_us'],$bdd);
			?>
			<tr class="w3-hover-grey">
            	<td><?php echo $n;?></td>
            	<td><?php echo (Datemysqltofr($t['Date_impr'])); ?></td>
                <td><?php echo ($t['Heure_impr']); ?></td>
                <td><?php echo ($mouv['ta']['Num_form']); ?></td>
                <td><?php echo ($mouv['ta']['Code_imm']); ?></td>
                <td><?php echo ($mouv['ta']['Nom_cli']); ?></td>
                <td><?php echo ($t['Num_facture']); ?></td>
                <td><?php echo ($mouv['tot_avec_tva']." USD"); ?></td>
                <td><?php echo ($user['nom']); ?></td>
                 <td>
                 	<a href="#" onClick="reimprimer_fact_cash_conf(<?php echo $t['Mouv']; ?>);"><i class="fa fa-print"></i> Imprime</a>&nbsp;
                    <!--<a href="#"><i class="fa fa-print"></i> Imprime</a>&nbsp;-->
                  </td>
            </tr>
		<?php
			$n--;
        }while($t=mysqli_fetch_array($e));
	?>
    	</table>
    </div>
</div>