<div class="tab-content">
    <h2>Informations personelles</h2>
    <p>Nom d'utilisateur : <strong><?php echo $_SESSION["nom_utilisateur"] ?></strong></p>
    <p>Adresse email  : <strong><?php echo $_SESSION["email"] ?></strong></p>
    <p>Nom d'utilisateur : <strong><?php echo $_SESSION["nom_utilisateur"] ?></strong></p>

    <button class="green_button" onclick="window.location.href='index.php?page=change_username'">Changer le nom d'utilisateur</button>
    <button class="green_button" onclick="window.location.href='index.php?page=change_password'">Changer le mot de passe</button>
    <button class="red_button" onclick="window.location.href='views/logout.php'">Se déconnecter</button>

</div>