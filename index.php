<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.open('login.php?auth=no','_self')</script>";
} else {

    ?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <title > Gestion des paiements</title>
        <?php include("header.php"); ?>
    
  </head>

  <body>
    
  <?php require 'includes/functions.php';

    require("config/bd.php");
    ?>

    <?php include("menubar.php"); ?>
<br>

          <div  class="container">
              <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item active" aria-current="page">Accueil</li>
                  </ol>
              </nav>


             <div class="ui two column grid">
  <div class="two column row">
    <div class="column"></div>
  </div>
   <div class="column" style="width:25%"> <?php include("dashboard.php"); ?></div>
  <div class="column" style="width:70%">
    <h1>Dashboard</h1>
    <h2 class="ui header">Paiements</h2>
    <table class="ui table" id="t_top_paiement">
      <thead>
        <tr>
          <th>#</th>
          <th>Date de paiement</th>
          <th>Nom et Prénom</th>
          <th>Mensualité</th>
          <th>Transport</th>
          <th>Parascolaire</th>
          <th>Cantine</th>
        </tr>
      </thead>
      <tbody>
    </table>
    <h2 class="ui header">Parascolaires</h2>
    <table class="ui table" id="t_top_parascolaire">
      <thead>
        <tr>
          <th>#</th>
          <th>Activité</th>
          <th>Total participants</th>
        </tr>
      </thead>
      <tbody>
    </table>
  </div>
</div>

         </div>


  <?php include("footer.php");?>

  </body>
      </html>

<?php } ?>
     

