<?php /*//ob_start(); */?><!--
<?php /*//session_start(); */?>
<?php /*//include "includes/db.php"; */?>
<?php /*//require_once("db.php")  */?>
--><?php  require_once "admin/functions.php"; ?>


        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cms">CMS Front</a> <!-- po access failo vietoj index.php galim deti index arba.. -->
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                  <?php
                $query = "SELECT * FROM categories LIMIT 3";
                $select_all_categories_query = mysqli_query($connection,$query);

                while($row = mysqli_fetch_assoc($select_all_categories_query)) {
                    $cat_title = $row['cat_title'];
                     $cat_id = $row['cat_id'];

//                     $category_class = '';
//                     $registration_class = '';  //jeigu darai static active link, reikia butinai sukurti toki kintamaji
//                     $contact_class = '';
//                     $login_class = '';
//                    $admin_class = '';
//                    $logout = '';
//
//                     $pageName = basename($_SERVER['PHP_SELF']);    //php_self butu kazkas panasaus i index puslapi
//
//                     $registration = 'registration.php';
//                     $contact = 'contact.php';
//                     $login = 'login.php';
//                    $admin = '/admin/index';
//                    $logout = '/cms/includes/logout.php';
//
//                     if(isset($_GET['category']) && $_GET['category'] == $cat_id) {
//                        $category_class = 'active';
//                     } elseif ($pageName == $registration) {
//                         $registration_class = 'active';
//                     } elseif ($pageName == $contact) {
//                        $contact_class = 'active';
//                     } elseif ($pageName == $admin) {
//                         $admin_class = 'active';
//                     } elseif ($pageName == $logout) {
//                         $logout_class = 'active';
//                     } elseif ($pageName == $login) {
//                        $login_class = 'active';
//                     }                                           //category.php?category=($cat_id} <-- buvo taip

                    echo "<li><a href='/cms/category/{$cat_id}'>{$cat_title}</a></li>";       //variables galima deti i cia tik naudojant {} norint kad atskirti nuo HTML, ir daryti echo su " kabutem, su ' kabutem neveiktu
                }
                    ?>

                    <?php if(isLoggedIn()): ?>  <!--shorthand php-->

                    <!--<li> class='<?php //echo $admin_class; ?>'>
                        <a href="/cms/admin">Adminas</a>
                    </li>-->


                    <?php elseif(isLoggedIn()): ?>


                    <li>  <!--class='<?php /*//echo $logout_class; */?>'>-->
                        <a href="/cms/includes/logout.php">Logout</a>
                    </li>

                    <?php else: ?>
                    
                    <li> <!--class='<?php /*//echo $admin_class; */?>'>-->
                        <a href="/cms/admin">Admin</a>
                    </li>
                    
                    <!--<li> class='<?php //echo $login_class; ?>'>
                        <a href="/cms/login">Login</a>
                    </li>-->
                    
                    <li> <!--class='<?php /*//echo $registration_class; */?>'>-->
                        <a href="/cms/registration">Registration</a>
                    </li>

                    <?php endif; ?>
                    
                     <li class='<?php //echo $contact_class; ?>'>
                        <a href="/cms/contact">Contact</a>
                    </li>

        <?php
            if (session_status() === PHP_SESSION_NONE) session_start();
            if(isset($_SESSION['user_role'])){
                if(isset($_GET['p_id'])){
                    $the_post_id = $_GET['p_id'];
                    echo "<li><a href='/cms/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit post</a></li>";
                }
            }
        ?>


                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
