<?php
 session_start();
 require_once 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $_SESSION['newpassReset'] = true;
     $currPass = $_POST['currentpass'];
     $newPass = $_POST['newpasschange'];

     $currentUserpass = hash('sha256', $currPass);
     $newUserpass = hash ('sha256', $newPass);

     $resPassQuery=mysqli_query($conn,"SELECT userPass FROM users WHERE userPass ='$currentUserpass'");
	 $rowCount = mysqli_num_rows($resPassQuery);

     if( $rowCount == 1 ) {
       $newReset = mysqli_query($conn, "UPDATE users SET userPass = '$newUserpass' WHERE userId=".$_SESSION['user']);
       if ($newReset) {
        header('Location: user-settings.php');
         } else {
            $_SESSION['newpassReset'] = false;
            $_SESSION['errordb'] = true;
            header('Location: user-settings.php');
         }
         
    } else {
        $_SESSION['errorChange'] = true;
        header('Location: user-settings.php');
    }
             
     
 }


?> 