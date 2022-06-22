<?php

require "../config/bd.php";
include "../config/bd.php";

 class TransportBO {
	private  $id_transport;
	private  $matricule;
    private  $trajectoire;
    private  $montant;
    private  $capacite;

    public function __construct($i,$m,$t,$mt,$c) {
        $this->id_transport=$i;
        $this->matricule=$m;
        $this->trajectoire=$t;
        $this->montant=$mt;
        $this->capacite=$c;
    }

    // GETTERS
    public function getIdTransport() {
    	return $this->id_transport;
    }

    public function getMatricule() {
    	return $this->matricule;
    }

    public function getTrajectoire() {
    	return $this->trajectoire;
    }

    public function getMontant() {
    	return $this->montant;
    }

    public function getCapacite() {
    	return $this->capacite;
    }


    // SETTERS
    public function setIdTransport($i) {
    	$this->id_transport=$i;
    }

    public function setMatricule($m) {
    	$this->matricule=$m;
    }

    public function setTrajectoire($t) {
    	$this->trajectoire=$t;
    }

    public function setMontant($mt) {
    	$this->montant=$mt;
    }

    public function setCapacite($c) {
    	$this->capacite=$c;
    }


    public function afficher() {
    	echo "matricule= ".$this->matricule;
    }
}


