<?php 

require "TransportBO.php";
//include "TransportBO.php";

require "../config/bd.php";
//include "../config/bd.php";

function getTransports() {
	require "../config/bd.php";
	$sql="select * from transport order by matricule asc";

    $result=mysqli_query($con,$sql);
    $row =mysqli_fetch_array($result);
    return json_encode($row);
}

<?