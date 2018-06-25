<?php
if(isset($_GET['p_id'])){
    $the_post_id = $_GET['p_id'];
}
 $query = "SELECT * FROM posts WHERE post_id= $the_post_id ";
    $select_posts_by_id = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($select_posts_by_id)){
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
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
        
        $post_author = $_POST['post_author'];
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
            $query .="post_author = '{$post_author}', ";
            $query .="post_status = '{$post_status}', ";    //sitie tarpai tarp ', "; turi buti
            $query .="post_tags = '{$post_tags}', ";
            $query .="post_content = '{$post_content}', ";
            $query .="post_image = '{$post_image}' ";   //cia kablelio priespaskutej eilutej neturi buti, kitaip nesuveiktu sekanti eilute su WHERE
            $query .="WHERE post_id = {$the_post_id} ";
        
        $update_post = mysqli_query($connection,$query);
        
        confirmQuery($update_post); //sita funkcija paimta is functions.php
        
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
        <select name="post_category" id="">        <!--zemiau esantis option value bus reikalingas sitam post_category, todel butina ji cia tureti-->
        <?php
                $query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection,$query);
        
                confirmQuery($select_categories);

                while($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                    echo "<option value='$cat_id'>{$cat_title}</option>";       //sita, reikalingas auksciau esantis name post_category
                }
        ?>
        </select>
    </div>

    <div class="form-group">
        <label for="title">Post Author</label>
        <input value="<?php echo $post_author; ?>" type="text" class="form-control" name="post_author">
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <input value="<?php echo $post_status; ?>" type="text" class="form-control" name="post_status">
    </div>

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
        <textarea class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>

</form>