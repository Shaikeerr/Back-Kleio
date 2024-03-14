<?php
session_start();


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require 'connexion.php';

$id_creneau = $_SESSION['id_creneau'];
$creneau = $_SESSION['creneau'];
$day = $_SESSION['id_day'];
$month = $_SESSION['month'];
$year = $_SESSION['year'];
$date = $year . "-" . $month . "-" . $day;

$adultes = $_POST['adultes'];
$enfants = $_POST['enfants'];
$visiteurs = $adultes + $enfants;

$name = $_POST['name'];
$surname = $_POST['surname'];
$fullname = $surname . " " . $name;

$email = $_POST['email'];
$tel = $_POST['tel'];



if ($visiteurs > 10) {
    header('Location: reservation.php?error=1');
} else if ($visiteurs == 0) {
    header('Location: reservation.php?error=2');
} else {
    $sql = "INSERT INTO reservations (id_reservation, nom_reservation, email_reservation, tel_reservation, date_reservation, creneau_reservation, plein_tarif, tarif_reduit) VALUES (NULL, :name, :email, :tel, :date, :creneau, :adultes, :enfants)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':name', $fullname);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':tel', $tel);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':creneau', $id_creneau);
    $stmt->bindValue(':adultes', $adultes);
    $stmt->bindValue(':enfants', $enfants);
    $stmt->execute();


    try {
        // Tentative de création d’une nouvelle instance de la classe PHPMailer, avec les exceptions activées
        $mail = new PHPMailer (true);
        // Configuration du serveur
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        
        // Informations personnelles
        $mail->Host = "smtp.ionos.fr";
        $mail->Port = "465";
        $mail->Username = "no_reply@reservationexpo.shaikeerr.fr";
        $mail->Password = "Motdepassedefoufurieux123*";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        // Destinataire
        $mail->setFrom('no_reply@reservationexpo.shaikeerr.fr', 'Exposition Kleio');
        $mail->addAddress($email, $name);
        

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = "Confirmation de réservation";
        $mail->Body = '
        <html>
            <head>
            <body style="background-color: #282828;color: #C6B38E;font-family: Arial, sans-serif;margin: 0;padding: 0; border: solid 5px #C6B38E;">
            <div class="container" style="max-width: 600px;margin: 0 auto;padding: 20px;align-items: center;">
                <img src="https://media.discordapp.net/attachments/1197131402697769023/1217137303097708666/Group_39.jpg?ex=6602ee72&is=65f07972&hm=7c3d401b7024da1d8391e68b5626f4ddfdea45d8281abe3838ac5a10029cc063&=&format=webp&width=462&height=458" class="logo" alt="logo" style="display: block; margin: 0 auto;width: 150px;height: auto;">
                <h1 style="text-align: center; margin-bottom: 10px; font-size: 48px; color: #C6B38E;">Votre réservation</h1>
                <p style="text-align: center; margin-bottom: 10px; color: #C6B38E;">Bonjour ' . $surname .',</p>
                <p style="text-align: center; margin-bottom: 10px; color: #C6B38E;">Nous vous confirmons votre réservation pour le ' . $day . ' ' .$_SESSION["month_name"] . ' ' .  $year .' à ' . $creneau . ' pour ' . $visiteurs .' personnes.</p>
                <p style="text-align: center; margin-bottom: 10px; color: #C6B38E;">Le montant total de votre réservation est de ' . ($adultes * 16 + $enfants * 8) .'€.</p>
                <p style="text-align: center; color: #C6B38E; margin-bottom: 10px;">À bientôt !</p>
                <div class="container_rs" style="display: block; margin: 0 auto; margin-top: 20px;margin-bottom: 20px;width: 25%;">
                <a href="https://www.instagram.com/kleio_agence?igsh=bXh6cXl5M2tzODcw" class=""><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Instagram_icon.png/1200px-Instagram_icon.png" alt="Instagram" style="width: 48px; height: auto; margin-right: 20px;"></a>
                <a href="https://www.linkedin.com/in/kleio-agence-7b3b3b1b3" class=""><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/LinkedIn_logo_initials.png/600px-LinkedIn_logo_initials.png" alt="LinkedIn" style="width: 48px; height: auto; margin-left: 20px;"></a>
                </div>
                
                <a href="https://www.kleio-agence.com" class="button" style="display: block; margin: 0 auto; background-color: #C6B38E;color: #282828;text-decoration: none;padding: 10px 20px;border-radius: 4px; width: 50%; text-align: center;">Visiter notre site</a>
            </div>
            </body>
            </html>
            ';

        // Envoi du mail
        $mail->CharSet = 'UTF-8';
        $mail->Encoding='base64';
        $mail->send();

    // (…)
    } catch (Exception $e) {
            echo "Mailer Error: ".$mail->ErrorInfo;
    }





    header('Location: index.php');
    exit(); 
}
?>
