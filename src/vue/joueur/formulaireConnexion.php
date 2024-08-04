<div class="container">
    <div class="row justify-content-center">
        <form method="post" action="ControleurFrontal.php?action=seConnecter&controleur=joueur" class="col-md-6">
            <div class="form-group">
                <label for="login">Pseudo:</label>
                <input type="text" id="login" name="login" required class="form-control">
            </div>

            <div class="form-group">
                <label for="mdp">Mot de passe:</label>
                <input type="password" id="mdp" name="mdp" required class="form-control">
            </div>

            <input type="submit" value="Se connecter" class="btn btn-primary mt-3">
        </form>
    </div>
</div>