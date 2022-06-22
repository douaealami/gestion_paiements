<?php

require "PaiementBO.php";
//include "TransportBO.php";

require "../config/bd.php";
//include "../config/bd.php";

class PaiementDAO {

	function getPaiements() {
		require "../config/bd.php";
	$sql="select 
p.id_paiement,
p.date_paiement, 
c.gamme as type_cantine, 
concat(upper(e.nom),', ',e.prenom) as nom_prenom_eleve,
s.id_scolarité, 
s.mensualité, 
s.avance, 
s.annee_scolaire,
t.montant as montant_transport_transport,
sum(para.montant) as montant_parascolaire_eleve
from paiement p
inner join cantine c on c.id_cantine=p.id_cantine
inner join eleve e on e.id_eleve=p.id_eleve
inner join scolarité s on s.id_scolarité=p.id_scolarite
inner join transport t on t.id_transport=p.id_transport
inner join eleve_parascolaires ep on ep.id_eleve=e.id_eleve
inner join parascolaires para on para.id_parscolaires=ep.id_parascolaires
order by p.date_paiement desc
limit 5
";

    $result=mysqli_query($con,$sql);
    $row =mysqli_fetch_array($result);
    return json_encode($row);
	}
}

$paiementDAO=new PaiementDAO();
echo $paiementDAO->getPaiements();

?>