<?php
	@session_start();
	if(isset($_SESSION['Cnx']))
	{
	}else
	{
		header("location:../index.php");
		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RVA--HANDLING :[ <?php echo $_SESSION['Nom']; ?> ]</title>
<?php
	include("../manager/parametre/parametre.php");
	entete();
?>
<!--<script language="javascript" type="application/javascript" src="plugins/lobibox/lobibox.js"></script>
<script language="javascript" type="application/javascript" src="plugins/lobibox/messageboxes.js"></script>
<script language="javascript" type="application/javascript" src="plugins/lobibox/notification.js"></script>
<link rel="stylesheet" media="all" href="plugins/lobibox/lobibox.css" />
<link rel="stylesheet" media="all" href="plugins/lobibox/animate.css" />-->
<script language="javascript" type="application/javascript" src="../controleurs/main_handling.js"></script>

</head>
<body class="couleur-grise" id="body">
<div style="position:fixed; width:100%; z-index:100">
<!--====================== BANIERE ========================-->
    <nav style="">
      <div class="nav-wrapper green pb-1 z-depth-1" style="padding-left:50px; padding-bottom:10px">
        <span class="brand-logo bold  m-05 mb-05" style="padding:0 10px 0 10px; margin-bottom:10px;">
        	REGIE DES VOIES AERIENNES <img src="images/logo_miniature.png" />  
            <small class='red-color bold orange-text'>[ Gestion de la Facturation Handling ]</small>
        </span>
        <ul class="right hide-on-med-and-down">
          <li>
			<div class="dropdown">
                  <a id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <span class="fs-15"><i class="fa fa-user"></i> <?php echo utf8_encode($_SESSION['Nom']); ?>
                    <span class="caret"></span>
                   </span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#" onclick="ouvrir('changer_mdp');" class="fs-15">Changer mot de passe</a></li>
                    <li><a href="#" onclick="hand_quitter();" class="fs-15">Quitter</a></li>
                  </ul>
             </div>
			</li>
        </ul>
      </div>
    </nav>
	<!--===================== MENU ========================-->
 	<div style="">
    	<!--===================== NAVBAR =====================-->
        <div class="navbar navbar-default" >
          <div class="container-fluid white blue-text fs-15">
            <!-- Brand and toggle get grouped for better mobile display -->       
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav blue-text">
              	<li class="dropdown">
                  <a href="#" class="dropdown-toggle blue-grey-text bold" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  	<i class="fa fa-home"></i>&nbsp;
                  </a>
                  <ul class="dropdown-menu">
                    <li class=""><a href="../FACTURATION" onclick="ouvrir('main_client')">Facturation aeronautiqueee</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle blue-grey-text bold" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  	<i class="fa fa-gear"></i>&nbsp;
                  RESSOURCES <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li class=""><a href="#" onclick="ouvrir('handleur')">HANDLEUR</a></li>
                    <li><a href="#" onclick="ouvrir('main_immatriculation')">IMMATRICULATIONS</a></li>                    
                  </ul>
                </li>
                <li>
                	 <a href="#" class="dropdown-toggle blue-grey-text bold" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  	<i class="fa fa-keyboard-o"></i>&nbsp;
                  	FACTURATION <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                  	<li class="fs-15"><a href="#" onclick="ouvrir('handling_facturation')"><i class="fa fa-usd"></i> Saisie facture</a></li>
                    <li class="fs-15">
                    	<a href="#" onclick="ouvrir('handling_paiement_liste_fact')"><i class="glyphicon glyphicon-check"></i> Paiement et impression facture</a>
                    </li>
                    <!-- <li class="fs-15">
                    	<a href="#" onclick="ouvrir('handling_releve')"><i class="fa fa-file-text"></i> Facture Relevé mensuel</a>
                    </li>-->
                    <li class="fs-15">
                    	<a href="#" onclick="ouvrir('handling_ventillation')"><i class="fa fa-file-text"></i> Ventillation handling</a>
                    </li>
                     
                  </ul>
                </li>
                 <?php
				/*if($_SESSION['Priv']!=='agent_handl')
				{ */?>
                <li>
                	 <a href="#" class="dropdown-toggle blue-grey-text bold" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  	<i class="fa fa-keyboard-o"></i>&nbsp;
                  	IMPRESSION <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                  	<li class="fs-15"><a href="#" onclick="ouvrir('handling_rapport_fact')"><i class="fa fa-usd"></i> Rapport factures</a></li>
                    <li class="fs-15">
                    	<a href="#" onclick="ouvrir('handling_liste_facture')"><i class="fa fa-list-ol"></i> Liste des paiements</a>
                    </li>
                   <!-- <li class="fs-15">
                    	<a href="#" onclick="ouvrir('handling_liste_facture')"><i class="fa fa-list-ol"></i> Liste des factures</a>
                    </li>-->
                     <li class="fs-15">
                    	<a href="#" onclick="ouvrir('handling_releve')"><i class="fa fa-file-text"></i> Facture Relevé mensuel</a>
                    </li>
                     <li class="divider"></li>
                     <li class="fs-15">
                     	<a href="#" onclick="ouvrir('handling_mouv_periode')">Mouvement par période</a>
                     </li>
                  </ul>
                </li>
                <?php
				//}
				if($_SESSION['Priv']=='adm')
				{ ?>
                <!--<li class="dropdown">
                  <a href="#" class="dropdown-toggle blue-grey-text bold" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  	<i class="fa fa-gear"></i>&nbsp;
                  	PARAMETRES <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a href="#" onclick="ouvrir('gestion_user')"><i class="fa fa-user"></i> Gestion des utilisateurs</a></li>
                    <li><a href="#" onclick="ouvrir('gestion_signataire')"><i class="fa fa-user"></i> Gestion des signataires</a></li>
                    <li><a href="#" onclick="ouvrir('mouvement_modif_liste');"><i class="fa fa-edit"></i> Modifier un mouvement</a></li>
                    <li><a href="#" onclick="ouvrir('redevance_aer');"><i class="fa fa-money"></i> Modifier un paiement</a></li>
                    <li class="divider"></li>
                    <li><a href="#" onclick="ouvrir('facture_non_paye');"><i class="fa fa-times"></i> Supprimer une facture non payée</a></li>
                    <li><a href="#" onclick="ouvrir('facture_paye');"><i class="fa fa-times"></i> Supprimer une facture payée</a></li>
                    <li class="divider"></li>
                   
                  </ul>
                </li>-->
                <?php
				}
				?>
              </ul>
              
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </div>

        <!--==================================================-->
    </div>
</div> 	
	<p style="padding-top:100px">&nbsp;</p>
    <div class="container white p-1" style="width:90%; min-height:400px;">
    	<div class="" id="fenetre_contenu">
        	 <center><img src="images/fond_acc.png" /></center>
             <center>
             	<a href="#" onclick="ouvrir('apropos');"><span class="fs-1">&copy; Conçu et dévéloppé chez PROTECH - Trésor DIWATA 2018</span></a>
             </center>
        </div>
    </div>
     <?php
  	//fenetre();
  	include('vues/popup/popup.php');
  ?>
</body>

</html>
