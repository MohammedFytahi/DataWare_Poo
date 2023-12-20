<?php
class Project {
    private $nomProjet;
    private $description;
    private $dateDebut;
    private $dateFin;
    private $statut;

    public function __construct($nomProjet, $description, $dateDebut, $dateFin, $statut){
        $this->nomProjet=$nomProjet;
        $this->description=$description;
        $this->dateDebut=$dateDebut;
        $this->dateFin=$dateFin;
        $this->statut=$statut;
    }

    public function getNomProjet(){
        return $this->nomProjet;
    }

    public function getdescription(){
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