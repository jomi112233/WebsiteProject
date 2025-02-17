<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="booking.css">
</head>
<body>
    <div class="container">
        <header class="hero">
            <div class="navigation">
                <a href="index.html"><img src="kuvat/logo-no-background.png" alt="Logo" class="logo"></a>
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

        <h4>Fill in!</h4>
<form action="booking.php" method="post">
    <label>Sukunimi: <input type="text" name="sukunimi" required></label><br>
    <label>Etunimi: <input type="text" name="etunimi" required></label><br>
    <label>Sähköposti: <input type="email" name="sahkoposti" required></label><br>
    <label>Puhelinnumero: <input type="tel" name="puhnumero" required></label><br>
    <label>Salasana: <input type="password" name="salasana" required></label><br>
    <label>Valitse päivämäärä: <input type="date" name="pvm" required></label><br>
    <label>Valitse aika: <input type="time" name="aika" required></label><br>
    <label>Valitse henkilömäärä: <input type="number" name="hlomaara" min="1" required><br>
    <input type="submit" name="ok" value="OK">
</form>
<style>

            form {
                display: flex;
                flex-direction: column;
                color: white;
            }

            form label {
                margin-bottom: 10px;
            }
            
            h4{
                color: white;
            }
            p {
                color: white;
            }

            form input[type="text"],
            form input[type="email"],
            form input[type="tel"],
            form input[type="password"] {
                padding: 10px;
                margin-top: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            form input[type="submit"] {
                padding: 10px;
                background-color:#202124;

                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            form input[type="submit"]:hover {
                background-color: #555;
            }

        </style>
<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$server = "db";
$username = "root";
$password = "password";
$database = "websiteProject";

$yhteys = mysqli_connect($server, $username, $password, $database);
if (!$yhteys) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sukunimi = trim($_POST["sukunimi"]);
    $etunimi = trim($_POST["etunimi"]);
    $sahkoposti = trim($_POST["sahkoposti"]);
    $puhnumero = trim($_POST["puhnumero"]);
    $salasana = password_hash(trim($_POST["salasana"]), PASSWORD_DEFAULT);
    $pvm = $_POST["pvm"];
    $aika =($_POST["aika"]);
    $hlomaara = $_POST["hlomaara"];

    $sql_check = "SELECT * FROM booking WHERE puhnumero = ?";
    $stmt_check = mysqli_prepare($yhteys, $sql_check);
    mysqli_stmt_bind_param($stmt_check, 's', $puhnumero);
    mysqli_stmt_execute($stmt_check);
    $result = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result) > 0) {
        $sql = "UPDATE booking SET etunimi=?, sukunimi=?, sahkoposti=?, salasana=?, pvm=?, aika=?, hlomaara=? WHERE puhnumero=?";
        $stmt = mysqli_prepare($yhteys, $sql);
        mysqli_stmt_bind_param($stmt, 'ssssssis', $etunimi, $sukunimi, $sahkoposti, $salasana, $pvm, $aika, $hlomaara, $puhnumero);
    } else {
        $sql = "INSERT INTO booking (etunimi, sukunimi, sahkoposti, salasana, puhnumero, pvm, aika, hlomaara) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($yhteys, $sql);
        mysqli_stmt_bind_param($stmt, 'ssssssis', $etunimi, $sukunimi, $sahkoposti, $salasana, $puhnumero, $pvm, $aika, $hlomaara);
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "<p>Booking information saved successfully!</p>";
}

$tulos = mysqli_query($yhteys, "SELECT * FROM booking");

while ($rivi = mysqli_fetch_object($tulos)) {
    echo "<p>Sukunimi=$rivi->sukunimi Etunimi=$rivi->etunimi Sähköposti=$rivi->sahkoposti Puhelinnumero=$rivi->puhnumero Päivämäärä=$rivi->pvm aika= $rivi->aika </p>" . 
         "<a href='./poista.php?puhnumero=$rivi->puhnumero'>Poista</a> " . 
         "<a href='./muokkaa.php?puhnumero=$rivi->puhnumero'>Muokkaa</a><br>";
}

mysqli_free_result($tulos);
mysqli_close($yhteys);
?>

             

        <footer class="footer">
            <div class="footer-container">
                <div class="footer-section">
                    <h3>About Us</h3>
                    <p>Cozy French restaurant</p>
                    <p>Mannerheimintie 59, Helsinki</p>
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
    </div>
    <script src="burgeri.js"></script>
</body>
</html>