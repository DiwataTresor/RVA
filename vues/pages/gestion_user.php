<style>
	label{font-size:15px}
</style>
<script type="application/javascript">
$(function(){
	user_liste_user();
});
</script>
<div class="panel panel-primary">
	<div class="panel-heading" align="center">GESTION DES UTILISATEURS</div>
    <div class="panel-body">
        <div class="row w3-align-left">
            <div class="col s12 m4" align="left">
            	<div class="panel panel-default">
                	<div class="panel-heading center">Ajouter</div>
                    <div class="panel-body">
                        <form onSubmit="ajout('user'); return false">
                        	<input type="hidden" id="id" />
                            <p class="mb-1">
                                <label>Nom complet</label>
                                <input type="text" id="nom" required class="browser-default form-control" />
                            </p>
                            <p class="mb-1">
                                <label>Matricule</label>
                                <input type="text" id="matr" required class="browser-default form-control" />
                            </p>
                             <p class="mb-1">
                                <label>Privilege</label>
                                <select id="priv" required class="browser-default form-control">
                                	<option value="perc">Percepteur/Taxateur/Facturateur</option>
                                    <option value="ch_serv">Chef de Service</option>
                                    <option value="ch_bur">Chef de Bureau</option>
                                    <option value="ut">Utilisateur simple</option>
                                     <option value="adm">Administrateur</option>
                                     <option value="comm">Commandant</option>
                                     <option value="hand">Handling utilisateur</option>
                                </select>
                            </p>
                            <p class="mb-1">
                                <label>Login</label>
                                <input type="text" id="login" required class="browser-default form-control" />
                            </p>
                             <p class="mb-1">
                                <label>Mot de passe</label>
                                <input type="text" id="mdp" required class="browser-default form-control" />
                            </p>
                            <p class="mb-1">
                                <label>Confirmation Mot de passe</label>
                                <input type="text" id="mdp2" required class="browser-default form-control" />
                            </p>
                            <p class="mb-1">
                                <label>Compte</label>
                                <select id="statut" required class="browser-default form-control">
                                	<option value="A">Actif</option>
                                    <option value="B">Bloqu&eacute;</option>
                                    
                                </select>
                            </p>
                            
                            <p>
                                <button class="btn green" type="submit" id="btn_enreg">
                                	<i class="fa fa-check-circle"></i>&nbsp;Enregistrer</button>
                                <button class="btn btn-success green hide" id="btn_modif" type="button">
                                	<i class="fa fa-check-circle"></i>&nbsp;Modifier</button>
                                <button class="btn teal hide" type="button" id="btn_annuler"><i class="fa fa-times-circle"></i> Annuler</button>
                            </p>
                        </form>
                     </div>
                </div>
            </div>
            <div class="col s12 m8">
            	<div class="w3-borde w3-round">
                	<div class="panel panel-default">
                    	<div class="panel-heading">UTILISATEURS DEJA ENREGISTRES</div>
                        <div class="panel-body" id="liste">
                        	<img src="images/gif/ajax-rond.gif" /> Chargement en cours...
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>