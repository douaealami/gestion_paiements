<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.open('login.php?auth=no','_self')</script>";
}
else {

require("config/bd.php");


// Lister toutes les cantines
$sel_sql="select * from cantine";

$result=mysqli_query($con,$sel_sql);
?>

<!DOCTYPE html>
<html>
<head>

    <title>Cantine - Gestion des Paiements</title>

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
            <li class="breadcrumb-item active" aria-current="page">Cantine</li>
        </ol>
    </nav>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCreerCantine">
        <i class="fas fa-plus-circle"></i> <b>Créer</b>
    </button>
    <!-- modalCreerCantine-->
    <form id="create_transport_form" action="transport/add.php">

        <div class="modal fade" id="modalCreerCantine" tabindex="-1" aria-labelledby="modalCreerCantineLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalCreerCantineLabel"><i class="fas fa-user-plus"></i> Nouvelle Cantine</h4>
                        <a  class="fas fa-times" data-dismiss="modal" aria-label="Close" style="cursor: pointer;"></a>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" class="well">
                            <label>Gamme</label>
                            <div class="ui input">
                                <input type="text" name="gamme_cantine" id="gamme_cantine" placeholder="GAMME-ABC">
                            </div>
                            <br><br>
                            <label>Prix</label>
                            <div class="ui input">
                                <input type="number"   name="prix_cantine" id="prix_cantine"  placeholder="200" required=""/>

                            </div><br><br>
                            <label>Disponibilité :</label>
                            <div class="ui toggle checkbox">
                              <input type="checkbox" name="is_disponible_cantine" id="is_disponible_cantine">
                            <label>Disponible ?</label>
                            </div><br><br>
                            <label>Description</label>
                            <div class="ui input">
                                <input type="text"  class="ui input" name="description_cantine" id="description_cantine"  placeholder="Description cantine ..." required=""/>

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

    <table class="ui celled table" id="tableCantine">
        <thead>
        <tr>
            <th>Gamme</th>
            <th>Prix</th>
            <th>Disponibilité</th>
            <th>Description</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
    <?php
    $i=0;
    while($row =mysqli_fetch_array($result)) {
        //Cantine
        $id=$row["id_cantine"];
        $gamme=$row["gamme"];
        $prix=$row["prix"];
        $is_disponible=$row["is_disponible"];
        $description=$row["description"];
        $i++;
        ?>
        <tr>
            <td data-ca-id="<?php echo $id?>" hidden ></td>
            <td data-ca-gamme="<?php echo $gamme ?>"><a class="ui <?php echo setGammeStyle($gamme);?> label"> <?php echo $gamme; ?></a></td>
            <td data-ca-prix="<?php echo $prix ?>" ><?php echo $prix; ?></td>
            <td data-ca-isdispo="<?php echo $is_disponible ?>">
            <div class="ui <?php echo ($is_disponible==1 ? " checked ": "") ?> read-only checkbox">
              <input type="checkbox" name="public">
             <label><?php echo ($is_disponible==1? "Oui":"Non"); ?></label>
                </div>
                </td>
            <td data-ca-description="<?php echo $description ?> "><?php echo $description; ?></td>

            <td>
                <a href="cantine/delete.php?id=<?php echo $id; ?>" class="ui red button" onclick="return confirm('Confirmer?');return false;">
                    Supprimer
                </a>
                <button id="btn_modal_edit_cantine" type="button" class="ui blue button" data-toggle="modal" data-target="#modalEditerCantine_<?php echo $id; ?>">Editer</button> 

                <!-- modalCantineEdit-->
                <div class="modal fade" id="modalEditerCantine_<?php echo $id; ?>" tabindex="2">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalCreerCantineLabel"><i class="fas fa-user-plus"></i> Modifier le cantine : <?php echo $gamme;?></h4>
                        <a  class="fas fa-times" data-dismiss="modal" aria-label="Close" style="cursor: pointer;"></a>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" class="well">
                            <label>Gamme</label>
                            <div class="ui input">
                                <input type="text" name="gamme_edit_transport" id="gamme_edit_transport"  value="<?php echo $gamme ?>">
                            </div>
                            <br><br>
                            <label>Prix</label>
                            <div class="ui input">
                                <input type="number"  name="prix_edit_transport" id="prix_edit_transport" value="<?php echo $prix?>" required=""/>

                            </div><br><br>
                            <label>Disponible:</label>
                            <div class="ui <?php ( $is_disponible==1? "checked":"") ?> checkbox">
                              <input type="checkbox" checked="<?php echo (is_disponible==1? "checked":"")?>">
                              <label>Oui / Non </label>
                            </div><br><br>
                            <label>Description</label>
                            <div class="ui input">
                                <input type="text"  class="ui input" name="description_edit_transport" id="description_edit_transport"  value="<?php echo $description; ?>" required=""/>

                            </div><br><br>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button class="ui blue button" onclick="return confirm('Confirmer?');return false;" data-cantine-id="<?php echo $id?>" name="update_cantine" id="update_transport">
                    Sauvegarder
                </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modalEditCantine -->
            </td>
       </tr>
   <?php }?>
    </tbody>
    </table>
    <small>Total: <?php echo $i;?></small>
</div>
<?php }?>
    <?php include("footer.php");?>
    <?php include("header.php"); ?>
    </body>
    </html>