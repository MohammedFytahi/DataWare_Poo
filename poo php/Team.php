<?php

class Team {
    private $name;
    private $description;
    private $creationDate;
    private $id_equipe;

    public function __construct($name, $description, $creationDate, $id_equipe) {
        $this->name = $name;
        $this->description = $description;
        $this->creationDate = $creationDate;
        $this->id_equipe = $id_equipe;
    }

    // Add getters if needed
    public function getNomEquipe() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getIdEquipe() {
        return $this->id_equipe;
    }
}

?>
