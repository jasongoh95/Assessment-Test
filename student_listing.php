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

    //GET STUDENT INFORMATION
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

    <title>Management System - Student Listing</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Student Listing</h1>
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <form class="form-inline" method="POST">
                        <div class="form-group">
                        <label for="course_id" style="padding-left:5px;">Student &nbsp;</label>
                        <select class="browser-default custom-select" name="course_id" id="course_id" onchange="load_semester();">
                            <option value="">Select one option</option>
                            <?php
                                if(!empty($student_course_arr)){
                                    foreach($student_course_arr as $key => $value){
                                        echo "<option value='".$value['id']."'>".$value['course_name']." - ".ucwords(strtolower($value['name']))."</option>";
                                    }
                                }
                            ?>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="semester_id" style="padding-left:5px;">Semester &nbsp;</label>
                        <select class="browser-default custom-select" name="semester_id" id="semester_id" onchange="load_subject();">
                            <option value="">Select one option</option>
                        </select>
                        </div>
                    </form>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Student Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Course Name</th>
                                            <th>Semester</th>
                                            <th>Term</th>
                                            <th>Subject</th>
                                            <th>Status</th>
                                            <th>Grade</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Course Name</th>
                                            <th>Semester</th>
                                            <th>Term</th>
                                            <th>Subject</th>
                                            <th>Status</th>
                                            <th>Grade</th>
                                        </tr>
                                    </tfoot>
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
        
        function deletestudentprofile(id){
            var x = confirm("<?php echo _("Are you sure want to delete this student?"); ?>");
            if(x) {
                $.ajax({
                    type: "POST",
                    url: 'ajax/student.php',
                    data: "action=deletestudentprofile&data="+id,
                    success: function (data) {
                            alert(data);
                            window.location='student.php';
                    }
                });
                
                return true;
            }
            else{
                return false;
            }
        }

        function load_semester(){
            var course_id = $('select[name="course_id"]').val();

            $.ajax({
                type: "POST",
                url: 'ajax/student.php',
                data: "action=load_semester&data="+course_id,
                success: function (data) {
                     //EMPTY THE SEMESTER DROPDOWN BEFORE APPEND
                     $('#semester_id').empty().append('<option value="">Select one option</option>');

                    var obj = JSON.parse(data);
                    for (i in obj) {
                        $('#semester_id').append(new Option(obj[i].semester, obj[i].id));
                    }
                }
            });
        }

        function load_subject(){
            var semester_id = $('select[name="semester_id"]').val();

            $.ajax({
                type: "POST",
                url: 'ajax/student.php',
                data: "action=load_subject&data="+semester_id,
                success: function (data) {
                    //CLEAR THE DATATABLE VALUE BEFORE APPEND
                    $('#dataTable').dataTable().fnClearTable();

                    var obj = JSON.parse(data);
                    var x = 1;
                    for (i in obj) {
                        var data = [
                            x, obj[i].name, obj[i].course_name, obj[i].semester, obj[i].term, obj[i].subject, obj[i].status, obj[i].grade
                        ];
                        $('#dataTable').dataTable().fnAddData(data);
                        x++;
                    }
                }
            });
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