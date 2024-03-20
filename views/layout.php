<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <?php if (!isset($style)) $style = "css/style.css"; ?>
    <link rel="stylesheet" href=<?php echo $style  ?>>
</head>

<body>
    <nav class="navbar">
        <!-- <div class="logo">MAGASIN_LOGO</div> -->
        <ul>
            <li><a href="index.php?page=home">Accueil</a></li>
            <?php
            // Vérifiez si l'utilisateur est connecté
            if (isset($_SESSION['id'])) {
                echo '<li><a href="index.php?page=users_manager">Gestion d\'utilisateur</a></li>';
                echo '<li><a href="index.php?page=profile">Profil</a></li>';
            }
            ?>
        </ul>
    </nav>
    <!-- Contenu de la page -->
    <?php echo $content; ?>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Magasin</p>
    </footer>
</body>

</html>