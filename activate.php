<?php
   require_once('includes/config.php');
    require_once('includes/db.php');


if(isset($_GET['token'])){
    $token = $_GET['token'];
    $query = "UPDATE users SET status ='1' WHERE token ='$token'";
    if($conn->query($query)){
        header("Location:index.php?success=Account Activated!");
        exit();
    }
}



?>