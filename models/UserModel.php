<?php

class UserModel {
    private function db_connexion() {
        $servername = "localhost";

        $conn = new mysqli($servername, "root", "", 'magasin');
        if ($conn->connect_error){
            die("Connexion base de donnée erreur :".$conn->connect_error);
        }
        return $conn;
    }

    public function authenticate($username, $password) {
        $conn = $this->db_connexion();

        // Utilisez des déclarations préparées pour éviter les injections SQL
        $query = "SELECT * FROM utilisateurs WHERE nom_utilisateur = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Utilisez password_verify pour vérifier le mot de passe haché
            if ($password == $row["mot_de_passe"]) {
                session_start();
                $_SESSION["user_id"] = $row["id"];
                
                $_SESSION["nom_utilisateur"] = $row["nom_utilisateur"];

                // Connecté
                header("Location: index.php");
                exit();
            }
        }

        // Fermez la connexion à la base de données
        $stmt->close();
        $conn->close();
    }

    public function changeUsername($id, $new_username,$new_username_confirmation, $password){
        if ($new_username != $new_username_confirmation){
            $_SESSION["bad_confirmation"] = true;
            return;
        }
        $conn = $this->db_connexion();

        $query = "SELECT mot_de_passe FROM utilisateurs WHERE id = ".$id;
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Utilisez password_verify pour vérifier le mot de passe haché
            if ($password == $row["mot_de_passe"]) {
                $query = "UPDATE utilisateurs SET nom_utilisateur = '$new_username' WHERE id = $id";
                $stmt = $conn->prepare($query);
                $stmt->execute();
            } else {
                $_SESSION["wrong_password"] = true;
            }
        }
    }

    function changePassword($id, $password, $new_password, $new_password_confirmation) {
        if ($new_password != $new_password_confirmation){
            $_SESSION["change_error"] = "Les mots de passe ne sont pas identiques.";
            return;
        }
        $conn = $this->db_connexion();

        $query = "SELECT mot_de_passe FROM utilisateurs WHERE id = $id";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            if ($password == $row['mot_de_passe']){
                $query = "UPDATE utilisateurs SET mot_de_passe = '$new_password' WHERE id = $id";
                $stmt = $conn->prepare(($query));
                $stmt->execute();
            }else {
                $_SESSION["change_error"] = "Le  mot de passe actuel est invalide";
            }
        }
    }
}
?>
