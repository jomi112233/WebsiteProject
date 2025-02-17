<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: booking.php");
    exit;
}

// Get the form data
$sukunimi = $_POST['sukunimi'];
$etunimi = $_POST['etunimi'];
$sahkoposti = $_POST['sahkoposti'];
$puhnumero = $_POST['puhnumero'];
$salasana = $_POST['salasana'];
$pvm = $_POST['pvm'];
$aika = $_POST['aika'];
$hlomaara = $_POST['hlomaara'];

// Connect to the database
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
$yhteys = mysqli_connect("db", "root", "password", "websiteProject");

if (!$yhteys) {
    header("Location: ../html/yhteysvirhe.html");
    exit;
}

// Update the booking information
$sql = "UPDATE booking SET sukunimi = ?, etunimi = ?, sahkoposti = ?, salasana = ?, pvm = ?, aika = ?, hlomaara = ? WHERE puhnumero = ?";
$stmt = mysqli_prepare($yhteys, $sql);
mysqli_stmt_bind_param($stmt, 'ssssssis', $sukunimi, $etunimi, $sahkoposti, $salasana, $pvm, $aika, $hlomaara, $puhnumero);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($yhteys);

// Redirect to a confirmation page or back to the booking page
header("Location: booking.php");
exit;

?>
