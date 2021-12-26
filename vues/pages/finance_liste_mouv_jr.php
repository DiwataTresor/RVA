<?php
	$dt=date("Y-m-d");
	
	include("../../manager/bd/cnx.php");
	$s="select * from caisse_mouv where Date_mouv='$dt'";
	$e=mysqli_query($bdd,$s);
	$n=mysqli_num_rows($e); $t=mysqli_fetch_array($e);
?>
<div class="panel panel-primary">
	<div class="panel-heading">MOUVEMENTS JOURNALIERS</div>
    <div class="panel-body">
    	<?php
			if($n==0)
			{
				echo ("<div class='alert alert-warning center bold fs-15'>Aucun mouvement saisie aujourd'hui</div>");
			}else
			{
				echo "<table class='w3-table w3-table-all'>
					<tr class='blue-grey white-text'>
						<td>Heure</td>
						<td>Mouvement</td>
						<td>Montant</td>
						<td>Motif</td>
						<td>Utilisateur</td>
						<td>Option</td>
					</tr>";
				do
				{ 
					$user=user($t['Id_us'],$bdd);
					$mouv=$t['Id_cais']
					?>
					<tr class=''>
						<td><?php echo $t['Heure_mouv']; ?></td>
						<td><?php echo $t['Type_mouv']; ?></td>
						<td><?php echo $t['Montant_mouv']." ".$t['Monnaie_mouv']; ?></td>
						<td><?php echo $t['Motif']; ?></td>
						<td><?php echo $user['nom']; ?></td>
                        <td><a href="#" onclick="del('caisse_mouv','Id_cais','<?php echo $mouv; ?>','ce mouvement','finance_liste_mouv_jr');"><i class="fa fa-trash"></i>Supprimer</a></td>
					</tr>
				<?php
                }while($t=mysqli_fetch_array($e));
			}
		?>
    </div>
</div>