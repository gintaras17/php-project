<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">

        <!-- Navigation -->
<?php include "includes/admin_navigation.php"; ?>


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to comments
                            <small><?php echo $_SESSION['username'] ?></small>
                        </h1>
                                <!-- jeigu virsaus nebutu, mestu klaida.. -->
<?php

if(isset($_POST['checkBoxArray'])) {
    foreach($_POST['checkBoxArray'] as $commentValueId ){    //tai loopas per checkboxus
        
        $bulk_options = $_POST['bulk_options']; //priregistruojame zemiau padaryta name='bulk_options' prie value. pratestinti galima uzrasius pries eilute echo komanda
            switch($bulk_options) {     //siuo switch statment compare one condition with multiple statements. patikrinam bulk_options
                case 'approved':
                    $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$commentValueId} "; //siuo query updatinam.. bulk options paimtas is 5 eileje esancio kintamojo
                    $update_to_approved_status = mysqli_query($connection, $query);
                    confirmQuery($update_to_approved_status);
                    break;  //jeigu randa case'a, breakas sustabdo
                    
                case 'unapproved':
                    $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$commentValueId} ";
                    $update_to_unapproved_status = mysqli_query($connection, $query);
                    confirmQuery($update_to_unapproved_status);
                    break;
                    
                 case 'delete':
                    $query = "DELETE FROM comments WHERE comment_id = {$commentValueId} ";
                    $update_to_delete_status = mysqli_query($connection, $query);
                    confirmQuery($update_to_delete_status);
                    break;  //jeigu randa case'a, breakas sustabdo
            }
    }
}
?>

<form action="" method='post'>

                        <table class="table table-bordered table-hover">
                        <div id="bulkOptionsContainer" class="col-xs-4">
                            <select class="form-control" name="bulk_options" id="">
                                <option value="">Select options</option>
                                <option value="approved">Approve</option>
                                <option value="unapproved">Unapprove</option>
                                <option value="delete">Delete</option>
                            </select>

                        </div>

            <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            </div>
                            <thead>
                                <tr>
                                    <th><input id="selectAllBoxes" type="checkbox"></th>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>In response to</th>
                                    <th>Date</th>
                                    <th>Approve</th>
                                    <th>Unapprove</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                        <tbody>

    <?php
    $query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection, $_GET['id'])." ";    //jeigu nebutu $connection, mestu klaida ->Warning: mysqli_real_escape_string() expects exactly 2 parameters, 1 given in C:\xampp\htdocs\cms\admin\post_comments.php on line 85
    $select_comments = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($select_comments)){
        $comment_id         = $row['comment_id'];
        $comment_post_id    = $row['comment_post_id'];
        $comment_author     = $row['comment_author'];
        $comment_email      = $row['comment_email'];
        $comment_content    = $row['comment_content'];
        $comment_status     = $row['comment_status'];
        $comment_date       = $row['comment_date'];

        echo "<tr>";

        ?>

    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $comment_id; ?>'></td>

    <?php

        echo "<td>$comment_id</td>";    //situ turi buti toks pats skaicius kaip ir auksciau esanciu table bloke
        echo "<td>$comment_author</td>";
        echo "<td>$comment_content</td>";

//       $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
//        $select_categories_id = mysqli_query($connection,$query);
//
//        while($row = mysqli_fetch_assoc($select_categories_id)) {   //sia iterpta funkcija galime keisti visa posta puslapyje posts.php
//        $cat_id = $row['cat_id'];
//         $cat_title = $row['cat_title'];
//
//        echo "<td>{$cat_title}</td>";
//        }

        echo "<td>$comment_email</td>";
        echo "<td>$comment_status</td>";
        $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
        $select_post_id_query = mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($select_post_id_query)){
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];

            echo "<td><a href='/cms/admin/post.php?p_id=$post_id'>$post_title</a></td>";
        }

        echo "<td>$comment_date</td>";
        echo "<td><a href='post_comments.php?approve=$comment_id&id=" . $_GET['id'] ."''>Approve</a></td>";
        echo "<td><a href='post_comments.php?unapprove=$comment_id&id=" . $_GET['id'] ."''>Unapprove</a></td>";
        echo "<td><a href='post_comments.php?delete=$comment_id&id=" . $_GET['id'] ."'>Delete</a></td>";    //jeigu nepridesim &id=" .$_GET['id'] ." -tuomet mes klaida ->Warning: mysqli_fetch_assoc() expects parameter 1 to be mysqli_result, boolean given in C:\xampp\htdocs\cms\admin\post_comments.php on line 87, nes del 85 eilutes esancio id, istrinant negauna to id..
        echo "</tr>";
    }
    ?>


                        </tbody>
                        </table>
</form>

<?php
if(isset($_GET['approve'])){                                         //istrinam komentarus is posts.php
    $the_comment_id = $_GET['approve'];
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_comment_id ";   //kiek suprantu, skliausteliai the_post_id nera reikalavimas..
    $approve_comment_query = mysqli_query($connection, $query);
    header("Location: post_comments.php?id=" . $_GET['id']."");   //sitas daro puslapio reloada, kai tik istrinam, sius dar karta comments.php puslapi is naujo.
}
?>

<?php
if(isset($_GET['unapprove'])){                                         //istrinam komentarus is posts.php
    $the_comment_id = $_GET['unapprove'];
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id ";   //kiek suprantu, skliausteliai the_post_id nera reikalavimas..
    $unapprove_comment_query = mysqli_query($connection, $query);
    header("Location: post_comments.php?id=" . $_GET['id']."");   //sitas daro puslapio reloada, kai tik istrinam, sius dar karta comments.php puslapi is naujo.
}
?>

<?php
if(isset($_GET['delete'])){                                         //istrinam komentarus is posts.php
    $the_comment_id = $_GET['delete'];
    $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";   //kiek suprantu, skliausteliai the_post_id nera reikalavimas..
    $delete_query = mysqli_query($connection, $query);
    header("Location: post_comments.php?id=" . $_GET['id']."");   //sitas daro puslapio reloada, kai tik istrinam, sius dar karta post_comments.php puslapi is naujo., jeigu bus be sit->?id=" . $_GET['id']. "", gali istrinant paskutini ismesti klaida-> Notice: Undefined index: id in C:\xampp\htdocs\cms\admin\post_comments.php on line 85
}
?>
                    <!-- jeigu visko kas cia zemiau yra nebus, mes klaida.. -->
                    </div>
            </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
        
    </div>
    <!-- /#wrapper -->

<?php include "includes/admin_footer.php"; ?>