<?php
	include("../../manager/bd/cnx.php");
	$fact=$_REQUEST['p'];
	$p=$_REQUEST['p'];
	$fact=handling_facture($fact,$bdd);
	//============= TEST SI FACTURE DEJA PAIE============
	$s="select * from handling_paiement where Fact_paie='$p'";
	$e=mysqli_query($bdd,$s);
	$n=mysqli_num_rows($e);
?>
<div class="panel panel-success">
	<div class="panel-heading center">Paiement facture</div>
    <div class="panel-body">
    	<table class="w3-table fs-15" style="border:0px" width="484" height="211" border="0">
          <tr class="w3-border-0">
            <td width="105">Date mouv</td>
            <td width="271"><?php echo $fact['dt_arr']." - ".$fact['dt_dep'] ?></td>
          </tr>
          <tr class="w3-border-0">
            <td>Immatriculation</td>
            <td><?php echo $fact['imm']." - ".$fact['client'] ?></td>
          </tr>
          <tr class="w3-border-0">
            <td>Poids</td>
            <td><?php echo $fact['poids']."T"; ?></td>
          </tr>
          <tr class="w3-border-0">
            <td>Handleur</td>
            <td><?php echo $fact['handleur']; ?></td>
          </tr>
          <tr class="w3-border-0">
            <td>Touché (s)</td>
            <td><?php echo $fact['touche']; ?></td>
          </tr>
          <tr class="w3-border-0">
            <td>Montant</td>
            <td><?php echo "USD ".$fact['mht'] ?></td>
          </tr>
          <tr class="w3-border-0">
            <td>TVA</td>
            <td><?php 
				echo("USD ".($fact['tva'])); ?>             </td>
          </tr>
          <tr class="w3-border-0 blue white-text bold">
            <td>TOTAL</td>
            <td><?php echo "USD ".arrondie($fact['mttc']); ?> </td>
          </tr>
          <tr class="w3-border-0">
            <td colspan="2"><input type="hidden" id="mht" value="<?php echo $fact['mht'];  ?>">
            	<?php
				if($n==0)
				{ 
				
				?>
            	<button class="w3-btn green white-text" onClick="handling_paiement()"><i class="fa fa-check"></i> Confirmer paiement</button>            	<?php
				}else
				{
					echo ("<div class='alert alert-danger center bold'>Facture déjà payéé</div>");
				}
				?>            </td>
            <input type="hidden" id="fact" value="<?php echo $p;  ?>" />
            <input type="hidden" id="poids" value="<?php echo $fact['poids'];  ?>" />
             <input type="hidden" id="tva" value="<?php echo $fact['tva'];  ?>" />
              <input type="hidden" id="mttc" value="<?php echo $fact['mttc'];  ?>" />
          </tr>
      </table>

    	
  </div>
</div>