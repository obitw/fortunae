<div class="container">
    <div class="row justify-content-center">
        <form action="?action=creerDepuisFormulaire&controleur=joueur" method="post" class="col-md-6">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="login">Login:</label>
                        <input type="text" id="login" name="login" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="nom">Nom:</label>
                        <input type="text" id="nom" name="nom" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="prenom">Prenom:</label>
                        <input type="text" id="prenom" name="prenom" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="dateNaissance">Date de naissance:</label>
                        <input type="date" id="dateNaissance" name="dateNaissance" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="mdp">Mot de passe:</label>
                        <input type="password" id="mdp" name="mdp" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="mdp2">Verification du mot de passe:</label>
                        <input type="password" id="mdp2" name="mdp2" required class="form-control">
                    </div>
                </div>

                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <input type="submit" value="S'inscrire" class="btn btn-primary mt-3 w-100" style="height: 15%;"/>
                </div>
            </div>
        </form>
    </div>
</div>