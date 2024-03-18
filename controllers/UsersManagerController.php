<?php
class UsersManagerController {
    public function showUsersManagerl() {
        $pageTitle = 'Gestionnaire des utilisateurs';
        ob_start();
        include 'views/users_manager.php';
        $content = ob_get_clean();
        include 'views/layout.php';
    }
}