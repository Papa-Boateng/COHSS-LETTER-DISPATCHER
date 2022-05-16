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
    if (isset($_SESSION['posted']) && $_SESSION['posted']) {
        unset($_SESSION['posted']);
    
        $errTyp = "success";
        $errTitle = "Completed";
        $errMsg = "Your Letter has been successfully received";
        $errMsgIcon = "<i class=\"fa fa-check\"></i>";

    }
    if (isset($_SESSION['errorAlert']) && $_SESSION['errorAlert']) {
        unset($_SESSION['errorAlert']);
    
        $errTyp = "danger";
        $errTitle = "Error";
        $errMsg = "Invalid characters included";
        $errMsgIcon = "<i class=\"ti-na\"></i>";

    }
     

?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>COHSS DISPATCHER PROGRAM - Input letter</title>
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
                            <li class="active"><a href="input-letter.php"><i class="ti-import"></i> <span>Input Letter</span></a></li>
                            <li><a href="dispatch-letters.php"><i class="ti-truck"></i> <span>Dispatch Letters</span></a></li>
                            <li><a href="user-settings.php"><i class="ti-settings"></i> <span>Settings</span></a></li>
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
                                <li><span>Input Letter</span></li>
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
                            <div class="card-body">
                                <h3 class="header-title">Input Letters <i class="fa fa-pencil"></i></h3>
                                <p class="text-muted font-14 mb-4">All incoming Letters go here:</p>
                                <hr>
                                <form name="input-letter" method="post" action="process.php" id="input-letter" onsubmit="return validateForm()" autocomplete="off">
                                <?php
                                    if (isset($errMsg)){

                                ?>
				                    <div class="alert-dismiss" id="successAlert">
                                        <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?> alert-dismissible fade show" role="alert">
                                        <strong><?php echo $errTitle?>!</strong> <?php echo $errMsg; ?> <?php echo $errMsgIcon; ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="fa fa-times"></span>
                                        </button>
                                        </div>
                                    </div>
                                <?php
                                    }
                                ?>
                                
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="example-date-input" class="col-form-label">Date Letter was Received</label>
                                            <input class="form-control" type="date" value="" id="DateLetter" name="DateLetter">
                                            <div class="text-danger"><span id="dtReceivedError"></span></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="example-date-input" class="col-form-label">Date on Letter</label>
                                            <input class="form-control" type="date" value="" id="DateOnLetter" name="DateOnLetter">
                                            <div class="text-danger"><span id="dtLetterError"></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Letter Subject</label>
                                            <input class="form-control" type="text" id="LetterSubject" name ="Lsubject">
                                            <div class="text-danger"><span id="subjectError"></span></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label for="example-date-input" class="col-form-label">Registry Number</label>
                                            <input class="form-control" type="number" id="RegNumber" name="RegistryNumber">
                                            <div class="text-danger"><span id="registryError"></span></div>
                                        </div> 
                                    </div>
                                    
                                    <div class="col-xl-4">    
                                            <label class="col-form-label" for="remarks">Remarks</label>
                                                <div class="input-group">
                                                 <select class="custom-select" name="remarks" id="selecRemark">
                                                    <option selected="selected">Select the following:</option>
                                                    <option value="Provost">Provost</option>
                                                    <option value="Registrar">Registrar</option>
                                                    <option value="Provost/Registrar">Provost / Registrar</option>
                                                    <option disabled role=separator> ───────────────</option>
                                                 </select>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-rounded btn-secondary btn-sm mb-3" id="remarkSelection" name="remarkSelection">Add</button>
                                                    </div>
                                                </div>
                                                <div class="input-group" id="newRemarks">
                                                    <input class="form-control form-control-sm input-rounded col-sm-6" type="text" id="newremarkcache" name="newremarkcache" placeholder="Add new remarks" maxlength="25">
                                                    <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary btn-xs" type="button" onclick="submitnewRemark()"><i class="fa fa-level-up"></i></button>
                                                    </div>
                                                    <span style="padding-left: 10px;" id="casheError"></span>
                                                </div>
                                                
                                              
                                    </div> 
                                    
                                  
                                    
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4" name="btn-input">Submit</button> 
                                    </div>
                                </div>
                                </form>
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
    function validateForm(){
	var LetterSub = document.forms["input-letter"]["LetterSubject"].value;
    var RegistryNum = document.forms["input-letter"]["RegNumber"].value;
    var dateOfLetter = document.forms["input-letter"] ["DateLetter"].value;
    var dateOnLetter = document.forms["input-letter"] ["DateOnLetter"].value;      

	if (LetterSub.length<1) {
        document.getElementById('subjectError').innerHTML = " Please enter a Subject";
        return false;
    }
    if (LetterSub.length<5) {
        document.getElementById('subjectError').innerHTML = " Subject must be more than 5 characters";
        return false;
    }
    if (RegistryNum.length<1) {
        document.getElementById('registryError').innerHTML = " Please enter the registry number";
        return false;
    }
    if (RegistryNum.length<5) {
        document.getElementById('registryError').innerHTML = " Registry number must be more than 5 characters";
        return false;
    }
    if (dateOfLetter.length<1) {
        document.getElementById('dtReceivedError').innerHTML = " Select a valid date for letter received";
        return false;
    }
    if (dateOnLetter.length<1){
        document.getElementById('dtLetterError').innerHTML = " Select a valid date on the letter";
        return false;
    }

    }
    function submitnewRemark() {
        var remarkTeshcache = document.getElementById('newremarkcache').value;
        if (remarkTeshcache.length<1) {
            document.getElementById('casheError').setAttribute('class', "text-danger");
            document.getElementById('casheError').innerHTML = "Please enter a remark";
            return false;
            
        }
        if (remarkTeshcache.length<4){
            document.getElementById('casheError').setAttribute('class', "text-danger");
            document.getElementById('casheError').innerHTML = "Invalid remark";
            return false;
            } 
        else {
            var remarkselect = document.getElementById('selecRemark');
            var remarkoption = document.createElement('option');
            var newRemarks = document.getElementById('newremarkcache').value;
            remarkoption.appendChild(document.createTextNode(newRemarks));
            remarkoption.value = newRemarks;
            remarkselect.appendChild(remarkoption);
            document.getElementById('newremarkcache').value = "";
            document.getElementById('casheError').setAttribute('class', "text-success"); 
            document.getElementById('casheError').innerHTML = "New Remark " + "\"" +newRemarks + "\""+ " added!";
        
        }
        }
    </script>
    <!-- maps Resources -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbeBYsZSDkbIyfUkoIw1Rt38eRQOQQU0o"></script>
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script type="text/javascript">
       $(document).ready(function() {
            $("#newRemarks").hide();
            $("#casheError").html("");
            $("#newremarkcache").val("");
        });
        $('#remarkSelection').on('click', function(e){

          $("#newRemarks").toggle();
          $("#newremarkcache").val("");
          $("#casheError").html("");
        //  $(this).toggleClass('class1')
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
