<div class="tab-content">
    <h2>Changer le mot de passe</h2>
    
    <form action="index.php?page=profile" method="post">
        <button type="submit" class="red_button">Retour</button>
    </form>

    <?php
    if (isset($_SESSION['change_error'])) {
        echo '<b><div id="errorDiv">' . $_SESSION['change_error'] . '</div></b>';
        unset($_SESSION['change_error']);
    }
    ?>

    <form id="changePasswordForm" action="index.php?page=change_password_process" method="post">
        <label for="password">Mot de passe actuel :</label>
            <input type="password" name="password"  required>
        <br>
        
        <label for="new_password"> Nouveau mot de passe :</label>
            <input type="text" name="new_password"  required>
        <br>
        
        <label for="new_password_confirmation">Confirmation du nouveau mot de passe :</label>
            <input type="text" name="new_password_confirmation" required>
        <br>
        
        <button type="submit">Changer le mot de passe</button>
    </form>
</div>
