<?php
require_once 'config.php';

$poistettava = isset($_GET["puhnumero"]) ? $_GET["puhnumero"] : 0;

$sql="delete from booking where puhnumero=?";
$stmt=mysqli_prepare($yhteys, $sql);
mysqli_stmt_bind_param($stmt, "i", $poistettava);
mysqli_stmt_execute($stmt);

header("Location: ./booking.php");
exit;
?>