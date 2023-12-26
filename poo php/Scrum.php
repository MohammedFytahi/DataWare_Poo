<?php

include "users.php";
include "Team.php";
include "pr.php";

class Scrum extends Users {
    private $db;

    public function __construct($nom, $prenom, $email, $tel, $equipe, $statut, $connection) {
        parent::__construct($nom, $prenom, $email, $tel, 'scrum_master', $equipe, $statut, $connection);
        $this->db = $connection;
    }

    public function getScrumDetails() {
        return "Scrum Master Details: " . $this->getNom() . " " . $this->getPrenom();
    }

    public function getAllTeams() {
        $sql = "SELECT * FROM equipe";
        $statement = $this->db->query($sql);
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

    public function assignProjectToTeam($selectedProject, $selectedTeam)
    {
        try {
            $query = "UPDATE equipe SET id_projet = :selectedProject WHERE id_equipe = :selectedTeam";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':selectedProject', $selectedProject->getIdProjet());
            $stmt->bindParam(':selectedTeam', $selectedTeam->getIdEquipe());
            $stmt->execute();

            // Redirection vers la page d'affectation après la mise à jour
            header("Location: equipe.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getProjects()
    {
        $queryProjects = "SELECT id_projet, nom_projet, description, date_debut, date_fin, statut FROM projets";
        $resultProjects = $this->db->query($queryProjects);
        $projects = [];

        while ($rowProject = $resultProjects->fetch(PDO::FETCH_ASSOC)) {
            $project = new Project(
                $rowProject['id_projet'],
                $rowProject['nom_projet'],
                $rowProject['description'],
                $rowProject['date_debut'],
                $rowProject['date_fin'],
                $rowProject['statut']
            );
            $projects[] = $project;
        }

        return $projects;
    }

    public function getTeams()
    {
        $queryTeams = "SELECT * FROM equipe";
        $resultTeams = $this->db->query($queryTeams);
        $teams = [];

        while ($rowTeam = $resultTeams->fetch(PDO::FETCH_ASSOC)) {
            $team = new Team(
                $rowTeam['nom_equipe'],
                $rowTeam['description_equipe'],
                $rowTeam['date_creation_equipe'],
                $rowTeam['id_equipe']
            );
            $teams[] = $team;
        }

        return $teams;
    }

    public function addNewTeam($nom_equipe, $description_equipe, $date_creation_equipe) {
        try {
            $stmt = $this->db->prepare("INSERT INTO equipe (nom_equipe, description_equipe, date_creation_equipe) VALUES (:nom, :description, :date_creation)");

            $stmt->bindParam(':nom', $nom_equipe);
            $stmt->bindParam(':description', $description_equipe);
            $stmt->bindParam(':date_creation', $date_creation_equipe);

            $stmt->execute();

            return "Team added successfully";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function addMemberToTeam($id_equipe, $id_user) {
        try {
            // Check if the user is already assigned to a team
            $existingTeam = $this->getUserTeam($id_user);

            if ($existingTeam) {
                return "User is already assigned to a team.";
            }

            // Update the user's team in the database
            $stmt = $this->db->prepare("UPDATE users SET id_equipe = :id_equipe WHERE id_user = :id_user");
            $stmt->bindParam(':id_equipe', $id_equipe);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->execute();

            return "User added to the team successfully";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function removeMemberFromTeam($id_equipe, $id_user) {
        try {
            // Check if the user is assigned to the specified team
            $userTeam = $this->getUserTeam($id_user);

            if (!$userTeam || $userTeam != $id_equipe) {
                return "User is not assigned to the specified team.";
            }

            // Remove the user from the team in the database
            $stmt = $this->db->prepare("UPDATE users SET id_equipe = NULL WHERE id_user = :id_user");
            $stmt->bindParam(':id_user', $id_user);
            $stmt->execute();

            return "User removed from the team successfully";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getUserTeam($id_user) {
        $stmt = $this->db->prepare("SELECT id_equipe FROM users WHERE id_user = :id_user");
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result && isset($result['id_equipe']) ? $result['id_equipe'] : null;
    }

    // Add this method to get a project by ID
    public function getProjectById($project_id) {
        $stmt = $this->db->prepare("SELECT * FROM projets WHERE id_projet = :project_id");
        $stmt->bindParam(':project_id', $project_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new Project(
                $result['id_projet'],
                $result['nom_projet'],
                $result['description'],
                $result['date_debut'],
                $result['date_fin'],
                $result['statut']
            );
        } else {
            return null;
        }
    }

    // Add this method to get a team by ID
    public function getTeamById($team_id) {
        $stmt = $this->db->prepare("SELECT * FROM equipe WHERE id_equipe = :team_id");
        $stmt->bindParam(':team_id', $team_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new Team(
                $result['nom_equipe'],
                $result['description_equipe'],
                $result['date_creation_equipe'],
                $result['id_equipe']
            );
        } else {
            return null;
        }
    }

    public function modifyTeam($teamId, $updatedNomEquipe, $updatedDescriptionEquipe) {
        try {
            $query = "UPDATE equipe SET nom_equipe = :updatedNomEquipe, description_equipe = :updatedDescriptionEquipe WHERE id_equipe = :teamId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':updatedNomEquipe', $updatedNomEquipe);
            $stmt->bindParam(':updatedDescriptionEquipe', $updatedDescriptionEquipe);
            $stmt->bindParam(':teamId', $teamId);
            $stmt->execute();

            return "Team modified successfully";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function deleteTeam($teamId) {
        try {
            // Start a transaction
            $this->db->beginTransaction();

            // SQL query to delete projects associated with the team
            $deleteProjectsQuery = "DELETE FROM projets WHERE equipe_id = :teamId";
            $stmtProjects = $this->db->prepare($deleteProjectsQuery);
            $stmtProjects->bindParam(':teamId', $teamId);
            $stmtProjects->execute();

            // Check if the projects deletion was successful
            if ($stmtProjects) {
                // SQL query to delete the team
                $deleteTeamQuery = "DELETE FROM equipe WHERE id_equipe = :teamId";
                $stmtTeam = $this->db->prepare($deleteTeamQuery);
                $stmtTeam->bindParam(':teamId', $teamId);
                $stmtTeam->execute();

                // Check if the team deletion was successful
                if ($stmtTeam) {
                    // Commit the transaction
                    $this->db->commit();
                    header("location:equipe.php");
                } else {
                    // Rollback the transaction in case of an error
                    $this->db->rollBack();
                    return "Error deleting team: " . $stmtTeam->errorInfo()[2];
                }
            } else {
                // Rollback the transaction in case of an error
                $this->db->rollBack();
                return "Error deleting associated projects: " . $stmtProjects->errorInfo()[2];
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
    public function getUsersByTeam() {
        $sql = "SELECT * FROM users WHERE nom_equipe = :equipe";
        $stmt = $this->db->prepare($sql);
    
        // Store the result of $this->getEquipe() in a variable
        $equipeValue = $this->getEquipe();
    
        // Pass the variable to bindParam
        $stmt->bindParam(':equipe', $equipeValue);
        $stmt->execute();
        $users = [];
    
        // Debug statements
        echo "SQL Query: $sql\n";
        echo "Rows Fetched: " . $stmt->rowCount() . "\n";
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new Users(
                $row['nom'],
                $row['prenom'],
                $row['email'],
                $row['tel'],
                $row['role'],
                $row['equipe'],
                $row['statut'],
                $this->db
            );
            $users[] = $user;
        }
    
        return $users;
    }
    
}
    
?>
