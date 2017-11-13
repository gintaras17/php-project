<?php

$connection = mysqli_connect('localhost', 'root', '', 'loginapp');
    if($connection) {
        echo "we are connected";
    } else {
        die("Database connection failed");
    }
    $query = "SELECT * FROM users";
    $result = mysqli_query($connection, $query);
        if(!$result) {
            die('Query Failed' . mysqli_error());
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
            
        <?php
        while($row = mysqli_fetch_assoc($result)) {
            
            ?>
            
            <pre>
            
            <?php
            print_r($row);
            ?>
            
            </pre>
            <?php
        
        }
        ?>
            
        </div>
        
        
    </div>

        
    </body>

</html>