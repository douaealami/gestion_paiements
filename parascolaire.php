<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.open('login.php?auth=no','_self')</script>";
}
else {

require("config/bd.php");


// Lister toutes les parascolaires
$sel_sql="select * from parascolaires order by type asc";

$result=mysqli_query($con,$sel_sql);
?>

<!DOCTYPE html>
<html>
<head>

    <title>Activités parascolaires - Gestion des Paiements</title>

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
            <li class="breadcrumb-item active" aria-current="page">Activités parascolaires</li>
        </ol>
    </nav>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCreerParascolaire">
        <i class="fas fa-plus-circle"></i> <b>Créer</b>
    </button>
    <!-- modalCreerParascolaire-->
    <form id="create_parascolaire_form" action="parascolaires/add.php">

        <div class="modal fade" id="modalCreerParascolaire" tabindex="-1" aria-labelledby="modalCreerParascolaireLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalCreerParascolaireLabel"><i class="fas fa-user-plus"></i> Nouvelle Activité parascolaire</h4>
                        <a  class="fas fa-times" data-dismiss="modal" aria-label="Close" style="cursor: pointer;"></a>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" class="well">
                            <label>Type</label>
                            <div class="ui input">
                                <input type="text" name="type_parascolaire" id="type_parascolaire" placeholder="Théâtre" required="">
                            </div>
                            <br><br>
                            <label>Montant</label>
                            <div class="ui input">
                                <input type="number" name="montant_parascolaire" id="montant_parascolaire"  placeholder="200" required=""/>

                            </div><br><br>
                             <label>Description</label>
                            <div class="ui input">
                                <input type="text" name="description_parascolaire" id="description_parascolaire"  placeholder="Description activité..."/>

                            </div>
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

    <table class="ui celled table" id="tableParascolaire">
        <thead>
        <tr>
            <th>Type</th>
            <th>Montant</th>
            <th>Description</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
    <?php
    $i=0;
    while($row =mysqli_fetch_array($result)) {
        //Parascolaire
        $id=$row["id_parscolaires"];
        $type=$row["type"];
        $montant=$row["montant"];
        $description=$row["description"];
        $i++;
        ?>
        <tr>
            <td data-ps-id="<?php echo $id?>" hidden ></td>
            <td data-ps-type="<?php echo $type ?>"?><?php echo $type ?> </td>
            <td data-ps-montant="<?php echo $montant ?>" ><?php echo $montant." DH"; ?></td>
            <td data-ps-description="<?php echo $description ?>" ><?php echo $description; ?></td>
            <td>
                <a href="parascolaires/delete.php?id=<?php echo $id; ?>" class="ui red button" onclick="return confirm('Confirmer?');return false;">
                    Supprimer
                </a>
                <button id="btn_modal_edit_parascolaire" type="button" class="ui blue button" data-toggle="modal" data-target="#modalEditerParascolaire_<?php echo $id; ?>">Editer</button> 

                <!-- modalParascolaireEdit-->
                <div class="modal fade" id="modalEditerParascolaire_<?php echo $id; ?>" tabindex="2">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalCreerParascolaireLabel"><i class="fas fa-user-plus"></i> Modifier l'activité : <?php echo $type;?></h4>
                        <a  class="fas fa-times" data-dismiss="modal" aria-label="Close" style="cursor: pointer;"></a>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" class="well">
                            <label>Gamme</label>
                            <div class="ui input">
                                <input type="text" name="type_edit_parascolaire" id="gamme_edit_parascolaire"  value="<?php echo $type ?>">
                            </div>
                            <br><br>
                            <label>Prix</label>
                            <div class="ui input">
                                <input type="number"  name="montant_edit_parascolaire" id="prix_edit_parascolaire" value="<?php echo $montant?>" required=""/>
                            </div><br><br>
                            <label>Description</label>
                            <div class="ui input">
                                <input type="text"  name="description_edit_parascolaire" id="description_edit_parascolaire" value="<?php echo $description?>" required=""/>
                            </div><br><br>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button class="ui blue button" onclick="return confirm('Confirmer?');return false;" data-parascolaire-id="<?php echo $id?>" name="update_parascolaire" id="update_parascolaire">
                    Sauvegarder
                </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modalEditParascolaire -->
            </td>
       </tr>
   <?php }?>
    </tbody>
    </table>
    <small>Total: <?php echo $i;?></small>
<?php }?>
</div>
    <?php include("footer.php");?>
    <?php include("header.php"); ?>
    </body>
    </html>