<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.open('login.php?auth=no','_self')</script>";
}
else {

require("config/bd.php");

//lister tous les élèves
$sel_el="select id_eleve, concat(upper(nom),', ',prenom) as 'nom_prenom' from eleve";
$result_el=mysqli_query($con,$sel_el);

// Lister tous les paiements
$id_e=isset($_REQUEST["id_e"]);
$sel_sql="select 
p.id_paiement,
p.date_paiement as date_paiement, 
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
order by p.date_paiement desc";
/*where p.id_eleve='$id_e'";*/

$result=mysqli_query($con,$sel_sql);
?>

<!DOCTYPE html>
<html>
<head>

    <title>Paiement - Gestion des Paiements</title>

</head>

<body>

<?php require 'includes/functions.php';

//  require("config/bd.php");
?>

<?php include("menubar.php"); ?>

<div  class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Paiement</li>
        </ol>
    </nav>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCreerPaiement">
        <i class="fas fa-plus-circle"></i> <b>Créer</b>
    </button>
    <!-- modalCreerPaiement-->
    <form id="create_transport_form" action="paiements/add.php">

        <div class="modal fade" id="modalCreerPaiement" tabindex="-1" aria-labelledby="modalCreerPaiementLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalCreerPaiementLabel"><i class="fas fa-user-plus"></i> Nouveau Paiement</h4>
                        <a  class="fas fa-times" data-dismiss="modal" aria-label="Close" style="cursor: pointer;"></a>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" class="well">
                            <label>Nom & Prénom de l'élève</label>
                            <div class="ui input">
                               <!-- <select id="id_paiement_eleve" name="id_paiement_eleve" class="ui dropdown">
                                     <?php
                                       while($row =mysqli_fetch_array($result_eleve)) {
                                         //eleves
                                         $id=$row["id_eleve"];
                                         $nom_prenom=$row["nom_prenom"];
                                    ?>
                                    <option value="<?php echo $id ?>"><?php echo $nom_prenom; }?></option>
                                </select>-->
                            </div>
                            <br><br>
                            <label>Capacité</label>
                            <div class="ui input">
                                <input type="number"   name="capacite_transport" id="capacite_transport"  placeholder="20" required=""/>

                            </div><br><br>
                            <label>Trajectoire:</label>
                            <div class="ui input">
                                <input type="text"  name="trajectoire_transport" id="trajectoire_transport"  placeholder="Exemple: TRAJET-2" required=""/>
                            </div><br><br>
                            <label>Montant</label>
                            <div class="ui input">
                                <input type="montant"  class="ui input" name="montant_transport" id="montant_Paiement"  placeholder="200" required=""/>

                            </div><br><br>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" id="envoi_enregistrer" name="envoi_enregistrer" class="btn btn-primary" onclick="return confirm('Confirmer?');return false;"><i class="fas fa-check"></i> Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <br>
<select class="ui dropdown" id="id_eleves" name="id_eleves">
                                 <?php
                                       while($row=mysqli_fetch_array($result_el)) {
                                     
                                         $id_eleve=$row["id_eleve"];
                                         $nom_prenom=$row["nom_prenom"];
                                      
                                    ?>
                                    <option value="<?php echo $id_eleve ?>"><?php echo $nom_prenom ?></option>
                                <?php }?>
                                </select>
    <table class="ui celled table" id="tablePaiement">
        <thead>
        <tr>
            <th>Date Paiement</th>
            <th>Nom & Prénom</th>
            <th>Mensualité</th>
            <th>Transport</th>
            <th>Cantine</th>
            <th>Parascolaire</th>
            <th>Avance</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
    <?php
    $i=0;
    $sum_mensualite=0;
    while($row =mysqli_fetch_array($result)) {
        //Paiement
       $id=$row["id_paiement"];
       $date_paiement=$row["date_paiement"];
       $cantine =$row["type_cantine"];
       $nom_prenom_eleve=$row["nom_prenom_eleve"];
       $id_scolarite=$row["id_scolarité"];
       $mensualite=$row["mensualité"];
       $avance=$row["avance"];
       $annee=$row["annee_scolaire"];
       $transport=$row["montant_transport_transport"];
       $parascolaire=$row["montant_parascolaire_eleve"];
       $sum_mensualite+=$mensualite;
        ?>
        <tr>
            <td data-p-id="<?php echo $id?>" hidden ></td>
            <td data-p-datepaiement="<?php echo $date_paiement ?>"><?php echo $date_paiement?></td>
            <td data-p-nomprenom="<?php echo $nom_prenom_eleve ?>" ><?php echo $nom_prenom_eleve ?></td>
            <td data-p-mensualite="<?php echo $mensualite?>"><?php echo $mensualite; ?></td>
            <td data-p-transport="<?php echo $transport ?> ">
                 <?php if($transport>0) {
                 echo $transport; } else {?>
                    <i class="fas fa-2x fa-times-circle" style="color:red;cursor:pointer;" title="Ne prend pas de transport"></i>
                <?php }?>       
            </td>
            <td data-p-cantine="<?php echo $cantine ?> ">
                <?php if($cantine>0) {
                 echo $cantine; } else {?>
                    <i class="fas fa-2x fa-times-circle" style="color:red;cursor:pointer;" title="Ne mange pas à la cantine"></i>
                <?php }?>
            </td>
            <td data-p-parascolaire="<?php echo $parascolaire ?> ">
                 <?php if($parascolaire>0) {
                 echo $parascolaire; } else {?>
                    <i class="fas fa-2x fa-times-circle" style="color:red"></i>
                <?php }?>
            </td>
            <td data-p-avance="<?php echo $avance ?> "><?php echo $avance; ?></td>

            <td>
                <a href="paiements/delete.php?id=<?php echo $id; ?>" class="ui red button" onclick="return confirm('Confirmer?');return false;">
                    Supprimer
                </a>
                <button id="btn_modal_edit_transport" type="button" class="ui blue button" data-toggle="modal" data-target="#modalEditerPaiement_<?php echo $id; ?>">Editer</button> 

                <!-- modalPaiementEdit-->
                <div class="modal fade" id="modalEditerPaiement_<?php echo $id; ?>" tabindex="2">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalCreerPaiementLabel"><i class="fas fa-user-plus"></i> Modifier le transport : <?php echo $matricule;?></h4>
                        <a  class="fas fa-times" data-dismiss="modal" aria-label="Close" style="cursor: pointer;"></a>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" class="well">
                            <label>Matricule</label>
                            <div class="ui input">
                                <input type="text" name="matricule_edit_transport" id="matricule_edit_transport"  value="<?php echo $matricule ?>" aria-label="matricule_edit_transport" aria-describedby="basic-addon1">
                            </div>
                            

                            </div><br><br>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button class="ui blue button" onclick="return confirm('Confirmer?');return false;" data-transport-id="<?php echo $id?>" name="update_transport" id="update_transport">
                    Sauvegarder
                </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modalEditPaiement -->
            </td>
       </tr>
   <?php }?>
    </tbody>
    <tfooter>
        <tr>
           <td colspan="7"><b>Total: <?php echo $sum_mensualite?></b></td>
       </tr>
    </tfooter>
    </table>
    <small>Total: <?php echo $i;?></small>
<?php }?>
</div>
    <?php include("footer.php");?>
    <?php include("header.php"); ?>
    </body>
    </html>