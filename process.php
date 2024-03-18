<?php
require_once 'controllers/HomeController.php';
require_once 'controllers/AuthController.php';
// require_once 'controllers/ProfileController.php';

$homeController = new HomeController();
$authController = new AuthController();
// $profileController = new ProfileController();

$process = isset($_GET['process']) ? $_GET['process'] : 'home';

switch ($process) {
    case 'login':
        $authController->login();
        break;
    case 'change_password':
        $authController->updatePassword();
        break;
    case 'change_username':
        $authController->updateUsername();
        break;
    default:
        $homeController->showHome();
}
