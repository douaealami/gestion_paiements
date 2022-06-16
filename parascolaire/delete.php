<?php

require "../config/bd.php";
include "../config/bd.php";


    $id=intval($_GET["id"]);
    $sql="delete from parascolaires where id_parascolaires=$id";
    $q = mysqli_query($con, $sql);

    if($q) {
        echo "<script>showInfo('Activité parascolaire supprimée avec succès');</script>";
        echo "<script>window.open('../parascolaire.php?delete=ok','_self')</script>";
    }
else {
    echo "<script>showError('Echec de la suppression de l'activité parascolaire. Veuillez réessayer plus tard.');</script>";
    echo "<script>window.open('./parascolaire.php?delete=ko','_self')</script>";
}