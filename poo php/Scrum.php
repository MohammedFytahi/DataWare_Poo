<?php
include "connexion.php";
include "users.php";
include "Team.php";

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
            // Pass the fourth parameter (id) to the Team constructor
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

    // ... other methods
}
?>
