<?php

require "../config/bd.php";
include "../config/bd.php";


    $id=intval($_GET["id"]);
    $sql="delete from transport where id_transport=$id";
    $q = mysqli_query($con, $sql);

    if($q) {
        echo "<script>showInfo('transport supprimé avec succès');</script>";
        echo "<script>window.open('../transport.php?delete=ok','_self')</script>";
    }
else {
    echo "<script>showError('Echec de la suppression du transport. Veuillez réessayer plus tard.');</script>";
    echo "<script>window.open('./transport.php?delete=ko','_self')</script>";
}