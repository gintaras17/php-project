                            <form action="" method="post">
                               <div class="form-group">
                                  <label for="cat-title">Edit Category</label>

              <?php

                    if(isset($_GET['edit'])){
                        $cat_id = $_GET['edit'];

                        $query = "SELECT * FROM categories WHERE cat_id = $cat_id ";
                        $select_categories_id = mysqli_query($connection,$query);

                while($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $user_id = $_SESSION['user_id'];    //pridejau pats.. nezinau ar gerai
                $cat_title = $row['cat_title'];
                    ?>

        <input value="<?php if(isset($cat_title)){echo $cat_title;} ?>" type="text" class="form-control" name="cat_title">

                    <?php  }} ?>

                    <?php
                            //Update query
                    if(isset($_POST['update_category'])) {
                    $the_cat_title = escape($_POST['cat_title']);
                    $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ? ");

                    mysqli_stmt_bind_param($stmt, 'si', $the_cat_title, $cat_id);  //is 'is' eina--> s atstovauja string, o i atstovauja integer, kadangi 26 eilutej pirmiausia buvo the_cat_title, tai dedam s, po to buvi cat_id, tai dedam i.. ir tuo paciu salia sudedam cat_title ir cat_id variables pagal raidziu reiksmes
                    mysqli_stmt_execute($stmt);


                        if(!$stmt){
                            die("Query Failed" . mysqli_error($connection));
                        }
                        mysqli_stmt_close($stmt); //tipo del greitesnio veikimo galima uzdaryti sesija su sia eilute. galima ir duombaze uzdaryti, bet tai padaro ir pats PHP
                        redirect("categories.php"); //sita redirect parasius, pataisant/updatinant kategorija nebelieka eilutes, kurioje taisome ja, ir sugriztame i kategoriju puslapi
                    }

                    ?>
                               </div>
                               <div class="form-group">
                                   <input class="btn btn-primary" type="submit" name="update_category" value="Update">
                               </div>

                            </form>
