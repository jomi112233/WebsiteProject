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
    laji:<input type="text" name="laji" value=""><br>
    paino:<input type="text" name="paino" value=""><br>
    <input type="submit" name="ok" value="OK"><br>
</form>

<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // https://www.php.net/manual/en/function.mysqli-connect.php
    $yhteys = mysqli_connect("db", "root", "password", "tkkalat");
} catch (Exception $e) {
    header("Location:../html/yhteysvirhe.html");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $laji = isset($_POST["laji"]) ? trim($_POST["laji"]) : "";
    $paino = isset($_POST["paino"]) ? (float)$_POST["paino"] : 0;

    if (!empty($laji) && $paino > 0) {  
        $sql = "INSERT INTO kala (laji, paino) VALUES (?, ?)";
        $stmt = mysqli_prepare($yhteys, $sql);
        mysqli_stmt_bind_param($stmt, 'sd', $laji, $paino);
        mysqli_stmt_execute($stmt);
    }
}


$tulos = mysqli_query($yhteys, "SELECT * FROM kala");

while($rivi=mysqli_fetch_object($tulos)) {
    print"id=$rivi->id laji=$rivi->laji paino=$rivi->paino".
"<a href='./poista.php?id=$rivi->id'>Poista</a>".
"<a href='./muokkaakala.php?id=$rivi->id'>Muokkaa</a><br>";
}

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