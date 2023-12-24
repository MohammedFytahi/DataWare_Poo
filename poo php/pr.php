<?php
class Project {
    private $id_projet;
    private $nomProjet;
    private $description;
    private $dateDebut;
    private $dateFin;
    private $statut;

    public function __construct($id_projet, $nomProjet, $description, $dateDebut, $dateFin, $statut){
        $this->id_projet = $id_projet;
        $this->nomProjet = $nomProjet;
        $this->description = $description;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->statut = $statut;
    }

    // Add getters for the other properties
    public function getIdProjet(){
        return $this->id_projet;
    }
    public function getNomProjet(){
        return $this->nomProjet;
    }

    public function getDescription(){
        return $this->description;
    }
    
    public function getDateDebut(){
        return $this->dateDebut;
    }

    public function getDateFin(){
        return $this->dateFin;
    }

    public function getStatut(){
        return $this->statut;
    }
}
