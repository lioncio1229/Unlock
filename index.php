<?php
    include_once("Database.php");
    $data = array();
    $query = "SELECT * FROM $attendance";
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $date = $row['date'];
            $timeIN = $row['timeIN'];
            $timeOUT = $row['timeOUT'];

            $date = date('M/j/Y', strtotime($date));

            if($timeIN == "00:00:00") $timeIN = "-- -- --";
            else $timeIN = date('g:i:s a', strtotime($timeIN));

            if($timeOUT == "00:00:00") $timeOUT = "-- -- --";
            else $timeOUT = date('g:i:s a', strtotime($timeOUT));

            $data[] = array(
                $row['userName'],
                $row['userID'],
                $date,
                $timeIN,
                $timeOUT
            );
        }
    }
    
    $rowCount = count($data);
?>


<!DOCTYPE html>

<html>

<head>
    <title> Doorlock System Report </title> 
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="main.js"></script>

</head>

<body>

    <div onclick="toggleMenuOff()">

        <?php include("Header.html"); ?>

        <div class="sidebar">
            <div class="sidebarTitle">
                Date
            </div>

            <div class="sidebarContent">
                <?php

                    $date = "";
                    $bookmarks = array();

                    $i = 0;
                    for($a = $rowCount-1; $a >= 0 ; $a--){
                        $d = $data[$a][2];
                        if($date != $d){
                            $date = $d;

                            $color = "";
                            if($a%2 == 0) $color = "rgb(222, 235, 241)";

                            echo "<p style='background-color: $color';> <a href='#$i'> $date </a> </p>";
                            array_push($bookmarks, "$i");
                            $i++;
                        }
                    }
                ?>
            </div>

        </div>

        <div class="attendanceContainer">
            <table class="reportTable">

                <tr class="firstRow">
                    <td> Username </td>
                    <td> User ID </td>
                    <td> Date </td>
                    <td> Time In </td>
                    <td> Time Out </td>
                </tr>

                <?php
                    $design = "";
                    $date = "";
                    $bookmark = "";

                    $i = 0;
                    for($a = $rowCount-1; $a >= 0; $a--){

                        $d = $data[$a][2];
                        if($a == $rowCount-1) $design = "des1";

                        if($design == "des1"){
                            if($date != $d) $design = "des2";
                        }
                        else{
                            if($date != $d) $design = "des1";
                        }

                        if($date != $d) {
                            $bookmark = $bookmarks[$i];
                            $i++;
                            $date = $d;
                        }
                        else $bookmark = "";

                        $cardNumber = $data[$a][1];
                        $query = "SELECT * FROM $rTable where cardNumber=$cardNumber";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_assoc($result);

                        if (isset($row['fileName']))
                            $fileName = $row['fileName'];

                        echo "
                            <tr class='$design' id='$bookmark'>
                        
                            <td class='tdIcon'> ";
                                if (isset($row['fileName']))
                                echo "
                                    <img onmouseover=showImage('".$fileName."') onmouseout=closeImage() class='icon' src='uploads/".$fileName."'>
                                    ";
                                echo "   ".$data[$a][0]." 
                            </td>
                    
                            <td class='tdIcon'> ".$data[$a][1]." </td>
                            <td class='tdIcon'> ".$data[$a][2]." </td>
                            <td class='tdIcon'> ".$data[$a][3]." </td>
                            <td class='tdIcon'> ".$data[$a][4]." </td>
                            <tr>
                        ";
                    }
                ?>

            </table>

            <div id='img-icon'> 
            </div>

        </div>
    </div>

    <img onclick="toggleMenu()" class="menuButton" src="Images/menuButton.jpg" alt="Menu">

    <div class="menu">
        <p onclick="generatePDF()">Generate Pdf </p>
        <p onclick="deleteAll()">Delete All Records </p>
    </div>

    <?php
        if (isset($_GET['printWindowOpen']))
        {
            if ($_GET['printWindowOpen'] === '1')
            {
                echo "<div class='print-property-window'>
                    <div class='print-panel'>
                        <form action='generatepdf.php' method='post'>
                            <h3>Select Date Range</h3> <br> <br>
                            Start Date <input type='date' name='startDate'> <br> <br>
                            End Date &nbsp <input type='date' value='".date('Y-m-d')."' name='endDate'> <br> <br> <br>
                            <input class='submit' type='submit' value='Generate PDF'>
                        </form>
                        <i class='fas fa-times-circle close-button' onclick='closePrintWindow()'> </i>
                    </div>
                </div>";
            }
        }
    ?>
    
</body>

</html>