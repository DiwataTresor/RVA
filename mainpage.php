<?php
	@session_start();
	if(isset($_SESSION['Cnx']))
	{
		if($_SESSION['Priv']=='agent_handl' || $_SESSION['Priv']=='hand')
		{
			header("location:_handling/main.php");
		}else
		{
			include("manager/bd/cnx.php");
			class m extends main{}
			
			$m=new m();		
		}
	}else
	{
		header("location:index.php");
		
	}
	
	
						//$datachart=$m->chart_data_rda();
						$tableau = array();
						$mois_en_cours=intval(date("m"));
						$annee_en_cours=intval(date('Y'));
						$tableau=array();
						
						//for($a=1;$a<=$mois_en_cours;$a++)
						for($a=1;$a<=$mois_en_cours;$a++)
						{
							if($a<10)
							{
								$a=$a;
								$mois=$a."-".$annee_en_cours;
								$mois=$a;
								//echo($mois)."<br>";
							}else
							{
								$mois=$a."-".$annee_en_cours;
								$mois=$a;
							}
							//$mois=
							$s="select * from rva_facturation2.mouvement2 where FORMAT(Date_mouv,'%M')='$mois' and FORMAT(Date_mouv,'yyyy')='$annee_en_cours' and Sens='A'";
							$e=$m->cnx->query($s);
							$t=$e->fetchAll();
							$mt=0;
							$n=count($t);
							//echo($n."<br >");
							$b=0;
							foreach($t as $row)
							{
								$b+=2;
							}
							$dtt=$annee_en_cours."-".$a."-01";
							array_push($tableau,array("y"=>$n,"label"=>$m->mois_long($dtt)));
							
						}
						
						//========== PAIEMENT CASH=========
						//$datachart=$m->chart_data_rda();
						$tableau2 = array();
						$mois_en_cours=intval(date("m"));
						$annee_en_cours=intval(date('Y'));
						$tableau2=array();
						//for($a=1;$a<=$mois_en_cours;$a++)
						for($a=1;$a<=$mois_en_cours;$a++)
						{
							if($a<10)
							{
								$a=$a;
								$mois=$a;
								//echo($mois)."<br>";
							}else
							{
								$mois=$a;
							}
							//$mois=
							$s="select * from rva_facturation2.paiement_facture where FORMAT(Date_paie,'%M')='$mois' and FORMAT(Date_paie,'yyyy')='$annee_en_cours' and Monnaie='USD'";
							$e=$m->cnx->query($s);
							$t=$e->fetchAll();
							$mt=0;
							$n=count($t);
							$mt=0;
							foreach($t as $row)
							{
								$mt+=$row["Mt_paye"];
							}
							$dtt=$annee_en_cours."-".$a."-01";
							array_push($tableau2,array("y"=>$mt,"label"=>$m->mois_long($dtt)));
							//echo json_encode($tableau2);
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
                    <li class=""><a href="_handling/main.php">Handling</a></li>
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
                    
                     <li><a href="#" onclick="ouvrir('main_acces')">GESTION DES ACCES</a></li>
                    <!--<li><a href="#" onclick="ouvrir('main_aero')">AERO PRIVE</a></li>-->
					<?php if($_SESSION["Priv"]=="adm" || $_SESSION["Priv"]=="dicom")
					{ ?>
					<li><a href="#" onclick="ouvrir('main_taux')">TAUX DE CHANGE</a></li>
                    <li><a href="#" onclick="ouvrir('main_tarif')">GESTION DES TARIFS DES REDEVANCES</a></li>
                    <li><a href="#">CHANGEMENT DES SIGNATAIRES</a></li>
                    <?php  
					
					} ?>
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
                    <li class="divider"></li>
                    <li>
                    	<a href="#" onclick="ouvrir('rda_suppl')"><i class="glyphicon glyphicon-check"></i> Paiement supplement facture</a>
                    </li>
                    <li class="divider"></li>
                    <li class="fs-15">
                    	<a href="#" onclick="ouvrir('mouvement_supprimer')"><i class="fa fa-times"></i> Supprimer mouvement</a>
                    </li>
                     <li class="fs-15">
                    	<a href="#" onclick="ouvrir('mouvement_recherche')"><i class="fa fa-search"></i> Recherche d'un mouvement</a>
                    </li>
                  </ul>
                </li>
                 <?php
				if($_SESSION['Priv']=='adm' || $_SESSION['Priv']=='comm' || $_SESSION['Priv']=='dicom')
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
                         <?php 
							if($_SESSION["Priv"]=="dicom" || $_SESSION['Priv']=='adm' || $_SESSION['Priv']=='ch_serv')
							{ ?>
                       	<li class=""><a href="#" onclick="ouvrir('facture_agree')">FACTURE DES MOUVEMENTS DES AGREES</a></li> 
                        <li class=""><a href="#" onclick="ouvrir('releve_mens_valorise')">RELEVE MENSUEL DES MOUVEMENTS VALORISES</a></li>
                        	<?php
							}
                            ?>
                        <li class="divider"></li>
                        <li class=""><a href="#" onclick="ouvrir('rapport_idf')">RAPPORT PAIEMENT IDF</a></li>
                        <li class=""><a href="#" onclick="ouvrir('rapport_rda_det')">RAPPORT REDEVANCES RDA DETAILLE</a></li>
                        <?php 
							if($_SESSION["Priv"]=="dicom")
							{ ?>
                        <li class=""><a href="#" onclick="ouvrir('tableau_bord')">TABLEAU DE BORD</a></li>
						<li><a href="#" onclick="ouvrir('rapport_pax');"> RAPPORT MENSUEL PAX</a></li>
                        <li class=""><a href="#" onclick="ouvrir('dicom')">RAPPORT DICOM</a></li>
                        	<?php
							}
							?>
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
				if($_SESSION['Priv']=='adm' || $_SESSION['Priv']=='dicom')
				{ ?>
                <?php
				  	if($_SESSION['Priv']=='dicom')
					{ ?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle blue-grey-text bold" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  	<i class="fa fa-gear"></i>&nbsp;
                  	PARAMETRES <span class="caret"></span>
                  </a>
                  
                  <ul class="dropdown-menu">
                    <li><a href="#" onclick="ouvrir('gestion_user')"><i class="fa fa-user"></i> Gestion des utilisateurs</a></li>
                    <li><a href="#" onclick="ouvrir('gestion_signataire')"><i class="fa fa-user"></i> Gestion des signataires</a></li>
                    <!--<li><a href="#" onclick="ouvrir('mouvement_modif_liste');"><i class="fa fa-edit"></i> Modifier un mouvement</a></li>
                    <li><a href="#" onclick="ouvrir('redevance_aer');"><i class="fa fa-money"></i> Modifier un paiement</a></li>
                    <li class="divider"></li>
                    <li><a href="#" onclick="ouvrir('parametre_suppr_mouv');"><i class="fa fa-times"></i> Supprimer un mouvement</a></li>-->
                    <li><a href="#" onclick="ouvrir('facture_non_paye');"><i class="fa fa-times"></i> Supprimer une facture non payée</a></li>
                    <!--<li><a href="#" onclick="ouvrir('facture_paye');"><i class="fa fa-times"></i> Supprimer une facture payée</a></li>-->
                    <!--<li><a href="#" onclick="ouvrir('handling_suppr_liste');"><i class="fa fa-times"></i> Supprimer paiement handling</a></li>-->
                   
                  </ul>
                </li>
                <?php
				}
				if($_SESSION['Priv']=='comm' || $_SESSION['Priv']=='adm' || $_SESSION['Priv']=='dicom')
				{
				?>
               <!-- <li class="dropdown">
                  <a href="#" class="dropdown-toggle blue-grey-text bold" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  	<i class="fa fa-gear"></i>&nbsp;
                  	JOURNAL <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a href="#" onclick="ouvrir('journal_mouvement');"> MOUVEMENTS</a></li>
                    <li><a href="#" onclick="ouvrir('journal_cnx')"> CONNEXION</a></li>
                    <li><a href="#" onclick="ouvrir('journal_impr');"> IMPRESSION FACTURE</a></li>
                    <li><a href="#" onclick="ouvrir('journal_suppression');"> SUPPRESSION MOUVEMENT</a></li>
                    <!--<li><a href="#" onclick="ouvrir('journal_tout');"> TOUT LE JOURNAL</a></li>-->
                  </ul>
                <!--</li>-->
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
        	 <center>
             	<?php
					if($_SESSION['Priv']=='dicoms')
					{ ?>
						<img width="300" src="images/fond_acc.png" />;
                        <div class="b fs-2">TABLEAU DE BORD<hr  /></div>
                        <div class="" align="left">
                        	<?php 
								$datejour=date("Y-m-d", strtotime("-1 day"));
								//$datejour=date("Y-m-d");
								echo '<div class="blue w3-round p-1 mb-1 white-text bold"><i class="fa fa-calendar"></i> '.$m->jrSemaine($datejour)." ".$m->Datemysqltofr($datejour).'</div>'; 
								$tableau_de_bord=$m->tableau_de_bord($datejour);
							?>
                            	<div class="row">
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading center">RDA</div>
															<div class="panel-body">
																<div><kbd>USD </kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["rda_mht"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["rda_tva"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["rda_ttc"]); ?></div>
																<hr  />
																<div><kbd class="orange">CDF</kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["rda_mht_fc"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["rda_tva_fc"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["rda_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
													
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading center">IDF</div>
															<div class="panel-body">
																<div><kbd>USD </kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["idf_mht"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["idf_tva"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["idf_ttc"]); ?></div>
																<hr  />
																<div><kbd class="orange">CDF</kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["idf_mht_fc"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["idf_tva_fc"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["idf_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading center">ACCES</div>
															<div class="panel-body">
																<div><kbd>USD </kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["acces_mht"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["acces_tva"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["acces_ttc"]); ?></div>
																<hr  />
																<div><kbd class="orange">CDF</kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["acces_mht_fc"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["acces_tva_fc"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["acces_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading center">PARKING</div>
															<div class="panel-body">
																<div><kbd>USD </kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["parking_mht"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["parking_tva"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["parking_ttc"]); ?></div>
																<hr  />
																<div><kbd class="orange">CDF</kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["parking_mht_fc"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["parking_tva_fc"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["parking_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading center">HANDLING</div>
															<div class="panel-body">
																<div><kbd>USD </kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["hand_mht"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["hand_tva"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["hand_ttc"]); ?></div>
																<hr  />
																<div><kbd class="orange">CDF</kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["hand_mht_fc"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["hand_tva_fc"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["hand_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
                                                    <div class="col-md-2">
														<div class="panel panel-danger">
															<div class="panel-heading center">TOTAL</div>
															<div class="panel-body">
																<div><kbd class="green">USD </kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["tot_mht"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["tot_tva"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["tot_ttc"]); ?></div>
																<hr  />
																<div><kbd class="red">CDF</kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["tot_mht_fc"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["tot_tva_fc"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["tot_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
												</div>   
                        </div>
                        
                        <div class="" align="left">
                        	<?php 
								$datejour=date("Y-m-d");
								echo '<div class="purple w3-round p-1 mb-1 white-text bold"><i class="fa fa-calendar"></i> AUJOURD\'HUI '.$m->Datemysqltofr($datejour).'</div>'; 
							$tableau_de_bord=$m->tableau_de_bord($datejour);
							?>
                            	<div class="row">
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading center">RDA</div>
															<div class="panel-body">
																<div><kbd>USD </kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["rda_mht"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["rda_tva"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["rda_ttc"]); ?></div>
																<hr  />
																<div><kbd class="orange">CDF</kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["rda_mht_fc"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["rda_tva_fc"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["rda_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
													
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading center">IDF</div>
															<div class="panel-body">
																<div><kbd>USD </kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["idf_mht"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["idf_tva"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["idf_ttc"]); ?></div>
																<hr  />
																<div><kbd class="orange">CDF</kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["idf_mht_fc"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["idf_tva_fc"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["idf_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading center">ACCES</div>
															<div class="panel-body">
																<div><kbd>USD </kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["acces_mht"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["acces_tva"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["acces_ttc"]); ?></div>
																<hr  />
																<div><kbd class="orange">CDF</kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["acces_mht_fc"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["acces_tva_fc"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["acces_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading center">PARKING</div>
															<div class="panel-body">
																<div><kbd>USD </kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["parking_mht"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["parking_tva"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["parking_ttc"]); ?></div>
																<hr  />
																<div><kbd class="orange">CDF</kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["parking_mht_fc"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["parking_tva_fc"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["parking_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading center">HANDLING</div>
															<div class="panel-body">
																<div><kbd>USD </kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["hand_mht"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["hand_tva"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["hand_ttc"]); ?></div>
																<hr  />
																<div><kbd class="orange">CDF</kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["hand_mht_fc"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["hand_tva_fc"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["hand_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
                                                    <div class="col-md-2">
														<div class="panel panel-danger">
															<div class="panel-heading center">TOTAL</div>
															<div class="panel-body">
																<div><kbd class="green">USD </kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["tot_mht"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["tot_tva"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["tot_ttc"]); ?></div>
																<hr  />
																<div><kbd class="red">CDF</kbd></div>
																	<div>MHT : <?php echo $m->arrondie($tableau_de_bord["tot_mht_fc"]); ?></div>
																	<div>TVA : <?php echo $m->arrondie($tableau_de_bord["tot_tva_fc"]); ?></div>
																	<div>TTC : <?php echo $m->arrondie($tableau_de_bord["tot_ttc_fc"]); ?></div>
															</div>
														</div>
													</div>
												</div>   
                        </div>
					<?php
                    }else
					{
                		echo('<img src="images/fond_acc.png" />');
					}
				if($_SESSION['Priv']=="dicom" || $_SESSION["Priv"]=="adm")
				{
				?>
                <div id="chartContainer" class="w-100 white m-0" style="height:500px">
                	
                </div>
                <hr />
                <div id="chartContainer2" class="clearfx w-100 white m-0" style="height:500px" >
                	
                </div>
				<?php
				}
				?>
            </center>
             <center>
             	<div class="mt-2 blue p-2 white-text">
                	<a class="white-text" href="#" onclick="ouvrir('apropos');"><span class="fs-1">&copy; Conçu et dévéloppé chez PROTECH - Trésor DIWATA 2018</span></a>
				</div>
              </center>
        </div>
    </div>
    <?php
  	//fenetre();
  	include('vues/popup/popup.php');
  ?>
</body>
<script language="javascript" type="application/javascript" src="plugins/js/canvasjs.min.js"></script>
<script>
$(document).ready(function(){
	var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		title: {
			text: "MOUVEMENTS DE L'ANNEE"
		},
		axisY: {
			title: "Nombre des mouvements"
		},
		data: [{
			theme:"light2",
			type: "line",
			markerType: "circle",  //"circle", "square", "cross", "none"
        	markerSize: 20,
			dataPoints: <?php echo json_encode($tableau, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart.render();
	
	
	chart = new CanvasJS.Chart("chartContainer2", {
		animationEnabled: true,
		title: {
			text: "SITUATION PAIEMENTS CASH"
		},
		axisY: {
			title: "Montant paiement"
		},
		data: [{
			type: "spline",
			markerType: "circle",  //"circle", "square", "cross", "none"
        	markerSize: 20,
			dataPoints: <?php echo json_encode($tableau2, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart.render();
});
</script>
</html>
