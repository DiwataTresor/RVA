<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RVA - LUBAMBASHI</title>
<style>
/*img{width:428px;height:320px}*/
img{width:228px;height:170px}

</style>
<link href="plugins/materialize/css/materialize.min.css" rel="stylesheet" type="text/css" />
<script type="application/javascript" src="plugins/js/jquery-3.2.1.min.js" language="javascript"></script>
<script type="application/javascript" language="javascript">
	function zoom(e)
	{
		var e="#"+e;
		$(e).animate({fontSize:"24px", width: "300px", height:"220", opacity: 0.6} , 600);
		
	}
	function zoom_close(e)
	{
		var e="#"+e;
		$(e).animate({fontSize:"24px", width: "228px", height:"170px", opacity: 1} , 600);
		
	}	
</script>
</head>

<body bgcolor="#999999">
<center>
<div style="width:83%;height:1000px; margin-top:10px; border-radius:48%; padding:20px; border:2px solid #C0C0C0" align="center" class="z-depht-2 white">
<table width="889" height="249" border="0" align="center">
  <tr>
    <td width="84">&nbsp;</td>
    <td width="236">&nbsp;</td>
    <td width="289"><a href="index.php"><img src="images/accueil_facturation.png" id="fact" class="zoom" onmouseover="zoom('fact');" onmouseout="zoom_close('fact');"  /></a></td>
    <td width="254">&nbsp;</td>
    <td width="9">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><a href="#"><img src="images/accueil_rh.png" id="rh" width="428" height="320" class="zoom" onmouseover="zoom('rh');" onmouseout="zoom_close('rh');"  /></a></td>
    <td rowspan="4" align="center"><center><img src="images/logo_rva - Copie.png" alt="LOGO" width="406" height="240" /></center></td>
    <td><a href="#"><img src="images/accueil_peage.png" id="peage" width="408" height="320" class="zoom" onmouseover="zoom('peage');" onmouseout="zoom_close('peage');"   /></a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    </tr>
  
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center"><a href="#"><img src="images/accueil_statistique.png" id="statistique" class="zoom" onmouseover="zoom('statistique');" onmouseout="zoom_close('statistique');"  width="428" height="320"  /></a></td>
    <td colspan="2" align="right"><a href="#"><img src="images/accueil_finance.png" id="finance" class="zoom" onmouseover="zoom('finance');" onmouseout="zoom_close('finance');"  width="428" height="320"  /></a></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><img src="images/accueil_logistic.png" width="428" height="320" id="logistic" class="zoom" onmouseover="zoom('logistic');" onmouseout="zoom_close('logistic');" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</center>
</body>
</html>
