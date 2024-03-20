<?php
session_start();

require_once 'controllers/HomeController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/ProfileController.php';

$homeController = new HomeController();
$authController = new AuthController();
$profileController = new ProfileController();

$process = isset($_GET['process']) ? $_GET['process'] : 'home';

switch ($process) {
    case 'login':
        $authController->login();
        break;
    case 'register':
        $authController->register();
        break;
    case 'change_password':
        $profileController->updatePassword();
        break;
    case 'change_username':
        $profileController->updateUsername();
        break;
    default:
        $homeController->showHome();
}
