<?php

require_once 'models/UserModel.php';

class AuthController
{
    public function showLogin()
    {
        $pageTitle = 'Formulaire de connexion';
        $style = "css/home.css";
        ob_start();
        include 'views/home.php';
        $content = ob_get_clean();
        include 'views/layout.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $userModel->authenticate($username, $password);

            $_SESSION['login_error'] = 'Nom d\'utilisateur ou mot de passe incorrect';
            $this->showLogin();
        } else {
            $this->showLogin();
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            $userModel = new UserModel();
            $userModel->createAccount($username, $password, $email, Roles::CLIENT);

            $this->showLogin();
        } else {
            $this->showLogin();
        }
    }
}
