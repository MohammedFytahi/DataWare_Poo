<?php


include "users.php";

class Membre extends Users
{
    private $db;

    public function __construct($database = null)
    {
        $this->db = $database;
    }
    

    public function getMemberTeams($memberId)
    {
        try {
            $query = "SELECT * FROM equipe INNER JOIN users ON equipe.id_equipe = users.id_equipe WHERE id_user = :memberId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':memberId', $memberId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getMemberProjects($memberId)
    {
        try {
            $query = "SELECT * FROM projets INNER JOIN equipe ON equipe.id_projet = projets.id_projet INNER JOIN users ON equipe.id_equipe = users.id_equipe WHERE id_user = :memberId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':memberId', $memberId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
