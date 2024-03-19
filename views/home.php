<?php
if (!isset($_SESSION["nom_utilisateur"])) {
    $_SESSION["nom_utilisateur"] = "null";
}


if (isset($_SESSION['login_error'])) {
    $error =  '<div id="errorDiv">' . $_SESSION['login_error'] . '</div>';
    unset($_SESSION['login_error']); // Efface l'erreur de la session après l'affichage
}

if (!isset($_SESSION["user_id"])) : ?>
    <div class="tab-content">
        <h2>Connexion</h2>

        <?php if (isset($error)) echo $error;
        unset($error) ?>

        <form action="process.php?process=login" method="POST">
            <div class="input-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
    </div>
<?php else : ?>
    <div class="tab-content">
        <div class="user-info">
            <p>Vous êtes connecté en tant que <strong><?php echo $_SESSION["nom_utilisateur"]; ?></strong>.</p>
            <p>Votre QR Code :</p>
            <img src="assets/QRcodeLoader.php" />
            <p>Ce QR Code vous permet de vous authentifier auprès d'un hôte de caisse. Un justificatif de votre identité peut vous être demandé.</p>
        </div>
    </div>
<?php endif; ?>