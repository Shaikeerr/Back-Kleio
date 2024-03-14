<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel=stylesheet href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> <!-- Lien vers la bibliothèque jQuery pour AJAX -->
</head>
<body>


<div class="header">
    <h1> Notre exposition vise à vous faire découvrir l'art de Rosa Bonheur, une artiste peintre française du XIXème siècle. Grâce à la Réalité Virtuelle, vous pourrez découvrir ses oeuvres comme si vous y étiez. </h1>
</div>

<div class="reservation">
    <div class="flex_row">
        <div class="calendar">
            <?php
        
            // Démarrer la session pour stocker le jour, le mois, l'année et la date en lettre dans des variables de session
            session_start();
        
            $currentMonth = date('m'); // Récupérer le mois actuel
            $currentYear = date('Y'); // Récupérer l'année actuelle
            $currentMonthName = date('F'); // Récupérer le mois actuel en lettres
            $currentDay = date('d'); // Récupérer le jour actuel
        
            // En cas de retour en arrière, si aucun jour n'est sélectionné, le jour actuel est sélectionné
            if (empty($_SESSION['id_day'])) {
                $_SESSION['id_day'] = $currentDay;
            }
        
            // Récupère le nombre total de jours dans le mois actuel selon le calendrier grégorien
            $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
        
            // Affiche le mois et l'année actuels en haut du calendrier
            echo "<h3>$currentMonthName $currentYear</h3>"
            ?>

           <!--  Affiche les jours de la semaine en haut de la grille -->
            <div class="calendar__date">
                <div class="calendar__day">Lu</div>
                <div class="calendar__day">Ma</div>
                <div class="calendar__day">Me</div>
                <div class="calendar__day">Je</div>
                <div class="calendar__day">Ve</div>
                <div class="calendar__day">Sa</div>
                <div class="calendar__day">Di</div>
    
                <?php
            
                $firstDay = date('N', strtotime("$currentYear-$currentMonth")); // Récupère le jour de la semaine du premier jour du mois
                $lastDay = date('N', strtotime("$currentYear-$currentMonth-$numberOfDays")); // Récupère le jour de la semaine du dernier jour du mois
            
                // Si le premier jour du mois n'est pas un lundi, affiche des cases vides jusqu'au premier jour
                for ($i = 1; $i < $firstDay; $i++) {
                    echo "<div class='calendar__number'></div>";
                }
            
                // Affiche les jours du mois a partir du moment ou le premier jour du mois est atteint
                for ($i = 1; $i <= $numberOfDays; $i++) {
                    
                    // Si le jour actuel est le jour sélectionné, il est mis en surbrillance
                    if ($i == $currentDay) {
                        echo "<a href='index.php?id=" . $i ."' id=". $i . " class='calendar__number today'>$i</a>";
            
                    // Sinon, il n'est pas mis en surbrillance
                    } else {
                        echo "<a href='index.php?id=" . $i ."' id=". $i . " class='calendar__number'>$i</a>";
                    }
                }
            
                ?>
    
               <!--  Script AJAX pour récupérer les créneaux disponibles -->
                <script type="text/javascript">
                    $(document).ready(function(){
                        $('.calendar__number').click(function(){ // Lorsqu'un jour est cliqué
                            event.preventDefault(); // Empêche le comportement par défaut des liens
                            $.ajax({
                                url: 'AJAX/choose_date.php', // Appelle le script AJAX "choose_date.php" pour récupérer les créneaux disponibles
                                type: 'POST',
                                data: { // Envoie les données suivantes au script 
                                    day: $(this).attr('id'), // Le jour sélectionné
                                    month: <?php echo $currentMonth; ?>, // Le mois actuel
                                    year: <?php echo $currentYear; ?>}, // L'année actuelle
            
                                success: function(response){
                                    $('#creneaux').html(response); // Affiche les créneaux disponibles dans la div #creneaux
                                }
                            });
                        });
                    });
                </script>

                <!-- Fin du script AJAX pour récupérer les créneaux disponibles -->
                
            </div>
        </div>
    
        <div id=creneaux class="creneaux">
            <h2> Choisissez un créneau <br> via le calendrier ci-contre</h2> <!-- Lorsque le jour n'est pas sélectionné, aucun créneau n'est affiché. -->
        </div>

    </div>
    
    <div id="confirm_button"></div> <!-- Affiche le bouton de confirmation de réservation lorsqu'un créneau est sélectionné -->

</div>
        


</div>

<div class="footer">
    <p>© 2024 - Tous droits réservés</p>
</div>

</body>
<script src="script.js"></script> <!-- Lien vers le fichier script.js permettant de mettre en surbrillance les jours du calendrier lorsqu'ils sont cliqués -->
</html>