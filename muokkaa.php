<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muokkaa Tietoja</title>
</head>
<body>

<?php

$muokattava = $_GET["puhnumero"] ?? "";


if (empty($muokattava)) {
    header("Location: booking.php");
    exit;
}


mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
$yhteys = mysqli_connect("db", "root", "password", "websiteProject");

if (!$yhteys) {
    header("Location: ../html/yhteysvirhe.html");
    exit;
}


$sql = "SELECT * FROM booking WHERE puhnumero = ?";
$stmt = mysqli_prepare($yhteys, $sql);
mysqli_stmt_bind_param($stmt, 's', $muokattava);
mysqli_stmt_execute($stmt);
$tulos = mysqli_stmt_get_result($stmt);

if (!$rivi = mysqli_fetch_assoc($tulos)) {
    
    exit;
}

mysqli_close($yhteys);
?>

<h2>Muokkaa Tietoja</h2>

<form action="paivita.php" method="post">
    <label>Sukunimi: <input type="text" name="sukunimi" value="<?= htmlspecialchars($rivi['sukunimi']) ?>" required></label><br>
    <label>Etunimi: <input type="text" name="etunimi" value="<?= htmlspecialchars($rivi['etunimi']) ?>" required></label><br>
    <label>Sähköposti: <input type="email" name="sahkoposti" value="<?= htmlspecialchars($rivi['sahkoposti']) ?>" required></label><br>
    <label>Puhelinnumero: <input type="tel" name="puhnumero" value="<?= htmlspecialchars($rivi['puhnumero']) ?>" readonly></label><br>
    <label>Salasana: <input type="password" name="salasana"></label><br>
    <input type="submit" value="Tallenna">
</form>

</body>
</html>
