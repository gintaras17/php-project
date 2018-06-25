<?php
//SET THE TIME ZONE
date_default_timezone_set('Europe/Vilnius');
 
//CREATE TIMESTAMP VARIABLES
$current_ts  = time();
//$deadline_ts = date("l", mktime(21,50,00,30,4,2018));
//$deadline_ts = date('l jS \of F Y H:i:s a');
$deadline_ts = DateTime + (0 * 0 * 0 * 10 );
 
//IF THE DEADLINE HAS PASSED, LET USER KNOW...ELSE, DISPLAY THE REGISTRATION FORM
if($current_ts > $deadline_ts) {
     echo "Viso";//message about the form being disabled
} else {
     echo "Labas";//code for the registration form
}
?>