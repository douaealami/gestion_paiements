<?php

require "../config/bd.php";

include "../config/bd.php";


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

        $sql = "insert into transport values(NULL,'$matricule','$capacite','$trajectoire','$montant')";
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