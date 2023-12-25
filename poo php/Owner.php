<?php
include_once 'users.php';
include_once 'pr.php';

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
    


}
?>
