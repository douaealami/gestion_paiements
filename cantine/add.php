<?php

require "../config/bd.php";

include "../config/bd.php";


if(isset($_REQUEST["gamme_cantine"]) &&
   isset($_REQUEST["prix_cantine"]) &&
   isset($_REQUEST["is_disponible_cantine"]) &&
   isset($_REQUEST["description_cantine"]) 
) {
    try {
        $gamme = $_REQUEST["gamme_cantine"];
        $prix = $_REQUEST["prix_cantine"];
        $is_disponible = $_REQUEST["is_disponible_cantine"];
        $description = $_REQUEST["description_cantine"];

        $sql = "insert into cantine values(NULL,'$gamme','$prix','$is_disponible','$description')";
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