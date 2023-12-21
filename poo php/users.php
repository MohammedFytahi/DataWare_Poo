<?php

class Users
{
    protected $nom;
    protected $prenom;
    protected $email;
    protected $tel;
    protected $role;
    protected $password;
    protected $equipe;
    protected $statut;
    protected $connection;


   
    public function __construct($nom = null, $prenom = null, $email = null, $tel = null, $role = null, $equipe = null, $statut = null, $connection = null)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->tel = $tel;
        $this->role = $role;
        $this->equipe = $equipe;
        $this->statut = $statut;
        $this->connection = $connection;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getTel()
    {
        return $this->tel;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getEquipe()
    {
        return $this->equipe;
    }

    public function getStatut()
    {
        return $this->statut;
    }
    
    public function getConnection() {
        return $this->connection;
    }

    public static function registerUser($nom, $prenom, $email, $password)
    {
        $db = new PDO("mysql:host=localhost;dbname=dataware", "root", "");

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO users (nom, prenom, email, password) VALUES (?, ?, ?, ?)");

        $stmt->bindParam(1, $nom);
        $stmt->bindParam(2, $prenom);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $hashedPassword);

        $stmt->execute();

        echo "User registered successfully!";
    }

    public function authenticateUser($password)
    {
        $select = "SELECT * FROM users WHERE email= '$this->email' AND password= '$password'";
        $query = $this->connection->query($select);
        $row = $query->rowCount();
        $fetch = $query->fetch(PDO::FETCH_ASSOC);

        if ($row == 1) {
            $this->startSession($fetch);
        } else {
            return "L’adresse e-mail ou le mot de passe que vous avez saisi(e) n’est pas associé(e) à un compte. ";
        }
    }

    private function startSession($userData)
    {
        $username = $userData['prenom'];
        $membre = $userData['id_user'];

        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $membre;
        $_SESSION['autoriser'] = "oui";

        if ($userData["role"] == "user") {
            header("Location: mes-equpes.php");
        } elseif ($userData["role"] == "scrum_master") {
            header("Location: equipe.php");
        } else {
            header("Location: project.php");
        }
    }
}
?>
