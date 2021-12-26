<?php
$dt_arr="2019-10-21";
$heure_arr="10:10:00";
$dt_dep="2019-10-21";
$heure_dep="10:11:00";
$tps_arr=strtotime($dt_arr." ".$heure_arr);	
$tps_dep=strtotime($dt_dep." ".$heure_dep);
if($tps_arr>$tps_dep)
{
	echo ("Tps arrive super");
}else
{
	echo("Tps depart super");
}
?>