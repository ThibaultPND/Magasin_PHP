<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar">
        <!-- <div class="logo">MAGASIN_LOGO</div> -->
        <ul>
            <li><a href="index.php?page=home">Accueil</a></li>
            <?php
            // Vérifiez si l'utilisateur est connecté
            if (isset($_SESSION['user_id'])) {
                // Affichez le bouton ou l'onglet du profil
                echo '<li><a href="index.php?page=users_manager">Gestion d\'utilisateur</a></li>';
                echo '<li><a href="index.php?page=profile">Profil</a></li>';
            }
            ?>
        </ul>
    </nav>
    <div class="container">
        <!-- Contenu de la page -->
        <?php echo $content; ?>
    </div>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Magasin</p>
    </footer>
</body>

</html>