<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.open('login.php?auth=no','_self')</script>";
}
else {

require("config/bd.php");


// Lister tous les cours supplémentaires
$sel_sql="select * from supplementaires";

$result=mysqli_query($con,$sel_sql);
?>

<!DOCTYPE html>
<html>
<head>

    <title>Transport - Gestion des Paiements</title>

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
            <li class="breadcrumb-item active" aria-current="page">Transport</li>
        </ol>
    </nav>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCreerTransport">
        <i class="fas fa-plus-circle"></i> <b>Créer</b>
    </button>
    <!-- modalCreerTransport-->
    <form id="create_transport_form" action="transport/add.php">

        <div class="modal fade" id="modalCreerTransport" tabindex="-1" aria-labelledby="modalCreerTransportLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalCreerTransportLabel"><i class="fas fa-user-plus"></i> Nouveau Transport</h4>
                        <a  class="fas fa-times" data-dismiss="modal" aria-label="Close" style="cursor: pointer;"></a>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" class="well">
                            <label>Matricule</label>
                            <div class="ui input">
                                <input type="text" name="matricule_transport" id="matricule_transport" placeholder="59-A-123456" aria-label="matricule_transport" aria-describedby="basic-addon1">
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
                                <input type="montant"  class="ui input" name="montant_transport" id="montant_Transport"  placeholder="200" required=""/>

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

    <table class="ui celled table" id="tableTransport">
        <thead>
        <tr>
            <th>Matricule</th>
            <th>Capacité</th>
            <th>Trajectoire</th>
            <th>Montant</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
    <?php
    $i=0;
    while($row =mysqli_fetch_array($result)) {
        //Transport
        $id=$row["id_transport"];
        $matricule=$row["matricule"];
        $capacite=$row["capacite"];
        $trajectoire=$row["trajectoire"];
        $montant=$row["montant"];
        $i++;
        ?>
        <tr>
            <td data-tr-id="<?php echo $id?>" hidden ></td>
            <td data-tr-matricule="<?php echo $matricule ?>"><?php echo $matricule; ?></td>
            <td data-tr-capacite="<?php echo $capacite ?>" ><?php echo $capacite; ?></td>
            <td data-tr-trajectoire="<?php echo $$trajectoire?>"><?php echo $trajectoire; ?></td>
            <td data-tr-montant="<?php echo $montant ?> "><?php echo $montant; ?></td>

            <td>
                <a href="transport/delete.php?id=<?php echo $id; ?>" class="ui red button" onclick="return confirm('Confirmer?');return false;">
                    Supprimer
                </a>
                <button id="btn_modal_edit_transport" type="button" class="ui blue button" data-toggle="modal" data-target="#modalEditerTransport_<?php echo $id; ?>">Editer</button> 

                <!-- modalTransportEdit-->
                <div class="modal fade" id="modalEditerTransport_<?php echo $id; ?>" tabindex="2">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalCreerTransportLabel"><i class="fas fa-user-plus"></i> Modifier le transport : <?php echo $matricule;?></h4>
                        <a  class="fas fa-times" data-dismiss="modal" aria-label="Close" style="cursor: pointer;"></a>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" class="well">
                            <label>Matricule</label>
                            <div class="ui input">
                                <input type="text" name="matricule_edit_transport" id="matricule_edit_transport"  value="<?php echo $matricule ?>" aria-label="matricule_edit_transport" aria-describedby="basic-addon1">
                            </div>
                            <br><br>
                            <label>Capacité</label>
                            <div class="ui input">
                                <input type="number"   name="capacite_edit_transport" id="capacite_edit_transport" value="<?php echo $capacite?>" required=""/>

                            </div><br><br>
                            <label>Trajectoire:</label>
                            <div class="ui input">
                                <input type="text"  name="trajectoire_edit_transport" id="trajectoire_edit_transport" value="<?php echo $trajectoire ?>"   required=""/>
                            </div><br><br>
                            <label>Montant</label>
                            <div class="ui input">
                                <input type="text"  class="ui input" name="montant_edit_transport" id="montant_edit_transport"  value="<?php echo $montant; ?>" required=""/>

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
        <!-- end modalEditTransport -->
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