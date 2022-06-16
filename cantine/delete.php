<?php

require "../config/bd.php";
include "../config/bd.php";


    $id=intval($_GET["id"]);
    $sql="delete from cantine where id_cantine=$id";
    $q = mysqli_query($con, $sql);

    if($q) {
        echo "<script>showInfo('cantine supprimée avec succès');</script>";
        echo "<script>window.open('../cantine.php?delete=ok','_self')</script>";
    }
else {
    echo "<script>showError('Echec de la suppression de la cantine. Veuillez réessayer plus tard.');</script>";
    echo "<script>window.open('./cantine.php?delete=ko','_self')</script>";
}