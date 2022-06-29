<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.open('login.php?auth=no','_self')</script>";
}
else {

require("config/bd.php");


// Lister tous les cours sup
$sel_sql="select * from supplementaires";

$result=mysqli_query($con,$sel_sql);
?>

<!DOCTYPE html>
<html>
<head>

    <title>Cours supplémentaires - Gestion des Paiements</title>

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
            <li class="breadcrumb-item active" aria-current="page">Cours Sup</li>
        </ol>
    </nav>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCreerCoursSup">
        <i class="fas fa-plus-circle"></i> <b>Créer</b>
    </button>
      <!-- modalCreerCoursSup select id_supplementaires,matiere,montant,nbr_heures from supplementaires-->
    <form id="create_coursup_form" action="courssup/add.php">

        <div class="modal fade" id="modalCreerCoursSup" tabindex="-1" aria-labelledby="modalCreerCoursSupLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalCreerCoursSupLabel"><i class="fas fa-user-plus"></i> Nouveau Cours SUp</h4>
                        <a  class="fas fa-times" data-dismiss="modal" aria-label="Close" style="cursor: pointer;"></a>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" class="well">
                            <label>Matière</label>
                            <div class="ui input">
                                <input type="text" name="matiere_courssup" id="matiere_courssup" placeholder="Mathématiques">
                            </div>
                            <br><br>
                            <label>Montant</label>
                            <div class="ui input">
                                <input type="number"   name="montant_courssup" id="montant_courssup"  placeholder="200" required=""/>

                            </div><br><br>
                             <label>Nombre d'heures</label>
                            <div class="ui input">
                                <input type="number"   name="nbr_heures_courssup" id="nbr_heures_courssup"  placeholder="2" required=""/>

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
 <table class="ui celled table" id="tableCoursSup">
        <thead>
        <tr>
            <th>Matière</th>
            <th>Montant</th>
            <th>Nombre d'heures</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        	 <?php
    $i=0;
    while($row =mysqli_fetch_array($result)) {
        //Cantine
        $id=$row["id_supplementaires"];
        $matiere=$row["matiere"];
        $montant=$row["montant"];
        $nbr_heures=$row["nbr_heures"];
        $i++;
        ?>
        <tr>
            <td data-cs-id="<?php echo $id?>" hidden ></td>
            <td data-cs-matiere="<?php echo $matiere ?>"><?php echo $matiere; ?></td>
            <td data-cs-montant="<?php echo $montant ?>" ><?php echo $montant; ?></td>
            <td data-cs-nbr_heures="<?php echo $nbr_heures ?>"> <?php echo $nbr_heures ?></td>

            <td>
                <a href="courssup/delete.php?id=<?php echo $id; ?>" class="ui red button" onclick="return confirm('Confirmer?');return false;">
                    Supprimer
                </a>
                <button id="btn_modal_edit_cantine" type="button" class="ui blue button" data-toggle="modal" data-target="#modalEditerCoursSup_<?php echo $id; ?>">Editer</button> </td>
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