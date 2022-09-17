<?php
    ob_start();
    if(isset($_POST['submit']) && isset($_POST['cardNumber']) && isset($_POST['inOrOut'])){
        insert($_POST['cardNumber'], $_POST['inOrOut']);
    }
    
    function insert($cardNumber, $inOrOut){
        include('Database.php'); //Isama ang Database
        include('InsertAttendance.php');
        
        if ($inOrOut == "In")
        {
            Header("Location: InsertCardData_In.php?id=$cardNumber&inOrOut=In");
        }
        else
        {
            Header("Location: InsertCardData_Out.php?id=$cardNumber&inOrOut=Out");
        }
    }
    ob_end_flush();
?>

<!DOCTYPE html>

<html>
    <head>
        <title> Example RIFD </title>

        <style>
            body{
                color: #212F6E;
            }
            form{
                padding: 60px;
                margin-top: 55px;
                border: 2px solid #212F6E;
                width: 400px;
            }
            span{
                cursor: default;
            }
            .radioBtn, .submitBtn{
                cursor: pointer;
            }

        </style>

    </head>
<body>

    <?php include("Header.html");?>

    <center>
        <form action="Test.php" method="POST">
            <h1> RFID Sensor Tester </h1>
            Card Number <input type="number" name="cardNumber"> <br> <br>
            <span> In </span> <input class="radioBtn" type="radio" name="inOrOut" value="In">
            <span> Out </span> <input class="radioBtn" type="radio" name="inOrOut" value="Out"> <br> <br>
            <input class="submitBtn" type="submit" value="Record" name="submit">
        </form>
    </center>

</body>

</html>