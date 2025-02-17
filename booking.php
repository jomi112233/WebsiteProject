<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>booking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="booking.css">

</head>
<body>

    <div class="container">

        <div class="mobile-nav">
            <a href="index.html"><img src="kuvat/logo-no-background.png" alt="" class="active"></a>


            <div id="linkit">
                <a href="menu.html">Menu</a>
                <a href="drinkit.html">Drinks</a>
                <a href="yhteystiedot.html">Contacts</a>
                <a href="booking.html">Booking</a>
                <a href="svenska.html">På Svenska</a>
            </div>

            <a href="javascript:void(0);" class="burgeri" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </div>

        <header class="hero">
            <div class="navigation">
                <a href="index.html"><img src="kuvat/logo-no-background.png" alt="" class="logo"></a>
                <nav>
                    <ul>
                        <li><a href="menu.html">Menu</a></li>
                        <li><a href="drinkit.html">Drinks</a></li>
                        <li><a href="yhteystiedot.html">Contacts</a></li>
                        <li><a href="booking.html">Booking</a></li>
                    </ul>
                </nav>
            </div>
        </header>


        <h2>Fill in!</h2>
<form action="" method="post">
    Sukunimi: <input type="text" name="sukunimi" value=""><br>
    Etunimi: <input type="text" name="etunimi" value=""><br>
    Sähköposti: <input type="email" name="sahkoposti" value=""><br>
    Puhelinnumero: <input type="tel" name="puhnumero" value=""><br>
    Salasana: <input type="password" name="salasana" value=""><br>
    <input type="submit" name="ok" value="OK"><br>
</form>

<?php

//MySql näyttää tarkat virheet
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$server = "db";
$username = "root";
$password = "password";
$database = "websiteProject";

// tietokantayhteys
$yhteys = mysqli_connect($server, $username, $password, $database);

// Tarkistaa yhteyden tietokantaan, jos ei onnistu tulee virheilmoitus
if (!$yhteys) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // tarkistaa onko lomake lähetetty POST metodilla
    // Otetaan vastaan käyttäjän syöttämät tiedot
    $sukunimi = isset($_POST["sukunimi"]) ? trim($_POST["sukunimi"]) : "";
    $etunimi = isset($_POST["etunimi"]) ? trim($_POST["etunimi"]) : "";
    $sahkoposti = isset($_POST["sahkoposti"]) ? trim($_POST["sahkoposti"]) : "";
    $puhnumero = isset($_POST["puhnumero"]) ? trim($_POST["puhnumero"]) : "";
    $salasana = isset($_POST["salasana"]) ? trim($_POST["salasana"]) : "";

    //Tarkistetaan että kaikki kentäöt on täytetty
    if (!empty($sukunimi) && !empty($etunimi) && !empty($sahkoposti) && !empty($puhnumero) && !empty($salasana)) {
        // Tarkistetaan löytyykö tietokannasta jo henkilö, puhelinnumeron avulla
        $sql_check = "SELECT * FROM booking WHERE puhnumero = ?";
        $stmt_check = mysqli_prepare($yhteys, $sql_check);
        mysqli_stmt_bind_param($stmt_check, 's', $puhnumero);
        mysqli_stmt_execute($stmt_check);
        $result = mysqli_stmt_get_result($stmt_check);
        
        if (mysqli_num_rows($result) > 0) {
            //päivitetään jo olemassaoleva tieto jos puhelinumero löytyy
            $sql = "UPDATE booking SET etunimi=?, sukunimi=?, sahkoposti=?, salasana=? WHERE puhnumero=?";
            $stmt = mysqli_prepare($yhteys, $sql);
            mysqli_stmt_bind_param($stmt, 'sssss', $etunimi, $sukunimi, $sahkoposti, $salasana, $puhnumero);
        } else {
            // jos ei ole sillä puhelinumerolla tietoja, lisätään uude tiedot
            $sql = "INSERT INTO booking (etunimi, sukunimi, sahkoposti, salasana, puhnumero) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($yhteys, $sql);
            mysqli_stmt_bind_param($stmt, 'sssss', $etunimi, $sukunimi, $sahkoposti, $salasana, $puhnumero);
        }
//jos tietojen tallennus onnistuu, jos ei tulee virheilmoitus
        if (mysqli_stmt_execute($stmt)) {
            echo "Record successfully saved.";
        } else {
            echo "Error: " . mysqli_error($yhteys);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "All fields are required!";
    }
}

$tulos = mysqli_query($yhteys, "SELECT * FROM booking");

while ($rivi = mysqli_fetch_object($tulos)) {
    echo "Sukunimi=$rivi->sukunimi Etunimi=$rivi->etunimi Sähköposti=$rivi->sahkoposti Puhelinnumero=$rivi->puhnumero " . 
         "<a href='./poista.php?puhnumero=$rivi->puhnumero'>Poista</a> " . 
         "<a href='./muokkaa.php?puhnumero=$rivi->puhnumero'>Muokkaa</a><br>";
}

//suljetaan yhteys
mysqli_free_result($tulos);
mysqli_close($yhteys);
?>
             

        <footer class="footer">
            <div class="footer-container">
                <div class="footer-section">
                    <h3>About Us</h3>
                    <p>
                        Cozy french restaurant <br>
                    </p>
                    <p>
                        Mannerheimintie 59  Helsinki<br>
                    </p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="yhteystiedot.html">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>Email: leboeufchaud@gmail.com</p>
                    <p>Phone: +358 01 800 033</p>
                </div>
            </div>
        </footer>
    </div> <!--conteiner loppu-->

    <script src="burgeri.js"></script>
</body>
</html>