<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: loginv2.php");
		exit;
	}
	// select loggedin users detail
	$res=mysqli_query($conn,"SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=mysqli_fetch_array($res);
    
    //alert Handler
    if (isset($_SESSION['newpassReset']) && $_SESSION['newpassReset']) {
        unset($_SESSION['newpassReset']);
    
        $msgTyp = "success";
        $msgTitle = "Completed";
        $msgBod = "Your password has been successfully changed. You can now logout and login with your new password";
        $msgIcon = "<i class=\"fa fa-check\"></i>";

    }

    if (isset($_SESSION['errorChange']) && $_SESSION['errorChange']) {
        unset($_SESSION['errorChange']);
    
        $msgTyp = "danger";
        $msgTitle = "Error";
        $msgBod = "Wrong current password";
        $msgIcon = "<i class=\"ti-na\"></i>";

    }
    if (isset($_SESSION['errordb']) && $_SESSION['errordb']) {
        unset($_SESSION['errordb']);
    
        $msgTyp = "danger";
        $msgTitle = "Error";
        $msgBod = "Database connection process failed";
        $msgIcon = "<i class=\"ti-na\"></i>";

    }
     

?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>COHSS DISPATCHER PROGRAM - User Settings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <script type="text/javascript">

    </script>

</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="index.php"><img src="assets/images/icon/logo.png" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Home</span></a>
                                <ul class="collapse">
                                    <li><a href="index.php">Dashboard</a></li>
                                </ul>
                            </li>
                            <li><a href="input-letter.php"><i class="ti-import"></i> <span>Input Letter</span></a></li>
                            <li><a href="dispatch-letters.php"><i class="ti-truck"></i> <span>Dispatch Letters</span></a></li>
                            <li class="active"><a href="user-settings.php"><i class="ti-settings"></i> <span>Settings</span></a></li>
                            <li><a href="logout.php?logout"><i class="ti-shift-right"></i> <span>Logout</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <div class="nav-btn pull-left">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <h4 class="page-title pull-left">Dashboard</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Home</a></li>
                                <li><span>Settings</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="assets/images/author/avatar.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?php echo $userRow['userName']; ?> <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="user-settings.php">Settings</a>
                                <a class="dropdown-item" href="logout.php?logout">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-xl-12 mt-5">
                        <div class="card">
                        <?php
                                    if (isset($msgBod)){

                                ?>
				                    <div class="alert-dismiss" id="successAlert">
                                        <div class="alert alert-<?php echo ($msgTyp=="success") ? "success" : $msgTyp; ?> alert-dismissible fade show" role="alert">
                                        <strong><?php echo $msgTitle?>!</strong> <?php echo $msgBod; ?> <?php echo $msgIcon; ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="fa fa-times"></span>
                                        </button>
                                        </div>
                                    </div>
                                <?php
                                    }
                                ?>
                            <div class="card-body">
                                <h3 class="header-title">Settings <i class="fa fa-gear"></i></h3>
                                <br>
                                <span>Profile and New users</span>
                                <hr>
                                <form>
                                <div class="form-row align-items-center">
                                    <div class="col-sm-1 my-1">
                                    <p>Username: </p>
                                    </div>
                                    <div class="col-sm-3 my-1">
                                        <label class="sr-only" for="inlineFormInputName">Username</label>
                                        <input type="text" class="form-control" id="inlineFormInputName" placeholder="Jane Doe" value="<?php echo $userRow['userName']; ?>" disabled>
                                    </div>
                                    <div class="col-sm-1 offset-sm-4">   
                                            <div class="form-group">
                                                <label for="newUserAdd">Add a new user:</label>
                                                <button class="btn btn-flat btn-secondary" id="newUserAdd" name="newUserAdd">Register</button>
                                            </div>
                                    </div>     
                                </div>
                                <div class="form-row align-items-center">
                                    <div class="col-sm-1 my-1">
                                    <p>Email: </p>
                                    </div>
                                    <div class="col-sm-3 my-1">
                                        <label class="sr-only" for="inlineFormInputName">Email</label>
                                        <input type="email" class="form-control" id="inlineFormInputName" placeholder="Jane Doe" value="<?php echo $userRow['userEmail']; ?>" disabled>
                                    </div>
                                </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                            <span>Password and Settings</span>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <form>
                                            <div class="form-group">
                                                <label for="resetcurrentpass">Change current password:</label>
                                                <button class="btn btn-flat btn-secondary" id="resetcurrentpass" name="resetcurrentpass" type="button">Change password</button>
                                            </div>
                                        </form>
                                        <form name="passSettings" id="passSettings" method="post" action="pass_new_request.php" onsubmit="return validatePassEntry()">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Current Password</label>
                                                <input type="password" class="form-control" id="currentpass" name="currentpass">
                                                <div class="text-danger"><span id="curError"></span></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">New Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="newpasschange" name="newpasschange">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i id="togglepass1" class="fa fa-eye-slash"></i></span>
                                                    </div>
                                                </div>
                                                <div class="text-danger"><span id="newcurError"></span></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Confirm New Password</label>
                                                <div class="input-group">
                                                <input type="password" class="form-control" id="newpasschangeconfirm" name="newpasschangeconfirm">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i id="togglepass2" class="fa fa-eye-slash"></i></span>
                                                    </div>
                                                    
                                                </div>
                                                <div class="text-danger"><span id="ncurConfirmError"></span></div>
                                            </div>
                                            <input type="submit" name="changePassbtn" id="changePassbtn" class="btn btn-light">
                                        </form>
                                    </div>
                                    
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <footer>
            <div class="footer-area">
                <p>© Copyright 2022. All right reserved.</p>
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <script type="text/javascript">
    function validatePassEntry(){
	var currentPass = document.forms["passSettings"]["currentpass"].value;
    var newcurPass = document.forms["passSettings"]["newpasschange"].value;
    var newcurPassConfirm = document.forms["passSettings"] ["newpasschangeconfirm"].value;      

	if (currentPass.length<1) {
        document.getElementById('curError').innerHTML = " Enter the current password";
        return false;
    }
    if (currentPass.length<5) {
        document.getElementById('curError').innerHTML = " Invalid password!";
        return false;
    }
    if (newcurPass.length<1) {
        document.getElementById('newcurError').innerHTML = " Enter new password";
        return false;
    }
    if (newcurPass.length<5) {
        document.getElementById('newcurError').innerHTML = " New password should be more than 5 characters";
        return false;
    }
    if (newcurPassConfirm.length<1) {
        document.getElementById('ncurConfirmError').innerHTML = " Confirm new password";
        return false;
    }
    if (newcurPassConfirm.length<5){
        document.getElementById('ncurConfirmError').innerHTML = " Invalid confirmation!";
        return false;
    }
    if (newcurPass != newcurPassConfirm){
        document.getElementById('ncurConfirmError').innerHTML = " Passwords don't match!";
        return false;
    }

    }
    </script>
    <!-- maps Resources -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbeBYsZSDkbIyfUkoIw1Rt38eRQOQQU0o"></script>
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script type="text/javascript">
       $(document).ready(function() {
            $("#passSettings").hide();
            $("#curError").html("");
            $("#newcurError").html("");
            $("#ncurConfirmError").html("");
        });
       $('#resetcurrentpass').on('click', function(e){
            $("#passSettings").toggle();
            $("#currentpass").val("");
            $("#curError").html("");
            $("#newcurError").html("");
            $("#ncurConfirmError").html("");
        });
        $('#newUserAdd').on('click', function(){
            window.open('add-userV2.php','_blank');
        });
        const togglePassword = document.querySelector("#togglepass1");
        const togglePassword_con = document.querySelector("#togglepass2");
        const password = document.querySelector("#newpasschange");
        const password_con = document.querySelector("#newpasschangeconfirm");

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            
            // toggle the icon
            this.classList.toggle("ti-eye");
        });
        togglePassword_con.addEventListener("click", function () {
            // toggle the type attribute
            const type = password_con.getAttribute("type") === "password" ? "text" : "password";
            password_con.setAttribute("type", type);
            
            // toggle the icon
            this.classList.toggle("ti-eye");
        });  
    </script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <!-- start amchart js -->
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/pie.js"></script>
    <script src="https://www.amcharts.com/lib/3/ammap.js"></script>
    <script src="https://www.amcharts.com/lib/3/ammap_amcharts_extension.js"></script>
    <script src="https://www.amcharts.com/lib/3/maps/js/worldLow.js"></script>
    <script src="https://www.amcharts.com/lib/3/maps/js/continentsLow.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <!-- maps js -->
    <script src="assets/js/maps.js"></script>
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>
<?php ob_end_flush(); ?>
