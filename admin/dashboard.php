
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
                            Welcome to the Admin dashboard

                            <small><?php echo $_SESSION['username'] ?></small>
                            <small>- <?php echo $_SESSION['user_role'] ?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

        <div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">


        

            <div class='huge'><?php echo $post_count = recordCount('posts'); ?></div>   <!-- sita gavome perdare anksciau buvusia funkcija ir ja padeje i functions 113 eile, $post count sitaip paliekame, nes cia zemiau 170eilej turime ta $post cont, kuris tures buti apibreztas -->

                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
<!--     <?php
    // $query = "SELECT * FROM comments";                            //vietoje
    // $select_all_comments =/mysqli_query($connection,$query);      //sios
    // $comment_count = mysqli_num_rows($select_all_comments);       //eilutes
    //     echo "<div class='huge'>{$comment_count}</div>";          //idedame paprastesne i 68 eilute zemiau
    //?> -->

        <div class='huge'><?php echo $comment_count = recordCount('comments'); ?></div>

                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
<!--      <?php
    // $query = "SELECT * FROM users";
    // $select_all_users = mysqli_query($connection,$query);
    // $user_count = mysqli_num_rows($select_all_users);
    //     echo "<div class='huge'>{$user_count}</div>";
    ?> -->

        <div class='huge'><?php echo $user_count = recordCount('users'); ?></div>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
        <div class='huge'><?php echo $category_count = recordCount('categories'); ?></div>
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
            <!-- /.row -->
            
    <?php
        ////**** 
        // $query = "SELECT * FROM posts WHERE post_status = 'published'";
        // $select_all_published_posts = mysqli_query($connection,$query);
        // $post_published_count = mysqli_num_rows($select_all_published_posts);
        //**** is 139 padarem 143***///
        $post_published_count = checkStatus('posts','post_status','published');     //sios visa funkcija function.php 123
                
        $post_draft_count = checkStatus('posts','post_status','draft');
                
        $unapproved_comment_count = checkStatus('comments','comment_status','unapproved');        //**sito man rodos funkcijos pas mane nera...
        
        $subscriber_count = checkUserRole('users','user_role','subscriber');

    ?>

            <div class="row">
                <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Count'],

                    //auksciau esantys $query padeda is duombazes gauti issaugotus duomenis is postu, komentaru ir useriu ir juos taip pat parodyti chartuose, kuriu kodas paimtas is google charts
            <?php   //javascript viduje iterpiame php kodu eilutes, kurios pereina per rezultatus naudodamos for loop ir taip atsiradanda gyvi rodykliai, kurie atvaizduojami spalvotuose rodikliuose
                $element_text = ['All posts', 'Active posts', 'Draft posts', 'Comments', 'Pending comments', 'Users', 'Subscribers', 'Categories'];
                $element_count = [ $post_count, $post_published_count, $post_draft_count, $comment_count, $unapproved_comment_count, $user_count, $subscriber_count, $category_count];
            for($i = 0; $i < 8; $i++) {
                echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";     //
            }
            ?>

        ]);

        var options = {
          chart: {
            title: '',  //sioje vietoje istryneme lenteles pavadinima ir pan. palikome tuscia
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

           <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>    <!-- vietoje buvusio skatmens width parasome "auto" kad charto plotis automatiskai prisitaikytu prie puslapio -->

            </div>

            </div>
            <!-- /.container-fluid -->

        </div>





        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php"; ?>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
        
        <script>
            $(document).ready(function() {
                var pusher = new Pusher('4efc81dd90f28cfd5b38', {
                cluster: 'eu',
                encrypted: true
            });

            var notificationChannel = pusher.subscribe('notifications');

            notificationChannel.bind('new_user', function(notification){
                var message = notification.message;
                toastr.success('${message} just registered');

            });

            });
            
        </script>