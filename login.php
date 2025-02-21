<?php
// Ensure no output before this point
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $puhnumero = trim($_POST["puhnumero"]);
    $salasana = trim($_POST["salasana"]);

    // Admin credentials
    $admin_puhnumero = "000";
    $admin_salasana = "salasana";

    if ($puhnumero === $admin_puhnumero && $salasana === $admin_salasana) {
        header("Location: admin.php");
        exit;
    }

    require_once 'config.php';

    $sql = "SELECT * FROM booking WHERE puhnumero = ?";
    $stmt = mysqli_prepare($yhteys, $sql);
    mysqli_stmt_bind_param($stmt, 's', $puhnumero);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($salasana, $row['salasana'])) {
            

            header("Location: muokkaa.php?puhnumero=" . urlencode($puhnumero));
            exit;
        } else {
            header("Location: login.php?error=invalid_credentials");
            exit;
        }
    } else {
        header("Location: login.php?error=invalid_credentials");
        exit;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($yhteys);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="booking.css">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }
        h2 {
            color: #333;
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
        }
        form label {
            margin-bottom: 10px;
            width: 100%;
            text-align: left;
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
            background-color: #202124;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px;
            margin-top: 10px;
        }
        form input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label>Puhelinnumero: <input type="tel" name="puhnumero" maxlength="15" required></label>
            <label>Salasana: <input type="password" name="salasana" maxlength="50" required></label>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>