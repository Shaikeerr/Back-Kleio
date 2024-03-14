<?php 

session_start();

$id = $_POST['id_creneau'];
$_SESSION['id_creneau'] = $id;

$creneau = $_POST['creneau'];
$_SESSION['creneau'] = $creneau;

echo "<form class='choix__visiteurs' action='confirm_reservation.php' method='post'>

<div class='flex__column'>
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
<input class=valider__button  type='submit' value='Valider'>
</form>;


<script type='text/javascript'>
$(document).ready(function(){
    $('#confirm').click(function(){
        event.preventDefault();
        $.ajax({
            url: 'confirm_reservation.php',
            type: 'POST',
            data: {
                id_creneau: " . $_SESSION['id_creneau'] . ",
                creneau: '" . $_SESSION['creneau'] . "',
                day: " . $_SESSION['id_day'] . ",
                month: " . $_SESSION['month'] . ",
                year: " . $_SESSION['year'] . "},
            
            success: function(response){
                if (response.errors && response.errors.length > 0) {
                    // Afficher les messages d'erreur sur la page
                    $('#reservation').html(response.errors.join('<br>'));
                } else {
                    // Redirection vers la page précédente
                    window.location.href = 'index.php';
                }
            },
            error: function(response){
                $('#reservation').html('Une erreur s\'est produite lors de la soumission du formulaire.');
            }
        });
    });
});
</script>";
?>
