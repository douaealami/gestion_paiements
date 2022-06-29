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

// Lister toutes les scolarités
$sel_sql="select s.id_scolarité, s.annee_scolaire, s.avance, s.date_paiement, s.mensualité, s.id_eleve, concat(upper(e.nom),', ',e.prenom) as nom_prenom from scolarité s inner join eleve e on e.id_eleve=s.id_eleve";

$result=mysqli_query($con,$sel_sql);
?>

<!DOCTYPE html>
<html>
<head>

    <title>Scolarité - Gestion des Paiements</title>

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
            <li class="breadcrumb-item active" aria-current="page">Scolarité</li>
        </ol>
    </nav>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCreerScolarite">
        <i class="fas fa-plus-circle"></i> <b>Créer</b>
    </button>
      <!-- modalCreerScolarite -->
    <form id="create_scolarite_form" action="scolarite/add.php">

        <div class="modal fade" id="modalCreerScolarite" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalCreerScolariteLabel"><i class="fas fa-user-plus"></i> Nouvelle scolarité</h4>
                        <a  class="fas fa-times" data-dismiss="modal" aria-label="Close" style="cursor: pointer;"></a>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" class="ui form">
                            <label>Eleve</label>
                              <div class="ui input">
                                <select id="id_eleve_scolarite" name="id_eleve_scolarite" class="ui dropdown">
                                     <?php
                                       while($row =mysqli_fetch_array($result_el)) {
                                         //eleves
                                         $id_e=$row["id_eleve"];
                                         $np=$row["nom_prenom"];
                                    ?>
                                    <option value="<?php echo $id_e ?>"><?php echo $np; }?></option>
                                </select>
                            </div>
                            <br><br>

                            <label>Année scolaire</label>
                            <div class="ui input">
                                <input type="number"   name="annee_scolaire_scolarite" id="annee_scolaire_scolarite"  placeholder="2022" required=""/>

                            </div><br><br>

                            <label>Mensualité</label>
                            <div class="ui input">
                                <input type="number"   name="montant_scolarite" id="montant_scolarite"  placeholder="200" required=""/>

                            </div><br><br>
                             <label>Avance</label>
                            <div class="ui input">
                                <input type="number"   name="avance_scolarite" id="avance_scolarite"  placeholder="2" required=""/>

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
 <table class="ui celled table" id="tableScolarite">
        <thead>
        <tr>
            <th>Date de paiement</th>
            <th>Année scolaire</th>
            <th>Nom et prénom</th>
            <th>Mensualité</th>
            <th>Avance</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <!--select s.id_scolarité, s.annee_scolaire, s.avance, s.date_paiement, s.mensualité, s.id_eleve, concat(upper(e.nom),", ",e.prenom) as nom_prenom from scolarité s inner join eleve e on e.id_eleve=s.id_eleves-->
        	 <?php
    $i=0;
    while($row =mysqli_fetch_array($result)) {
        //Cantine
        $id=$row["id_scolarité"];
        $annee_scolaire=$row["annee_scolaire"];
        $avance=$row["avance"];
        $date_paiement=$row["date_paiement"];
        $mensualite=$row["mensualité"];
        $id_eleve=$row["id_eleve"];
        $nom_prenom=$row["nom_prenom"];
        $i++;
        ?>
        <tr>
            <td data-s-id="<?php echo $id?>" hidden ></td>
            <td data-s-date-paiement="<?php echo $date_paiement ?>"><?php echo $date_paiement; ?></td>
            <td data-s-annee-scolaire="<?php echo $annee_scolaire ?>" ><?php echo $annee_scolaire; ?></td>
            <td data-s-nom-prenom="<?php echo $nom_prenom ?>"> <?php echo $nom_prenom ?></td>
            <td data-s-mensualite="<?php echo $mensualite ?>"> <?php echo $mensualite." DH" ?></td>
            <td data-s-avance="<?php echo $avance ?>"> <?php echo ($avance==0? "<span class='ui red label'>AUCUN</span>":$avance) ?></td>

            <td>
                <a href="scolarite/delete.php?id=<?php echo $id; ?>" class="ui red button" onclick="return confirm('Confirmer?');return false;">
                    Supprimer
                </a>
                <button id="btn_modal_edit_scolarite" type="button" class="ui blue button" data-toggle="modal" data-target="#modalEditerScolarite_<?php echo $id; ?>">Editer</button> 


                <button id="btn_modal_recu_scolarite" type="button" class="ui yellow button" data-toggle="modal" data-target="#modalRecuScolarite_<?php echo $id?>">Reçu</button>

                <!-- modalRecuScolarite -->

                 <div class="modal fade" id="modalRecuScolarite_<?php echo $id; ?>" tabindex="2"  data-modal-id="modal-recu-<?php $id ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalRecuScolariteEntete"><i class="fas fa-book"></i> RECU : <?php echo $nom_prenom ." (".$date_paiement.")";?></h4>
                        <a  class="fas fa-times" data-dismiss="modal" aria-label="Close" style="cursor: pointer;"></a>
                    </div>
                    <div class="modal-body">
                        <form method="get" action="" class="well">
                            <label>Date de Paiement:</label> <label data-recu-paiement="<?php echo $date_paiement ?>"><b><?php echo $date_paiement ?></b></label>
                            <br><br>

                             <label>Année scolaire:</label> <label data-recu-annee-scolaire="<?php echo $annee_scolaire ?>"><b><?php echo $annee_scolaire ?></b></label>
                            <br><br>

                            <label>Mensualité:</label> <label data-recu-mensualite="<?php echo $mensualite?>"><b><?php echo $mensualite." DH" ?></b></label>
                            <br><br>

                             <label>Avance: </label> <label data-recu-avance="<?php echo $avance?>"><?php echo ($avance==0? "<span class='ui red label'>AUCUN</span>":$avance) ?></label>
                            <br><br>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="ui blue button" onclick="return confirm('Confirmer?');return false;" data-recu-id="<?php echo $id?>" name="download_recu_scolarite_<?php echo $id?>" id="download_recu_scolarite">
                    Télécharger</button>
                </a>
                    </div>
                </div><
            </div>
        </div><!-- end modalRecuScolarite -->
            </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>

<?php } ?>

    <?php include("footer.php");?>
    <?php include("header.php"); ?>
</body>
</html>