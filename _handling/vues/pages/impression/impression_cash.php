<?php
	$id_mouv=$_REQUEST["id_mouv"];
	$num_mouv=$_REQUEST["num_mouv"];
?>

<iframe src="http://localhost:8888/rva_facturation/vues/pages/impression/facture_cash.php?id_mouv='<?php echo $id_mouv; ?>'&num_mouv='<?php echo $num_mouv; ?>'" style="width:100%; min-height:400px;">
	
</iframe>