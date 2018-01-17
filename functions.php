<?php include "db.php";?>

<?php

function createRows() {     //mano prirasyta pagal video.. kadangi nesutapo turinys
    if(isset($_POST['submit'])) {
        global $connection;
$username = $_POST['username'];
$password = $_POST['password'];
        
$username = mysqli_real_escape_string($connection, $username);  //sita eilute tai sql injection,
//leidzia varde rasyti toki (') zenkliuka. apsauga pries database statements,
//kad neistrintu duombaziu ir pan.
$password = mysqli_real_escape_string($connection, $password);  //sita tokia pat.
        
$hashFormat = "$2y$10$";
$salt = "iusesomecrazystrings22";
$hashF_and_salt = $hashFormat . $salt;
$password = crypt($password,$hashF_and_salt);
        
        $query = "INSERT INTO users(username,password) ";
        $query .= "VALUES ('$username', '$password')";
        
        $result = mysqli_query($connection, $query);
        if(!$result) {
            die('Query failed' . mysqli_error());
        } else {
            echo "record create";
        }
    }
}                               //iki pat cia...

function showAllData() {
    global $connection;
    $query = "SELECT * FROM users";
    $result = mysqli_query($connection, $query);
        if(!$result) {
            die('Query Failed' . mysqli_error());
        }

 while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            echo "<option value='$id'>$id</option>";
        }
}

function UpdateTable() {
    global $connection;
$username = $_POST['username'];
$password = $_POST['password'];
$id = $_POST['id'];
    
$query = "UPDATE users SET ";
$query .= "username = '$username', ";
$query .= "password = '$password' ";
$query .= "WHERE id = $id ";
    $result = mysqli_query($connection, $query);
    if(!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

function deleteRows() {
    global $connection;
$username = $_POST['username'];
$password = $_POST['password'];
$id = $_POST['id'];
    
$query = "DELETE FROM users ";
$query .= "WHERE id = $id ";
    $result = mysqli_query($connection, $query);
    if(!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

?>