<?php

function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function confirmQuery($result) {
    global $connection;
    if(!$result) {
     die("Query failed. " . mysqli_error($connection));
    }
}

function insert_categories(){
        global $connection;
     if(isset($_POST['submit'])) {   //jeigu spaudziame submit

                            $cat_title = $_POST['cat_title'];       //priskirtam kintamajam priskiriame kazka

                            if($cat_title == "" || empty($cat_title)) { //tikriname ar kintamasis nera tuscas ir ar nera zodzio
                                echo "this field should not be empty";
                            }                //cia kazkas nesutampa su 14pamoka ~112dalim
                            $query = "INSERT INTO categories(cat_title)";
                            $query .= "VALUE('{$cat_title}') ";

                            $create_category_query = mysqli_query($connection, $query);
                            if(!$create_category_query) {   //tikriname ar viskas veikia
                                    die("Query failed. " . mysqli_error($connection));    //jeigu neveikia, stabdome veikima ir ziurime koks erroras
                                }
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

?>
