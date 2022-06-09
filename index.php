<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.open('login.php?auth=no','_self')</script>";
} else {

    ?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <title > GESTION DES PATIENTS</title>
        <?php include("header.php"); ?>
    
  </head>

  <body>
    
  <?php require 'includes/functions.php';

    require("config/bd.php");
    ?>

    <?php include("menubar.php"); ?>

          <div  class="container">
              <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item active" aria-current="page">Accueil</li>
                  </ol>
              </nav>
          <?php include("dashboard.php"); ?>


  <?php include("footer.php");?>

  </body>
      </html>

<?php } ?>
     

