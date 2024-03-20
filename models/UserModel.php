<?php

class Roles
{
    const HOTE_DE_CAISSE = 'hote_de_caisse';
    const CLIENT = 'client';
    const RESPONSABLE = 'responsable';
    const MAGASINIER = 'magasinier';
}
class UserModel
{
    private function db_connexion()
    {
        $servername = "localhost";

        $conn = new mysqli($servername, "root", "", 'magasin');
        if ($conn->connect_error) {
            die("Connexion base de donnée erreur :" . $conn->connect_error);
        }
        return $conn;
    }

    public function executeQuery($query, $params = array())
    {
        $conn = $this->db_connexion();

        $stmt = $conn->prepare($query);

        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        // TODO Verifier si il n'y a pas d'erreurs dans la requête. Si oui la retourné.

        $stmt->close();
        $conn->close();
        return $result;
    }

    public function getRowByQuery($query, $param = array())
    {
        $result = $this->executeQuery($query, $param);
        return $result->fetch_assoc();
    }
    public function authenticate($username, $password)
    {
        // Utilisez des déclarations préparées pour éviter les injections SQL
        $query = "SELECT * FROM utilisateurs WHERE nom_utilisateur = ?";
        $row = $this->getRowByQuery($query, array($username));
        if (!empty($row)) {
            // Utilisez password_verify pour vérifier le mot de passe haché
            if ($password == $row["mot_de_passe"]) {
                session_start();
                $_SESSION["id"] = $row["id"];
                $_SESSION["nom_utilisateur"] = $row["nom_utilisateur"];
                $_SESSION["email"] = $row["email"];
                $_SESSION["role"] = $row["role"];
                // Connecté
                header("Location: index.php");
                exit();
            }
        }
    }

    public function is_connected()
    {
        if (isset($_SESSION["id"])) {
            return true;
        } else {
            return false;
        }
    }
    public function createAccount($username, $password, $email, $role)
    {
        $query = "INSERT INTO `utilisateurs` (`nom_utilisateur`, `mot_de_passe`, `email`, `role`) VALUES (?,?,?,?);";

        $req = $this->executeQuery($query, array($username, $password, $email, $role));
        if ($req !== false) {
            $_SESSION["register_error"] = "Erreur lors de l'ajout de l'enregistrement.";
            unset($_SESSION["register_error"]);
        }
    }

    public function changeUsername($new_username, $new_username_confirmation, $password)
    {
        if ($new_username != $new_username_confirmation) {
            return "Les noms ne sont pas identiques";
        }

        $query = "SELECT mot_de_passe FROM utilisateurs WHERE id = ?";
        $row =  $this->getRowByQuery($query, array($_SESSION["id"]));

        if (!empty($row)) {
            if ($password == $row["mot_de_passe"]) {
                $query = "UPDATE utilisateurs SET nom_utilisateur = ? WHERE id = ?";
                $result = $this->executeQuery($query, array($new_username, $_SESSION["id"]));
                if ($result === true) {
                    return "Erreur lors de la mise à jour du nom d'utilisateur";
                }
            } else {
                return "Le mot de passe fournis est incorect";
            }
        }
        return 0;
    }

    function changePassword($password, $new_password, $new_password_confirmation)
    {
        if ($new_password != $new_password_confirmation) {
            $_SESSION["change_error"] = "Les mots de passe ne sont pas identiques.";
            return;
        }
        $query = "SELECT mot_de_passe FROM utilisateurs WHERE id = ?";
        $row = $this->getRowByQuery($query, array($_SESSION["id"]));

        if (sizeof($row) > 0) {
            if ($password == $row['mot_de_passe']) {
                $query = "UPDATE utilisateurs SET mot_de_passe = ? WHERE id = ?";
                $this->executeQuery($query, array($new_password, $_SESSION["id"]));
            } else {
                $_SESSION["change_error"] = "Le  mot de passe actuel est invalide";
            }
        }
    }


    public function reloadQrCodeData()
    {
        if (!isset($_SESSION["id"]))
            return 1;

        $query = "SELECT EXISTS(SELECT 1 FROM utilisateurs WHERE qrcode_data = ?);";
        do {
            $qr_code = uniqid(mt_rand(), true);
            $qrcode_exist = $this->executeQuery($query, array($qr_code));
        } while (!$qrcode_exist);

        $query = "UPDATE utilisateurs SET qrcode_data = ? WHERE id = ?";
        return $this->executeQuery($query, array($qr_code, $_SESSION["id"]));
    }

    public function showQrCodeImage()
    {
        if (!isset($_SESSION["id"]))
            return 1;

        $this->reloadQrCodeData();
        $query = "SELECT qrcode_data FROM utilisateurs WHERE id = ?";
        $row = $this->getRowByQuery($query, array($_SESSION["id"]));

        ob_start();
        QRcode::png($row["qrcode_data"], null, QR_ECLEVEL_L, 10);
        $qrCodeImage = ob_get_contents();
        ob_end_clean();

        echo '<img style="height:250px;" src="data:image/png;base64,' . base64_encode($qrCodeImage) . '"/>';
        return 0;
    }
}
