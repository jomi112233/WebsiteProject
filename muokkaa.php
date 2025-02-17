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

// Validate credentials
if(empty($username_err) && empty($password_err)){
    // Prepare a select statement
    $sql = "SELECT id, etunimi, sukunimi, sahkoposti, salasana FROM Booking WHERE puhnumero = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_puhnumero);

        // Set parameters
        $param_puhnumero = $username;  // Username here is actually the phone number (puhnumero)
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Store result
            mysqli_stmt_store_result($stmt);
            
            // Check if phone number exists, if yes then verify password
            if(mysqli_stmt_num_rows($stmt) == 1){                    
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $id, $etunimi, $sukunimi, $sahkoposti, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($password, $hashed_password)){
                        // Password is correct, so start a new session
                        session_start();
                        
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["etunimi"] = $etunimi;
                        $_SESSION["sukunimi"] = $sukunimi;
                        $_SESSION["sahkoposti"] = $sahkoposti;
                        
                        // Redirect user to welcome page
                        header("location: welcome.php");
                    } else{
                        // Password is not valid, display a generic error message
                        $login_err = "Invalid phone number or password.";
                    }
                }
            } else{
                // Phone number doesn't exist, display a generic error message
                $login_err = "Invalid phone number or password.";
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
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
