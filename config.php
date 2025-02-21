<?php
$config_path = __DIR__ . "/.ht.asetukset.ini"; 

// Tarkistaa, löytyykö tiedosto
if (!file_exists($config_path)) {
    die("Virhe: Asetustiedostoa ei löydy ($config_path)");
}

$config = parse_ini_file($config_path, true);

if (!$config) {
    die("Virhe: Asetustiedoston lukeminen epäonnistui.");
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$yhteys = mysqli_connect(
    $config['database']['host'],
    $config['database']['username'],
    $config['database']['password'],
    $config['database']['dbname']
) or die("Tietokantayhteys epäonnistui: " . mysqli_connect_error());

?>
