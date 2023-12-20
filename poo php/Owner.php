<?php
include "users.php";
include "pr.php";

class Owner extends Users {
    
    public function getAllProjects() {
        $sql = "SELECT * FROM projets";
        $statement = $this->connection->query($sql);
        
        $projects = [];
        
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $project = new Project(
                $row['nom_projet'],
                $row['description'],
                $row['date_debut'],
                $row['date_fin'],
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

}
?>
