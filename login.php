<?php session_start();?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <title id="WEBSIT_NAME">
   GESTION DES PATIENTS
  </title>

      <?php include("header.php"); ?>
  </head>

  <body>
    
  <?php include'includes/functions.php'; ?>

<?php include("menubar.php"); ?>

<div  class="container">
<br/>
  <div class="row">
   <div class="col">
              
                <div  class="panel panel-primary">
                <div  class="panel-heading ">
                 <h1 style="text-align: center;"><i class="fas fa-user-circle" aria-hidden="true"></i> Authentification </h1>
               </div>
                <div class="panel-body">
           

               <form method="post" action="" class="well" id="form_login">
                   <div class="input-group mb-3">
                       <span class="input-group-text" id="basic-addon1"><b>@</b></span>
                       <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="username" aria-label="username" aria-describedby="basic-addon1">
                   </div>
                   <br>
                  <div class="input-group mb-3">
                
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                  <input type="password"  id="password" class="form-control form-control-lg" name="password" placeholder="******" required=""/>
               
                 </div><br>
 
                 <div class="form-group">
                     <button type="submit"  class="btn btn-lg btn-primary" name="envoi"><i class="fa fa-check"></i> Login</button>
                 </div>

               </form>
             
           </div>
         </div>
          </div>
</div>
        </div>



<?php include("footer.php"); ?>
      </body>
      </html>

          <?php

include('config/bd.php');
include('includes/functions.php');

 if (isset($_POST['envoi'])) {
  

  $username = $_POST['username'];

  $password = $_POST['password'];
     
     $sel_user="SELECT * FROM admin WHERE username='$username' AND password=MD5('$password')";
     
     $run_user = mysqli_query($con, $sel_user);

     $check_user = mysqli_num_rows($run_user);


     echo "username= ".$username.", password= ".$password." check= ".$check_user;

    // if ($check_user==0) {
      //   echo "<script>showError('Email ou mot de passe incorrect. Veuillez réessayer.')</script>";
         //echo "KO";
     //echo "<script>alert('Email ou mot de passe incorrect.Veuillez réessayer.')</script>";

     //else
     //{
if($check_user==1) {
         echo "OK";
while($row = $run_user->fetch_assoc())
 {
      $_SESSION["user_id"]= $row["id_admin"];
      $_SESSION["user_username"]= $row["username"];
  }
    
   //$_SESSION['email'] = $email;
  //  echo "<script>alert('success!')</script>";

       //  echo "index.php?auth=ok";
    echo "<script>window.open('index.php?auth=ok','_self')</script>";

     }
else {
    echo "<script>showError('Identifiants incorrectes');</script>";
    //echo "<script>alert('check user: ".$check_user."');</script>";
}
}
  
?>
