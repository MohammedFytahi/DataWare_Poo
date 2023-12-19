<?php
class Team{
    private $id;
    private $name;
    private $description;
    private $creationdate;
    public function __construct($id, $name, $description, $creationdate){
        $this->id=$id;
        $this->name=$name;
        $this->description=$description;
        $this->creationdate=$creationdate;
        
    }
    public function getId(){
        return $this->id;

    }
    public function getName(){
        return $this->name;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getCreationdate(){
        return $this->creationdate;
    }
    
    
}
