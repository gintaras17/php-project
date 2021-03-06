
    <?php include "includes/db.php"; ?>
    <?php include "includes/header.php"; ?>

    <!-- Navigation -->

    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

               <?php

                if(isset($_GET['p_id'])){   //array p_id. sitas get yra key. as esu in loop.
                    $the_post_id     = $_GET['p_id'];   //we are catching here with variable $post_id, and need condition
                    $the_post_user = $_GET['author'];
                    
                $query = "SELECT * FROM posts WHERE post_user = '{$the_post_user}' ";
                $select_all_posts_query = mysqli_query($connection, $query);
                    
//                    if(!$send_query) {
//                        die("query failed");
//                    }
                
                //-> jeigu mes turi user_role sesija ir jeigu tai nustatyta ir jeigu mes prisilogin kaip admin, mes matysime postus.. <--//
//                if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
//                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
//                    
//                } else {    //ir jeigu ne adminas, matys tik published postus
//                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published' ";
//                }
//
//                //$query = "SELECT * FROM posts WHERE post_id = $the_post_id "; //-- nes is cia mes rodome visa posta index faile ---//
//                $select_all_posts_query = mysqli_query($connection,$query);
//                
//                if(mysqli_num_rows($select_all_posts_query) < 1) {    //sitas if skaiciuos kiek eiluciu yra musu query..
//                    
//                    echo "<h2 class='text-center'>Postu nera</h2>";
//                } else {

                while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];

                    ?>

                    <h1 class="page-header">
                    Posts
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    All posts by <?php echo $post_user ?>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image;?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>

                <hr>

    <?php }
                
        ?>

          <!-- Blog Comments -->
                <?php

                if(isset($_POST['create_comment'])){
                    
                    $the_post_id = $_GET['p_id'];
                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];
                    
            if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){
                $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
                $query .= "VALUES ($the_post_id , '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved',now())";

                    $create_comment_query = mysqli_query($connection,$query);

                    if(!$create_comment_query){
                        die('Query failed' . mysqli_error($connection));
                    }
                $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";   //padarem taip, kad phpmyadmin posts table matytusi post_comment_count augantis skaicius, buvo 4 faile add_post.php, dabar auga..
                $query .= "WHERE post_id = $the_post_id ";
                $update_comment_count = mysqli_query($connection,$query);
                } else {
                    echo "<script>alert('fields cannot be empty')</script>";
                    }

                }   }
                ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->

        <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php";?>
