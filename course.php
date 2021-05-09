<?php  
session_start();
include "base.php";

//CHECKING LOGIN
if(isset($_SESSION['id']) && isset($_SESSION['username'])){

    //CHECKING ROLE
    if(isset($_SESSION['role']) && $_SESSION['role'] != "ADMIN"){
        header("Location: home.php");
        exit();
    }

    //GET STUDENT COURSE INFORMATION
    $student_course_arr = getStudentCourse();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Management System - Student Course</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">

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
                        <h1 class="h3 mb-0 text-gray-800">Course</h1>
                        <a href="add-edit-student-course.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-plus fa-sm text-white-50"></i> Add Student Course</a>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Course Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Course Name</th>
                                            <th>Intake Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Course Name</th>
                                            <th>Intake Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                            if(!empty($student_course_arr)){
                                                foreach ($student_course_arr as $key => $value) {
                                                    echo "
                                                    <tr>
                                                        <td>".($key+1)."</td>
                                                        <td>".$value['name']."</td>
                                                        <td>".$value['course_name']."</td>
                                                        <td>".$value['intake_date']."</td>
                                                        <td>".$value['status']."</td>
                                                        <td><a href='add-edit-student-course.php?id=".$value['id']."' class='btn btn-success btn-icon-split'>
                                                                <span class='icon text-white-50'>
                                                                    <i class='fas fa-flag'></i>
                                                                </span>
                                                                <span class='text'>Edit</span>
                                                            </a>
                                                            <a href='#' onclick='deletestudentcourse(".$value['id'].")' class='btn btn-danger btn-icon-split'>
                                                                <span class='icon text-white-50'>
                                                                    <i class='fas fa-flag'></i>
                                                                </span>
                                                                <span class='text'>Delete</span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    ";
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
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
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if ((charCode < 48 || charCode > 57))
                return false;

            return true;
        }
        
        function deletestudentcourse(id){
            var x = confirm("<?php echo _("Are you sure want to delete this student course?"); ?>");
            if(x) {
                $.ajax({
                    type: "POST",
                    url: 'ajax/student.php',
                    data: "action=deletestudentcourse&data="+id,
                    success: function (data) {
                            alert(data);
                            window.location='course.php';
                    }
                });
                
                return true;
            }
            else{
                return false;
            }
        }
    </script>
</body>

</html>

<?php
}else{
    header("Location: index.php");
    exit();
}
?>