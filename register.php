<?php
    session_start();
    require_once('includes/config.php');
    require_once('includes/db.php');


    function isUnique($email){
       $query = "SELECT * FROM users WHERE email='$email'";
        global $conn;
         $result = $conn->query($query);
        
        if($result->num_rows ==1){
            return false;
        }
        
        else return true; 
    }
  if(isset($_POST['register'])){
      
   $_SESSION['user_name']= $_POST['user_name'];
   $_SESSION['email']= $_POST['email'];
   $_SESSION['password']= $_POST['password'];
   $_SESSION['confirm_password']= $_POST['confirm_password'];
      
      if(strlen($_POST['user_name'])<3){
          header ("Location: register.php?err=". urlencode("The name must be at least 3 Characters log"));
          exit();
      }
      
      //Validate the password
      
      else if($_POST['password'] != $_POST['confirm_password']){
           header ("Location: register.php?err=". urlencode("The password and confirm password do not match"));
          exit();
          
      }
      
      else if(strlen($_POST['password']) < 5){
          header ("Location: register.php?err=". urlencode("The password should be at least 5 characters"));
          exit();
      }
      else if(strlen($_POST['confirm_password']) < 5){
          header ("Location: register.php?err=". urlencode("The confirm password should be at least 5 characters"));
          exit();
      }
      
      //Validate Email
      
      else if(!isunique($_POST['email'])){
           header ("Location: register.php?err=". urlencode("Email already in use. Please use another one"));
          exit();
          
      }
          
      else { 
            // Save user into database
          
          $name = mysqli_real_escape_string($conn, $_POST['user_name']);
          $email =mysqli_real_escape_string($conn, $_POST['email']);
          $password =mysqli_real_escape_string($conn, $_POST['password']);
          $token = bin2hex(openssl_random_pseudo_bytes(32));
          
          $query = "INSERT INTO users (name,email,password,token) VALUES ('$name','$email','$password', '$token')";
          $conn->query( $query);
          
          //Sending  Activation Emails to the user
          $message = "Hi $name ! Account created here is the activation link http://localhost/Registration/activate.php?token=$token"; 
          mail($email , 'Activate Account', $message , 'From : bchisumo74@yahoo.com'); //Send u the user
          header("Location:index.php?success=" .urlencode("Activation Email Sent!"));
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
   
    <title>Register</title>

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
            <li class=""><a href="index.php">Login</a></li>
            <li class="active"><a href="register.php">Register</a></li>
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
     <div class="row">
        <div class="col-md-12">
            
           <form  action="register.php" method="post" style="margin-top:50px;">
            <h2>Register Here</h2>
            
            <?php if(isset($_GET['err'])){?>
             <div class="alert-danger"><?php echo $_GET['err'];?></div>
             <?php }?>
             <hr>
             <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="user_name" class="form-control"  placeholder="Enter your Name" value="<?php echo @$_SESSION['user_name'];?>" required>
              </div>
              <div class="form-group">
                <label for="">Email address</label>
                <input type="email" name="email" class="form-control"  placeholder="Email" value="<?php echo @$_SESSION['email'];?>" required>
              </div>
  
              <div class="form-group">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control"  placeholder="Password" value="<?php echo @$_SESSION['password'];?>" required>
              </div>
               
              <div class="form-group">
                <label >Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control"  placeholder="Confirm Password" value="<?php echo @$_SESSION['confirm_password'];?>" required>
              </div>
                
                  <button type="submit" name="register" class="btn btn-primary">Register</button>
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
