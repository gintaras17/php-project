                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                               
    <?php
    $query = "SELECT * FROM users";
    $select_users = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($select_users)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
        
        echo "<tr>";
        echo "<td>$user_id</td>";    //situ turi buti toks pats skaicius kaip ir auksciau esanciu table bloke
        echo "<td>$username</td>";
        echo "<td>$user_firstname</td>";
        
//       $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
//        $select_categories_id = mysqli_query($connection,$query);
//
//        while($row = mysqli_fetch_assoc($select_categories_id)) {   //sia iterpta funkcija galime keisti visa posta puslapyje posts.php
//        $cat_id = $row['cat_id'];
//         $cat_title = $row['cat_title'];
//        
//        echo "<td>{$cat_title}</td>";
//        }
            
        echo "<td>$user_lastname</td>";
        echo "<td>$user_email</td>";
        echo "<td>$user_role</td>";
//        $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
//        $select_post_id_query = mysqli_query($connection,$query);
//        while($row = mysqli_fetch_assoc($select_post_id_query)){
//            $post_id = $row['post_id'];
//            $post_title = $row['post_title'];
//            
//            echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
//        }
        
        echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";   //href adresas turi buti toks, kuriame mes viska keiciame, kitaip redirectins kitur
        echo "<td><a href='users.php?change_to_sub={$user_id}'>Subscriber</a></td>";
        echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
        echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
        echo "</tr>";
    }
    ?>
                               
        
    </tbody>
</table>

<?php
if(isset($_GET['change_to_admin'])){                                         //istrinam komentarus is posts.php
    $the_user_id = $_GET['change_to_admin'];
    $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $the_user_id ";   //kiek suprantu, skliausteliai the_post_id nera reikalavimas..
    $change_to_admin_query = mysqli_query($connection, $query);
    header("Location: users.php");   //sitas daro puslapio reloada, kai tik istrinam, sius dar karta comments.php puslapi is naujo.
}
?>

<?php
if(isset($_GET['change_to_sub'])){                                         //istrinam komentarus is posts.php
    $the_user_id = $_GET['change_to_sub'];
    $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $the_user_id ";   //kiek suprantu, skliausteliai the_post_id nera reikalavimas..
    $change_to_sub_query = mysqli_query($connection, $query);
    header("Location: users.php");   //sitas daro puslapio reloada, kai tik istrinam, sius dar karta comments.php puslapi is naujo.
}
?>

<?php
if(isset($_GET['delete'])){                                         //istrinam komentarus is posts.php
    $the_user_id = $_GET['delete'];
    $query = "DELETE FROM users WHERE user_id = {$the_user_id} ";   //kiek suprantu, skliausteliai the_post_id nera reikalavimas..
    $delete_user_query = mysqli_query($connection, $query);
    header("Location: users.php");   //sitas daro puslapio reloada, kai tik istrinam, sius dar karta comments.php puslapi is naujo.
}
?>