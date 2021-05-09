<?php  
session_start();
include "base.php";

//CHECKING LOGIN
if(isset($_SESSION['id']) && isset($_SESSION['username'])){

    //GET STUDENT INFORMATION
    $student_profile_arr = getStudentProfile();

    //GET STUDENT COURSE INFORMATION
    $student_course_arr = getStudentCourse();

    //GET STUDENT COURSE SEMESTER INFORMATION
    $student_course_semester_arr = getStudentCourseSemester();

    //GET STUDENT COURSE SEMESTER SUBJECT INFORMATION
    $student_course_semester_subject_arr = getStudentCourseSemesterSubject();

    //GET CURRENT STUDENT SEMESTER INFORMATION
    $current_student_semester_arr = getCurrentStudentSemester($_SESSION['id']);

    //GET CURRENT STUDENT SEMESTER SUBJECT INFORMATION
    $current_student_semester_subject_arr = getCurrentStudentSemesterSubject($_SESSION['id']);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Management System - Dashboard</title>

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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <?php if($_SESSION['role'] == "ADMIN"){ ?>
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Student Record (Total) Card Example -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Student Record (Total)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo !empty($student_profile_arr)?count($student_profile_arr):"0" ?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Course Record (Total) Card Example -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Course Record (Total)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo !empty($student_course_arr)?count($student_course_arr):"0" ?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Semester Record (Total) Card Example -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Semester Record (Total)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo !empty($student_course_semester_arr)?count($student_course_semester_arr):"0" ?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Subject Record (Total) Card Example -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Subject Record (Total)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo !empty($student_course_semester_subject_arr)?count($student_course_semester_subject_arr):"0" ?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } if($_SESSION['role'] == "STUDENT"){ ?>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Student Semester Record (Total) Card Example -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Semester Record (Total)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo !empty($current_student_semester_arr)?count($current_student_semester_arr):"0" ?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Course Record (Total) Card Example -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Subject Record (Total)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo !empty($current_student_semester_subject_arr)?count($current_student_semester_subject_arr):"0" ?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php } ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website <?php echo date('Y'); ?></span>
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

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>

<?php
}else{
    header("Location: index.php");
    exit();
}
?>