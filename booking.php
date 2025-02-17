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

        <h2>Fill in!</h2>
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

                .mobile-nav {
                    overflow: hidden;
                    background-color: #202124;
                    position: relative;
                }




                .mobile-nav #linkit {
                    display: none;
                }

                .mobile-nav a {
                    color: white;
                    padding: 14px 16px;
                    text-decoration: none;
                    font-size: 17px;
                    display: block;
                }

                .mobile-nav a.burgeri {
                    background: #202124;
                    display: block;
                    position: absolute;
                    right: 0;
                    top: 0;
                }

                .mobile-nav a:hover {
                    color: #bfa98a;
                    text-align: center;
                }

                .active {
                    width: 30%;
                    margin: 0;
                    padding: 0;
                }

            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .hero {
                background-color: #333;
                color: #fff;
                padding: 20px;
                text-align: center;
            }

            .navigation {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .navigation nav ul {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
            }

            .navigation nav ul li {
                margin-left: 20px;
            }

            .navigation nav ul li a {
                color: #fff;
                text-decoration: none;
            }

            form {
                display: flex;
                flex-direction: column;
            }

            form label {
                margin-bottom: 10px;
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

            footer {
                background-color: #333;
                color: #fff;
                padding: 20px;
                text-align: center;
            }

            .footer-container {
                display: flex;
                justify-content: space-between;
            }

            .footer-section {
                flex: 1;
                padding: 10px;
            }

            .footer-section h3 {
                margin-top: 0;
            }

            .footer-section ul {
                list-style: none;
                padding: 0;
            }

            .footer-section ul li {
                margin-bottom: 10px;
            }

            .footer-section ul li a {
                color: #fff;
                text-decoration: none;
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
    echo "Booking information saved successfully!";
}

$tulos = mysqli_query($yhteys, "SELECT * FROM booking");

while ($rivi = mysqli_fetch_object($tulos)) {
    echo "Sukunimi=$rivi->sukunimi Etunimi=$rivi->etunimi Sähköposti=$rivi->sahkoposti Puhelinnumero=$rivi->puhnumero Päivämäärä=$rivi->pvm Aika=$rivi->aika Henkilömäärä=$rivi->hlomaara " . 
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