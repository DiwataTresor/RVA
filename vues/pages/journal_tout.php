<?php
	include('../../manager/bd/cnx.php');
	$s="select * from journal,user where journal.Id_us=user.Id_us order by Date_jrn desc";
	$e=mysqli_query($bdd,$s);
	$t=mysqli_fetch_array($e); $n=mysqli_num_rows($e);
		echo ("
			<div class='panel panel-primary'>
				<div class='panel-heading center bold fs-15'>JOURNAL DES IMPRESSIONS</div>
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
										<td class='w-15'>OPERATION</td>
										<td class=''>DETAIL OP</td>
										
									</tr>");
									$a=$n;
									do
									{
										if($t["Type_op"]=="mouvement")
										{
											$mouve=mouv($t['Detail_op'],$bdd);
											$detail=$mouve['ta']['Nom_cli']."--".$mouv['ta']['Code_imm'];
										}else if($t['Type_op']=="impression_facture")
										{
											$mouv=mouv($t['Detail_op'],$bdd);
											//num_fact($mouv,$bdd);
											$detail=num_fact($t['Detail_op'],$bdd)."***".$mouv['ta']['Nom_cli']."--".$mouv['ta']['Code_imm'];
										}else if($t["Type_op"]=="C")
										{
											$detail="Connexion au systeme";
										}else
										{
											$detail=$t['Detail_op'];
										}
										//$detail=explode("***",$t['Detail_op']);
										echo ("<tr>
											<td>".$a."</td>
											<td>".Datemysqltofr($t['Date_jrn'])."</td>
											<td>".$t['Heure_jrn']."</td>
											<td>".$t['Nom_complet']."</td>
											<td>".$t['Type_op']."</td>
											<td>".afficher_text($detail)."</td>
										</tr>");
										$a--;
									}while($t=mysqli_fetch_array($e));
								echo ("</table>");	
						}
?>