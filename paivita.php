<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: booking.php");
    exit;
}


mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
$yhteys = mysqli_connect("db", "root", "password", "websiteProject");

if (!$yhteys) {
    header("Location: ../html/yhteysvirhe.html");
    exit;
}


$sukunimi = trim($_POST["sukunimi"]);
$etunimi = trim($_POST["etunimi"]);
$sahkoposti = trim($_POST["sahkoposti"]);
$puhnumero = trim($_POST["puhnumero"]);
$salasana = trim($_POST["salasana"]);


if (!empty($salasana)) {
    $hashed_password = password_hash($salasana, PASSWORD_DEFAULT);
    $sql = "UPDATE booking SET sukunimi=?, etunimi=?, sahkoposti=?, salasana=? WHERE puhnumero=?";
    $stmt = mysqli_prepare($yhteys, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $sukunimi, $etunimi, $sahkoposti, $hashed_password, $puhnumero);
} else {
    $sql = "UPDATE booking SET sukunimi=?, etunimi=?, sahkoposti=? WHERE puhnumero=?";
    $stmt = mysqli_prepare($yhteys, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $sukunimi, $etunimi, $sahkoposti, $puhnumero);
}


mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($yhteys);


header("Location: booking.php");
exit;

?>
