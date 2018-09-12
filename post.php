
    <?php include "includes/db.php"; ?>
    <?php include "includes/header.php"; ?>

    <!-- Navigation -->

    <?php include "includes/navigation.php"; ?>

    <?php
        if(isset($_POST['liked'])){
            echo "<h1>Tai veikia</h1>";
            //die();
        }
    ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

               <?php

                if(isset($_GET['p_id'])){   //array p_id. sitas get yra key. as esu in loop.
                    $the_post_id = $_GET['p_id'];   //we are catching here with variable $post_id, and need condition
                    
                    $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $the_post_id ";
                    $send_query = mysqli_query($connection, $view_query);
                    
                        if(!$send_query) {
                            die("query failed");
                        }
                
                    //-> jeigu mes turi user_role sesija ir jeigu tai nustatyta ir jeigu mes prisilogin kaip admin, mes matysime postus.. <--//
                    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin' ) {
                        $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
                    
                    } else {    //ir jeigu ne adminas, matys tik published postus
                        $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published' ";
                    }

                        //$query = "SELECT * FROM posts WHERE post_id = $the_post_id "; //-- nes is cia mes rodome visa posta index faile ---//
                        $select_all_posts_query = mysqli_query($connection,$query);
                
                            if(mysqli_num_rows($select_all_posts_query) < 1) {    //sitas if skaiciuos kiek eiluciu yra musu query..
                                echo "<h2 class='text-center'>Postu nera</h2>";
                            } else {

                                while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                                    $post_id = $row['post_id'];
                                    $post_title = $row['post_title'];
                                    $post_user = $row['post_user'];
                                    //$post_user = $row['post_user'];
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
                    by <a href="index.php"><?php echo $post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
                
                <a href="post.php?p_id=<?php echo $post_id; ?>">
                <img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image);?>" alt="">
                </a>

                <hr>
                <p><?php echo $post_content ?></p>

                <hr>

                <div class="row">
                    <p class="pull-right"><a class="like" href="#"><span class="glyphicon glyphicon-thumbs-up"></span>Like</a></p>
                </div>
                <div class="row">
                    <p class="pull-right">Like: 10</a></p>
                </div>
                <div class="clearfix"></div>

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
                    //*** turbut nebenaudosim sito bloko **///
                // $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";   //padarem taip, kad phpmyadmin posts table matytusi post_comment_count augantis skaicius, buvo 4 faile add_post.php, dabar auga..
                // $query .= "WHERE post_id = $the_post_id ";
                // $update_comment_count = mysqli_query($connection,$query);
                    //****** bloko pabaiga **///
                } else {
                    echo "<script>alert('fields cannot be empty')</script>";
                }
            }

                

                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                       <div class="form-group">
                           <label for="Author">Author</label>
                            <input type="text" name="comment_author" class="form-control" name="comment_author">
                        </div>
                        <div class="form-group">
                           <label for="Email">Email</label>
                            <input type="email" name="comment_email" class="form-control" name="comment_email">
                        </div>
                        <div class="form-group">
                           <label for="Comment">Your comment</label>
                            <textarea name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php

                $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
                $query .= "AND comment_status = 'approved' ";
                $query .= "ORDER BY comment_id DESC ";
                $select_comment_query = mysqli_query($connection, $query);
                if(!$select_comment_query) {
                    die('Query failed. ' . mysqli_error($connection));
                }
                while ($row = mysqli_fetch_array($select_comment_query)) {  //loop
                    $comment_date = $row['comment_date'];
                    $comment_content = $row['comment_content'];
                    $comment_author = $row['comment_author'];

                ?>

                               <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>

        <?php   }  } } else {
                    
                    header("Location: index.php");
                }
                ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->

        <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php";?>
<!--            siuo skriptu tikriname ar veikia mygtukas Like-->
        <script>
            $(document).ready(function(){

                    var post_id = <?php echo $the_post_id; ?>;
                    var user_id = 15;

                $('.like').click(function(){
                    //console.log("Tai veikia")   //sia eilute tikriname ar veikia
                    $.ajax({
                        url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",   //su php tikrinsim ar post reguest bus issiustas
                        type: 'post',   //tikrinsim ar duomenys bus post tipo
                        data: {
                            'liked': 1,   //cia tiesiog paziuresim ar yra kokia verte - nezinau kas cia per velnias:))
                            'post_id': post_id,
                            'user_id': user_id
                        }
                    });
                });
            });
        </script>