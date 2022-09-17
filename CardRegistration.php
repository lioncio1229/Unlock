<?php
    ob_start();
    include_once("Database.php");

    if(isset($errorMessage) && !empty($errorMessage)){
        if($errorMessage == "noError")
            echo "<p style='background-color: #00FF00; color: white; margin: 0px; padding: 3px;'> Registered </p>";
        else
            echo "<p style='background-color: red; color: white; margin: 0px; padding: 3px;'> $errorMessage </p>";
    }

    if(isset($_GET['cnum'])){
        $cnum = $_GET['cnum'];
        $query = "DELETE FROM $unregistered where cardNumber=$cnum";
        mysqli_query($connection, $query);
        Header("Location: CardRegistration.php");
        return;
    }
    ob_end_flush();
?>

<!DOCTYPE html>

<html>
    <head>

        <title>Card Registration</title>
        <link rel="stylesheet" href="vRegStylesheet.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="main.js"></script>
        <script type="text/javascript">
            function jsFunction(){
                alert('Execute Javascript Function Through PHP');
            }
        </script>

    </head>
    
<body>

    <?php include('Header.html'); ?>

    <p class="navTitle"> CARD REGISTRATION </p>

    <div class="container">    
        <table>
            <tr> 
                <th> Date Scanned </th>
                <th> Card Number </th>
                <th> Username </th>  
            </tr>

            <?php
                $query = "SELECT * FROM $unregistered ORDER BY rollNumber DESC";
                $result = mysqli_query($connection, $query);
                $lenght = mysqli_num_rows($result);
            
                $i = 0;
                if($lenght > 0){
                    while($row = mysqli_fetch_assoc($result)){

                        $id = "CardReg".$i;

                        echo "
                        <tr style='color: #212F6E;'> 
                           
                            <td style='font-size: 14px;'> ".date('M/j/Y g:i:s a', strtotime( $row['date'] ))." </td>
                            <td> ".$row['cardNumber']." </td>
                            <td> <input type='text' id='$id' name='userName'> </td>
                            <td class='remove'> <button class='regButton' onclick=registerCard(".$row['cardNumber'].",'".$id."')> Register </button>
                            <td class='remove'> <a href='CardRegistration.php?cnum=".$row['cardNumber']."' > Remove </a> </td>
                        </tr>";
                        
                        $i++;

                    }
                }
            ?>
            
        </table>
        
    </div>

</body>

</html>

<!-- <td class='remove'> <button class='regButton' onclick=registerCard(".$row['cardNumber'].",'".$id."')> Register </button> </td> -->