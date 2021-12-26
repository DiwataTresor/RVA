<?php
	@session_start();
	if(isset($_SESSION['Cnx']))
	{
		if($_SESSION['Priv']=='agent_handl')
		{
			header("location:HANDLING");
		}else
		{
		
		}
	}else
	{
		header("location:index.php");
		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RVA--FACTURATION :[ <?php echo $_SESSION['Nom']; ?> ]</title>
<link rel="shortcut icon" href="images/logo_miniature.png">

<?php
	include("manager/parametre/parametre.php");
	entete();
?>
</head>
<body class="couleur-grise" id="body">
<div style="position:fixed; width:100%; z-index:100">
<!--====================== BANIERE ========================-->
    <ul id="dropdown1" class="dropdown-content">
      <li><a href="#!">one</a></li>
      <li><a href="#!">two</a></li>
      <li class="divider"></li>
      <li><a href="#!">three</a></li>
    </ul>
    <nav style="">
      <div class="nav-wrapper purple pb-1 z-depth-1" style="padding-left:50px; padding-bottom:10px">
        <span class="brand-logo bold  m-05 mb-05" style="padding:0 10px 0 10px; margin-bottom:10px;">
        	REGIE DES VOIES AERIENNES <img src="images/logo_miniature.png" />  
            <small class='red-color bold orange-text'>[ Gestion de la Facturation ]</small>
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
                    <li><a href="#" onclick="quitter();" class="fs-15">Quitter</a></li>
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
                    <li class=""><a href="_handling/main.php" >Handling</a></li>
                  </ul>
                </li>
                <?php
                if($_SESSION['Priv']=='agent_handl')
				{
				
				}else
				{  ?>
                
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle blue-grey-text bold" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  	<i class="fa fa-gear"></i>&nbsp;
                  RESSOURCES <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li class=""><a href="#" onclick="ouvrir('main_client')">CLIENTS</a></li>
                    <li><a href="#" onclick="ouvrir('main_immatriculation')">IMMATRICULATIONS</a></li>
                    <li><a href="#" onclick="ouvrir('main_type_av')">TYPES AVIONS</a></li>
                    
                    <li><a href="#" onclick="ouvrir('route_pt')">POINT ENTR&Eacute;E SORTIE / EMPLACEMENT</a></li>
                    <li><a href="#" onclick="ouvrir('main_taux')">TAUX DE CHANGE</a></li>
                     <li><a href="#" onclick="ouvrir('main_acces')">GESTION DES ACCES</a></li>
                    <!--<li><a href="#" onclick="ouvrir('main_aero')">AERO PRIVE</a></li>-->
                    <li><a href="#" onclick="ouvrir('main_tarif')">GESTION DES TARIFS DES REDEVANCES</a></li>
                    <li><a href="#">CHANGEMENT DES SIGNATAIRES</a></li>
                    <!-- <li><a href="#" onclick="reinitialisation_numerotation(); return false">
                     	<i class="fa fa-refresh"></i> Reinitialiser N° Factures</a>
                     </li>-->
                      <li><a href="#" onclick="ouvrir('reinit_ok'); return false">
                     	<i class="fa fa-refresh"></i> Reinitialiser N° Factures</a>
                     </li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle blue-grey-text bold" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  	<i class="fa fa-random"></i>&nbsp;
                  ACCES ET AUTRES REDEV. <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li class=""><a href="#" onclick="ouvrir('acces_saisie')"><i class="fa fa-file-o"></i> Nouvel acc&egrave;s</a></li>
                    <li class=""><a href="#" onclick="ouvrir('idf')"><i class="fa fa-file-o"></i> Enregistrer Idf</a></li>
                    <li class="divider"></li>
                    <li class=""><a href="#" onclick="ouvrir('rapport_acces')"><i class="fa fa-file-o"></i> Rapport des acces</a></li>
                    <!--<li><a href="#" onclick="ouvrir('main_immatriculation')">Rapport mouv.</a></li>-->
                  </ul>
                </li>
                <li>
                	 <a href="#" class="dropdown-toggle blue-grey-text bold" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  	<i class="fa fa-keyboard-o"></i>&nbsp;
                  	FACTURATION <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                  	<li class="fs-15"><a href="#" onclick="ouvrir('mouv_saisie')"><i class="fa fa-usd"></i> Saisie facture</a></li>
                    <li class="fs-15">
                    	<a href="#" onclick="ouvrir('mouvement_liste')"><i class="glyphicon glyphicon-check"></i> Paiement facture</a>
                    </li>
                    <li class="fs-15">
                    	<a href="#" onclick="ouvrir('mouvement_supprimer')"><i class="fa fa-times"></i> Supprimer mouvement</a>
                    </li>
                     <li class="fs-15">
                    	<a href="#" onclick="ouvrir('mouvement_recherche')"><i class="fa fa-search"></i> Recherche d'un mouvement</a>
                    </li>
                  </ul>
                </li>
                 <?php
				if($_SESSION['Priv']=='adm' || $_SESSION['Priv']=='comm')
				{ ?>
                <li>
                	 <a href="#" class="dropdown-toggle blue-grey-text bold" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  	<i class="fa fa-usd"></i>&nbsp;
                  	FINANCE <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li class=""><a href="#" onclick="ouvrir('depense_saisie')"><i class="fa-check fa"></i> GESTION DEPENSES</a></li>
                    <li class=""><a href="#" onclick="ouvrir('entree')"><i class="fa-check fa"></i> GESTION DES ENTREES (ACCES PONCTUELS, PARKING &amp; AERONAUTIQUE)</a></li>
                    <li class=""><a href="#" onclick="ouvrir('entree_recouvrement')"><i class="fa-check fa"></i> GESTION DES ENTREES (RECOUVREMENT)</a></li>
                    <li class="divider"></li>
                    <li class=""><a href="#" onclick="ouvrir('finance_liste_depense')"><i class="fa-check fa"></i> RAPPORT DES DEPENSES</a></li>
                    <li class=""><a href="#" onclick="ouvrir('finance_liste_entree')"><i class="fa-check fa"></i> RAPPORT DES ENTREES</a></li>
                    <li class=""><a href="#" onclick="ouvrir('finance_rapport_jr')"><i class="fa-check fa"></i> RAPPORT JOURNALIER</a></li>
                  </ul>
                </li>
                <?php
				}
				?>
                <li>
                	<a href="#" class="dropdown-toggle blue-grey-text bold" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  	<i class="fa fa-print"></i>&nbsp;
                  IMPRESSION <span class="caret"></span>
                  </a>
                	<ul class="dropdown-menu">
                        <li class=""><a href="#" onclick="ouvrir('liste_facture')">FACTURE</a></li>
                        <li class=""><a href="#" onclick="reimpression();">REIMPRESSION FACTURE</a></li>
                        <li class=""><a href="#" onclick="ouvrir('bordereau')">BORDEREAU</a></li>
                        <li class=""><a href="#" onclick="ouvrir('ventillation')">VENTILLATION DES MOUVEMENTS</a></li>
                        <!--<li class=""><a href="#" onclick="ouvrir('ventillation')">VENTILLATION DES PAIEMENTS</a></li>-->
                       	<li class=""><a href="#" onclick="ouvrir('facture_agree')">FACTURE DES MOUVEMENTS DES AGREES</a></li> 
                        <li class=""><a href="#" onclick="ouvrir('releve_mens_valorise')">RELEVE MENSUEL DES MOUVEMENTS VALORISES</a></li>
                        <li class="divider"></li>
                        <li><a href="#" onclick="ouvrir('liste_facture_non_paye');">LISTE DES FACTURES NON PAYEES</a></li>
                        <li><a href="#" onclick="ouvrir('rapport_fact_non_paye');">RAPPORT FACTURATION CLIENT</a></li>
                        <li><a href="#" onclick="ouvrir('releve_client');">MOUVEMENTS/CLIENT</a></li>
                        <!--<li><a href="#" onclick="ouvrir('main_immatriculation')">IMMATRICULATIONS</a></li>
                        <li><a href="#" onclick="ouvrir('main_type_av')">TYPES AVIONS</a></li>                        
                        <li><a href="#" onclick="ouvrir('route_pt')">POINT ENTR&Eacute;E SORTIE</a></li>
                        <li><a href="#" onclick="ouvrir('route_pt')">EMPLACEMENT</a></li>
                        <li><a href="#" onclick="ouvrir('main_taux')">TAUX DE CHANGE</a></li>-->
                  </ul>
                </li>
                <?php
				if($_SESSION['Priv']=='adm')
				{ ?>
                <li class="dropdown">
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
                    <!--<li><a href="#" onclick="ouvrir('parametre_suppr_mouv');"><i class="fa fa-times"></i> Supprimer un mouvement</a></li>-->
                    <li><a href="#" onclick="ouvrir('facture_non_paye');"><i class="fa fa-times"></i> Supprimer une facture non payée</a></li>
                    <li><a href="#" onclick="ouvrir('facture_paye');"><i class="fa fa-times"></i> Supprimer une facture payée</a></li>
                    <li class="divider"></li>
                   
                  </ul>
                </li>
                <?php
				if($_SESSION['Priv']=='comm' || $_SESSION['Priv']=='adm')
				{
				?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle blue-grey-text bold" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  	<i class="fa fa-gear"></i>&nbsp;
                  	JOURNAL <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a href="#" onclick="ouvrir('journal_mouvement');"> MOUVEMENTS</a></li>
                    <li><a href="#" onclick="ouvrir('journal_cnx')"> CONNEXION</a></li>
                    <li><a href="#" onclick="ouvrir('journal_impr');"> IMPRESSION FACTURE</a></li>
                    <li><a href="#" onclick="ouvrir('journal_suppression');"> SUPPRESSION MOUVEMENT</a></li>
                    <li><a href="#" onclick="ouvrir('journal_tout');"> TOUT LE JOURNAL</a></li>
                  </ul>
                </li>
				<?php
				 }
				}
				?>
              </ul>
             <?php
			 }
			 ?> 
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
             <center><a href="#" onclick="ouvrir('apropos');"><span class="fs-1">&copy; Conçu et dévéloppé chez PROTECH - Trésor DIWATA 2018</span></a></center>
        </div>
    </div>
    <?php
  	//fenetre();
  	include('vues/popup/popup.php');
  ?>
</body>
</html>
