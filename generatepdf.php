<?php
ob_start();
require('Database.php');
require('fpdf_lib/fpdf.php');

if (isset($_POST['startDate']) && isset($_POST['endDate']))
{
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
}

$query = "SELECT * FROM $attendance where date BETWEEN '$startDate' and '$endDate'";

$resultQuery = mysqli_query($connection, $query);

$pdf = new FPDF('P', 'mm');

$pdf->AddPage();

$pdf->SetTextColor(42,58,129);

$pdf->Image('Images/Olinsterg_Logo.jpg',10,5,28,25,'JPG');
$pdf->Cell(27, 30, '', 0, 0);
$pdf->SetFont('Arial', 'B', 14);
$title = "Doorlock System Report (".$startDate." | ".$endDate.")";
$pdf->Cell(190, 17, $title, 0, 1);
$pdf->Ln(10);

$pdf->SetFontSize(10);
$pdf->SetFillColor(221,183,60);
$pdf->SetDrawColor(255, 255, 255);

$pdf->Cell(45, 8, 'Username', 1, 0, 'C', true);
$pdf->Cell(45, 8, 'UserID', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Date', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Time In', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Time Out', 1, 0, 'C', true);

$pdf->Ln();

$pdf->SetFont('', '', 10);
$pdf->SetFillColor(241,241,241);

$currentDate = $startDate;

$hasSwitch = false;
$switchDateColor = false;


$primaySwitch = false;
$secondarySwitch = false;

if (mysqli_num_rows($resultQuery) > 0)
{
    $switch = false;
    
    while($row = mysqli_fetch_assoc($resultQuery))
    {
        $date = $row['date'];
        if ($currentDate != $date)
        {
            $hasSwitch = true;
            $currentDate = $date;
        }
        else
        {
            $hasSwitch = false;
        }

        if ($hasSwitch)
        {
            $switchDateColor = !$switchDateColor;
        }

        if ($switchDateColor)
        {
            if ($switch)
                $pdf->SetFillColor(255, 255, 255);
            else
                $pdf->SetFillColor(241,241,241);
                
            $switch = !$switch;
        }
        else
        {
            if ($secondarySwitch)
                $pdf->SetFillColor(255, 255, 201);
            else
                $pdf->SetFillColor(240,230,140);
                
            $secondarySwitch = !$secondarySwitch;
        }

        $pdf->Cell(45, 8, $row['userName'], 1, 0, 'C', true);
        $pdf->Cell(45, 8, $row['userID'], 1, 0, 'C', true);
        $pdf->Cell(40, 8, $date, 1, 0, 'C', true);
        $pdf->Cell(30, 8, $row['timeIN'], 1, 0, 'C', true);
        $pdf->Cell(30, 8, $row['timeOUT'], 1, 0, 'C', true);
        $pdf->Ln();
    }
}

$pdf->Output();
// $pdf->Output('I', 'DoorlockSystemReport.pdf');