<?php
class UsersManagerController {
    public function showUsersManagerl() {
        $pageTitle = 'Gestionnaire des utilisateurs';
        ob_start();
        $style = "css/user_manager.css";
        include 'views/users_manager.php';
        $content = ob_get_clean();
        include 'views/layout.php';
    }
}