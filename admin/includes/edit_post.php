<?php
if(isset($_GET['p_id'])){
    $the_post_id = $_GET['p_id'];
}
 $query = "SELECT * FROM posts WHERE post_id= $the_post_id ";
    $select_posts_by_id = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($select_posts_by_id)){
        $post_id = $row['post_id'];
        $post_user = $row['post_user'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
    }

    if(isset($_POST['update_post'])) {

        $post_user = $_POST['post_user'];
        $post_title = $_POST['post_title'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        $post_content = $_POST['post_content'];
        $post_tags = $_POST['post_tags'];

        move_uploaded_file($post_image_temp, "../images/$post_image");

            if(empty($post_image)) {    //jeigu nera sios funkcijos, updatinant komentara, paveiksliukas dings
                $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
                $select_post_image = mysqli_query($connection,$query);   //$select_image = mysqli_query($connection,$query);
                while($row = mysqli_fetch_array($select_post_image)) {   //while($row = mysqli_fetch_array($select_image)) {
                    $post_image = $row['post_image'];
                }
            }

            $query = "UPDATE posts SET ";
            $query .="post_title = '{$post_title}', ";          //post_title is duombazes, o sekantis $post_title is formos..
            $query .="post_category_id = '{$post_category_id}', ";
            $query .="post_date = now(), ";     //sitas now() mums duos datą, kuri yra siuo metu.
            $query .="post_user = '{$post_user}', ";
            $query .="post_status = '{$post_status}', ";    //sitie tarpai tarp ', "; turi buti
            $query .="post_tags = '{$post_tags}', ";
            $query .="post_content = '{$post_content}', ";
            $query .="post_image = '{$post_image}' ";   //cia kablelio priespaskutej eilutej neturi buti, kitaip nesuveiktu sekanti eilute su WHERE
            $query .="WHERE post_id = {$the_post_id} ";

        $update_post = mysqli_query($connection,$query);

        confirmQuery($update_post); //sita funkcija paimta is functions.php
        
        echo "<p class='bg-success'>Post updated. <a href='../post.php?p_id={$the_post_id}'>View post</a> or <a href='posts.php'>Edit more posts</a></p>";

        //if(!$update_post) {     //jeigu del kazkokios priezasties confirmQuery blogai suveikia, reikia tureti sita eilute
          //  die("query failed" . mysqli_error($connection));
        //}
    }
?>
    <form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title">
    </div>

    <div class="form-group">
        <label for="categories">Categories</label>
        <select name="post_category" id="">        <!--zemiau esantis option value bus reikalingas sitam post_category, todel butina ji cia tureti-->
        <?php
                $query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection,$query);

                confirmQuery($select_categories);

                while($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                
                    if ($cat_id == $post_category_id) {
                        echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
                    } else {
                        echo "<option value='$cat_id'>{$cat_title}</option>";       //sita, reikalingas auksciau esantis name post_category
                    }
                }
                
        ?>
        </select>
    </div>

            <div class="form-group">
        <label for="users">Users</label>
            <select name="post_user" id="">

                <?php echo "<option value='{$post_user}'>{$post_user}</option>"; ?>
        <?php
                $query = "SELECT * FROM users";
                $select_users = mysqli_query($connection,$query);

                confirmQuery($select_users);

                while($row = mysqli_fetch_assoc($select_users)) {
                $user_id = $row['user_id'];
                $username = $row['username'];
                    echo "<option value='{$username}'>{$username}</option>";
                }
        ?>

        </select>
        </div>

<!--     <div class="form-group">
        <label for="title">Post Author</label>
        <input value="<?php //echo $post_user; ?>" type="text" class="form-control" name="post_user" readonly="read">
    </div> -->

       <div class="form-group">
    <select name="post_status" id="">
        <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>    <!-- padarem kad matytusi posto statusas kaip meniu pasirinkimas, kurio nereikia rasyti ranka prie posto editinimo-->
        <?php
            if($post_status == 'published'){        //kai uzdedam is draft i publish ir spaudziam update, pavirsta i published
                echo "<option value='draft'>Draft</option>";
            } else {
               echo "<option value='published'>Publish</option>"; 
            } 
        ?>
    </select>
        </div>

<!--    <div class="form-group">
        <label for="post_status">Post Status</label>        //buvusi statini post status paverciame i automatini pasirinkima, kuri parasom auksciau esanciom kodo eilutem
        <input value="<?php //echo $post_status; ?>" type="text" class="form-control" name="post_status">
    </div>-->

    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_image; ?>" alt="">
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="post_tages">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"><?php echo $post_content; ?></textarea>
                                                                                            <!-- jeigu koreguojant posta kelis kartus paspausim is naujos eil.bet neparasysim nieko ir spausim update, gali buti kad ismes \r\n rezultatus, tokiu atveju.. -->
                                                                                            <!-- echo str_replace(search, replace, subject) padarysim str_replace('\r\n', '<br>', $post_content) -->
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>

</form>
