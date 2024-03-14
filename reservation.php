<?php

session_start();


require 'AJAX/connexion.php';

$id_creneau = $_SESSION['id_creneau'];
$creneau = $_SESSION['creneau'];
$day = $_SESSION['id_day'];
$month = $_SESSION['month'];
$year = $_SESSION['year'];
$date = $year . "-" . $month . "-" . $day;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link rel="stylesheet" href="reservation.css">
</head>
<body>
    
        <div class='recap_reservation'>
            <h1>Réservation</h1>
            <p>Date: <?php echo $day . " " . $_SESSION['month_name'] . " " . $year; ?></p>
            <p>Créneau: <?php echo $creneau; ?></p>
        </div>

        <form class="infos_persos" action="AJAX/confirm_reservation.php" method="post">
            <h2>Informations personnelles</h2>
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" required>
                <label for="surname">Prénom</label>
                <input type="text" id="surname" name="surname" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <label for="tel">Téléphone</label>
                <input type="tel" id="tel" name="tel" pattern="[0-9]{10}" required>
                <div class="separator"></div>
                <?php 
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == 1) {
                            echo "<div class='error'>Vous ne pouvez pas réserver pour plus de 10 personnes.</div>";
                        } else if ($_GET['error'] == 2) {
                            echo "<div class='error'>Vous devez réserver pour au moins une personne.</div>";
                        }
                    }
                ?>
                <div class="choix__visiteurs">
                <div class='flex__column'>
                <?php 
                echo "
                <strong><p>" . $_SESSION['id_day'] . " " . $_SESSION['month_name'] . " " . $_SESSION['year'] . "</p></strong>
                <p>" . $_SESSION['creneau'] . "</p>
                </div>

                <div class='container__visiteurs'>
                <div class='box__visiteurs'>
                <label for='adultes'>Plein Tarif</label>
                <input type='number' id='adultes' name='adultes' min='0' max='10' value='0'>
                <p>16€</p>
                </div>
                <div class='box__visiteurs'>
                <label for='enfants'>Jeunes de moins <br> de 18 ans</label>
                <input type='number' id='enfants' name='enfants' min='0' max='10' value='0'>
                <p>8€</p>
                </div>
                </div>
                "
                ?>     
                </div>
                <input class="valider__button" type="submit" value="Valider">
                </form>




</body>
</html>

