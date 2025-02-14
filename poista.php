<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
 //https://www.php.net/manual/en/function.mysqli-connect.php
    $yhteys = mysqli_connect("db", "root", "password", "websiteProject");
}
catch (Exception $e) {
    header("Location: ./html/yhteysvirhe.html");
    exit;
}

$poistettava = isset($_GET["puhnumero"]) ? $_GET["puhnumero"] : 0;

$sql="delete from booking where puhnumero=?";
$stmt=mysqli_prepare($yhteys, $sql);
mysqli_stmt_bind_param($stmt, "i", $poistettava);
mysqli_stmt_execute($stmt);

header("Location: ./booking.php");
exit;
