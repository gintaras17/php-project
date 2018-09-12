    <?php include "includes/db.php"; ?>
    <?php include "includes/header.php"; ?>
    <?php include_once "admin/functions.php"; ?>

    <!-- Navigation -->

    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

               <?php

            if(isset($_GET['category'])){   //reikia gaudyti category ir konvertuoti, kad galetume patikrinti
                $post_category_id = $_GET['category'];
                
                //if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin' ) {
                //if(is_admin($_SESSION['username'])) {
                 if (isset($_SESSION['username']) && is_admin($_SESSION['username'])){
                
                    // $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id";
                    $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? ");   //patobulinimas su prepare statement, kad uzkirstu kelia blogiems dalykams. "?" kaip kazkoks placeholder... nzn kas tai

                } else {    //ir jeigu ne adminas, matys tik published postus
                    $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ? ");
                    $published = 'published';   //sita sukuriam tam, kad butu ka paimti kodui is 42 eilutes
                }

               
                // $select_all_posts_query = mysqli_query($connection,$query);  //vietoj sito..
                if(isset($stmt1)){
                    mysqli_stmt_bind_param($stmt1, "i", $post_category_id); //kadangi post_category_id yra integer, rasome "i", jeigu butu string, rasytume "is" //situo imam reikalus ir executiname 38 eilute
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);  //kadangi mes fetching, tai reikia sitos eilutes
                    $stmt = $stmt1;
                } else {
                    mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published);
                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);
                    $stmt = $stmt2;
                }
                
//                if(mysqli_stmt_num_rows($stmt) === 0) {    //sitas if skaiciuos kiek eiluciu yra musu query..//patobulinam su stmt.. kadangi nezinom ka ims, tai padarom ir duodam $stmt, kad galetu imti tiek pirma tiek antra stmt
//
//                    echo "<h2 class='text-center'>Kategorijų nėra</h2>";
//                }

                while(mysqli_stmt_fetch($stmt)):  //loopas prasideda nuo cia
                    // $post_id = $row['post_id'];
                    // $post_title = $row['post_title'];
                    // $post_user = $row['post_user'];
                    // $post_date = $row['post_date'];
                    // $post_image = $row['post_image'];
                    // $post_content = substr($row['post_content'],0,100);

                    ?>

                    <h1 class="page-header">    <!--Visa sitas zemiau yra loop'as, kuris ima duomenis is lenteles-->
                    
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>    <!--kai spausim ant title, tai nusius parametra i URL, matysim vien posto puslapi, kuris bus sios eilutes pradzia p_id=visa php eilute. cia toks pat reikalas, kai mes spaudziame edit, ir updateiname posta, url eilutej matom jo id nr, tai cia bus taip pat. mums ji reikia pagauti, kad tai veiktu..-->
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id ?>"><img class="img-responsive" src="images/<?php echo $post_image;?>" alt=""></a>
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

    <?php endwhile; mysqli_stmt_close($stmt); } else { 
                    
            header("Location: index.php");      //jeigu nera kategoriju. tuomet siusim asmeni tiesiog i cia.           
                    
            }?>



            </div>

            <!-- Blog Sidebar Widgets Column -->

        <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php";?>
