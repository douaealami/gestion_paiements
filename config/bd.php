<?php
//include("constants/constants.php");
//include("./constants/constants.php");

$db_host="localhost";
$db_name="gestion_paiements";
$db_uid="root";
$db_pwd="";
$con = mysqli_connect($db_host,$db_uid,$db_pwd,$db_name);

if (mysqli_connect_errno()) {
	echo 'Failed to connect to MYSQL: '.$mysqli_connect_errno();
}

?>