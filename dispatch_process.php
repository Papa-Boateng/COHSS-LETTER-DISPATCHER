<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
session_start();
require_once 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['dispatched'] = true;
    $dispatchRow = $_POST['dispatchId'];
    $recipt = $_POST['reciptA'];

    $dataDispatch = "SELECT * FROM Received_letter WHERE LetterID='$dispatchRow'";
    $dataDispatch_quer = mysqli_query($conn, $dataDispatch);
    $dataDispatch_mem = mysqli_fetch_assoc($dataDispatch_quer);
    
    //store all data in seperate variables
    $dateReceive = $dataDispatch_mem['DateOFLetter'];
    $regNum = $dataDispatch_mem['RegistryNumber'];
    $dateonLetter = $dataDispatch_mem['LetterDate'];
    $letterSubject = $dataDispatch_mem['Lsub'];
    $reMark = $dataDispatch_mem['Remarks'];

    //store results
    $queryDispatch = "INSERT INTO Dispatched_letters(DateOfReceived,RegistryNum,RecipientOfLetter,DateOnLetter,LetterSubject,RemarksSig) VALUES('$dateReceive','$regNum','$recipt','$dateonLetter','$letterSubject','$reMark')";
    $results = mysqli_query($conn,$queryDispatch);
             
     if ($results) {
         $deleteCopy = "DELETE FROM Received_letter WHERE LetterID=$dispatchRow";
         $resDel = mysqli_query($conn, $deleteCopy);
         if ($resDel) {
            header('Location: dispatch-letters.php');
           } else {
            $errTyp = "danger";
            $errMsg = "Something went wrong, try again..";	
           }

         } else {
             $errTyp = "danger";
             $errMsg = "Something went wrong, try again..";	
         }	
         exit;

 } 
?>