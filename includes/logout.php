<?php session_start(); ?>    <!--ijungiame sesija su sia eilute-->

<?php

    $_SESSION['username'] = null;   //reiskia nieko, netgi jokios zodzio..
    $_SESSION['firstname'] = null;
    $_SESSION['lastname'] = null;
    $_SESSION['user_role'] = null;  //su null atsaukiame sesija ir keliames atgal tarkim i index.php

header("Location: ../index.php");

?>