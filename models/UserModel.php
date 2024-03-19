<?php

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
        $conn = $this->db_connexion();

        // Utilisez des déclarations préparées pour éviter les injections SQL
        $query = "SELECT * FROM utilisateurs WHERE nom_utilisateur = ?";
        $row = $this->getRowByQuery($query, array($username));

        if (sizeof($row) > 0) {
            // Utilisez password_verify pour vérifier le mot de passe haché
            if ($password == $row["mot_de_passe"]) {
                session_start();
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["nom_utilisateur"] = $row["nom_utilisateur"];
                $_SESSION["email"] = $row["email"];
                $_SESSION["role"] = $row["role"];

                // Connecté
                header("Location: index.php");
                exit();
            }
        }

        // Fermez la connexion à la base de données
        $conn->close();
    }

    public function changeUsername($new_username, $new_username_confirmation, $password)
    {
        if ($new_username != $new_username_confirmation) {
            $_SESSION["bad_confirmation"] = true;
            return;
        }

        $query = "SELECT mot_de_passe FROM utilisateurs WHERE id = ?";
        $row =  $this->getRowByQuery($query, array($_SESSION["id"]));

        if (sizeof($row) > 0) {
            if ($password == $row["mot_de_passe"]) {
                $query = "UPDATE utilisateurs SET nom_utilisateur = ? WHERE id = ?";
                $this->executeQuery($query, array($new_username, $_SESSION["id"]));
            } else {
                $_SESSION["wrong_password"] = true;
            }
        }
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
}
