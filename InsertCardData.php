<?php
   
    include("Database.php");
  	include("InsertAttendance.php");

	$cardNumber= $_GET['id'];
    $inOrOut = $_GET['inOrOut'];

    $query = "SELECT * FROM $rTable where cardNumber=$cardNumber;";
    $result = mysqli_query($connection, $query);
    $length = mysqli_num_rows($result);

    if($length > 0){
        echo "&true";
        insertAttendance($cardNumber, $inOrOut);
    }
    else{
        echo "&false";
        $query = "SELECT * FROM $unregistered where cardNumber=$cardNumber;";
        $result = mysqli_query($connection, $query);
        $length = mysqli_num_rows($result);
            
        if($length == 0){
            $sql = "INSERT INTO $unregistered (cardNumber, date) VALUES ($cardNumber, CURRENT_TIME)";
            mysqli_query($connection, $sql);
        }
    }
    echo "&";
?>