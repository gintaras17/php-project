<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">

        <!-- Navigation -->
<?php include "includes/admin_navigation.php"; ?>


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small>Author</small>
                        </h1>

                    <?php

                      if(isset($_GET['source'])){       //kad switch dalykas veiktu, reikia daryti taip
                          $source = $_GET['source'];    //kol nera else bukles, tol ekrane matom klaida su Notice: undefined variable..
                      }  else {
                          $source = '';                 //parasius sia else eilute, mes nebegauname notice klaidos ekrane.
                      }

                        switch($source) {
                                case 'add_post';
                                include "includes/add_post.php";
                                break;

                                case 'edit_post';
                                include "includes/edit_post.php";
                                break;

                                case '200';
                                echo "nice 200";
                                break;

                            default:

                                include "includes/view_all_comments.php";  //sita iterpiam cia tam, kad jeigu nieko negausim su 23 eilutej padaryta if busena $_GET['source], kad kazkas vistik butu visa laika

                                break;
                        }

                    ?>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>





        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php"; ?>
