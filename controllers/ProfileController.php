<?php
class ProfileController {
    public function showProfil() {
        $pageTitle = 'Profile';
        ob_start();
        include 'views/profile.php';
        $content = ob_get_clean();
        include 'views/layout.php';
    }
}
