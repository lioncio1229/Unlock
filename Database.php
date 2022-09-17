<?php
    $serverName = "localhost";
    $userName = "id17484432_unlock";
    $password = "CamiloCasabal_09";
    $databaseName = "id17484432_unlock_database";

    $attendance = "attendance";
    $rTable = "registered";
    $unregistered = "unregistered";

    $connection = mysqli_connect($serverName, $userName, $password, $databaseName);
    mysqli_query($connection, "SET time_zone = '+08:00'");
    set_time_limit(60);
?>


<!-- <?php
    // $serverName = "localhost";
    // $userName = "id16707723_doorlock";
    // $password = "DoorlockSystem_1229";
    // $databaseName = "id16707723_doorlock_database";

    // $attendance = "attendance";
    // $rTable = "registered";
    // $unregistered = "unregistered";

    // $connection = mysqli_connect($serverName, $userName, $password, $databaseName);
    // mysqli_query($connection, "SET time_zone = '+08:00'");
?> -->