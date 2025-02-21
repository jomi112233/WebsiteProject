<?php
    // Yhteys tietokantaan
    require_once 'config.php';



    $tulos = mysqli_query($yhteys, "SELECT * FROM booking");

    echo '<div class="booking-container">';
    while ($rivi = mysqli_fetch_object($tulos)) {
        $formatted_date = date("d/m/Y", strtotime($rivi->pvm));
        echo "<div class='booking-entry'><p>Varauksesi tiedot = <b>Sukunimi:</b> " . htmlspecialchars($rivi->sukunimi) . ", <b>Etunimi:</b> " . htmlspecialchars($rivi->etunimi) . ", <b>Sähköposti:</b> " . htmlspecialchars($rivi->sahkoposti) . ", <b>Puhelinnumero:</b> " . htmlspecialchars($rivi->puhnumero) . ", <b>Päivämäärä:</b> $formatted_date, <b>Aika:</b> " . htmlspecialchars($rivi->aika) . ", <b>Henkilömäärä:</b> " . htmlspecialchars($rivi->hlomaara) . "</p>" . 
         "<a href='./poista.php?puhnumero=" . htmlspecialchars($rivi->puhnumero) . "'>Poista</a> " . 
         "<a href='./muokkaa.php?puhnumero=" . htmlspecialchars($rivi->puhnumero) . "'>Muokkaa</a></div>";
    }
    echo '</div>';


?>