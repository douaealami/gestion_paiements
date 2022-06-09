<?php 
session_start();
if (!isset($_SESSION['email'])) {
   echo "<script>window.open('login.php','_self')</script>";
}else{

 ?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    

    <title id="WEBSIT_NAME">
GESTION DES PATIENTS
  </title>

      <?php include("header.php");?>
  </head>

  <body>
    
  <?php require'includes/functions.php';

 require('config/bd.php');

  ?>
  <?php include("menubar.php");  ?>


<div  class="container">

    <?php include'dashboard.php'; ?>
<div class="col-sm-11 col-sm-offset-0">
              
                <div  style="border: solid 1px #004d99;"  class="panel panel-default">
                <div  style="border: solid 1px #004d99 ;"  class="panel-heading ">
                 <h5 style="text-align: center;"><a style="float: left; color: white; font-size: 15px;" href="index.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Retour</a> Ajouter un patient ici <i class="fa fa-plus-circle" aria-hidden="true"></i><br></h5>
               </div>
                <hr>
                 <div id="main-content">

      <div class="container">

        <div class="row">
       
          <div class="col-sm-7 col-sm-offset-2">
              <div class="panel panel-default">
               <div class="panel-heading">
                <h3 style="text-align:center;" class="panel-title"><b>formulaire d'ajout</b></h3>
            
              </div>
            <div class="panel-body">
      
                <!--nom-->
           <form data-parsley-validate method="post" enctype="multipart/form-data">
             <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label" for="nom" >Nom<span class="text-danger">*</span></label>
                  <input type="text" placeholder="nom..." name="nom" id="nom" class="form-control" value="nom" required="required">
                </div>
                
              </div>
                  <!--vile-->
             
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label" for="poste" > occupé<span class="text-danger">*</span></label>
                  <input type="text" placeholder="post..." name="poste" id="poste" value="poste" class="form-control" required="required">
                </div>
                
              </div>
               
             </div>
              
             
             <div class="row">
               <div class="col-md-12">
                 <div class="form-group">
                   <label for="avatar">changer mon avatar</label>
                   <input type="file" name="avatar" id="avatar" required="required">
                 </div>
               </div>
             </div>
             <!--vile-->
             <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label" for="quartier" >Quartier<span class="text-danger">*</span></label>
                  <input type="text" placeholder="quartier..." name="quartier" id="quartier" value="quartier" class="form-control" required="required">
                </div>
                
              </div>

               <!--sex-->
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label" for="sex" >sex<span class="text-danger">*</span></label>
                  <select name="sex" id="sex" class="form-control" required="required">
                    <option>
                      Homme
                    </option>
                    <option>
                      Femme
                    </option>
                  </select>
                </div>
              </div>
              
               
             </div>


               <!--twitter-->
             <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label" for="numero" >numéro<span class="text-danger">*</span></label>
                  <input type="text"  name="numero" id="numero" value="numero" class="form-control" placeholder="numero...">
                </div>
                
              </div>

               <!--github-->
             
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label" for="email" >Email<span class="text-danger">*</span></label>
                  <input type="email"  name="email" id="email" class="form-control" value="email" placeholder="email...">
                </div>
                
              </div>
               
               
             </div>
         <!--disponibilites-->
             <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                
                  <label class="control-label" for="matricule" >Matricule<span class="text-danger">*</span></label>
                    <input type="text"  name="matricule" id="matricule" value="matricule" class="form-control" placeholder="matricule" />
              
                </div>
                
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                
                  <label class="control-label" for="password" >Password<span class="text-danger"></span></label>
                    <input type="password"  name="password" id="password" value="password" class="form-control" placeholder="password" />
              
                </div>
                
              </div>
               
             </div>


              <!--vile-->
             
             <input style="background-color: #004d99; border : #004d99;" type="submit" class="btn btn-primary" value="valider" name="registeruser">
              <input style="background-color: #004d99; border : #004d99; float: right;" type="reset" class="btn btn-primary" value="actualiser">
           </form> 

          </div>
          
        </div>
            
          </div>
      

        </div>
      
     </div><!-- /.container -->

       
   </div>
         </div>
          </div>

        </div>


  <div class="bcg" class="container">
        
            

 
           
            <div class="col-sm-4 col-sm-offset-4">
                <p style="color:#0BD0F8; text-align: center;"  > &copy; 2020, All Rights Reserved (DOUAE ALAMI)</p>
            </div>
         
        </div>  
<script src="libs/parsley.min.js"></script>
</body>
</html>

<?php
  include'includes/functions.php';

  include('config/bd.php');

if (isset($_POST['registeruser'])) {

  global $con;

  $nom = $_POST['nom'];

  $poste  = $_POST['poste'];

  $quartier = $_POST['quartier'];

  $avatar= $_FILES['avatar']['name'];
  $avatar_tmp = $_FILES['avatar']['tmp_name'];

  move_uploaded_file($avatar_tmp,"images/$avatar");

  $sex = $_POST['sex'];

  $numero = $_POST['numero'];

  $email  = $_POST['email'];

  $matricule = $_POST['matricule'];

  $password  = $_POST['password'];
  
  


  echo
   $insert = " INSERT INTO users (nom, poste, quartier,avatar, sex, numero, email, matricule, password) VALUES('$nom','$poste','$quartier','$avatar','$sex','$numero','$email','$matricule','$password')";

$run = mysqli_query($con, $insert);

  
if ($run) {
   echo "<script>alert('patient ajouté avec succés!')</script>";
   echo "<script>window.open('liste.php','_self')</script>";
   

}else{
  echo "<script>alert('Echec!')</script>";
   echo "<script>window.open('ajoute.php','_self')</script>";
}

}

  
?>

<?php } ?>
     

