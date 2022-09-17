<?php

    if(isset($_POST['functionName'])){

        include("Database.php");
        switch($_POST['functionName'])
        {
            case "deleteAll":
                mysqli_query($connection, "DELETE FROM $attendance");
                include("index.php");
                break;

            case "register":
                    register();
                break;
        }
    }

    function register(){

        include("Database.php");

        $userName = $_POST['arguments'][0];
        $cardNumber = $_POST['arguments'][1];
    
        $query = "SELECT * FROM $rTable;";
        $result = mysqli_query($connection, $query);
        $lenght = mysqli_num_rows($result);
            
        if($lenght > 0){
            while($row = mysqli_fetch_assoc($result)){
                if($row['userName'] == $userName){
                    $errorMessage = "Username Already Exist";
                    break;
                }
                if($row['cardNumber'] == $cardNumber){
                    $errorMessage = "ID card number Already Exist";
                    break;
                }
            }
        }
        
        if(!empty($errorMessage)){
            include("CardRegistration.php");
            exit;
        }

        $errorMessage = "noError";
        $fileName = 'default.jpg';

        $query = "INSERT INTO $rTable(userName, cardNumber, fileName) VALUES ( '$userName' , $cardNumber, '$fileName');";
        mysqli_query($connection, $query);

        $query = "DELETE FROM $unregistered WHERE cardNumber=$cardNumber";
        mysqli_query($connection, $query);

        $result = mysqli_query($connection, "SELECT userName FROM $attendance where userID=$cardNumber;");
        if(mysqli_num_rows($result) > 0){
            $name = mysqli_fetch_assoc($result)['userName'];

            if($name != $userName){
                mysqli_query($connection, "UPDATE $attendance SET userName='$userName' where userID=$cardNumber;");
            }
        }
        include("CardRegistration.php");
    }
?>