<?php
session_start();
require_once 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['deleted'] = true;
    $dataDel = $_POST['dataId'];

    $query = "DELETE FROM Received_letter WHERE LetterID=$dataDel";
    $res = mysqli_query($conn,$query);
    if ($res) {
        header('Location: dispatch-letters.php');
         } else {
             $errTyp = "danger";
             $errMsg = "Something went wrong, try again..";	
         }	
     exit;
 }

?>