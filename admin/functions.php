<?php

//=== Database Helper Functions ===//

function currentUser(){
    if (isset($_SESSION['username'])){
        return $_SESSION['username'];
    }
    return false;
}

function imagePlaceholder($image=''){
    if(!$image){
        return 'images.jpg';
    } else {
        return $image;
    }
}

function redirect($location) {
    header("Location:" . $location);    //vietoj return dinamiskiau deti exit
    exit;
}

function query($query){
    global $connection;
    $result = mysqli_query($connection,$query);
    confirmQuery($result);
    return $result;
}

function fetchRecords($result){
    return mysqli_fetch_array($result);
}

function count_records($result){
    return mysqli_num_rows($result);
}

//== End Database Helper ==//

//== General Helpers ==//

function get_user_name(){
    return isset($_SESSION['username']) ? ($_SESSION['username']) : null;
}

//== End General Helpers ==//



//== Authentication Helper ==//

function is_admin() {
    if(isLoggedIn()){
        $result = query("SELECT user_role FROM users WHERE user_id=".$_SESSION['user_id']."");
        $row = mysqli_fetch_array($result);
        
        if($row['user_role'] == 'admin') {
        return true;
        } else {
        return false;
        }
    }
    return false;
}

//== End Authentication Helper ==//

//== User Specific Helper ==//

function get_all_user_posts(){
     return query("SELECT * FROM posts WHERE user_id=".loggedInUserId()."");
}

function get_all_posts_user_comments(){
    return query("SELECT * FROM posts
    INNER JOIN comments ON posts.post_id = comments.comment_post_id
    WHERE user_id=".loggedInUserId()."");
}

function get_all_user_categories(){
    return query("SELECT * FROM categories WHERE user_id=".loggedInUserId()."");
}

function get_all_user_published_posts(){
    return query("SELECT * FROM posts WHERE user_id=".loggedInUserId()." AND post_status='published'");
}

function get_all_user_draft_posts(){
    return query("SELECT * FROM posts WHERE user_id=".loggedInUserId()." AND post_status='draft'");
}

function get_all_user_approved_posts_comments(){
    return query("SELECT * FROM posts
    INNER JOIN comments ON posts.post_id = comments.comment_post_id
    WHERE user_id=".loggedInUserId()." AND comment_status='approved'");
}

function get_all_user_unapproved_posts_comments(){
    return query("SELECT * FROM posts
    INNER JOIN comments ON posts.post_id = comments.comment_post_id
    WHERE user_id=".loggedInUserId()." AND comment_status='unapproved'");
}

//== End User Specific Helper ==//

function ifItIsMethod($method=null){    //nezinau kam sita funkcija:)))
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
        return true;
    }
    return false;
}

function isLoggedIn(){
    if(isset($_SESSION['user_role'])){
        return true;
    }
    return false;
}

function loggedInUserId(){
    if(isLoggedIn()){
        $result = query("SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'");
        confirmQuery($result);
        $user = mysqli_fetch_array($result);
//        if(mysqli_num_rows($result) >=1){
//            return $user['user_id'];
//        }
        return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
    }
    return false;
}

function userLikedThisPost($post_id){
    $result = query("SELECT * FROM likes WHERE user_id=" .loggedInUserId() . " AND post_id={$post_id}");
    confirmQuery($result);
    return mysqli_num_rows($result) >= 1 ? true : false;    //if >=1 return true, if not, return false
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }
}

function getPostlikes($post_id){
    $result = query("SELECT * FROM likes WHERE post_id=$post_id");
    confirmQuery($result);
    echo mysqli_num_rows($result);
}

//** nezinau is kur sita dalis ***//
function set_message($msg){
if(!$msg) {
$_SESSION['message']= $msg;
} else {
$msg = "";
    }
}

function display_message() {
    if(isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}
///*** sios dalies pabaiga **///


function users_online() {

        if(isset($_GET['onlineusers'])) {
    
        global $connection;  //jeigu jo nera, tai gali ismesti klaida siuo atveju admin_navigation 17 eilute. //sitas global connection veikia tik admin header faile..

            if(!$connection) {
                session_start();
                include("../includes/db.php");

                        //** userio rodymui online
            $session = session_id();    //si eilute gaudo visus, kas prisijungia prie admin paneles, bet koki useri
            $time = time();             //si eilute laikys laika..
            $time_out_in_seconds = 10;      //si eilute apibrezia kazkoki buvimo laika..
            $time_out = $time - $time_out_in_seconds;
            
            //***count users
            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);      //skaiciuojam, ziurim ar kas nors yra prisijunge
            
                if($count == NULL) {        //jeigu matysim nauja useri, mes jo duomenis sukelsim sekancios eilutes deka i duombaze
                    mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");      //jeigu bus online, tuomet mes ji seksim pagal time ir session. jeigu values vietoje bus time ir time, tai duombazej session ir time laukeliuose bus vienoda info, jeigu bus session ir time, tuomet session bus simboliai, o time bus skaiciai, kaip ir turi buti.
                } else {        //jeigu tai ne naujas vartotojas, o jis yra buves cia, tuomet..
                    mysqli_query($connection, "UPDATE users_online SET time ='$time' WHERE session = '$session'");
                }
            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
            echo $count_user = mysqli_num_rows($users_online_query);     //***sitas nezinia is kur atsirado.. vienam video neirase, kitam video atsirades is niekur. //is return darom echo, nes cia jau kitokia funkcija turi atlikti

        }

        } //get request isset()
}

users_online();  //sitas saukia funkcija is 8 eilutes

function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function confirmQuery($result) {
    global $connection;
    if(!$result) {
     die("Query failed ." . mysqli_error($connection));
    }
}

function insert_categories(){
        global $connection;     //reikalingas kad prisijungti prie duombazes
     if(isset($_POST['submit'])) {   //jeigu spaudziame submit

            $cat_title = $_POST['cat_title'];       //priskirtam kintamajam priskiriame kazka
            $user_id = $_SESSION['user_id'];

            if($cat_title == "" || empty($cat_title)) { //tikriname ar kintamasis nera tuscas ir ar nera zodzio
                echo "this field should not be empty";
            } else {               //cia kazkas nesutampa su 14pamoka ~112dalim

            $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?) ");

            mysqli_stmt_bind_param($stmt, 's', $cat_title);
            mysqli_stmt_execute($stmt);

            if(!$stmt) {   //tikriname ar viskas veikia
                    die("Query failed. " . mysqli_error($connection));    //jeigu neveikia, stabdome veikima ir ziurime koks erroras
                }
            }
            mysqli_stmt_close($stmt);
}
}



function findAllCategories(){
    global $connection;

    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection,$query);

    while($row = mysqli_fetch_assoc($select_categories)) {
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];

    echo "<tr>";
    echo "<td>{$cat_id}</td>";
    echo "<td>{$cat_title}</td>";
    echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
    echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
    echo "</tr>";
    }
}

function deleteCategories(){
    global $connection;

        if(isset($_GET['delete'])) {
        $the_cat_id = $_GET['delete'];  //$the_cat_id siaip yra tas pats, kuris yra funkcijoj, bet siuo atvejjuu naudojam kita pavadinima, kad nnesusipainioti
        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";
        $delete_query = mysqli_query($connection,$query);   //$delete_query galima vadinti ir kitaip, kaip noriu
        header("Location: categories.php");     //sita funkcija padaro refresh page ir grizta i ta pati puslapi, tokiu atveju, nereikia spausti dukart ties "delete" mygtuku tam kad issitrint reiksme
        }
}

function unApprove() {
    global $connection;
    if(isset($_GET['unapprove'])) {
        $the_comment_id = $_GET['unapprove'];
        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id ";
        $unapprove_comment_query = mysqli_query($connection, $query);
        header("Location: comments.php");   
    }
}

//**** perdaryta is admin/index.php  61 eilute ir sekancias kitas ir ideta 68 ir t.t. ***////
function recordCount($table) {
    global $connection;
        $query = "SELECT * FROM " . $table;
        $select_all_posts = mysqli_query($connection,$query);
        $result = mysqli_num_rows($select_all_posts);
        confirmQuery($result);      //sitas tam kad tiksliau parodytu kur yra klaida
        return $result;
    }

function checkStatus($table,$column,$status) {
    global $connection;     //reikalingas sujungimui su baze
        $query = "SELECT * FROM $table WHERE $column = '$status'";   //**buvo taip $query = "SELECT * FROM posts WHERE post_status = 'published'";
        $result = mysqli_query($connection,$query);
        confirmQuery($result);
       return mysqli_num_rows($result);
}


function checkUserRole($table,$column,$role) {
    global $connection;
    $query = "SELECT * FROM $table WHERE $column = '$role'";
    $select_all_subscribers = mysqli_query($connection,$query);
    return mysqli_num_rows($select_all_subscribers);
}



function username_exists($username) {
    global $connection;
        $query = "SELECT username FROM users WHERE username = '$username'";
        $result = mysqli_query($connection,$query);
        confirmQuery($result);
        if(mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
}

function email_exists($email) {
    global $connection;
        $query = "SELECT user_email FROM users WHERE user_email = '$email'";
        $result = mysqli_query($connection,$query);
        confirmQuery($result);
        if(mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
}

function register_user($username, $email, $password) {
    global $connection;
            
            $username = mysqli_real_escape_string($connection, $username);   //turi buti connection ir kintamasis. mysqlirealescapestring apsaugai blogu dalyku pries registracija 
            $email    = mysqli_real_escape_string($connection, $email);     //testavimui rasome echo pries visa eilute
            $password = mysqli_real_escape_string($connection, $password);
            
            $password = password_hash( $password, PASSWORD_BCRYPT, array('cost' => 12));
            
            $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
            $query .= "VALUES ('{$username}','{$email}','{$password}', 'subscriber' )";
            $register_user_query = mysqli_query($connection, $query);

                confirmQuery($register_user_query);
                    //galima ir cia daryti login user...
}

function login_user($username, $password) {
    global $connection;

    $username = trim($username);
    $password = trim($password);

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

            if(password_verify($password, $db_user_password)) {    //galiam daryti su if == arba if !==, kaip pats nori. --> edwin from future pakeite i "===" identical reiksme
                
                $_SESSION['user_id'] = $db_user_id;
                $_SESSION['username'] = $db_username;       //cia kazkas panasaus i placeholder ar variable, ar cookies, prie kurio prisegame gautas reiksmes
                $_SESSION['firstname'] = $db_user_firstname;
                $_SESSION['lastname'] = $db_user_lastname;
                $_SESSION['user_role'] = $db_user_role;     //kai tik prijungiamas sitas prie sesijos, galima pasiekti sita value bet kur

                redirect("/cms/admin");   //kai tik viskas sueina, tuomet redirektinasi viskas i admin puslapi ir prie jo prikabina ir parodo tame admin_header //Location turi buti su L, ne su l. "../" turi buti, nes mes esame include folderyje.
            } else {
               //redirect("/cms/index.php");
                return false;
            }
        }
    return true;
}
    
    //$password = crypt($password, $db_user_password);    //registration faile 25 eilutej mes uzkodavom slaptazodi su salt, bet tokiu budu negalim vel prisijungti su savo slapt. todel sioj vietoj mes vietoj salt imame vel db_user_password kad prisijungimas butu igalintas, nes tokiu budu is uzkoduoto slaptazodzio ten kazkaip ji konvertuoja atgal ir mes vel galim juo prisijungti, kuriuo registravomes... tiksliau aprasyta php.net manuale. tai kazkoks hash formatas, kuris duomnbazej yra lentelej po randSalt
    
    /* loginimasis */   //tikriname su sia funkcija ar sie duomenys tokie pat is gautos per login forma su tais paciai kurie yra duombazej. jeigu jie neteisingi, header deka vartotojas niekur nenueina



?>
