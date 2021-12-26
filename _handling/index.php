<?php
	@session_start();
	session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1, user-scalable=no">
<title>RVA--FACTURATION</title>
<link rel="shortcut icon" href="images/logo_miniature.png">

<?php
include("manager/parametre/parametre.php");
entete();
?>
</head>

<body class="grey lighten-3" style="margin:0px; padding:30px 0 0 0; background-color:#FFF; background-image:url(images/fond.png); background-attachment:scroll">
	<center>
    	<div class=""><img src="images/logo_rva.png" class="" /></div>
    	<div class="w-25 card mt-2 pt-1 couleur-grise-faible">
        	<p class="bold mt-05">Identification</p>
            <div class="divider"></div>
            <div class="p-1 white">
            	<form onsubmit="connexion(); return false">
                	<div class="row pl-1">
                    	<div class="col s12 m1" style="vertical-align:bottom"><i class="fa fa-user"></i>&nbsp;</div>
                        <div class="col s12 m9">
                        	<p class="">
                            	<input type="text" placeholder="Login" id="login" required />
                            </p>
                        </div>
                    </div>
                    
                    <div class="row pl-1">
                    	<div class="col s12 m1" style="vertical-align:bottom"><i class="fa fa-lock"></i>&nbsp;</div>
                        <div class="col s12 m9">
                        	<p class="">
                            	<input type="password" placeholder="Mot de passe" id="mdp" required />
                            </p>
                        </div>
                    </div>
                    
                    <div class="row pl-1">
                    	<button class="btn red waves waves-effect">Connexion</button>
                    </div>
                    <p class="loading">
                    	
                    </p>
                </form>
            </div>
        </div>
        <div class="w-25  mt-2 pt-1">
			<span class="white-text fs-1">&copy; Conçu et dévéloppé chez PROTECH - Trésor DIWATA 2018</span>
        </div>
    </center>
</body>
</html>
