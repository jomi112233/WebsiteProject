<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muokkaa Tietoja</title>
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
                <a href="booking.php">Booking</a>
                <a href="login.php">Login</a>
            </div>
            <a href="javascript:void(0);" class="burgeri" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <header class="hero">
            <div class="navigation">
                <a href="index.html"><img src="kuvat/logo-no-background.png" alt="Logo" class="logo"></a>
                <nav>
                    <ul>
                        <li><a href="menu.html">Menu</a></li>
                        <li><a href="drinkit.html">Drinks</a></li>
                        <li><a href="yhteystiedot.html">Contacts</a></li>
                        <li><a href="booking.php">Booking</a></li>
                    </ul>
                </nav>
            </div>
        </header>
    
    <div class="container">
        <?php
        require_once 'config.php';
        $muokattava = $_GET["puhnumero"] ?? "";
        if (empty($muokattava)) {
            header("Location: booking.php");
            exit;
        }
        $sql = "SELECT * FROM booking WHERE puhnumero = ?";
        $stmt = mysqli_prepare($yhteys, $sql);
        mysqli_stmt_bind_param($stmt, 's', $muokattava);
        mysqli_stmt_execute($stmt);
        $tulos = mysqli_stmt_get_result($stmt);
        if (!$rivi = mysqli_fetch_assoc($tulos)) {
            mysqli_close($yhteys);
            header("Location: booking.php");
            exit;
        }
        mysqli_close($yhteys);
        ?>

        <h2>Muokkaa Tietoja</h2>

        <form action="paivita.php" method="post">
            <label>Sukunimi: <input type="text" name="sukunimi" value="<?= htmlspecialchars($rivi['sukunimi']) ?>" required></label>
            <label>Etunimi: <input type="text" name="etunimi" value="<?= htmlspecialchars($rivi['etunimi']) ?>" required></label>
            <label>Sähköposti: <input type="email" name="sahkoposti" value="<?= htmlspecialchars($rivi['sahkoposti']) ?>" required></label>
            <label>Puhelinnumero: <input type="tel" name="puhnumero" value="<?= htmlspecialchars($rivi['puhnumero']) ?>" readonly></label>
            <label>Salasana: <input type="password" name="salasana"></label>
            <label>Päivämäärä: <input type="date" name="pvm" value="<?= htmlspecialchars($rivi['pvm']) ?>" required></label>
            <label>Aika: <input type="time" name="aika" value="<?= htmlspecialchars($rivi['aika']) ?>" required></label>
            <label>Henkilömäärä: <input type="number" name="hlomaara" value="<?= htmlspecialchars($rivi['hlomaara']) ?>" min="1" required></label>
            
            <div class="button-container">
                <input type="submit" value="Tallenna">
                <input type="submit" value="Poista" a href="poista.php?puhnumero=<?= htmlspecialchars($rivi['puhnumero']) ?>" class="delete-button"></input>
            </div>
        </form>
    </div>

    <style>
        body {
            background-color: #202124;
            font-family: Arial, sans-serif;
        }
        .hero {
        background: url('kuvat/kattaus1.jpg') no-repeat center center;
        background-size: cover; 
        height: 60vh; 
        display: flex; 
        flex-direction: column;
        justify-content:end;
        align-items: center;
        color: white; 
        text-align: center;
        position: relative;

}
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h2 {
            color: #ffff;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-bottom: 20px;
        }
        form label {
            margin-bottom: 10px;
            width: 100%;
            text-align: left;
            font-family: Arial, sans-serif;
            text-decoration: none;
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
            padding: 10px;
            margin-top: 10px;
        }
        form input[type="submit"]:hover {
            background-color: #555;
        }
        .button-container {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .delete-button {
            background-color: #bfa98a;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px;
            margin-top: 10px;
            text-decoration: ;  
            
        }
        .delete-button:hover {
            background-color: #555;
            text-decoration: none;
        }
    </style>

    <script src="burgeri.js"></script>
    
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

</body>
</html>
