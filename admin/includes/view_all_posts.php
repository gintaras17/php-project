<?php

include('delete_modal.php');

if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $postValueId ){    //tai loopas per checkboxus
        
        $bulk_options = $_POST['bulk_options']; //priregistruojame zemiau padaryta name='bulk_options' prie value. pratestinti galima uzrasius pries eilute echo komanda
            switch($bulk_options) {     //siuo switch statment compare one condition with multiple statements. patikrinam bulk_options
                case 'published':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} "; //siuo query updatinam.. bulk options paimtas is 5 eileje esancio kintamojo
                    $update_to_published_status = mysqli_query($connection, $query);
                    confirmQuery($update_to_published_status);
                    break;  //jeigu randa case'a, breakas sustabdo
                    
                case 'draft':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                    $update_to_draft_status = mysqli_query($connection, $query);
                    confirmQuery($update_to_draft_status);
                    break;
                    
                 case 'delete':
                    $query = "DELETE FROM posts WHERE post_id = {$postValueId} ";
                    $update_to_delete_status = mysqli_query($connection, $query);
                    confirmQuery($update_to_delete_status);
                    break;  //jeigu randa case'a, breakas sustabdo
                    
                case 'clone';
                    $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}' ";
                    $select_post_query = mysqli_query($connection, $query);
                    
                    while ($row = mysqli_fetch_array($select_post_query)) {
                    $post_title         = $row['post_title'];
                    $post_category_id   = $row['post_category_id'];
                    $post_date          = $row['post_date'];
                    $post_user          = $row['post_user'];
                    $post_status        = $row['post_status'];
                    $post_image         = $row['post_image'];
                    $post_tags          = $row['post_tags'];
                    $post_content       = $row['post_content'];

                     // if(empty($post_title)) {      //jeigu del kazkokios priezasties kazkoks laukas dingsta ir neapsiraso, tuomet galima is bedos padaryti toki dalyka, kad lenteles eilutes nepasistumtu i sona..
                     //    $post_title         = "no info";
                     // }   //**not working
                        
                    }


                    $query = "INSERT INTO posts (post_category_id, post_title, post_user, post_date,post_image,post_content,post_tags,post_status) ";
                    $query .= "VALUES({$post_category_id},'{$post_title}','{$post_user}',now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') ";    //visi kintamieji cia paimti is auksciau esancios funkcijos su isset. ir visi kintamieji yra kabutese '', nes jie yra strings, isskyrus nereikia pirmajam post_category_id, nes tai ne string, o number
                    //taip pat antroje $query eiluteje yra now() funkcija -->ji turi daug alternatyvu, bet tai kita tema<--, kuri padaro grazia data duombazej -->galima apie ja paskaityti php.net<--
                        $copy_query = mysqli_query($connection, $query);
                    if(!$copy_query) {
                        die("Query failed" . mysqli_error($connection));
                    }
                        break;
            }
    }
}

?>
 
<form action="" method="post">
   
    <table class="table table-bordered table-hover">
    
    <div id="bulkOptionsContainer" class="col-xs-4">
        <select class="form-control" name="bulk_options" id="">    <!--uzvadiname name kad turetume kaip tikrinti vertes, ar kazkas tokio. name bulk_options gaudo vertes kad butu priskiriamos auksciau esanciam kintamajam foreach loope -->
           <option value="">Select options</option>
           <option value="published">Publish</option>    <!-- kai pridedame value reiksme, tuomet ji atsiranda kintamajame bulk_options kuris yra auksciau esanciam loope -->
           <option value="draft">Draft</option>    <!-- value reiksme pasirupina select eiluteje esantis name bulk_options-->
           <option value="delete">Delete</option>
           <option value="clone">Clone</option>
        </select>
    </div>
    
    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a class="btn btn-primary" href="posts.php?source=add_post">Add new</a>
    </div>
        <thead>
            <tr>
            <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>User</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>View post</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Post views</th>
            </tr>
         </thead>

    <?php

    $user = currentUser();
     $query = "SELECT * FROM posts WHERE post_user = '$user' ORDER BY post_id DESC";
    $query = "SELECT posts.post_id, posts.post_author, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
    $query .= "posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title ";       //*kad eiti pirmiausi i table ir tada i column, darome taip "SELECT posts.post_id," <-- taip pasiekiam table.column, perskirdami kableliu
    $query .= " FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC "; //ON yra beveik tas pats kas WHERE ir post_categiry_id toks pat kaip cat_id

    $select_posts = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($select_posts)){
        $post_id            = $row['post_id'];
        $post_author        = $row['post_author'];
        $post_user          = $row['post_user'];
        $post_title         = $row['post_title'];
        $post_category_id   = $row['post_category_id'];
        $post_status        = $row['post_status'];
        $post_image         = $row['post_image'];
        $post_tags          = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date          = $row['post_date'];
        $post_views_count   = $row['post_views_count'];
        $category_title     = $row['cat_title'];
        $category_id        = $row['cat_id'];   //sita nebutina, bet siaip prideta

        echo "<tr>";
        ?>
        
        <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>    <!--reikia sita padaryti kaip array. kai tik spausim apply, sitas name= checkBoxArray eis per post, kuris yra sio puslapio virsuje i superglobal kaip array, ir mums reikia paduoti value kad jis galetu kazka daryti. tas $post_id ima checkboxarray -->
        
        <?php
        
        echo "<td>$post_id</td>";

        if (!empty($post_user)) {
            echo "<td>$post_user</td>";
        } elseif (!empty($post_user)) {
            echo "<td>$post_user</td>";
        } 

        echo "<td>$post_title</td>";

        //**102 eilute mes aprasom trumpiau, kitaip..///
        // $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
        // $select_categories_id = mysqli_query($connection,$query);

        // while($row = mysqli_fetch_assoc($select_categories_id)) {   //sia iterpta funkcija galime keisti visa posta puslapyje posts.php
        // $cat_id = $row['cat_id'];
        //  $cat_title = $row['cat_title'];

        echo "<td>{$category_title}</td>";
        // }

        echo "<td>{$post_status}</td>";
        echo "<td><img width='100' src='/cms/images/$post_image' alt='image'></td>";
        echo "<td>{$post_tags}</td>";
        //komentaramas skaiciuoti pradzia ///
        $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
        $send_comment_query = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($send_comment_query);
        $comment_id = $row['comment_id'];
        $count_comments = mysqli_num_rows($send_comment_query);
        //komentarams skaiciuoti pabaiga ///

        echo "<td><a class='badge' href='post_comments.php?id=$post_id'>$count_comments</a></td>";

        echo "<td>{$post_date}</td>";
        echo "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>View post</a></td>";
        echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";

        ?>

        <form method="post">
            <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
            <?php 
                echo '<td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>';
            ?>
        </form>

        <?php

        // echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";

        //echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>"; //pridedam javascript kad gautume papildoma patvirtinima pries istrinant posta is post leneteles. atidarymas - \" ir uzdarymas - \" kode.
        echo "<td><a class='badge' href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
        echo "</tr>";
    }
    ?>

    </table>
</form>

<?php
if(isset($_POST['delete'])){                                         //istrinam komentarus is posts.php
    $the_post_id = escape($_POST['post_id']);
    $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";   //kiek suprantu, skliausteliai the_post_id nera reikalavimas..
    $delete_query = mysqli_query($connection, $query);
    header("Location: posts.php");  //kad automatiskai puslapis persikrautu, o nereiketo dukart spausti delete, reikia prideti sita.
}

if(isset($_GET['reset'])){                                         //istrinam komentarus is posts.php
    $the_post_id = $_GET['reset'];
    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $_GET['reset']) . " ";   //kiek suprantu, skliausteliai the_post_id nera reikalavimas..
    $reset_query = mysqli_query($connection, $query);
    header("Location: posts.php");  //kad automatiskai puslapis persikrautu, o nereiketo dukart spausti delete, reikia prideti sita.
}

?>

<script>

$(document).ready(function(){
   
    $(".delete_link").on('click', function(){
        
        var id = $(this).attr("rel");
        
        var delete_url = "posts.php?delete="+ id +" ";
        
        $(".modal_delete_link").attr("href", delete_url);
        
        $("#myModal").modal('show');
        
    });
    
});

</script>
