<?php
session_start();
session_destroy();
header('Location: ../index.php'); // Redirigez vers la page d'accueil après la déconnexion
exit();
