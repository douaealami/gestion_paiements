<?php
include("../config/bd.php");

if(isset($_POST["update_cantine"])) {
    $id = $_GET["id"];
    $gamme = $_POST["gamme_edit_cantine"];
    $prix = $_POST["prix_edit_cantine"];
    $is_disponible = $_POST["is_disponible_edit_cantine"];
    $description = $_POST["description_edit_cantine"];

    $sql="update cantine set gamme='$gamme', prix='$prix', is_disponible='$is_disponible', description='$description' where id_cantine=$id";

    $q = mysqli_query($con, $sql);

    $count = mysqli_num_rows($q);

    if($q) {
    	echo "<script>alert('cantine '".$gamme." modifiée avec succès.')</script>";
        echo "<script>window.open('../cantine.php?edit=ok','_self')</script>";

    }
    else {
    	echo "<script>alert('Echec de la suppression de la cantine: ".$gamme." .')</script>";
        echo "<script>window.open('../cantine.php?edit=ko','_self')</script>";


    }
    echo $count;

}


