<?php

session_start();

$day = $_POST['day'];
$_SESSION['day'] = $day;
$_SESSION['id_day'] = $_POST['day'];

$month = $_POST['month'];
$_SESSION['month'] = $month;


$month_name = date("F", mktime(0, 0, 0, $month, 10));
$month_name_french = array("January" => "Janvier", "February" => "Février", "March" => "Mars", "April" => "Avril", "May" => "Mai", "June" => "Juin", "July" => "Juillet", "August" => "Août", "September" => "Septembre", "October" => "Octobre", "November" => "Novembre", "December" => "Décembre");
$month_name_french = $month_name_french[$month_name];
$_SESSION['month_name'] = $month_name_french;

$year = $_POST['year'];
$_SESSION['year'] = $year;  



echo "<h2 id='jour_creneau'>" . $_SESSION['id_day'] . " " . $month_name_french . " " . $_SESSION['year'] . "</h2>";
echo "<div class='creneau__group'>";
echo "<button id=1 class='creneau__button'>10:00 - 11:00</button>";
echo "<button id=2 class='creneau__button'>11:00 - 12:00</button>";
echo "</div>";
echo "<div class='creneau__group'>";
echo "<button id=3 class='creneau__button'>12:00 - 13:00</button>";
echo "<button id=4 class='creneau__button'>13:00 - 14:00</button>";
echo "</div>";
echo "<div class='creneau__group'>";
echo "<button id=5 class='creneau__button'>14:00 - 15:00</button>";
echo "<button id=6 class='creneau__button'>15:00 - 16:00</button>";
echo "</div>";
echo "<div class='creneau__group'>";
echo "<button id=7 class='creneau__button'>16:00 - 17:00</button>";
echo "<button id=8 class='creneau__button'>17:00 - 18:00</button>";

echo "</div>";

echo "<script type='text/javascript'>";
echo "$(document).ready(function(){";
echo "$('.creneau__button').click(function(){";

echo '
// Remove the class from all elements
$(".creneau__button").removeClass("creneau__selected");

// Add the class only to the clicked element
$(this).addClass("creneau__selected");
';

echo "console.log('click');";
echo "console.log($(this).text());";
echo "let creneau_id = $(this).attr('id');";
echo "console.log(creneau_id);";
echo "event.preventDefault();";
echo "$.ajax({";
echo "url: 'AJAX/confirm_button.php',";
echo "type: 'POST',";
echo "data: {";
echo "creneau: $(this).text(),";
echo "id_creneau: creneau_id,";
echo "day: " . $_SESSION['id_day'] . ",";
echo "month: " . $_SESSION['month'] . ",";
echo "year: " . $_SESSION['year'] . "},";

echo "success: function(response){";
echo "$('#confirm_button').html(response);";
echo "}";
echo "});";
echo "});";
echo "});";
echo "</script>";


?>  

