<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("connexion.php");

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

    protected $erreur_nom;
    protected $erreur_prenom;
    protected $erreur_email;
    protected $erreur_mot_de_passe;


   
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
        $this->erreur_nom = null;
        $this->erreur_prenom = null;
        $this->erreur_email = null;
        $this->erreur_mot_de_passe = null;
       
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
    private function validate($nom, $prenom, $email, $mot_de_passe)
    {
        $patterns = [
            'nom' => '/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]{3,}$/u',
            'prenom' => '/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]{3,}$/u',
            'email' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'mot_de_passe' => '/^.{8,}$/',
        ];

        foreach ($patterns as $field => $pattern) {
            if (!preg_match($pattern, ${$field})) {
                $errorKey = "erreur_" . $field;
                $this->$errorKey = "Veuillez entrer un $field valide.";
                echo "Erreur $field: " . $this->$errorKey . "<br>";
            }
        }
    }

    public static function registerUser($nom, $prenom, $email, $password)
    {
        $db = new PDO("mysql:host=localhost;dbname=dataware", "root", "");

        // Validate user input
        $user = new self($nom, $prenom, $email);
        echo "Nom: " . $user->getNom() . "<br>";
        echo "Prénom: " . $user->getPrenom() . "<br>";
        echo "Email: " . $user->getEmail() . "<br>";
        $user->validate($nom, $prenom, $email, $password);

        // Check for validation errors
        if ($user->erreur_nom || $user->erreur_prenom || $user->erreur_email || $user->erreur_mot_de_passe) {
            // Handle validation errors as needed
            // For example, you can return an array of errors or throw an exception
            $errors = [
                'erreur_nom' => $user->erreur_nom,
                'erreur_prenom' => $user->erreur_prenom,
                'erreur_email' => $user->erreur_email,
                'erreur_mot_de_passe' => $user->erreur_mot_de_passe,
            ];
            return $errors;
        }

        // Proceed with user registration
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO users (nom, prenom, email, password) VALUES (?, ?, ?, ?)");

        $stmt->bindParam(1, $nom);
        $stmt->bindParam(2, $prenom);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $hashedPassword);

        $stmt->execute();

        return "User registered successfully!";
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
            header("Location: mes-equipes.php");
        } elseif ($userData["role"] == "scrum_master") {
            header("Location: equipe.php");
        } else {
            header("Location: project.php");
        }
    }
}
?>
