<?php
session_start();
if (!isset($_SESSION['email'])) {
    echo "<script>window.open('login.php?auth=no','_self')</script>";
}
else {

require("config/bd.php");


// Lister tous les patients
$sel_sql="select p.id,p.cin,p.nom,p.prenom,p.sexe,p.telephone,p.adresse, dm.id as id_dm, dm.date_creation, dm.diagnostique, dm.observation from patient p left join dossierpatient dm on dm.id=p.id";

$result=mysqli_query($con,$sel_sql);
?>

<!DOCTYPE html>
<html>
<head>

    <title>Patients - Gestion Hôpital</title>

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
            <li class="breadcrumb-item active" aria-current="page">Patients</li>
        </ol>
    </nav>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCreerPatient">
        <i class="fas fa-plus-circle"></i> <b>Créer</b>
    </button>
    <!-- modalCreerPatient-->
    <form id="create_patient_form" action="patients/add.php">

        <div class="modal fade" id="modalCreerPatient" tabindex="-1" aria-labelledby="modalCreerPatientLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCreerPatientLabel"><i class="fas fa-user-plus"></i> Nouveau Patient</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" class="well">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><b><i class="fas fa-id-card"></i></b></span>
                                <input type="text" name="cin_patient" id="cin_patient" class="form-control form-control-lg" placeholder="A123456" aria-label="cin" aria-describedby="basic-addon1">
                            </div>
                            <br>
                            <div class="input-group mb-3">

                                <span class="input-group-text"><b>A</b></span>
                                <input type="text"  class="form-control form-control-lg" name="nom_patient" id="nom_patient"  placeholder="Exemple: ALAMI" required=""/>

                            </div><br>
                            <div class="input-group mb-3">

                                <span class="input-group-text"><b>A</b></span>
                                <input type="text"  class="form-control form-control-lg" name="prenom_patient" id="prenom_patient"  placeholder="Exemple: Douae" required=""/>

                            </div><br>

                            <div class="input-group mb-3">

                                <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                <select name="sexe_patient" id="sexe_patient" class="form-control form-control-lg">
                                    <option value="Femme">Femme</option>
                                    <option value="Homme">Homme</option>
                                </select>

                            </div><br>

                            <div class="input-group mb-3">

                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="text"  class="form-control form-control-lg" name="telephone_patient" id="telephone_patient"  placeholder="Exemple: 06123456789" required=""/>

                            </div><br>


                            <div class="input-group mb-3">

                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                                <input type="text"  class="form-control form-control-lg" name="adresse_patient" id="adresse_patient"  placeholder="Exemple: Rabat, Maroc" required=""/>

                            </div><br>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" id="envoi_enregistrer" name="envoi_enregistrer" class="btn btn-primary" onclick="return confirm('Confirmer?');return false;"><i class="fas fa-check"></i> Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <br>

    <table class="table table-sm table-bordered table-hover">
        <thead>
        <tr>
            <th>Nom Complet</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
    <?php
    $i=0;
    while($row =mysqli_fetch_array($result)) {
        //patient
        $id=$row["id"];
        $cin=$row["cin"];
        $nom=$row["nom"];
        $prenom=$row["prenom"];
        $sexe=$row["sexe"];
        $telephone=$row["telephone"];
        $adresse=$row["adresse"];

        //dossiermedical
        $id_dm=$row["id_dm"];
        $date_creation=$row["date_creation"];
        $diagnostique=$row["diagnostique"];
        $observation=$row["observation"];
        $i++;
        ?>
        <tr>
            <td><i class="fas  fa-user"></i>
                <?php if($id_dm==null) { ?>
                    <i class="fas fa-exclamation-triangle text-warning" title="Ce patient n'a aucun dossier médical."></i>
                <?php }?>
                <?php echo $nom.", ".$prenom; ?></td>
            <td>
                <a href="patients/delete.php?id=<?php echo $id; ?>" class="btn btn-danger" onclick="return confirm('Confirmer?');return false;">
                    <i class="fas fa-ban"></i>
                </a>

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDetailPatient_<?php echo $id;?>">
                    <i class="fas fa-info-circle"></i>
                </button>

                <?php if($id_dm==null) { ?>

                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAddDossierMedical_<?php echo $id; ?>">
                        <i class="fas fa-folder-plus"></i>
                    </button>

                <form id="create_dm_patient_form" action="dossierpatient/add.php">
                    <div class="modal fade" id="modalAddDossierMedical_<?php echo $id; ?>" data-id="<?php echo $id; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5><i class="fas fa-2x fa-user-md"></i> Créer un dossier médical pour <b><?php echo $nom.", ".$prenom; ?></b></h5>
                            </div>
                                <div class="modal-body">
                                    <input type="hidden" value="<?php echo $id;?>" name="dm_id_patient" id="dm_id_patient">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><b><i class="fas fa-calendar"></i></b></span>
                                        <input type="date" name="dm_date_creation_patient" id="dm_date_creation_patient" class="form-control form-control-lg" placeholder="A123456" aria-label="cin" aria-describedby="basic-addon1">
                                    </div>
                                    <br>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><b><i class="fas fa-file-medical-alt"></i></b></span>
                                        <input type="text" name="dm_diagnostique" id="dm_diagnostique" class="form-control form-control-lg" placeholder="Diabète, Allergie..." aria-label="cin" aria-describedby="basic-addon1">
                                    </div>
                                    <br>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><b><i class="fas fa-info-circle"></i></b></span>
                                        <input type="text" name="dm_observation" id="dm_observation" class="form-control form-control-lg" placeholder="Observation abc.." aria-label="cin" aria-describedby="basic-addon1">
                                    </div>
                                    <br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" name="envoi_dm_patient" class="btn btn-primary" onclick="return confirm('Confirmer?');return false;"><i class="fas fa-check"></i> Enregistrer</button>
                                </div>
                                </div>
                        </div>
                    </div>
                    </form>
            <?php } ?>

                <!-- modalDetailPatient -->
                <div class="modal fade" id="modalDetailPatient_<?php echo $id;?>" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5><i class="fas fa-2x fa-user-md"></i> <b><?php echo $nom.", ".$prenom; ?></b></h5>
                            </div>
                            <div class="modal-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="infos-tab" data-toggle="tab" href="#infos<?php echo $id;?>" role="tab" aria-controls="infos" aria-selected="true"><i class="fas fa-info-circle text-primary"></i> Informations Générales</a>
                                    </li>
        <?php if($id_dm!=null) { ?>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="dossier-tab" data-toggle="tab" href="#dossier<?php echo $id;?>" role="tab" aria-controls="dossier" aria-selected="false"><i class="fas fa-notes-medical text-danger"></i> Dossier Médical</a>
                                    </li>
            <?php }?>

                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="infos<?php echo $id;?>" role="tabpanel" aria-labelledby="infos-tab">
                                        <div class="card" style="width: 100%;">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $nom.", ".$prenom; ?></h5>
                                                <h6 class="card-subtitle mb-2 text-muted"><?php echo $cin; ?></h6><br>
                                                <p class="card-text"><i class="fas fa-home"></i> <?php echo $adresse; ?></p>
                                                <a href="#" class="card-link"><i class="fas fa-phone"></i>  <?php echo $telephone;?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($id_dm!=null) { ?>
                                    <div class="tab-pane fade" id="dossier<?php echo $id;?>" role="tabpanel" aria-labelledby="dossier-tab">
                                        <br>
                                        <table style="width:100%">
                                            <tr>
                                                <th> <label class="card-text text-info">Date de Création:</label></th>
                                                <td><span><?php echo $date_creation; ?></span></td>
                                            </tr>
                                            <tr>
                                                <th><label class="card-text text-info">Diagnostique: </label> </th>
                                                <td><span><?php echo $diagnostique; ?></span></td>
                                            </tr>
                                            <tr>
                                                <th>  <label class="card-text text-info">Observations: </label></th>
                                                <td><span><?php echo $observation; ?></span></td>
                                            </tr>
                                        </table>

                                    </div>
                                    <?php } ?>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
        </tr>
        <?php } ?>
    </tbody>
    </table>
    <small>Total: <?php echo $i;?></small>
</div>

    <?php include("footer.php");?>
    <?php include("header.php"); ?>

    </body>
    </html>
  <?php }  ?>