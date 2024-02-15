<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/fav.png" />
    <!-- Author Meta -->
    <meta name="author" content="colorlib" />
    <!-- Meta Description -->
    <meta name="description" content="" />
    <!-- Meta Keyword -->
    <meta name="keywords" content="" />
    <!-- meta character set -->
    <meta charset="UTF-8" />
    <!-- Site Title -->
    <title>Course Details</title>

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:900|Roboto:400,400i,500,700" rel="stylesheet" />
    <!--
      CSS
      =============================================
    -->
    <link rel="stylesheet" href="css/linearicons.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/magnific-popup.css" />
    <link rel="stylesheet" href="css/owl.carousel.css" />
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/hexagons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/themify-icons/0.1.2/css/themify-icons.css" />
    <link rel="stylesheet" href="css/main.css" />
    <style>
        span {
                font-family: 'Pacifico', cursive;
                color:white;
            }
      </style>
</head>

<body>
    <!-- ================ Start Header Area ================= -->
    <header class="default-header">
        <nav class="navbar navbar-expand-lg  navbar-light">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                    <span>
                      Tune Tutor 
                    </span>
                  </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="lnr lnr-menu"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        
                    <?php
            session_start();

            // Check if the user is logged in
            if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
                // User is logged in
                echo '<li><a href="home.php">Home</a></li>';
                echo '<li><a href="mycourse.php">My Course</a></li>';
                echo '<li><a href="courses.php">Courses</a></li>';
                echo '<li><a href="blog-home.html">Blog</a></li>';
                echo '<li><a href="logout.php">Logout</a></li>';
            } else {
                echo'
                <li><a href="index.html">Home</a></li>
                <li><a href="courses.php">Courses</a></li>            
                <li><a href="contacts.html">Contacts</a></li>
                <li class="dropdown">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                    Join Now
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="login.php">Login</a>
                    <a class="dropdown-item" href="signup.php">Signup</a>
                </div>
                </li>';
            }
            ?>
                    <!-- end login -->

                    </ul>
                </div>
            </div>
        </nav>
        
    </header>
    <!-- ================ End Header Area ================= -->

    <!-- ================ start banner Area ================= -->
    <section class="banner-area">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-12 banner-right">
                    <h1 class="text-white">
                        Course Details
                    </h1>
                   
                    <div class="link-nav">
                        <span class="box">
                            <a href="index.html">Home </a>
                            <i class="lnr lnr-arrow-right"></i>
                            <a href="courses.html">Courses </a>
                            <i class="lnr lnr-arrow-right"></i>
                            <a href="course-details.html">Course Details</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ End banner Area ================= -->
    <?php

include 'vendor/autoload.php';

// MongoDB connection
$mongoClient = new MongoDB\Client;
$collection = $mongoClient->tunetutor->coursedetails;

// Get the course ID from the URL parameter
$courseId = $_GET['id'] ?? null;
$_SESSION['courseid'] = $courseId;
// Check if the ID is provided
if ($courseId) {
    // Convert the string ID to MongoDB\BSON\ObjectID
    $objectId = new MongoDB\BSON\ObjectID($courseId);

    // Query to find the course by ID
    $course = $collection->findOne(['_id' => $objectId]);

    // Concatenate the base path with the stored image path
    $basePath = "admin/template/courseimage/"; // Change this to your actual base URL
    $imagePath = $basePath . $course['c_img_filename']; 
    $originalDate = $course['last_update'];
$newDate = date("d-m-Y", strtotime($originalDate));


   
} else {
    echo "Course ID is not provided.";
}

?>

    <!--================ Start Course Details Area =================-->
    <section class="course-details-area section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 course-details-left">
                    <div class="main-image">
                        <img class="img-fluid" style="height:500px; width:750px;" src="<?= $imagePath ?>" alt="">
                    </div>
                    <div class="content-wrapper">
                        <h4 class="title">Objectives</h4>
                        <div class="content">
                        <?= $course['objective'] ?>                            
                        </div>

                        <h4 class="title">Eligibility</h4>
                        <div class="content">
                        <?= $course['eligibility'] ?>
                        </div>

<?php
    $c_outline = $course['c_outline'];
    $outlineArray = explode(', ', $c_outline);
?>

<h4 class="title">Course Outline</h4>
<div class="content">
    <ul class="course-list">
        <?php
        foreach ($outlineArray as $outline) {
            echo '<li class="justify-content-between d-flex">';
            echo '<p>' . $outline . '</p>';
            echo '<a class="btn text-uppercase" href="singlevideo.php?course='.$outline.'">View Course</a>';
            echo '</li>';
        }
        ?>
    </ul>
</div>

                    </div>
                </div>


                <div class="col-lg-4 right-contents">
                    <ul>
                        <li>
                            <a class="justify-content-between d-flex" href="#">
                                <p>Trainer’s Name</p>
                                <span class="or"><?= $course['t_name'] ?></span>
                            </a>
                        </li>
                        <li >
                            <a class="justify-content-between d-flex" href="#">
                                <p>Course Fee </p>
                                <span style="color:black;">₹ <?= $course['c_fee'] ?></span>
                            </a>
                        </li>
                        <li>
                            <a class="justify-content-between d-flex" href="#">
                                <p>Instrument </p>
                                <span style="color:black;"> <?= $course['instrument'] ?></span>
                            </a>
                        </li>
                        <li>
                            <a class="justify-content-between d-flex" href="#">
                                <p>Last Update </p>
                                <span style="color:black;"><?php echo $newDate; ?></span>
                            </a>
                        </li>
                    </ul>
                    <a href="#" class="btn text-uppercase enroll">Enroll the course</a>

                    <h4 class="title">Reviews</h4>
                    <div class="content">
                        <div class="review-top row pt-40">
                            <div class="col-lg-12">
                                <h6 class="mb-15">Provide Your Rating</h6>
                                <div class="d-flex flex-row reviews justify-content-between">
                                    <span>Quality</span>
                                    <div class="star">
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <span>Outstanding</span>
                                </div>
                                <div class="d-flex flex-row reviews justify-content-between">
                                    <span>Puncuality</span>
                                    <div class="star">
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <span>Outstanding</span>
                                </div>
                                <div class="d-flex flex-row reviews justify-content-between">
                                    <span>Quality</span>
                                    <div class="star">
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <span>Outstanding</span>
                                </div>
                            </div>
                        </div>
                        <div class="feedeback">
                            <h6 class="mb-10">Your Feedback</h6>
                            <textarea name="feedback" class="form-control" cols="10" rows="10"></textarea>
                            <div class="mt-10 text-right">
                                <a href="#" class="btn text-center text-uppercase enroll">Submit</a>
                            </div>
                        </div>
                        <div class="comments-area mb-30">
                            <div class="comment-list">
                                <div class="single-comment single-reviews justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img src="img/blog/c1.jpg" alt="">
                                        </div>
                                        <div class="desc">
                                            <h5><a href="#">Emilly Blunt</a>
                                                <div class="star">
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star"></span>
                                                    <span class="fa fa-star"></span>
                                                </div>
                                            </h5>
                                            <p class="comment">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                eiusmod tempor incididunt ut labore et dolore.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="comment-list">
                                <div class="single-comment single-reviews justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img src="img/blog/c2.jpg" alt="">
                                        </div>
                                        <div class="desc">
                                            <h5><a href="#">Elsie Cunningham</a>
                                                <div class="star">
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star"></span>
                                                    <span class="fa fa-star"></span>
                                                </div>
                                            </h5>
                                            <p class="comment">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                eiusmod tempor incididunt ut labore et dolore.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="comment-list">
                                <div class="single-comment single-reviews justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img src="img/blog/c3.jpg" alt="">
                                        </div>
                                        <div class="desc">
                                            <h5><a href="#">Maria Luna</a>
                                                <div class="star">
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star"></span>
                                                    <span class="fa fa-star"></span>
                                                </div>
                                            </h5>
                                            <p class="comment">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                eiusmod tempor incididunt ut labore et dolore.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End Course Details Area =================-->

    <!-- ================ start footer Area ================= -->
    <footer class="footer-area section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-6 single-footer-widget">
                    <h4>Top Products</h4>
                    <ul>
                        <li><a href="#">Managed Website</a></li>
                        <li><a href="#">Manage Reputation</a></li>
                        <li><a href="#">Power Tools</a></li>
                        <li><a href="#">Marketing Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 single-footer-widget">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#">Jobs</a></li>
                        <li><a href="#">Brand Assets</a></li>
                        <li><a href="#">Investor Relations</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 single-footer-widget">
                    <h4>Features</h4>
                    <ul>
                        <li><a href="#">Jobs</a></li>
                        <li><a href="#">Brand Assets</a></li>
                        <li><a href="#">Investor Relations</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 single-footer-widget">
                    <h4>Resources</h4>
                    <ul>
                        <li><a href="#">Guides</a></li>
                        <li><a href="#">Research</a></li>
                        <li><a href="#">Experts</a></li>
                        <li><a href="#">Agencies</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 single-footer-widget">
                    <h4>Newsletter</h4>
                    <p>You can trust us. we only send promo offers,</p>
                    <div class="form-wrap" id="mc_embed_signup">
                        <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                            method="get" class="form-inline">
                            <input class="form-control" name="EMAIL" placeholder="Your Email Address" onfocus="this.placeholder = ''"
                                onblur="this.placeholder = 'Your Email Address '" required="" type="email">
                            <button class="click-btn btn btn-default text-uppercase">subscribe</button>
                            <div style="position: absolute; left: -5000px;">
                                <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
                            </div>

                            <div class="info"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="footer-bottom row align-items-center">
                <p class="footer-text m-0 col-lg-8 col-md-12">
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                <div class="col-lg-4 col-md-12 footer-social">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-dribbble"></i></a>
                    <a href="#"><i class="fa fa-behance"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <!-- ================ End footer Area ================= -->

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/parallax.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/hexagons.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>