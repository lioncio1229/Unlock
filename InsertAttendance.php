<?php

    function insertAttendance($cardNumber, $inOrOut){

        include('Database.php'); //Isama ang Database
        $lastRecordQuery = "SELECT * FROM $attendance WHERE userID=$cardNumber ORDER BY id DESC LIMIT 1;";

        $result = mysqli_query($connection, $lastRecordQuery);
        $currentDate = "CURRENT_DATE";

        if(mysqli_num_rows($result) == 0)
        {
            $r = mysqli_query($connection, "SELECT userName FROM $rTable WHERE cardNumber=$cardNumber LIMIT 1;");
            $userName = mysqli_fetch_assoc($r)['userName'];

            if($inOrOut == "In"){
                $saveQuery = "INSERT INTO $attendance (userName, userID, date, timeIN, timeOUT) VALUES('$userName', 
                    $cardNumber, $currentDate, CURRENT_TIME, '00:00:00');";
            }
            else{
                $saveQuery = "INSERT INTO $attendance (userName, userID, date, timeIN, timeOUT) VALUES('$userName', 
                    $cardNumber, $currentDate, '00:00:00', CURRENT_TIME);";
            }
            mysqli_query($connection, $saveQuery);
            return;
        }

        $n = mysqli_query($connection, "SELECT userName FROM $rTable where cardNumber=$cardNumber");
        $row = mysqli_fetch_assoc($n);
        $userName = $row['userName'];

        $row = mysqli_fetch_assoc($result);
        date_default_timezone_set("Singapore");
        $date = $row['date'];
        $timeOut = $row['timeOUT'];

        if($inOrOut == "In"){
            $saveQuery = "INSERT INTO $attendance (userName, userID, date, timeIN, timeOUT) VALUES('$userName', 
                $cardNumber, $currentDate, CURRENT_TIME, '00:00:00');";
        }
        else{
            if($date != date('Y-m-d')){
                $saveQuery = "INSERT INTO $attendance (userName, userID, date, timeIN, timeOUT) VALUES('$userName', 
                    $cardNumber, $currentDate, '00:00:00', CURRENT_TIME);";
            }
            else{
                if($timeOut == "00:00:00"){
                    $saveQuery = "UPDATE $attendance SET timeOUT=CURRENT_TIME WHERE userID=$cardNumber ORDER BY id DESC LIMIT 1;";
                }
                else{
                    $saveQuery = "INSERT INTO $attendance (userName, userID, date, timeIN, timeOUT) VALUES('$userName', 
                        $cardNumber, $currentDate, '00:00:00', CURRENT_TIME);";
                }
            }
        }
        mysqli_query($connection, $saveQuery);
    }

?>