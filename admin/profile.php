<?php include "includes/admin_header.php"; ?>

<?php
    if(isset($_SESSION['username'])) {  //checkin for username, if find it, we find session available
        $username = $_SESSION['username'];      //prisega verte prie kintamojo
        $query = "SELECT * FROM users WHERE username = '{$username}' ";
        $select_user_profile_query = mysqli_query($connection, $query);
        
        while($row = mysqli_fetch_array($select_user_profile_query)) {    //sukuriam loop kad paziuretu per visus tuos values. kad istrauktume ta informacija
            
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
        
?>
  
<?php

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
        
            $query = "UPDATE users SET ";
            $query .="user_firstname = '{$user_firstname}', ";          //post_title is duombazes, o sekantis $post_title is formos..
            $query .="user_lastname = '{$user_lastname}', ";
            $query .="user_role = '$user_role', ";     //sitas now() mums duos datą, kuri yra siuo metu.
            $query .="username = '{$username}', ";
            $query .="user_email = '{$user_email}', ";    //sitie tarpai tarp ', "; turi buti
            $query .="user_password = '{$user_password}' ";
            $query .= "WHERE username = '{$username}' ";
    
        $edit_user_query = mysqli_query($connection,$query);
        confirmQuery($edit_user_query);
}



?>
   
    <div id="wrapper">


        <!-- Navigation -->
<?php include "includes/admin_navigation.php"; ?>
      
       
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small>Author</small>
                        </h1>
            
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

        <option value="subscriber"><?php echo $user_role; ?></option>
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
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update profile">
    </div>

</form>
                   
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        
        
        
        
        
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php"; ?>