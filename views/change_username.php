<?php
$new_username = isset($_GET['new_username']) ? $_GET['new_username'] : '';
$new_username_confirmation = isset($_GET['new_username_confirmation']) ? $_GET['new_username_confirmation'] : '';
?>

<div class="tab-content">
    <h2>Changer le nom d'utilisateur</h2>
    
    <form action="index.php?page=profile" method="post">
        <button type="submit" class="red_button">Retour</button>
    </form>

    <?php
    if (isset($_SESSION['change_error'])) {
        echo '<b><div id="errorDiv">' . $_SESSION['change_error'] . '</div></b>';
        unset($_SESSION['change_error']);
    }
    ?>

    <form id="changeUsernameForm" action="index.php?page=change_username_process" method="post">
        <label for="new_username">Nouveau nom d'utilisateur :</label>
        <input type="text" name="new_username" value="<?php echo htmlspecialchars($new_username); ?>" required>
        <br>
        
        <label for="new_username_confirmation">Confirmation du nouveau nom d'utilisateur :</label>
        <input type="text" name="new_username_confirmation" value="<?php echo htmlspecialchars($new_username_confirmation); ?>" required>
        <br>
        
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required>
        <br>
        
        <button type="submit">Changer le nom d'utilisateur</button>
    </form>
</div>
