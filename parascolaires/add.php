<?php

require "../config/bd.php";

include "../config/bd.php";


if(isset($_REQUEST["type_parascolaire"]) &&
   isset($_REQUEST["montant_parascolaire"]) 
) {
    try {
        $type = $_REQUEST["type_parascolaire"];
        $montant = $_REQUEST["montant_parascolaire"];
        $description=$_REQUEST["description_parascolaire"];

        $sql = "insert into parascolaires(type,montant,description) values('$type','$montant','$description')";
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