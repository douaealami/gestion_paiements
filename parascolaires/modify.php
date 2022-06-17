<?php
include("../config/bd.php");

if(isset($_POST["update_parascolaire"])) {
    $id = $_GET["id"];
    $type = $_POST["type_edit_parascolaire"];
    $montant = $_POST["montant_edit_parascolaire"];

    $sql="update parascolaires set type='$type', montant='$montant' where id_parascolaire=$id";

    $q = mysqli_query($con, $sql);

    $count = mysqli_num_rows($q);

    if($q) {
    	echo "<script>alert('Activité parascolaire '".$type." modifiée avec succès.')</script>";
        echo "<script>window.open('../parascolaire.php?edit=ok','_self')</script>";

    }
    else {
    	echo "<script>alert('Echec de la suppression du parascolaire: ".$matricule." .')</script>";
        echo "<script>window.open('../parascolaire.php?edit=ko','_self')</script>";
    }
    echo $count;

}


