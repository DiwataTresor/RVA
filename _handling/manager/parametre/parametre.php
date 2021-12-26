<?php
function m_mainUrl($p)
{
	echo $p;
}
function m_mainUrlP($p)
{
	echo $p;
}
function entete()
{ ?>
	<link rel="stylesheet" type="text/css" href="plugins/css/w3.css" />
	<link rel="stylesheet" type="text/css" href="plugins/materialize/css/materialize.min.css" />
	<link rel="stylesheet" type="text/css" href="plugins/materialize/css/style.css" />
	<link rel="stylesheet" type="text/css" href="plugins/bootstrap/css/bootstrap.css" />
	<!--<link rel="stylesheet" type="text/css" href="plugins/bootstrap/css/style.css" />-->
	<link rel="stylesheet" type="text/css" href="plugins/bootstrap/css/font-awesome.css" />
	<link rel="stylesheet" type="text/css" href="styles/main.css" />
	
	<script language="javascript" type="application/javascript" src="plugins/js/jquery-3.2.1.min.js"></script>
	<script language="javascript" type="application/javascript" src="plugins/js/w3.js"></script>
    <script language="javascript" type="application/javascript" src="plugins/bootstrap/js/bootstrap.js"></script>
	<script language="javascript" type="application/javascript" src="plugins/materialize/js/materialize.js"></script>
	
	<script language="javascript" type="application/javascript" src="controleurs/fenetre.js"></script>
	<script language="javascript" type="application/javascript" src="controleurs/main.js"></script>
	<script language="javascript" type="application/javascript" src="controleurs/add.js"></script>
    <script language="javascript" type="application/javascript" src="controleurs/update.js"></script>
    <script language="javascript" type="application/javascript" src="controleurs/delete.js"></script>
<?php
}

function baniere()
{ ?>    	
  
 <div class="navbar-fixed">
 <nav class="light-green lighten-1" >
	<div class="nav-wrapper ">
		<ul class="left">
			<li><a href="#" data-target="sidenavi" class="sidenav-trigger ml-1 w3-show"><i class="fa fa-barss"></i></a></li>
		</ul>
		<span class="ml-2 fs-2 w3-round-xxlarge w3-blues w3-padding">e-<span class="bold">Promed</span></span>
	  <ul class="right hide-on-med-and-down">
	   
		<li>
			<a href="#">
				<i class="fa fa-envelope"></i>
			</a>
		</li>	
		<li>
			<a href="#">
				<i class="fa fa-calendar"></i>
			</a>
		</li>	
		<li>
			<a class="dropdown-trigger blue-grey" href="#!" data-target="dropdown1"><i class="fa fa-user"></i>&nbsp;Mon compte</a>
		</li>
	  </ul>
	
	  <ul id="nav-mobile" class="sidenav">
		<li>
			<a href="#!" data-target="dropdown1" class="dropdown-trigger">
			Accueil</a>
		</li>
		<li class="divider"></li>
		
	  </ul>
	  <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
	</div>
	
  </nav>
 </div> 
<?php
}
function menu_user()
{ ?>
	<div class="row">
    	<div class="col s12 m3" onclick="ouvrir_fenetre('main_reception');">
        	<div class="card blue lighten-2 hoverable white-text bold" style="height:70px; padding:20px; cursor:pointer">
            	<i class="fa fa-user fs-3"></i> |
                RECEPTION
            </div>
        </div>
        
        <div class="col s12 m3" onclick="ouvrir_fenetre('main_infirmerie');">
        	<div class="card blue hoverable lighten-2 white-text bold" style="height:70px; padding:20px; cursor:pointer">
            	<i class="fa fa-stethoscope fs-3"></i> |
                INFIRMERIE
            </div>
        </div>
        <div class="col s12 m3" onclick="ouvrir_fenetre('main_consultation');">
        	<div class="card blue lighten-2 hoverable white-text bold" style="height:70px; padding:20px; cursor:pointer">
            	<i class="fa fa-user-md fs-3"></i> |
               CONSULTATION
            </div>
        </div>
        <div class="col s12 m3" onclick="ouvrir_fenetre('main_hospitalisation');">
        	<div class="card blue lighten-2 hoverable white-text bold" style="height:70px; padding:20px; cursor:pointer">
            	<i class="fa fa-user-md fs-3"></i> |
               HOSPITALISATION
            </div>
        </div>
        <div class="col s12 m3">
        	<div class="card blue hoverable white-text bold" onclick="ouvrir_fenetre('main_admin'); return false" style="height:70px; padding:20px; cursor:pointer;">
            	<i class="fa fa-gear fs-3"></i> |
                ADMIN
            </div>
        </div>
        <div class="col s12 m3">
        	<div class="card orange hoverable white-text bold" style="height:70px; padding:20px; cursor:pointer;">
            	<i class="fa fa-print fs-3"></i> |
                RAPPORTS
            </div>
        </div>
        
    </div>
<?php
}
function fenetre()
{ ?>
	
<?php
}
?>