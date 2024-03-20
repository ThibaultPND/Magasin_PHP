<?php
require_once 'models/UserModel.php';
include("lib/phpqrcode/qrlib.php");
class HomeController
{
    public function showHome()
    {
        $pageTitle = 'Accueil';
        $style = "css/home.css";
        ob_start();
        include 'views/home.php';
        $content = ob_get_clean();
        include 'views/layout.php';
    }
}
