<?php
if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

$connection = mysqli_connect('localhost', 'root', '', 'loginapp');
    if($connection) {
        echo "we are connected";
    } else {
        die("Database connection failed");
    }

 /*       if($username && $password) {     
    echo $username;
    echo $password;
        } else {
            echo "noo";
        }*/
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>login</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    </head>
    <body>
    
    <div class="container">
        <div class="col-sm-6">
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                <input type="text" name="username" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                <input type="password" name="password" class="form-control">
                </div>
                <input class="btn btn-primary" type="submit" name="submit" value="Submit">
            </form>
        </div>
        
        
    </div>

        
    </body>

</html>