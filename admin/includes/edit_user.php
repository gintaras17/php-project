<?php

if(isset($_GET['edit_user'])){
    $the_user_id = escape($_GET['edit_user']);

    $query = "SELECT * FROM users WHERE user_id = $the_user_id ";
    $select_users_query = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($select_users_query)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }
}


if(isset($_POST['edit_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];

//    $post_image = $_FILES['image']['name'];
//    $post_image_temp = $_FILES['image']['tmp_name'];

    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
//    $post_date = date('d-m-y');
//    $post_comment_count = 4;

//    move_uploaded_file($post_image_temp, "../images/$post_image" );
    
    $query = "SELECT randSalt FROM users";                          //nuo 37 iki 46 eilutes kodo eilutes reikalingos tam, kad butu viskas sutvarkyta su loginimusi ir userio slaptazodzio pakeitimu
    $select_randsalt_query = mysqli_query($connection, $query);     //pries tai prisiregistravus ir editinant slaptazodi userio formoj, is koduoto slaptazodzio editinant duombazej atsirasdavo nekoduotas slapt.
    if(!$select_randsalt_query) {                                   //taigi, siom eilutem sitas reikalas sutvarkomas, kad keiciant nebutu prarastas uzkodavimas ir useris galetu registruotis, taisytis ir t.t.
        die("Query failed" . mysqli_error($connection));            //44-46 eilutes kazkaip tam ir reikalingos
        
    }
    
    $row = mysqli_fetch_array($select_randsalt_query);      //tvarkom slaptazodziu kodavimus duombazej, useris pas save mato tokio pat ilgio slaptazodi koki suvede ar atnaujino, o duombazej is encrypted
    $salt = $row['randSalt'];
    $hashed_password = crypt($user_password, $salt);

            $query = "UPDATE users SET ";
            $query .="user_firstname = '{$user_firstname}', ";          //post_title is duombazes, o sekantis $post_title is formos..
            $query .="user_lastname = '{$user_lastname}', ";
            $query .="user_role = '$user_role', ";     //sitas now() mums duos datą, kuri yra siuo metu.
            $query .="username = '{$username}', ";
            $query .="user_email = '{$user_email}', ";    //sitie tarpai tarp ', "; turi buti
            $query .="user_password = '{$hashed_password}' ";   //pakeiciam is user_password i hashed..
            $query .= "WHERE user_id = {$the_user_id} ";

        $edit_user_query = mysqli_query($connection,$query);
        confirmQuery($edit_user_query);
    
        echo "User updated" . " <a href='users.php'>View users</a>";    //si vieta rodo pranesima kad lentele buvo sekmingai paimta
}


?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">First name</label>
        <input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="post_status">Last name</label>
        <input type="text" value="<?php echo $user_lastname; ?>" class="form-control" name="user_lastname">
    </div>


    <div class="form-group">
        <select name="user_role" id="">        <!--zemiau esantis option value bus reikalingas sitam post_category, todel butina ji cia tureti-->

        <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
        <?php

        if($user_role == 'admin'){
            echo "<option value='subscriber'>subscriber</option>";
        } else {
            echo "<option value='admin'>admin</option>";
        }

        ?>




        </select>
    </div>


<!--    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>-->

    <div class="form-group">
        <label for="post_tages">Username</label>
        <input type="text" value="<?php echo $username; ?>" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="post_content">Email</label>
        <input type="email" value="<?php echo $user_email; ?>" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="post_content">Password</label>
        <input type="password" value="<?php echo $user_password; ?>" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update user">
    </div>

</form>

<?php //include "../includes/admin_footer.php"; ?>
