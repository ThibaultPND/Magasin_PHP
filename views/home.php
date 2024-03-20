<?php
require_once "models/UserModel.php";

if (!isset($_SESSION["nom_utilisateur"])) {
    $_SESSION["nom_utilisateur"] = "null";
}


if (isset($_SESSION['login_error'])) {
    $login_error =  '<div id="errorDiv">' . $_SESSION['login_error'] . '</div>';
    unset($_SESSION['login_error']); // Efface l'erreur de la session après l'affichage
}
if (isset($_SESSION['register_error'])) {
    $register_error =  '<div id="errorDiv">' . $_SESSION['register_error'] . '</div>';
    unset($_SESSION['register_error']); // Efface l'erreur de la session après l'affichage
}

if (!isset($_SESSION["id"])) : ?>
    <div class="home_container">
        <div class="login_form">
            <h2>Connexion</h2>

            <?php
            if (isset($login_error)) {
                echo $login_error;
                unset($login_error);
            } ?>

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
        <div class="separator"></div>
        <div class="register_form">
            <h2>Inscription</h2>

            <?php
            if (isset($register_error)) {
                echo $register_error;
                unset($register_error);
            } ?>

            <form action="process.php?process=register" method="POST">
                <div class="input-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <!-- Crée une confirmation du mot de passe -->
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <button type="submit">Crée un compte</button>
            </form>
        </div>
    </div>
<?php else : ?>
    <div class="home_connected_container">
        <div class="user-info">
            <p>Vous êtes connecté en tant que <strong><?php echo $_SESSION["nom_utilisateur"]; ?></strong>.</p>
            <p>Votre QR Code :</p>
            <?php 
            $user = new UserModel();
            $user->showQrCodeImage();
            ?>
            <p>Ce QR Code vous permet de vous authentifier auprès d'un hôte de caisse. Un justificatif de votre identité peut vous être demandé.</p>
        </div>
    </div>
<?php endif; ?>