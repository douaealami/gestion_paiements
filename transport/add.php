<?php

require "TransportBO.php";
//include "TransportBO.php";

require "../config/bd.php";
//include "../config/bd.php";

function creer($transport) {
    
require "../config/bd.php";
        try {
        $matricule = $_REQUEST["matricule_transport"];
        $capacite = $_REQUEST["capacite_transport"];
        $trajectoire = $_REQUEST["trajectoire_transport"];
        $montant = $_REQUEST["montant_transport"];

        $transport=new TransportBO(0,$matricule,$trajectoire,$montant,$capacite);

 $sql = "insert into transport(matricule,capacite,trajectoire,montant) values('$matricule','$capacite','$trajectoire','$montant')";
        $run = mysqli_query($con, $sql);
        if ($run) {
            echo "OK";
        } else {
            echo "KO";
        }
    } catch (PDOException $ex) {
        die();
        echo $ex->getMessage();
    }
}

if(isset($_REQUEST["matricule_transport"]) &&
   isset($_REQUEST["capacite_transport"]) &&
   isset($_REQUEST["trajectoire_transport"]) &&
   isset($_REQUEST["montant_transport"]) 
) {
   try {
        $matricule = $_REQUEST["matricule_transport"];
        $capacite = $_REQUEST["capacite_transport"];
        $trajectoire = $_REQUEST["trajectoire_transport"];
        $montant = $_REQUEST["montant_transport"];
        $transport=new TransportBO(0,$matricule,$trajectoire,$montant,$capacite);
        creer($transport);
   }
   catch(PDOException $ex) {
           die();
        echo $ex->getMessage();
   }
}

/*if(isset($_REQUEST["matricule_transport"]) &&
   isset($_REQUEST["capacite_transport"]) &&
   isset($_REQUEST["trajectoire_transport"]) &&
   isset($_REQUEST["montant_transport"]) 
) {
    try {
        $matricule = $_REQUEST["matricule_transport"];
        $capacite = $_REQUEST["capacite_transport"];
        $trajectoire = $_REQUEST["trajectoire_transport"];
        $montant = $_REQUEST["montant_transport"];

        $sql = "insert into transport(matricule,capacite,trajectoire,montant) values(NULL,'$matricule','$capacite','$trajectoire','$montant')";
        $run = mysqli_query($con, $sql);
        if ($run) {
            echo "OK";
        } else {
            echo "KO";
        }
    } catch (PDOException $ex) {
        die();
        echo $ex->getMessage();
    }
}*/

?>