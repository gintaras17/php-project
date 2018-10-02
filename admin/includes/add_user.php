<?php


if(isset($_POST['create_user'])) {
    $user_firstname = escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);
    $user_role = $_POST['user_role'];

//    $post_image = $_FILES['image']['name'];
//    $post_image_temp = $_FILES['image']['tmp_name'];

    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
//    $post_date = date('d-m-y');
//    $post_comment_count = 4;

//    move_uploaded_file($post_image_temp, "../images/$post_image" );

    $user_password = password_hash( $user_password, PASSWORD_BCRYPT, array('cost' => 10));  //sistemos pagerinimas

$query = "INSERT INTO users (user_firstname, user_lastname, user_role,username,user_email,user_password) ";
$query .= "VALUES ('{$user_firstname}','{$user_lastname}','{$user_role}','{$username}','{$user_email}','{$user_password}') ";    //visi kintamieji cia paimti is auksciau esancios funkcijos su isset. ir visi kintamieji yra kabutese '', nes jie yra strings, isskyrus nereikia pirmajam post_category_id, nes tai ne string, o number
    //taip pat antroje $query eiluteje yra now() funkcija -->ji turi daug alternatyvu, bet tai kita tema<--, kuri padaro grazia data duombazej -->galima apie ja paskaityti php.net<--

    $create_user_query = mysqli_query($connection, $query);

    confirmQuery($create_user_query);

        echo "User created: " . " " . "<a href='users.php'>View users</a> ";
}

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">First name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="post_status">Last name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <select name="user_role" id="">        <!--zemiau esantis option value bus reikalingas sitam post_category, todel butina ji cia tureti-->

            <option value="subscriber">Select options</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>

        </select>
    </div>

<!--    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>-->

    <div class="form-group">
        <label for="post_tages">Username</label>
        <input type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="post_content">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="post_content">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add user">
    </div>

</form>

<?php //include "../includes/admin_footer.php"; ?>
