<?php
include("../config/bd.php");

if(isset($_POST["update_transport"])) {
    $id = $_GET["id"];
    $matricule = $_POST["matricule_transport"];
    $capacite = $_POST["capacite_transport"];
    $trajectoire = $_POST["trajectoire_transport"];
    $montant = $_POST["montant_transport"];

    $sql="update transport set matricule='$matricule', capacite='$capacite', trajectoire='$trajectoire', montant='$montant'";

    $q = mysqli_query($con, $sql);

    $count = mysqli_num_rows($q);


    echo $count;

}


