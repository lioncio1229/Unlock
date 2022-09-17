<?php
    include_once("Database.php");

    if(isset($_GET['cnum'])){
        $cnum = $_GET['cnum'];
        $query = "DELETE FROM $rTable where cardNumber=$cnum";
        mysqli_query($connection, $query);
    }
?>

<!DOCTYPE html>

<html>
    <head>
        <title>View Registered</title>
        <link rel="stylesheet" href="vRegStylesheet.css">
        <script src="main.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    </head>
<body>

    <?php include("Header.html");?>

    <?php

        if (isset($_GET['errorMessage']))
        {
            $errorMessage = $_GET['errorMessage'];
            if($errorMessage == '')
                echo "<p style='background-color: #00FF00; color: white; margin: 0px; padding: 3px;'> Image Updated </p>";
            else
                echo "<p style='background-color: red; color: white; margin: 0px; padding: 3px;'> $errorMessage </p>";
        }

        if (isset($_GET['cnumImage']))
        {
            $cardNumber = $_GET['cnumImage'];
            $query = "SELECT * FROM $rTable where cardNumber=$cardNumber";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $fileName = $row['fileName'];
            $userName = $row['userName'];

            echo "
                <div class='upload-image-window' id='upload-image-window'>
                    <div class='upload-image-panel'>
    
                        <h2> $userName </h2>
                        <p> Users Id : $cardNumber </p>

                        <img src='uploads/$fileName'>

                        <form action='processImage.php' method='post' enctype='multipart/form-data'>
                            <input type='hidden' name='cardNumber' value='$cardNumber'>
                            <input type='file' name='myfile'>
                            <button class='regButton' name='submit'> Change Picture </button>
                        </form>
                        <i class='fas fa-times-circle close-button' onclick='closeWindow()'> </i>
                    </div>
                </div> 
            ";
        }
    ?>

    <p class="navTitle"> REGISTERED CARD NUMBERS </p>
    <div class="container">
        
        <table>
            <tr> 
                <th> Username </th>
                <th> User ID </th>
            </tr>

            <?php
                $query = "SELECT * FROM $rTable ORDER BY userName";
                $result = mysqli_query($connection, $query);
                $lenght = mysqli_num_rows($result);
            
                if($lenght > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $cardNumber = $row['cardNumber'];
                        echo "
                        <tr style='color: #212F6E;'> 

                            <td class='userName'> 
                                <div>
                                    <img src='uploads/$row[fileName]'>
                                    ".$row['userName']."
                                </div>
                            </td>

                            <td> ".$cardNumber." </td>

                            <td class='remove'> <a href='ViewRegistered.php?cnumImage=".$cardNumber."' > View Image </a> </td>

                            <td class='remove'> <a href='ViewRegistered.php?cnum=".$cardNumber."' > Remove </a> </td>
                        </tr>
                        ";
                    }
                }
            ?>
            
        </table>

    </div>

</body>

</html>