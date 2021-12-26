<?php
	include('../../manager/bd/cnx.php');
	class m extends main{}
	$m=new m();
	$s="select TOP 100 journal.Id_us,utilisateur.Id_us,Type_op,Date_jrn
		from 
			rva_facturation2.journal,rva_facturation2.utilisateur 
		where 
			journal.Id_us=utilisateur.Id_us 
		and 
			Type_op='impression_facture' 
		order by 
			Date_jrn desc";
	$e=($m->cnx->query($s));
	$row=$e->fetchAll(); $n=count($row);
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
										<td class='w-15'>FACTURE</td>
										<td class='w-15'>CLIENT</td>
										<td>MONTANT FACT.</td>
									</tr>");
									$a=$n;
									foreach($row as $t)
									{
										$mouv=$m->mouv($t['Detail_op']);
										$facture=$m->num_fact($t['Detail_op']);
										echo ("<tr>
											<td>".$a."</td>
											<td>".$m->Datemysqltofr($t['Date_jrn'])."</td>
											<td>".$t['Heure_jrn']."</td>
											<td>".$t['Nom_complet']."</td>
											<td>".$facture."</td>
											<td>".$mouv['ta']['Nom_cli']." (".$mouv['ta']['Code_imm']." )"."</td>
											<td>".$mouv['tot_avec_tva']." USD</td>
										</tr>");
										$a--;
									}
								echo ("</table>");	
						}
?>