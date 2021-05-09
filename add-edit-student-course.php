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
    $student_profile_arr = getStudentProfile();

    //PARAMETER
    $id = !empty($_GET['id'])?($_GET['id']):"";
    $student_id = !empty($_POST['student_id'])?validate($_POST['student_id']):"";
    $coursename = !empty($_POST['coursename'])?validate($_POST['coursename']):"";
    $intakedate = !empty($_POST['intakedate'])?validate($_POST['intakedate']):"";
    $status = !empty($_POST['status'])?validate($_POST['status']):"";
    $submit = !empty($_POST['submit'])?validate($_POST['submit']):""; 
    $error = "";

    //WHEN SUBMIT
    if(!empty($submit)){
        if($submit == "Add Student Course"){
            if(empty($student_id)){
                $error = "Student is required";
            }else if(empty($coursename)){
                $error = "Course name is required";
            }else if(!empty($coursename)&&invalidCoursename($coursename)){
                $error = "Course Name should only contain Uppercase and lowercase letters. e.g. Degree In Information Technology";
            }else if(empty($intakedate)){
                $error = "Intake Date is required";
            }else if(empty($status)){
                $error = "Status is required";
            }else{
                $stmt1 = $conn->prepare("INSERT INTO student_course (profile_id, course_name, intake_date, status) VALUES (?, ?, ?, ?)");
                $stmt1->bind_param("ssss", $student_id,$coursename,$intakedate,$status);
                $stmt1->execute();
                $stmt1->close();

                echo "<script>
                    alert('Successfully Add Student Course');
                    window.location.replace('course.php');
                </script>";
                exit();
            }
        }

        if($submit == "Edit Student Course"){
            if(empty($coursename)){
                $error = "Course name is required";
            }else if(!empty($coursename)&&invalidCoursename($coursename)){
                $error = "Course Name should only contain Uppercase and lowercase letters. e.g. Degree In Information Technology";
            }else if(empty($intakedate)){
                $error = "Intake Date is required";
            }else if(empty($status)){
                $error = "Status is required";
            }else{
                //UPDATE STUDENT
                $stmt = $conn->prepare("UPDATE student_course SET course_name= ?, intake_date = ?, status = ? WHERE id = ?");
                $stmt->bind_param("sssi", $coursename,$intakedate,$status,$id);
                $stmt->execute();
                $stmt->close();

                echo "<script>
                    alert('Successfully Edit Student Course');
                    window.location.replace('course.php');
                </script>";
                exit();
            }
        }
    }

    if(!empty($id))
    {
        $stmt = $conn->prepare("SELECT * FROM student_course WHERE id = ?");
        $stmt -> bind_param("s",$id);
        $stmt -> execute();
        $result = $stmt->get_result();
        $stmt->close();

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $student_id = $row['profile_id'];
            $coursename = $row['course_name'];
            $intakedate = $row['intake_date'];
            $status = $row['status'];
        }else{
            echo "<script>
                alert('Student Course Not Found');
                window.location.replace('course.php');
            </script>";
            exit();
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Blank</title>

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
                    <h1 class="h3 mb-4 text-gray-800"><?php echo (empty($id)?"Add Student Course":"Edit Student Course"); ?></h1>
                    
                    <form method="POST">
                        <div class="form-group">
                            <?php if(!empty($error)){ ?>
                                <p class="errormsg"><?php echo $error; ?></p> 
                            <?php } ?>
                        </div>
                        <div class="form-group">
                        <label for="student_id" style="padding-left:5px;">Student</label>
                        <select class="browser-default custom-select" name="student_id" required <?php echo (!empty($id)?"disabled":""); ?>>
                            <option value="">Select one option</option>
                            <?php
                                if(!empty($student_profile_arr)){
                                    foreach($student_profile_arr as $key => $value){
                                        echo "<option value='".$value['id']."'".($student_id == $value['id']?'selected':'').">".$value['name']."</option>";
                                    }
                                }
                            ?>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="coursename" style="padding-left:5px;">Course Name</label>
                            <input type="text" class="form-control form-control-user" id="coursename" name="coursename" value="<?php echo $coursename; ?>"
                                placeholder="Course Name" pattern="[A-Za-z ]+" title="Course Name should only contain Uppercase and lowercase letters. e.g. Degree In Information Technology" required>
                        </div>
                        <div class="form-group">
                            <label for="intakedate" style="padding-left:5px;">Intake Date</label>
                            <input type="date" class="form-control form-control-user" id="intakedate" name="intakedate" value="<?php echo $intakedate; ?>" required>
                        </div>
                        <div class="form-group">
                        <label for="status" style="padding-left:5px;">Status</label>
                        <select class="browser-default custom-select" name="status" required>
                            <option value="">Select one option</option>
                            <option value="Active" <?php echo ($status == "Active") ? "selected" : "" ; ?> >Active</option>
                            <option value="Graduated" <?php echo ($status == "Graduated") ? "selected" : "" ; ?> >Graduated</option>
                            <option value="Withdrawn" <?php echo ($status == "Withdrawn") ? "selected" : "" ; ?> >Withdrawn</option>
                        </select>
                        </div>
                        <input type="submit" name="submit" value="<?php echo (empty($id)?"Add Student Course":"Edit Student Course"); ?>" class="btn btn-primary btn-user btn-block">
                    </form>

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
    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if ((charCode < 48 || charCode > 57))
                return false;

            return true;
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