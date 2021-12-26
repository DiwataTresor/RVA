<?php
	include('../../manager/bd/cnx.php');
	$s="select * from journal,user where journal.Id_us=user.Id_us and Type_op='suppression_facture' group by Detail_op order by Date_jrn desc";
	$e=mysqli_query($bdd,$s);
	$t=mysqli_fetch_array($e); $n=mysqli_num_rows($e);
		echo ("
			<div class='panel panel-primary'>
				<div class='panel-heading center bold fs-15'>JOURNAL DE SUPRESSIONS  DES MOUVEMENTS</div>
				<div class='panel-body'>
					
				");
						if($n==0)
						{
							echo ("<div class='alert alert-warning center bold fs-2'>Aucun element dans le journal</div>");
						}else
						{ 
							echo ("<table class='w3-table w3-table-all'>
									<tr class='bold blue-grey white-text'>
										<td class='w-5'>N°</td>
										<td class='w-10'>DATE</td>
										<td class='w-10'>HEURE</td>
										<td class='w-15'>PAR</td>
										<td class='w-15'>FORMULAIRE</td>
										<td class=''>CLIENT</td>
										<td class='w-15'>MONTANT</td>
										<td class=''>MOTIF DE SUPPRESSION</td>
										
									</tr>");
									$a=$n;
									do
									{
										
										$detail=explode("***",$t['Detail_op']);
										echo ("<tr>
											<td>".$a."</td>
											<td>".Datemysqltofr($t['Date_jrn'])."</td>
											<td>".$t['Heure_jrn']."</td>
											<td>".$t['Nom_complet']."</td>
											<td>".$detail[0]."</td>
											<td>".$detail[1]."</td>
											<td>".$detail[2]." USD</td>
											<td>".afficher_text($detail[3])."</td>
										</tr>");
										$a--;
									}while($t=mysqli_fetch_array($e));
								echo ("</table>");	
						}
?>