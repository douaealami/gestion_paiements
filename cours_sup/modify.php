<?php
include("../config/bd.php");

if(isset($_POST["update_transport"])) {
    $id = $_GET["id"];
    $matricule = $_POST["matricule_edit_transport"];
    $capacite = $_POST["capacite_edit_transport"];
    $trajectoire = $_POST["trajectoire_edit_transport"];
    $montant = $_POST["montant_edit_transport"];

    $sql="update transport set matricule='$matricule', capacite='$capacite', trajectoire='$trajectoire', montant='$montant' where id_transport=$id";

    $q = mysqli_query($con, $sql);

    $count = mysqli_num_rows($q);

    if($q) {
    	echo "<script>alert('Transport '".$matricule." modifié avec succès.')</script>";
        echo "<script>window.open('../transport.php?edit=ok','_self')</script>";

    }
    else {
    	echo "<script>alert('Echec de la suppression du transport: ".$matricule." .')</script>";
        echo "<script>window.open('../transport.php?edit=ko','_self')</script>";


    }
    echo $count;

}


