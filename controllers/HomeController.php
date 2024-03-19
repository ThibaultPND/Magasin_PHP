<?php
include("lib/phpqrcode/qrlib.php");
class HomeController
{
    public function showHome()
    {
        $pageTitle = 'Accueil';
        ob_start();
        include 'views/home.php';
        $content = ob_get_clean();
        include 'views/layout.php';
    }
    public function CreateQRCode() {
        if (!isset($_SESSION["nom_utilisateur"]))
            return;

        $content = $_SESSION["nom_utilisateur"];
        
        ob_start();
        QRcode::png($content, null, QR_ECLEVEL_L, 10);
        $qrCodeImage = ob_get_contents();
        ob_end_clean();

        // TODO Mettre l'image dans la BDD SQL.
        // UPDATE utilisateurs SET qrcode_image = ? WHERE id = ?
    }
}
