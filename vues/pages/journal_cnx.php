<?php
	include('../../manager/bd/cnx.php');
	class m extends main{}
	$m=new m();
	$s="select TOP 100 journal.Date_jrn,journal.Heure_jrn,journal.Id_us from rva_facturation2.journal,rva_facturation2.utilisateur where journal.Id_us=utilisateur.Id_us and Type_op='C' order by Date_jrn desc";
	$e=$m->cnx->query($s);
	$row=($e->fetchAll()); $n=count($row);
		echo ("
			<div class='panel panel-primary'>
				<div class='panel-heading center bold fs-15'>JOURNAL DES CONNEXIONS</div>
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
										<td>UTILISATEUR</td>
									</tr>");
									$a=$n;
									foreach ($row as $t)
									{
									$user=$m->user($t["Id_us"]);
										echo ("<tr>
											<td>".$a."</td>
											<td>".$m->Datemysqltofr($t['Date_jrn'])."</td>
											<td>".$m->Heureformat($t['Heure_jrn'])."</td>
											<td>".$user['nom']."</td>
										</tr>");
										$a--;
									}
								echo ("</table>");	
						}
?>