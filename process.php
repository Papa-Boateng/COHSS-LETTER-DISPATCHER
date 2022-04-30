<?php
 session_start();
 require_once 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $_SESSION['posted'] = true;
     $dateLetter = $_POST['DateLetter'];
     $letterSub = $_POST['Lsubject'];
     $dateOnLetter = $_POST['DateOnLetter'];
     $registryNum = $_POST['RegistryNumber'];
     $remark = $_POST['remarks'];
         
     $query = "INSERT INTO Received_letter(DateOFLetter,Lsub,LetterDate,RegistryNumber,Remarks) VALUES('$dateLetter','$letterSub','$dateOnLetter','$registryNum','$remark')";
     $res = mysqli_query($conn,$query);
             
     if ($res) {
        header('Location: input-letter.php');
         } else {
             $errTyp = "danger";
             $errMsg = "Something went wrong, try again..";	
         }	
     exit;
 }


?> 