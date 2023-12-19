<?php
include "connexion.php";
include "users.php";
class Scrum extends Users {
    private $user;

 
    public function __construct($nom, $prenom, $email, $tel, $equipe, $statut) {
        $this->user = new Users($nom, $prenom, $email, $tel, 'scrum_master', $equipe, $statut);
    }
   

    public function getScrumDetails() {
        
        return "Scrum Master Details: " . $this->getNom() . " " . $this->getPrenom();
    }

    
    public function addNewTeam($nom_equipe, $description_equipe, $date_creation_equipe) {
       
        $db = new PDO("mysql:host=localhost;dbname=dataware", "root", "");

       
        $stmt = $db->prepare("INSERT INTO equipe (nom_equipe, description_equipe, date_creation_equipe) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $nom_equipe);
        $stmt->bindParam(2, $description_equipe);
        $stmt->bindParam(3, $date_creation_equipe);

        
        $stmt->execute();
    }

    public function addMemberToTeam($id_equipe, $id_user) {
        $db = new PDO("mysql:host=localhost;dbname=dataware", "root", "");

     
        $userQuery = "SELECT * FROM users WHERE id_user = $id_user";
        $equipeQuery = "SELECT * FROM equipe WHERE id_equipe = $id_equipe";

        $userResult = $db->query($userQuery);
        $equipeResult = $db->query($equipeQuery);

        if ($userResult->rowCount() > 0 && $equipeResult->rowCount() > 0) {
          
            $updateQuery = "UPDATE users SET nom_equipe = (SELECT nom_equipe FROM equipe WHERE id_equipe = $id_equipe), id_equipe = $id_equipe WHERE id_user = $id_user";
            $resultUpdate = $db->query($updateQuery);

            if ($resultUpdate) {
                return "Utilisateur ajouté à l'équipe avec succès.";
            } else {
                return "Erreur lors de la mise à jour du champ nom_equipe : " . implode(" ", $db->errorInfo());
            }
        } else {
            return "L'utilisateur ou l'équipe n'existe pas.";
        }
    }
    public function removeMemberFromTeam($id_equipe, $id_user) {
        $db = new PDO("mysql:host=localhost;dbname=dataware", "root", "");
    
        $updateQuery = "UPDATE users SET nom_equipe = NULL WHERE id_user = $id_user AND nom_equipe = (SELECT nom_equipe FROM equipe WHERE id_equipe = $id_equipe)";
        $resultUpdate = $db->query($updateQuery);
    
        if ($resultUpdate) {
            return "Membre retiré de l'équipe avec succès.";
        } else {
            return "Erreur lors de la mise à jour du champ nom_equipe : " . implode(" ", $db->errorInfo());
        }
    }
    
}

?>


