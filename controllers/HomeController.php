<?php
class HomeController {
    public function showHome() {
        $pageTitle = 'Accueil';
        ob_start();
        include 'views/home.php';
        $content = ob_get_clean();
        include 'views/layout.php';
    }
}
