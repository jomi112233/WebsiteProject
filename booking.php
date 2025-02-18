<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="booking.css">
    <style>
        .container, form {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
        }
        form {
            width: 300px;
        }
        form label {
            margin-bottom: 10px;
            text-align: left;
            width: 100%;
        }
        form input {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }
        form input[type="submit"] {
            background-color: #bfa98a;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 15px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        form input[type="submit"]:hover {
            background-color: #555;
        }
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        .booking-container {
            margin-top: 20px;
            width: 80%;
            background-color: #333;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .booking-entry {
            background-color: #444;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .booking-entry p {
            margin: 0;
        }
        .booking-entry a {
            color: #bfa98a;
            text-decoration: none;
            margin-right: 10px;
        }
        .booking-entry a:hover {
            text-decoration: underline;
        }
        <?php endif; ?>
    </style>
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

        <h4>Pöydän Varaus</h4>
        <form action="booking.php" method="post">
            <label>Sukunimi: <input type="text" name="sukunimi" maxlength="50" required></label>
            <label>Etunimi: <input type="text" name="etunimi" maxlength="50" required></label>
            <label>Sähköposti: <input type="email" name="sahkoposti" maxlength="100" required></label>
            <label>Puhelinnumero: <input type="tel" name="puhnumero" maxlength="15" required></label>
            <label>Salasana: <input type="password" name="salasana" maxlength="50" required></label>
            <label>Valitse päivämäärä: <input type="date" name="pvm" required></label>
            <label>Valitse aika: <input type="time" name="aika" required></label>
            <label>Valitse henkilömäärä: <input type="number" name="hlomaara" min="1" required></label>
            <input type="submit" name="ok" value="Varaa pöytä">
        </form>

        <?php
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $yhteys = mysqli_connect("db", "root", "password", "websiteProject");
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
            $aika = $_POST["aika"];
            $hlomaara = $_POST["hlomaara"];

            $sql_check = "SELECT * FROM booking WHERE puhnumero = ?";
            $stmt_check = mysqli_prepare($yhteys, $sql_check);
            mysqli_stmt_bind_param($stmt_check, 's', $puhnumero);
            mysqli_stmt_execute($stmt_check);
            $result = mysqli_stmt_get_result($stmt_check);

            if (mysqli_num_rows($result) > 0) {
                $sql = "UPDATE booking SET etunimi=?, sukunimi=?, sahkoposti=?, salasana=?, pvm=?, aika=?, hlomaara=? WHERE puhnumero=?";
                $stmt = mysqli_prepare($yhteys, $sql);
                mysqli_stmt_bind_param($stmt, 'sssssssi', $etunimi, $sukunimi, $sahkoposti, $salasana, $pvm, $aika, $hlomaara, $puhnumero);
            } else {
                $sql = "INSERT INTO booking (etunimi, sukunimi, sahkoposti, salasana, puhnumero, pvm, aika, hlomaara) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($yhteys, $sql);
                mysqli_stmt_bind_param($stmt, 'sssssssi', $etunimi, $sukunimi, $sahkoposti, $salasana, $puhnumero, $pvm, $aika, $hlomaara);
            }
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "<p>Booking information saved successfully!</p>";
        }

        $tulos = mysqli_query($yhteys, "SELECT * FROM booking");

        echo '<div class="booking-container">';
        while ($rivi = mysqli_fetch_object($tulos)) {
            $formatted_date = date("d/m/Y", strtotime($rivi->pvm));
            echo "<div class='booking-entry'><p>Varauksesi tiedot = <b>Sukunimi:</b> " . htmlspecialchars($rivi->sukunimi) . ", <b>Etunimi:</b> " . htmlspecialchars($rivi->etunimi) . ", <b>Sähköposti:</b> " . htmlspecialchars($rivi->sahkoposti) . ", <b>Puhelinnumero:</b> " . htmlspecialchars($rivi->puhnumero) . ", <b>Päivämäärä:</b> $formatted_date, <b>Aika:</b> " . htmlspecialchars($rivi->aika) . ", <b>Henkilömäärä:</b> " . htmlspecialchars($rivi->hlomaara) . "</p>" . 
             "<a href='./poista.php?puhnumero=" . htmlspecialchars($rivi->puhnumero) . "'>Poista</a> " . 
             "<a href='./muokkaa.php?puhnumero=" . htmlspecialchars($rivi->puhnumero) . "'>Muokkaa</a></div>";
        }
        echo '</div>';

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
