<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kalalomake</title>
</head>
<body>

<?php

$muokattava = $_GET["puhnumero"] ?? "";

//if (empty($muokattava)){
 //   header("Location: ./booking.php");
 //   exit;
//}

mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
try {
    $yhteys = mysqli_connect("db", "root", "password", "websiteProject");
    if (!$yhteys) {
        throw new Exception("Tietokantayhteys epäonnistui.");
    }
} catch (Exception $e) {
    header("Location: ../html/yhteysvirhe.html");
    exit;
}

$sql = "SELECT * FROM booking WHERE puhnumero = ?";
$stmt = mysqli_prepare($yhteys, $sql);
mysqli_stmt_bind_param($stmt, 's', $muokattava);
mysqli_stmt_execute($stmt);
$tulos = mysqli_stmt_get_result($stmt);

if (!$rivi = mysqli_fetch_assoc($tulos)) {
    header("Location: ../html/tietuettaeiloydy.html");
    exit;
}

mysqli_close($yhteys);
?>

<form action="./muokkaa.php" method="post">
    Sukunimi: <input type="text" name="sukunimi" value="<?= htmlspecialchars($rivi['sukunimi']) ?>"><br>
    Etunimi: <input type="text" name="etunimi" value="<?= htmlspecialchars($rivi['etunimi']) ?>"><br>
    Sähköposti: <input type="email" name="sahkoposti" value="<?= htmlspecialchars($rivi['sahkoposti']) ?>"><br>
    Puhelinnumero: <input type="tel" name="puhnumero" value="<?= htmlspecialchars($rivi['puhnumero']) ?>" readonly><br>
    Salasana: <input type="password" name="salasana" value=""><br>
    <input type="submit" name="ok" value="OK"><br>
</form>

</body>
</html>
