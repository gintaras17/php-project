    <?php ob_start(); ?>
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
                

                
                //pagination limiting posts per page code lines
                    $per_page = 5;
                
                if(isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = "";
                }
                if($page == "" || $page == 1) {
                    $page_1 = 0;
                } else {
                    $page_1 = ($page * $per_page) - $per_page;
                }
                
                      //** kodas tam, kad jeigu esi adminas, gali matyti ir draft ir published postus
                    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                      $post_query_count = "SELECT * FROM posts WHERE post";
                  } else {  //*** toliau kodas, jeigu nesi adminas, draft postu nematysi
                      $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
                    }

                $post_query_count = "SELECT * FROM posts";
                //pagination kodo eiles//
                $find_count = mysqli_query($connection, $post_query_count);
                $count = mysqli_num_rows($find_count);
                
                if($count < 1) {
                    echo "<h2 class='text-center'>Įrašų nėra</h2>"; //padarom kad rodytu toki irasa, jeigu nera jokio posto
                } else {
                
                $count = ceil($count / $per_page);  //sio suskaiciuota rezultata galime parodyti 44 eilutej su echo $count = mysqli_num_row($find_count);
                //pagination kodo eiles pabaiga//

                $query = "SELECT * FROM posts LIMIT $page_1, $per_page";
                $select_all_posts_query = mysqli_query($connection,$query);

                while($row = mysqli_fetch_assoc($select_all_posts_query)) { //loopas prasideda nuo cia
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'],0,100);
                    $post_status = $row['post_status'];

                    ?>

                    <h1 class="page-header">    <!--Visa sitas zemiau yra loop'as, kuris ima duomenis is lenteles-->
                        Post
                </h1>

                <!-- First Blog Post -->
                
                <h1><?php// echo $count; ?></h1>
                <h2>          <!-- po pagerinimo htaccess 5 eilutej galima perdaryti post.php?p_id= // po sito url matysime tik adresas/postoNumeris -->
                    <a href="post/<?php echo $post_id ?>"><?php echo $post_title ?></a>    <!--kai spausim ant title, tai nusius parametra i URL, matysim vien posto puslapi, kuris bus sios eilutes pradzia p_id=visa php eilute. cia toks pat reikalas, kai mes spaudziame edit, ir updateiname posta, url eilutej matom jo id nr, tai cia bus taip pat. mums ji reikia pagauti, kad tai veiktu..-->
                </h2>
                
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_user ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id ?>"><img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image);?>" alt=""></a>
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

    <?php   }  } ?>



            </div>

            <!-- Blog Sidebar Widgets Column -->

        <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>
            <!--  pagination kodo pradzia      -->
        <ul class="pager">
           
           
           <?php
            //$count = '';
           for($i = 1; $i <= $count; $i++) {
               
            if($i == $page) {
                echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
            } else {
                echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
            }
           }
           
            ?>
            
        </ul>
            <!--   pagination kodo pabaiga     -->

<?php include "includes/footer.php";?>
