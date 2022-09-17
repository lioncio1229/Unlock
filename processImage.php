<?php
    ob_start();
    include_once("Database.php");

    if (isset($_POST['submit']) && isset($_POST['cardNumber']))
    {
        $file = $_FILES['myfile'];
        $cardNumber = $_POST['cardNumber'];

        $fileName = $file['name'];
        $fileTempName = $file['tmp_name'];
        $fileSize = round( ($file['size'] / 1024) / 1024); //In mb
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileNameArray = explode(".", $fileName);
        $fileExt = strtolower(end($fileNameArray));

        $allowedExtentions = array('png', 'jpg', 'jpeg');

        $requireFileSize = 5;

        $errorMessage = '';

        if (in_array($fileExt, $allowedExtentions))
        {
            if ($fileError === 0)
            {
                if ($fileSize < $requireFileSize)
                {
                    $newFileName = $cardNumber.".".$fileExt;
                    $fileDestination = "uploads/".$newFileName;
                    move_uploaded_file($fileTempName, $fileDestination);

                    echo $cardNumber;
                    $query = "UPDATE $rTable SET fileName='$newFileName' WHERE cardNumber=$cardNumber;";
                    mysqli_query($connection, $query);
                }
                else
                   $errorMessage = "Your file is too big. It's should be less than $requireFileSize mb";
            }
            else
                $errorMessage = "There was an error uploading your file!";
        }
        else
            $errorMessage = "You cannot upload file of this type!";
            
        Header("Location: ViewRegistered.php?errorMessage=$errorMessage");
    }
    ob_end_flush();
?>