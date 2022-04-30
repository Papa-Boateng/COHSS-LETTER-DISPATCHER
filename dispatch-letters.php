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

    //Alert Halder
    if (isset($_SESSION['deleted']) && $_SESSION['deleted']) {
        unset($_SESSION['deleted']);
    
        $msgTyp = "info";
        $msgBod = "Letter deleted successfully"; 
    }
    if (isset($_SESSION['dispatched']) && $_SESSION['dispatched']) {
        unset($_SESSION['dispatched']);
    
        $msgTyp = "success";
        $msgBod = "Letter has been successfully dispatched";
    }
    if (isset($_SESSION['notDispatch']) && $_SESSION['notDispatch']) {
        unset($_SESSION['notDispatch']);
    
        $msgTyp = "danger";
        $msgBod = "Letter Could not dispatch";
    }
    if (isset($_SESSION['fatalerror']) && $_SESSION['fatalerror']) {
        unset($_SESSION['fatalerror']);
    
        $msgTyp = "danger";
        $msgBod = "Could not establish database process";
    }
    
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>COHSS DISPATCHER PROGRAM - Dispatch letters</title>
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
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
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
                            <li class="active"><a href="dispatch-letters.php"><i class="ti-truck"></i> <span>Dispatch Letters</span></a></li>
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
                                <li><span>Dispatch Letters</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="assets/images/author/avatar.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?php echo $userRow['userName']; ?> <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Settings</a>
                                <a class="dropdown-item" href="logout.php?logout">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                            <?php
                                    if (isset($msgBod)){

                                ?>
				                    <div class="alert-dismiss" id="successAlert">
                                        <div class="alert alert-<?php echo ($msgTyp=="success") ? "success" : $msgTyp; ?> alert-dismissible fade show" role="alert">
                                        <strong>Completed!</strong> <?php echo $msgBod; ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="fa fa-times"></span>
                                        </button>
                                        </div>
                                    </div>
                                <?php
                                    }
                                ?>
                                <h4 class="header-title">Received Letters</h4>
                                <div class="modal fade" id="ModalMessageDelete">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Delete</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p> Are you sure you want to delete this Letter?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                <button type="button" class="btn btn-primary delConfirm">Yes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="ModalConfirmDispatch">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Dispatch</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <form action="dispatch_process.php" method="post" id="confirmDispatchForm" name="confirmDispatchForm" onsubmit="return javLiveform()" autocomplete="off">
                                            <div class="modal-body">
                                                <p> Enter the <strong>Recipient</strong> of the Dispatched Letter.
                                                </p>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                    <label for="example-text-input" class="col-form-label" style="font-size: 8pt;">Recipient</label>
                                                    <input class="form-control" type="text" placeholder="Carlos Rath" id="reciptA" name="reciptA">
                                                    <div class="text-danger"><span id="ReciptEA"></span></div>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <label for="example-text-input" class="col-form-label" style="font-size: 8pt;">Confirm recipient</label>
                                                    <input class="form-control" type="text" placeholder="Carlos Rath" id="reciptAconfirm" name="reciptAconfirm">
                                                    <div class="text-danger"><span id="ReciptEB"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary dispatchConfirm">Confirm</button>
                                            </div>
                                            <input type="hidden" id="dispatchId" name="dispatchId">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <?php
                                        $letterReceived = mysqli_query($conn, "SELECT * FROM Received_letter");
                                        $letterResults = mysqli_num_rows ($letterReceived);
                                        ?>
                                        <table class="table text-center">
                                            <thead class="text-uppercase bg-primary">
                                                <tr class="text-white">
                                                    <th scope="col">Registry Number</th>
                                                    <th scope="col">Date Received</th>
                                                    <th scope="col">Subject</th>
                                                    <th scope="col">Date on Letter</th>
                                                    <th scope="col" colspan="2">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                               if( $letterResults ==0 ){
                                                echo '<tr><th>No Rows Returned</th></tr>';
                                                }else{
                                                while( $dataRow = mysqli_fetch_assoc($letterReceived)){
                                                  echo "<tr><th scope=\"row\">{$dataRow['RegistryNumber']}</th><td>{$dataRow['DateOFLetter']}</td><td>{$dataRow['Lsub']}</td><td>{$dataRow['LetterDate']}</td><td><a id=\"{$dataRow['LetterID']}\" class=\"delBtn\" data-toggle=\"modal\" data-target=\"#ModalMessageDelete\"><i class=\"ti-trash\"></i></a></td><td><button id=\"{$dataRow['LetterID']}\" class=\"btn btn-rounded btn-primary dispatch\" data-toggle=\"modal\" data-target=\"#ModalConfirmDispatch\"><i class=\"ti-truck\"></i> Dispatch</button></td>
                                                  </tr>\n";
                                                }
                                              }
                                            ?>
                                            </tbody>
                                           </table>
                                    </div>
                                </div>
                                <form action="deleteDat.php" method="post" name="deleteData" id="deleteData"> 
                                    <input type="hidden" id="dataId" name="dataId">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Dispatched Letters</h4>
                                <div class="data-tables datatable-dark">
                                <?php
                                        $letterDispatched = mysqli_query($conn, "SELECT * FROM Dispatched_letters");
                                        $letterDisRes = mysqli_num_rows ($letterDispatched);
                                        ?>
                                    <table id="dataTable3" class="text-center">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th>Date of received</th>
                                                <th>Registry Number</th>
                                                <th>To whom received</th>
                                                <th>Date of letter</th>
                                                <th>Subject</th>
                                                <th>Remarks:</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                               if( $letterDisRes ==0 ){
                                                echo '<tr><th>No Rows Returned</th></tr>';
                                                }else{
                                                while( $dataDispatchRow = mysqli_fetch_assoc($letterDispatched)){
                                                  echo "<tr><td>{$dataDispatchRow['DateOfReceived']}</td><td>{$dataDispatchRow['RegistryNum']}</td><td>{$dataDispatchRow['RecipientOfLetter']}</td><td>{$dataDispatchRow['DateOnLetter']}</td><td>{$dataDispatchRow['LetterSubject']}</td><td>{$dataDispatchRow['RemarksSig']}</td>
                                                  </tr>\n";
                                                }
                                              }
                                            ?>
                                        </tbody>
                                    </table>
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
    
    
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/additional-methods.min.js"></script>
    <script type="text/javascript">
    function javLiveform() {
        var Recipt = document.forms["confirmDispatchForm"]["reciptA"].value; 
        var ReciptConfirm = document.forms["confirmDispatchForm"]["reciptAconfirm"].value;

        if (Recipt.length<1) {
        document.getElementById('ReciptEA').innerHTML = "Please enter a Recipient";
        return false;
        }
        if (Recipt.length<6) {
        document.getElementById('ReciptEA').innerHTML = "Please enter a valid recipient name";
        return false;
        }

        if (ReciptConfirm.length<1) {
        document.getElementById('ReciptEB').innerHTML = "Please confirm the Recipient";
        return false;
        }
        if (ReciptConfirm.length<6) {
        document.getElementById('ReciptEB').innerHTML = "Please enter a valid confirmation";
        return false;
        }

        if (Recipt != ReciptConfirm) {
        document.getElementById('ReciptEB').innerHTML = "Recipient name dont match";
        return false;
        }

    }
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
        
        $(document).on('click','.delBtn',function() {
            var id = this.id;
            $('#ModalMessageDelete .delConfirm').data('row-id', id); //set data id
            
       });

       $(document).on("click", '#ModalMessageDelete button.delConfirm', function(e) {
        e.preventDefault();
        var rowId = $(this).data('row-id');
        document.getElementById("dataId").setAttribute('value', rowId);
        $('#ModalMessageDelete').modal('toggle');
        $('form#deleteData').submit();
        
        
    });

    $(document).on('click','.dispatch',function() {
            var dispatchID = this.id;
            $('#ModalConfirmDispatch .dispatchConfirm').data('row-id', dispatchID); //set data id
            
       });

    $(document).on("click", '#ModalConfirmDispatch button.dispatchConfirm', function(e) {
        e.preventDefault();
        var dispatchrowId = $(this).data('row-id');
        alert (dispatchrowId);
        document.getElementById("dispatchId").setAttribute('value', dispatchrowId);
    //    $('#ModalMessageDelete').modal('toggle');
        $('form#confirmDispatchForm').submit();
        
    });


      });
    </script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    <!-- Start datatable js -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>
<?php ob_end_flush(); ?>