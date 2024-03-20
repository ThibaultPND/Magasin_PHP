<?php
class ProfileController
{
    public function showProfil()
    {
        $pageTitle = 'Profile';
        ob_start();
        include 'views/profile.php';
        $content = ob_get_clean();
        include 'views/layout.php';
    }


    public function showChangeUsername()
    {
        $pageTitle = 'Change le nom d\'utilisateur';
        ob_start();
        include 'views/change_username.php';
        $content = ob_get_clean();
        include 'views/layout.php';
    }

    public function updateUsername()
    {
        $userModel = new UserModel();

        if ($userModel->is_connected()) {

            $new_username = $_POST['new_username'];
            $new_username_confirmation = $_POST['new_username_confirmation'];
            $valid = $userModel->changeUsername($new_username, $new_username_confirmation, $_POST['password']);
            if ($valid !== 0) {
                header('Location: index.php?page=change_username&new_username=' . $new_username . '&new_username_confirmation=' . $new_username_confirmation);
                $_SESSION['change_error'] = $valid;
                exit();
            }
            // Modification bien effectué
            header('Location: index.php?page=profile');
        } else {
            // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
            header('Location: index.php?page=login');
            exit();
        }
    }

    function showChangePassword()
    {
        $pageTitle = 'Changer le mot de passe';
        ob_start();
        include 'views/change_password.php';
        $content = ob_get_clean();
        include 'views/layout.php';
    }

    function updatePassword()
    {
        $userModel = new UserModel();

        if ($userModel->is_connected()) {

            $new_password = $_POST['new_password'];
            $new_password_confirmation = $_POST['new_password_confirmation'];
            $userModel->changePassword($_POST['password'], $new_password, $new_password_confirmation);

            if (isset($_SESSION["change_error"])) {
                header('Location: index.php?page=change_password');
                exit();
            } else { // Redirigez vers la page de profil après la mise à jour
                header('Location: index.php?page=profile');
                exit();
            }
        } else {
            // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
            header('Location: index.php?page=login');
            exit();
        }
    }
}
