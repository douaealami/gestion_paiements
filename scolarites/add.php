<?php

require "../config/bd.php";
//include "../config/bd.php";

function creer($scolarite) {
    
require "../config/bd.php";

if(isset($_REQUEST["annee_scolaire_scolarite"]) &&
   isset($_REQUEST["avance_scolarite"]) &&
   isset($_REQUEST["id_eleve_scolarite"]) &&
   isset($_REQUEST["mensualite_scolarite"]) 
) {
        try {
        $annee_scolaire = $_REQUEST["annee_scolaire_scolarite"];
        $avance = $_REQUEST["avance_scolarite"];
        $id_eleve = $_REQUEST["id_eleve_scolarite"];
        $mensualite = $_REQUEST["mensualite_scolarite"];

         $sql = "insert into scolarité(annee_scolaire,avance,date_paiement,id_eleve,mensualité) values('$annee_scolaire','$avance',now(),'$id_eleve','$mensualite')";
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
}

?>