<?php

require "../config/bd.php";

include "../config/bd.php";


if(isset($_REQUEST["type_parascolaire"]) &&
   isset($_REQUEST["montant_parascolaire"]) 
) {
    try {
        $type = $_REQUEST["type_parascolaire"];
        $montant = $_REQUEST["montant_parascolaire"];

        $sql = "insert into parascolaires(type,montant) values('$type','$montant')";
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