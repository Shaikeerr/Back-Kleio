<?php 

session_start();

require 'connexion.php';

$id_creneau = $_POST['id_creneau'];
$creneau = $_POST['creneau'];

$_SESSION['id_creneau'] = $id_creneau;

$_SESSION['creneau'] = $creneau;

echo "<a href='./reservation.php'><button id=1 class='confirm__button'>Suivant</button></a>";



?>