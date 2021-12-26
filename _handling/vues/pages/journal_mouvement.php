<?php
	include('../../manager/bd/cnx.php');
	$s="select * from journal,user where journal.Id_us=user.Id_us and Type_op='mouvement' group by Detail_op order by Date_jrn desc";
	$e=mysqli_query($bdd,$s);
	$t=mysqli_fetch_array($e); $n=mysqli_num_rows($e);
		echo ("
			<div class='panel panel-primary'>
				<div class='panel-heading center bold fs-15'>JOURNAL DES MOUVEMENTS</div>
				<div class='panel-body'>
					
				");
						if($n==0)
						{
							echo ("<div class='alert alert-warning center bold fs-2'>Aucun element dans le journal</div>");
						}else
						{ 
							echo ("<table class='w3-table w3-table-all'>
									<tr class='bold blue-grey white-text'>
										<td class='w-10'>N°</td>
										<td class='w-15'>DATE</td>
										<td class='w-15'>HEURE</td>
										<td class='w-15'>CLIENT</td>
										<td class='w-15'>MONTANT</td>
										<td>UTILISATEUR</td>
									</tr>");
									$a=$n;
									do
									{
										$mouv=mouv($t['Detail_op'],$bdd);
										echo ("<tr>
											<td>".$a."</td>
											<td>".Datemysqltofr($t['Date_jrn'])."</td>
											<td>".$t['Heure_jrn']."</td>
											<td>".$mouv['ta']['Nom_cli']." (".$mouv['ta']['Code_imm']." )"."</td>
											<td>".$mouv['tot_avec_tva']." USD</td>
											<td>".$t['Nom_complet']."</td>
										</tr>");
										$a--;
									}while($t=mysqli_fetch_array($e));
								echo ("</table>");	
						}
?>