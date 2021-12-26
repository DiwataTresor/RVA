<?php
	$id_mouv=$_REQUEST['p'];
	$num_mouv=$_REQUEST['p2'];
	include('../../manager/bd/cnx.php');
	class m extends main
	{
	}
	$m=new m();
	@$mouvement=$m->mouv($num_mouv);
	//echo $num_mouv;
?>
<!--============================ 1ER TABLEAU=========================-->
	<div class="panel panel-default">
	<div class="panel-heading center bold fs-2">DETAIL FACTURE</div>	
    <div class="panel-body">
    	<p>
        	<div><span>Client : <?php echo $mouvement['nom_cli']; ?></span></div>
            <div><span>Immatr : <?php echo $mouvement['code_imm']; ?></span></div>
            <table class="row fs-12 p-1 w3-table-all w3-small" style="margin:0px">
            	<tr class="blue-text bold center">
            	  <td colspan="14" class="center fs-12 bold">
                  	I.MOUVEMENTS EFFECTUES PAR IMMAT : <?php echo $mouvement['code_imm'] ?> &nbsp;&nbsp;TYPE : <?php echo $mouvement['type_av']; ?> &nbsp;&nbsp; N&deg; FORM :<br />
                    Poids : <?php echo $mouvement['poids']."T"; ?>
                  </td>
           	  </tr>
            	<tr class="blue-grey white-text center">	
                    <td class="center ">Sens</td>
                     <td class="center">Date</td>
                     <td class="center">Heure</td>
                    <td class="center">ESCALE</td>
                    <td class="center">ADULTE</td>
                    <td class="center">ENFANT</td>
                    <td class="center">BEBE</td>
                    <td class="center">PEC</td>
                    <td class="center">PAX TRAN</td>
                    <td class="center">FRET LOC</td>
                    <td class="center">FRET TRA</td>
                    <td class="center">FRET PTT</td>
                    <td class="center">BALISAGE</td>
                    <td class="center">STAT</td>
            	</tr>
            <?php
            	$s="select * from rva_facturation2.escale,rva_facturation2.pt_emplacement where escale.Prov_dest=Pt_emplacement.Id_pt and Sens='A' and Id_mouv='$num_mouv'"; 
				$e=$m->cnx->query($s); $row=$e->fetchAll();
				foreach($row as $t)
				{
					echo "<tr class=''>";
						echo ("<td class='col s12 m2'>".$t['Sens']."</td>");
						echo ("<td class=' center'>".$m->Datemysqltofr($mouvement['ta'][0]['Date_mouv'])."</td>");
						echo ("<td class=' center'>".$m->Heureformat($mouvement['ta'][0]['Heure_mouv'])."</td>");
						echo ("<td class=' center'>".$t['Code_pt']."</td>");
						echo ("<td class=' center'>".$t['Ad']."</td>");
						echo ("<td class=' center'>".$t['Ch']."</td>");
						echo ("<td class=' center'>".$t['Inf']."</td>");
						echo ("<td class=' center'>".$t['Pec']."</td>");
						echo ("<td class=' center'>".$t['Tra']."</td>");
						echo ("<td class=' center'>".$t['Loc']."</td>");
						echo ("<td class=' center'>".$t['Trat']."</td>");
						echo ("<td class=' center'>".$t['Ptt']."</td>");
						echo ("<td class=' center'>".$mouvement['balisage_a']."</td>");
						echo ("<td class=' center'>".$mouvement['stat_a']."</td>");
					echo "</tr>";

				}
			?>
            
            <?php
            	$s="select * from rva_facturation2.escale,rva_facturation2.pt_emplacement where escale.Pt_ent=Pt_emplacement.Id_pt and Sens='D' and Id_mouv='$num_mouv'"; 
				$e=$m->cnx->query($s); $row=$e->fetchAll();
				foreach($row as $t)
				{
					echo "<tr class=''>";
						echo ("<td class=''>".$t['Sens']."</td>");
						echo ("<td class=' center'>".$m->Datemysqltofr($mouvement['td'][0]['Date_mouv'])."</td>");
						echo ("<td class=' center'>".$m->Heureformat($mouvement['td'][0]['Heure_mouv'])."</td>");
						echo ("<td class=' center'>".$t['Code_pt']."</td>");
						echo ("<td class=' center'>".$t['Ad']."</td>");
						echo ("<td class=' center'>".$t['Ch']."</td>");
						echo ("<td class=' center'>".$t['Inf']."</td>");
						echo ("<td class=' center'>".$t['Pec']."</td>");
						echo ("<td class=' center'>".$t['Tra']."</td>");
						echo ("<td class=' center'>".$t['Loc']."</td>");
						echo ("<td class=' center'>".$t['Trat']."</td>");
						echo ("<td class=' center'>".$t['Ptt']."</td>");
						echo ("<td class=' center'>".$mouvement['balisage_d']."</td>");
						echo ("<td class=' center'>".$mouvement['stat_d']."</td>");
					echo "</tr>";

				}
			?>
            </table>
            
      </p>
    	
  </div>
</div>
<!--=================================================================-->
<table width="1098" height="104" border="0" cellspacing="0" class="w3-small w3-table-all">
  <tr class="">
    <td colspan="13" class="bold blue-text">II.REDEVANCES A PAYER</td>
  </tr>
  <tr class="blue-grey white-text">
    <td width="41">SENS</td>
    <td width="123">ROUTE</td>
    <td width="82">ATTER</td>
    <td width="82">BALISAGE</td>
    <td width="82">FRET</td>
    <td width="82">PASSAGER</td>
    <td width="82">PEC</td>
    <td width="82">STATIONNEMENT</td>
    <td width="82">COMPT ENR</td>
    <td width="82">FORM</td>
    <td width="82">ASS ANT</td>
    <td width="82">SURETE</td>
    <td width="88">SECURITE</td>
  </tr>
  <tr>
    <td>A</td>
    <td><?php echo $m->arrondie($mouvement['red_route_a']); ?></td>
    <td>&nbsp;</td>
    <td><?php echo $m->arrondie($mouvement['red_bal_a']); ?></td>
    <td><?php echo $m->arrondie($mouvement['red_fret_a']); ?></td>
    <td><?php echo $m->arrondie($mouvement['red_pass_a']); 
				//arrondie($mouvement['tot_pax_d']); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>D</td>
    <td><?php echo $m->arrondie($mouvement['red_route_d']); ?></td>
    <td><?php echo $m->arrondie($mouvement['red_att']); ?></td>
    <td><?php echo $m->arrondie($mouvement['red_bal_d']); ?></td>
    <td><?php echo $m->arrondie($mouvement['red_fret_d']); ?></td>
    <td><?php echo $m->arrondie($mouvement['red_pass_d']); ?></td>
    <td><?php echo $m->arrondie($mouvement['red_pec']); ?></td>
    <td><?php echo $m->arrondie($mouvement['red_stat']); ?></td>
    <td><?php echo $m->arrondie($mouvement['red_compt']); ?></td>
    <td><?php echo $m->arrondie($mouvement['red_formu']); ?></td>
    <td><?php echo $m->arrondie($mouvement['red_assantinc']); ?></td>
    <td><?php echo $m->arrondie($mouvement['red_surete']); ?></td>
    <td><?php echo $m->arrondie($mouvement['red_securite']); ?></td>
  </tr>
  <tr class="red lighten-3">
    <td>&nbsp;</td>
    <td><?php echo $m->arrondie($mouvement['tot_red_rout']); ?></td>
    <td><?php echo $m->arrondie($mouvement['tot_red_att']); ?></td>
    <td><?php echo $m->arrondie($mouvement['tot_red_bal']); ?></td>
    <td><?php echo $m->arrondie($mouvement['tot_red_fret']); ?></td>
    <td><?php echo $m->arrondie($mouvement['tot_red_pass']); ?></td>
    <td><?php echo $m->arrondie($mouvement['tot_red_pec']); ?></td>
    <td><?php echo $m->arrondie($mouvement['tot_red_stat']); ?></td>
    <td><?php echo $m->arrondie($mouvement['tot_red_compt']); ?></td>
    <td><?php echo $m->arrondie($mouvement['tot_red_formu']); ?></td>
    <td><?php echo $m->arrondie($mouvement['tot_red_assantinc']); ?></td>
    <td><?php echo $m->arrondie($mouvement['tot_red_surete']); ?></td>
    <td><?php echo $m->arrondie($mouvement['tot_red_securite']); ?></td>
  </tr>
</table>
<div class="row p-1">
	<div class="col s12 center"><button class="btn btn-success" onclick='imprimer_fact_cash("<?php echo $id_mouv; ?>","<?php  echo $num_mouv;?>");'><i class="fa fa-print"></i>&nbsp;Apercu</button></div>
</div>

<div class="w-50 center">
	<table class="w3-table-all w3-small">
    	<tr>
        	<td colspan="2" class="bold">Taux de <?php echo $mouvement['taux'][0]['Usd_fc']; ?> </td> <td></td> <td></td>
        </tr>
        <tr>
        	<td>Montant hors taxe</td> 
            <td><span class="bold blue fs-1 p-1 white-text m-1"><?php echo $m->arrondie($mouvement['tot_sans_tva']); ?></span></td>
            <td>Equivalent a </td> 
            <td><span class="bold blue fs-1 p-1 white-text m-1"><?php echo $m->arrondie($mouvement['tot_sans_tva_fc']); ?></span></td>
        </tr>
        <tr>
        	<td>Montant TVA</td> 
            <td><span class="bold blue fs-1 p-1 white-text m-1"><?php echo $m->arrondie($mouvement['tva']); ?></span></td>
            <td>Equivalent a </td> 
            <td><span class="bold blue fs-1 p-1 white-text m-1"><?php echo $m->arrondie($mouvement['tva_fc']); ?></span></td>
        </tr>
        <tr>
        	<td>Montant Toutes taxes</td> 
            <td><span class="bold blue fs-1 p-1 white-text m-1"><?php echo ($mouvement['tot_avec_tva']); ?></span></td>
            <td>Equivalent a </td> 
            <td><span class="bold blue fs-1 p-1 white-text m-1"><?php echo $m->arrondie($mouvement['tot_avec_tva_fc']); ?></span></td>
        </tr>
    </table>
</div>
