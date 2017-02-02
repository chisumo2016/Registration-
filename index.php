<?php
        session_start();
    require_once('includes/config.php');
    require_once('includes/db.php');

  //Check for form submission
 if(isset($_POST['login'])){
     
     $email =mysqli_real_escape_string($conn, $_POST['email']); 
     $password =mysqli_real_escape_string($conn, $_POST['password']); 
     
     $query = "SELECT * FROM users WHERE email='$email' and password='$password'";
     $result = $conn->query($query);
     
     var_dump($query);
     exit;
     
     //Validating the status of account
     if($rows = $result->fetch_assoc()){
         if($rows['status']==1){
             $_SESSION['user_email'] = $email;
             header("Location:myaccount.php");
             exit();
             
         }else{
             header("Location:index.php:err=". urlencode("The user account is not activated"));
             exit();
         }
             
         }else{
             header("Location:index.php:err=". urlencode("Wrong Email or Password"));
             exit();
         
     }
 }



 ?>
 

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <title>login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
     <div class="row">
        <div class="col-md-12">
            
           <form  action="index.php" method="post" style="margin-top:50px;">
             <h2>Login</h2>
             
             <?php if(isset($_GET['success'])){?>
              
              <div class="alert alert-success"><?php echo $_GET['success'];?></div>
               
               
               <?php }?>
               
               <hr>
              <div class="form-group">
                <label for="">Email address</label>
                <input type="email" name="email" class="form-control"  placeholder="Email">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control"  placeholder="Password">
              </div>
                  
                  <div class="checkbox">
                     <label for="">
                      <input type="checkbox" name="remember_me">Remember Me
                      </label>
                  </div>

                  <button type="submit" name="login" class="btn btn-primary">Login</button>
                  <a href="forgot_password.php">Forgot Password</a>
            </form>
            
            
            
        </div>
         
         
     </div>

     
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>
