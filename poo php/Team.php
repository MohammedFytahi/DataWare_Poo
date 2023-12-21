<?php

class Team {
    private $name;
    private $description;
    private $creationDate;

    public function __construct($name, $description, $creationDate, $id) {
        $this->name = $name;
        $this->description = $description;
        $this->creationDate = $creationDate;
        $this->id = $id;
    }

    // Add getters if needed
    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getId() {
        return $this->id;
    }
}

?>
