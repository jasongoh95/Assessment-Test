<?php  
session_start();
include "base.php";

//CHECKING LOGIN
if(isset($_SESSION['id']) && isset($_SESSION['username'])){

    //CHECKING ROLE
    if(isset($_SESSION['role']) && $_SESSION['role'] != "STUDENT"){
        header("Location: home.php");
        exit();
    }

    //GET CURRENT STUDENT PROFILE INFORMATION
    $current_student_profile_arr = getCurrentStudentProfile($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Buttons</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            include "sidebar.php";
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                    include "topbar.php";
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Profile</h1>

                    <div class="row">

                        <div class="col-lg-6">

                            <!-- Circle Buttons -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Personal Profile</h6>
                                </div>
                                <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-3">Full Name :</dt>
                                    <dd class="col-sm-9"><p><?php echo !empty($current_student_profile_arr[0]['name'])?$current_student_profile_arr[0]['name']:""; ?></p></dd>
                                    
                                    <dt class="col-sm-3">Date of birth :</dt>
                                    <dd class="col-sm-9">
                                        <p><?php echo !empty($current_student_profile_arr[0]['dob'])?$current_student_profile_arr[0]['dob']:""; ?></p>
                                    </dd>

                                    <dt class="col-sm-3">Nationality :</dt>
                                    <dd class="col-sm-9"><p><?php echo !empty($current_student_profile_arr[0]['nationality'])?ucwords(strtolower($current_student_profile_arr[0]['nationality'])):""; ?></p></dd>

                                    <dt class="col-sm-3 text-truncate">Phone :</dt>
                                    <dd class="col-sm-9"><p><?php echo !empty($current_student_profile_arr[0]['phone'])?$current_student_profile_arr[0]['phone']:""; ?></p></dd>
                                </dl>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

<?php
}else{
    header("Location: index.php");
    exit();
}
?>