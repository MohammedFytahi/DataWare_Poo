<?php
include_once 'users.php';
include_once 'pr.php';
include_once 'Team.php';

class Owner extends Users {

    public function __construct($nom, $prenom, $email, $tel, $role, $equipe, $statut, $connection)
    {
        parent::__construct($nom, $prenom, $email, $tel, $role, $equipe, $statut, $connection);
    }

    
    public function getAllProjects() {
        $sql = "SELECT * FROM projets";
        $statement = $this->connection->query($sql);
        
        $projects = [];
        
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $project = new Project(
                $row['id_projet'],
                $row['nom_projet'], // Mettez à jour cette ligne
                $row['description'],
                $row['date_debut'], // Mettez à jour cette ligne
                $row['date_fin'],   // Mettez à jour cette ligne
                $row['statut']
            );
            
            $projects[] = $project;
        }
        
        return $projects;
    }
    
    public function deleteProject($projectId) {
        $sql = "DELETE FROM projets WHERE id_projet = :id_projet";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id_projet', $projectId, PDO::PARAM_INT);
    
        try {
            $statement->execute();
            return true;
        } catch (PDOException $e) {

            echo "Error deleting project: " . $e->getMessage();
            return false;
        }
    }
    

  
    public function getProjectData($projectId)
    {
        $query = "SELECT * FROM projets WHERE id_projet = :project_id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':project_id', $projectId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function addProject($nomProjet, $description, $dateDebut, $dateFin, $statut)
    {
        $requeteProjet = "INSERT INTO projets (nom_projet, description, date_debut, date_fin, statut) VALUES (?, ?, ?, ?, ?)";
        $statement = $this->connection->prepare($requeteProjet);
        $statement->bindParam(1, $nomProjet);
        $statement->bindParam(2, $description);
        $statement->bindParam(3, $dateDebut);
        $statement->bindParam(4, $dateFin);
        $statement->bindParam(5, $statut);
    
        if ($statement->execute()) {
            echo "Le projet a été ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout du projet : " . $this->connection->error;
        }
    
        $statement->closeCursor();
    }
    
    public function updateProject($projectId, $nomProjet, $description, $dateDebut, $dateFin, $statut)
    {
        $requeteProjet = "UPDATE projets 
                          SET nom_projet = ?, description = ?, date_debut = ?, date_fin = ?, statut = ? 
                          WHERE id_projet = ?";
        $statement = $this->connection->prepare($requeteProjet);
        $statement->bindParam(1, $nomProjet);
        $statement->bindParam(2, $description);
        $statement->bindParam(3, $dateDebut);
        $statement->bindParam(4, $dateFin);
        $statement->bindParam(5, $statut);
        $statement->bindParam(6, $projectId);

        if ($statement->execute()) {
            echo "Le projet a été mis à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour du projet : " . $this->connection->error;
        }

        $statement->closeCursor();
    }

    
    public function assignScrumMaster($selectedProject, $selectedScrumMaster)
    {
        $requete = "UPDATE projets SET scrum_master = ? WHERE id_projet = ?";
        $statement = $this->connection->prepare($requete);
        $statement->bindParam(1, $selectedScrumMaster);
        $statement->bindParam(2, $selectedProject);

        if ($statement->execute()) {
            echo "Scrum Master assigné avec succès.";
        } else {
            echo "Erreur lors de l'attribution du Scrum Master : " . $this->connection->error;
        }

        $statement->closeCursor();
    }

    public function getAllTeams() {
        $sql = "SELECT * FROM equipe";
        $statement = $this->connection->query($sql);
        $teams = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $team = new Team(
                $row['nom_equipe'],
                $row['description_equipe'],
                $row['date_creation_equipe'],
                $row['id_equipe']
            );
            $teams[] = $team;
        }

        return $teams;
    }
    
    public function updateUser($userId, $updatedName, $updatedEmail, $updatedRole) {
        // Vérifier les doublons d'email
        $duplicateCheck = $this->connection->prepare("SELECT id_user FROM users WHERE email = :email AND id_user != :userId");
        $duplicateCheck->bindParam(':email', $updatedEmail, PDO::PARAM_STR);
        $duplicateCheck->bindParam(':userId', $userId, PDO::PARAM_INT);
        $duplicateCheck->execute();

        if ($duplicateCheck->rowCount() > 0) {
            echo "Erreur lors de la mise à jour de l'utilisateur : Email en double.";
            exit();
        }

        // Continuer avec la mise à jour
        $updateQuery = "UPDATE users SET nom = :nom, email = :email, role = :role WHERE id_user = :userId";
        $updateStatement = $this->connection->prepare($updateQuery);
        $updateStatement->bindParam(':nom', $updatedName, PDO::PARAM_STR);
        $updateStatement->bindParam(':email', $updatedEmail, PDO::PARAM_STR);
        $updateStatement->bindParam(':role', $updatedRole, PDO::PARAM_STR);
        $updateStatement->bindParam(':userId', $userId, PDO::PARAM_INT);

        if ($updateStatement->execute()) {
            header("Location: interface.php");
        } else {
            echo "Erreur lors de la mise à jour de l'utilisateur : " . $updateStatement->errorInfo()[2];
        }
    }


}
?>
