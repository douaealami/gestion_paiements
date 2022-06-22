<?php 

require "../config/bd.php";
class ParascolaireDAO {

	function getTopParascolaire() {
	require "../config/bd.php";
	$sql="select p.type as 'type', count(ep.id_parascolaires) as 'somme' from parascolaires p inner join eleve_parascolaires ep on ep.id_parascolaires=p.id_parscolaires group by p.type";
    $result=mysqli_query($con,$sql);
    $rows=Array();
    while($row =mysqli_fetch_array($result)) {
    	$rows[]=$row;
    }
    return json_encode($rows);
}
}
$paraDAO=new ParascolaireDAO();
echo $paraDAO->getTopParascolaire();

?>