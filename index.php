<?php
session_start();

require_once 'controllers/HomeController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/ProfileController.php';
require_once 'controllers/UsersManagerController.php';

$homeController = new HomeController();
$authController = new AuthController();
$profileController = new ProfileController();
$usersManager = new UsersManagerController();

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'profile':
        $profileController->showProfil();
        break;
    case 'change_username':
        $authController->showChangeUsername();
        break;
    case 'change_password':
        $authController->showChangePassword();
        break;
    case 'users_manager':
        $usersManager->showUsersManagerl();
        break;
    default:
        $homeController->showHome();
}
