<!DOCTYPE html>
<?php
//$logged=false;
session_start();
if (isset($_POST['submit'])) {
if($_POST['submit']) {
	include_once('connection.php');
	$username = strip_tags($_POST['username']);
	$password = strip_tags($_POST['password']);

	$sql = "SELECT activated, username, password FROM members where username = '$username' LIMIT 1";
	$query = mysqli_query($db_login, $sql);
	if($query) {
		$row = mysqli_fetch_row($query);
		$userId= $row[2];
		$dbUserName = $row[1];
		$dbPassword = $row[2];
    }
    if(!empty($_POST['username'])){
        if($username == $dbUserName && $password == $dbPassword) {
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $userId;
            header('Location: index.php');
        }
        else {
            echo "<b><i>Invalid password</i><b>";
        }
    }else{
         echo '<div class="modal fade bd-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">';
         echo '<div class="modal-dialog modal-sm">';
         echo '  <div class="modal-content">';
         echo '    ...';
         echo '  </div>';
         echo '</div>';
         echo '</div>';

       echo'<script> $(\'#myModal\').modal(\'show\');</script>';
    //echo '<script> window.alert("Don\'t waste time")</script>';

    }
}
}
//only if session is created then user has logged in
if (isset($_SESSION['id'])){
	$userId = $_SESSION['id'];
    $username = $_SESSION['username'];
    $logged=true; 
}else{
    $logged=false;
  }
?>
<!-- Image Upload -->
<?php
	$msg="";
	if(isset($_POST['upload'])){
		$target="alladds/".basename($_FILES['image']['name']);
		$db = mysqli_connect("localhost","root","","login");
		$image = $_FILES['image']['name'];
		$text = $_POST['text'];
		$TNum = $_POST['TNum'];
		$Price = $_POST['Price'];
		$sql = "INSERT INTO alladds(image, text,price,pnum) VALUES ('$image','$text','$TNum','$Price');";
		mysqli_query($db,$sql);
		if(move_uploaded_file($_FILES['image']['name'],$target)){
				$msg = "image uploaded successfully";
		}else{
			$msg = "There was a problem uploading image";
		}
		
	}
?>

<html>

<head>
    <meta charset="ISO-8859-1">
    <title>කුළියට</title>
    <link rel="shortcut icon" href="Resources/favicon.ico">
    <!-- Bootstrap CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap Local -->
    <link rel="stylesheet" href="Resources/bootstrap/css/bootstrap.min.css">
    <script src="Resources/bootstrap/js/bootstrap.min.js"> </script>
    <script src="//Resources/jquery/jquery-3.3.1.min"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- File uploader plugin -->

    <script src="Resources/fileUploader/dropzone.js"></script>

    <!-- <link href="http://hayageek.github.io/jQuery-Upload-File/4.0.11/uploadfile.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://hayageek.github.io/jQuery-Upload-File/4.0.11/jquery.uploadfile.min.js"></script> -->

    <link href="Resources/dist/css/jquery.dm-uploader.min.css" rel="stylesheet">
    <link href="Resoures/styles.css" rel="stylesheet">


</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark justify-content-between">
        <!-- Logo -->
        <a class="navbar-brand">
            <img classs="img-responsive" width="" height="75px" src="Resources/Kuliyata_logo_full.png">
        </a>
        <!-- Div for generel user items -->
        <div class="generel_user" id="div_generel_user" <?php if($logged===true ){?>style="display:none" <?php }?>>

            <div class="row">
                <!-- Login form -->
                <form method="post" action="index.php" class="form-inline " style="content-right">
                    <input type="text" name="username" class="form-control mr-sm-2" placeholder="Username or email">
                    <input type="password" name="password" class="form-control mr-sm-2" placeholder="Password">
                    <button type="submit" name="submit"
                        class="float btn btn-outline-info my-2 my-sm-0 mr-sm-2 mr-xs-1 my-xs-0"
                        value="login">Login</button>
                </form>
                <!-- Register button -->
                <form action="register.php">
                    <input type="submit" class="float btn btn-outline-info my-2 my-sm-0 mr-sm-2 mr-xs-1 my-xs-0"
                        value="Register" />
                </form>
            </div>
        </div>
        <!-- Div for logged user items -->
        <div class="logged_user" id="div_logged_user" <?php if($logged===false ){?>style="display:none" <?php }?>>
            <div class="btn-group">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                    data-display="static" aria-haspopup="true" aria-expanded="false">
                    <?php echo htmlentities($username) ?>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" type="button">Account</a>
                    <a class="dropdown-item" type="button">Another action</a>
                    <a class="dropdown-item" type="button" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Search section -->
    <section class="search-sec">
        <div class="container">
            <form action="search.php" method="GET">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="row align-items-center">
                            <div class="col-lg-5 col-md-5 col-sm-12 p-2">
                                <input type="text" name="query" class="form-control search-slt"
                                    placeholder="What do you want?">
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-12 p-2">
                                <select class="form-control search-slt" name="category" id="selectCategory" placeholder="Select Category">
                                    <option>Vehicles</option>
                                    <option>Cleaning appliences</option>
                                    <option>Electrical/Electronic</option>
                                    <option>Catering</option>
                                    <option>Building and construction</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 p-2 ">
                                <!-- <button type="button" value="Search" class="btn btn-primary wrn-btn">Search</button> -->
                                <input type="submit" class="btn btn-info active align-items-center" value="Search">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>


    <div id="sub_content">
        <?php
			include_once('connection.php');
			$sql = "SELECT * FROM ads";
			$result = mysqli_query($db_login,$sql);
			while ($row = mysqli_fetch_array($result)){
					echo "<div class='card mb-2'>";
						echo "<img src='".$row['images']."' class='card-img-top' alt='image'>";
							echo "<div class='card-body'>";
								echo "<h5 class='card-title'>".$row['title']."</h5>";
							echo "<p class='card-text'>".$row['description']."</p>";
							echo "<p class='card-text'><small class='text-muted'>Last updated 3 mins ago</small></p>";
							echo "</div>";
					echo "</div>";
			}
			
		?>

        <!-- <div class="card mb-3">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                    content. This content is a little bit longer.</p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
        </div> -->

        <div class="tab-content clear">
                <div role="tabpanel" class="tab-pane active" id="home">
                  <?php while ($row = mysqli_fetch_array($result)): ?>
                    <div class="col-sm-4 col-xs-4 section1a">
                        <div class="sectionstyle">
                            <div class="textcenter">
                                <h2> <?php echo $row['title'] ?></h2>
                                <p>description goes here</p>
                            </div>
                            <div class="">
                                <img class="img-responsive" src="images/image.jpg">
                            </div>
                            <div class="clear"></div>
                            <p><small>bar A</small>
                            </p>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                            <p><small>bar B</small>
                            </p>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                    <span class="sr-only">20% Complete</span>
                                </div>
                            </div>
                            <p><small>bar C</small>
                            </p>
                            <div class="progress">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                    <span class="sr-only">60% Complete (warning)</span>
                                </div>
                            </div>
                            <p><a class="btn btn-success btn-primary btn-block buttoncenter" href="#" role="button">Submit</a>
                            </p>
                        </div>

                    </div>
                  <?php endwhile; ?>
                </div>
              </div>














        <!-- Footer -->
        <footer class="page-footer font-small stylish-color-dark pt-4">

            <!-- Footer Links -->
            <div class="container text-center text-md-left">

                <!-- Grid row -->
                <div class="row">

                    <!-- Grid column -->
                    <div class="col-md-4 mx-auto">

                        <!-- Content -->
                        <h5 class="font-weight-bold text-uppercase mt-3 mb-4">කුළියට.lk</h5>
                        <p>Sri Lankas fastest growing renting service. Register now</p>

                    </div>
                    <!-- Grid column -->

                    <hr class="clearfix w-100 d-md-none">

                    <!-- Grid column -->
                    <div class="col-md-2 mx-auto">

                        <!-- Links -->
                        <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Useful Links</h5>

                        <ul class="list-unstyled">
                            <li>
                                <a href="#!">Home</a>
                            </li>
                            <li>
                                <a href="#!">Categories</a>
                            </li>
                            <li>
                                <a href="#!">Link 3</a>
                            </li>
                            <li>
                                <a href="#!">Link 4</a>
                            </li>
                        </ul>

                    </div>
                    <!-- Grid column -->

                    <hr class="clearfix w-100 d-md-none">

                    <!-- Grid column -->
                    <div class="col-md-2 mx-auto">

                        <!-- Links -->
                        <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Links</h5>

                        <ul class="list-unstyled">
                            <li>
                                <a href="#!">Link 1</a>
                            </li>
                            <li>
                                <a href="#!">Link 2</a>
                            </li>
                            <li>
                                <a href="#!">Link 3</a>
                            </li>
                            <li>
                                <a href="#!">Link 4</a>
                            </li>
                        </ul>

                    </div>
                    <!-- Grid column -->

                    <hr class="clearfix w-100 d-md-none">

                    <!-- Grid column -->
                    <div class="col-md-2 mx-auto">

                        <!-- Links -->
                        <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Links</h5>

                        <ul class="list-unstyled">
                            <li>
                                <a href="#!">Link 1</a>
                            </li>
                            <li>
                                <a href="#!">Link 2</a>
                            </li>
                            <li>
                                <a href="#!">Link 3</a>
                            </li>
                            <li>
                                <a href="#!">Link 4</a>
                            </li>
                        </ul>

                    </div>
                    <!-- Grid column -->

                </div>
                <!-- Grid row -->

            </div>
            <!-- Footer Links -->

            <hr>

            <!-- Call to action -->
            <ul class="list-unstyled list-inline text-center py-2">
                <li class="list-inline-item">
                    <h5 class="mb-1">Register for free</h5>
                </li>
                <li class="list-inline-item">
                    <a href="#!" class="btn btn-danger btn-rounded">Sign up!</a>
                </li>
            </ul>
            <!-- Call to action -->

            <hr>

            <!-- Social buttons -->
            <ul class="list-unstyled list-inline text-center">
                <li class="list-inline-item">
                    <a class="btn-floating btn-fb mx-1">
                        <i class="fab fa-facebook-f"> </i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a class="btn-floating btn-tw mx-1">
                        <i class="fab fa-twitter"> </i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a class="btn-floating btn-gplus mx-1">
                        <i class="fab fa-google-plus-g"> </i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a class="btn-floating btn-li mx-1">
                        <i class="fab fa-linkedin-in"> </i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a class="btn-floating btn-dribbble mx-1">
                        <i class="fab fa-dribbble"> </i>
                    </a>
                </li>
            </ul>
            <!-- Social buttons -->

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">© 2019 Copyright:
                <!-- <a href="https://mdbootstrap.com/education/bootstrap/"> MDBootstrap.com</a> -->
                <a href="https://kuliyata.lk">Kuliyata.lk</a>
            </div>
            <!-- Copyright -->

        </footer>
        <!-- Footer -->
</body>

</html>