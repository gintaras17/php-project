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
                <th>Author</th>
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
            </tr>
         </thead>

    <?php
    $query = "SELECT * FROM posts";
    $select_posts = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($select_posts)){
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];

        echo "<tr>";
        ?>
        
        <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>    <!--reikia sita padaryti kaip array. kai tik spausim apply, sitas name= checkBoxArray eis per post, kuris yra sio puslapio virsuje i superglobal kaip array, ir mums reikia paduoti value kad jis galetu kazka daryti. tas $post_id ima checkboxarray -->
        
        <?php
        
        echo "<td>{$post_id}</td>";
        echo "<td>{$post_author}</td>";
        echo "<td>{$post_title}</td>";

        $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
        $select_categories_id = mysqli_query($connection,$query);

        while($row = mysqli_fetch_assoc($select_categories_id)) {   //sia iterpta funkcija galime keisti visa posta puslapyje posts.php
        $cat_id = $row['cat_id'];
         $cat_title = $row['cat_title'];

        echo "<td>{$cat_title}</td>";
        }

        echo "<td>{$post_status}</td>";
        echo "<td><img width='100' src='../images/{$post_image}' alt='image'></td>";
        echo "<td>{$post_tags}</td>";
        echo "<td>{$post_comment_count}</td>";
        echo "<td>{$post_date}</td>";
        echo "<td><a href='../post.php?p_id={$post_id}'>View post</a></td>";
        echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
        echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
        //echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>"; //pridedam javascript kad gautume papildoma patvirtinima pries istrinant posta is post leneteles. atidarymas - \" ir uzdarymas - \" kode.
        echo "</tr>";
    }
    ?>

    </table>
</form>

<?php
if(isset($_GET['delete'])){                                         //istrinam komentarus is posts.php
    $the_post_id = $_GET['delete'];
    $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";   //kiek suprantu, skliausteliai the_post_id nera reikalavimas..
    $delete_query = mysqli_query($connection, $query);
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
