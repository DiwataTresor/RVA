<div class="panel panel-primary">
	<div class="panel-heading center"><i class="fa fa-refresh"></i> CHANGEMENT DE MOT DE PASSE</div>
    <div class="panel-body" align="left">
    	<div class="row ml-1">
        	<div class="panel panel-default col s12 m5 ">
            <div class="panel-heading">Mise &agrave; jour</div>
            <div class="panel-body">
            	<form  onsubmit="changer_mdp_conf(); return false">
                    <p>
                        <label>Actuel mot de passe</label>
                        <input type="password" id="actuel" class="browser-default form-control" required />
                    </p>
                    <p>
                        <label>Nouveau</label>
                        <input type="password" id="nouveau" class="browser-default form-control" required />
                    </p>
                    <p>
                        <label>Confirmer mot de passe</label>
                        <input type="password" id="nouveau2" class="browser-default form-control" required />
                    </p>
                    <p class="center">
                        <button class="btn btn-success">Changer</button>
                    </p>
                </form>
              </div>
            </div>
            <div class="col s12 m7 pl-3 center">
                <div class="alert alert-info"><i class="fa fa-warning"></i> Si vous changez votre Mot de passe</div>
                <div class="fs-12 center">
                    Apr&egrave;s la modification de votre mot de passe, veuillez vous d&eacute;connecter et se r&eacute;connecter de nouveau pour actualiser votre changement</div>
            </div>
        </div>
    </div>
</div>