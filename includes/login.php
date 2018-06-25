<?php include "db.php"; ?>
<?php session_start(); ?>    <!--ijungiame sesija su sia eilute-->

<?php
/* login forma */
if(isset($_POST['login'])){ 
    $username = $_POST['username']; //gauname username ir password ir juos uzdedame prie $variable
    $password = $_POST['password'];
    
    /* apsauga nuo bandymo isilauzti rasant kazka i login langelius */
    $username = mysqli_real_escape_string($connection, $username);  //juos pravalome nuo blogo ir vel pridedame prie tu paciu $variables
    $password = mysqli_real_escape_string($connection, $password);
                                        /*sita kintamaji gauta is "table-> users" sql bazes, username prilyginam kitam kintamajam {$username} gautame is gaunamo username'o auksciau esancio isset post*/
    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query); //sita naudojame kad gautume visa informacija, kai prisijungiame prie duombazes ir ta informacija prisegame prie variable
    if(!$select_user_query) {   //tuomet testuojame ar tai tas kas yra, ar ne tas kas yra duombazej.
        die("Query failed" . mysqli_error($connection));    //jeigu viskas ok, tuomet einame prie while loop, kurio deka istraukiame ta visa informacija is duombazes
    }
/* login formos pabaiga */
    while($row = mysqli_fetch_array($select_user_query)) {    //cia tam, kad istrauktume informacija, kad paziuretu kas ten ir istrauktu
        $db_user_id = $row['user_id'];  //istraukiame informacija ir prisegame prie kazkokio variable. kai tik prisegame sias vertes prie kintamuju siame array
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];                  //kai tik istraukiame info is bazes tikriname su if-->
        
    }
    /* loginimasis */   //tikriname su sia funkcija ar sie duomenys tokie pat is gautos per login forma su tais paciai kurie yra duombazej. jeigu jie neteisingi, header deka vartotojas niekur nenueina
if($username === $db_username && $password === $db_user_password) {    //galiam daryti su if == arba if !==, kaip pats nori. --> edwin from future pakeite i "===" identical reiksme
    $_SESSION['username'] = $db_username;       //cia kazkas panasaus i placeholder ar variable, ar cookies, prie kurio prisegame gautas reiksmes
    $_SESSION['firstname'] = $db_user_firstname;
    $_SESSION['lastname'] = $db_user_lastname;
    $_SESSION['user_role'] = $db_user_role;     //kai tik prijungiamas sitas prie sesijos, galima pasiekti sita value bet kur
    
    header("Location: ../admin");   //kai tik viskas sueina, tuomet redirektinasi viskas i admin puslapi ir prie jo prikabina ir parodo tame admin_header
    //header("Location: ../index.php ");   //Location turi buti su L, ne su l. "../" turi buti, nes mes esame include folderyje.
//} else if ($username == $db_username && $password == $db_user_password) {   //jeigu viskas atitinka gerai, tuomet prisegam visus duomenis prie sesijos..
    //edwin from future panaikino sita dali ir padare keleta pakeitimu

} else {
    header("Location: ../index.php");
}
}

?>