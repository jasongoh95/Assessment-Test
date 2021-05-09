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

    //PARAMETER
    $id = !empty($_GET['id'])?($_GET['id']):"";
    $semester = !empty($_POST['semester'])?validate($_POST['semester']):"";
    $course_id = !empty($_POST['course_id'])?validate($_POST['course_id']):"";
    $term = !empty($_POST['term'])?validate($_POST['term']):"";
    $status = !empty($_POST['status'])?validate($_POST['status']):"";
    $submit = !empty($_POST['submit'])?validate($_POST['submit']):""; 
    $error = "";

    //WHEN SUBMIT
    if(!empty($submit)){
        if($submit == "Add Student Course Semester"){
            if(empty($semester)){
                $error = "Semester is required";
            }else if(empty($course_id)){
                $error = "Course - Student is required";
            }else if(empty($term)){
                $error = "Term is required";
            }else if(empty($status)){
                $error = "Course Status is required";
            }else{
                $stmt1 = $conn->prepare("INSERT INTO student_course_semester (semester, course_id, term, status) VALUES (?, ?, ?, ?)");
                $stmt1->bind_param("ssss", $semester,$course_id,$term,$status);
                $stmt1->execute();
                $stmt1->close();

                echo "<script>
                    alert('Successfully Add Student Course Semester');
                    window.location.replace('semester.php');
                </script>";
                exit();
            }
        }

        if($submit == "Edit Student Course Semester"){
            if(empty($semester)){
                $error = "Semester is required";
            }else if(empty($term)){
                $error = "Term is required";
            }else if(empty($status)){
                $error = "Course Status is required";
            }else{
                //UPDATE STUDENT COURSE SEMESTER
                $stmt = $conn->prepare("UPDATE student_course_semester SET semester= ?, term = ?, status = ? WHERE id = ?");
                $stmt->bind_param("sssi", $semester,$term,$status,$id);
                $stmt->execute();
                $stmt->close();

                echo "<script>
                    alert('Successfully Edit Student Course Semester');
                    window.location.replace('semester.php');
                </script>";
                exit();
            }
        }
    }

    if(!empty($id))
    {
        $stmt = $conn->prepare("SELECT * FROM student_course_semester WHERE id = ?");
        $stmt -> bind_param("s",$id);
        $stmt -> execute();
        $result = $stmt->get_result();
        $stmt->close();

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $semester = $row['semester'];
            $course_id = $row['course_id'];
            $term = $row['term'];
            $status = $row['status'];
        }else{
            echo "<script>
                alert('Student Course Semester Not Found');
                window.location.replace('semester.php');
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
                    <h1 class="h3 mb-4 text-gray-800"><?php echo (empty($id)?"Add Student Course Semester":"Edit Student Course Semester"); ?></h1>
                    
                    <form class="user" method="POST">
                        <div class="form-group">
                            <?php if(!empty($error)){ ?>
                                <p class="errormsg"><?php echo $error; ?></p> 
                            <?php } ?>
                        </div>
                        <div class="form-group">
                        <label for="semester" style="padding-left:5px;">Semester</label>
                        <select class="browser-default custom-select" name="semester" required>
                            <option value="">Select one option</option>
                            <option value="semester-1" <?php echo ($semester == "semester-1") ? "selected" : "" ; ?> >semester-1</option>
                            <option value="semester-2" <?php echo ($semester == "semester-2") ? "selected" : "" ; ?> >semester-2</option>
                            <option value="semester-3" <?php echo ($semester == "semester-3") ? "selected" : "" ; ?> >semester-3</option>
                            <option value="semester-4" <?php echo ($semester == "semester-4") ? "selected" : "" ; ?> >semester-4</option>
                            <option value="semester-5" <?php echo ($semester == "semester-5") ? "selected" : "" ; ?> >semester-5</option>
                            <option value="semester-6" <?php echo ($semester == "semester-6") ? "selected" : "" ; ?> >semester-6</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="course_id" style="padding-left:5px;">Course - Student</label>
                        <select class="browser-default custom-select" name="course_id" required <?php echo (!empty($id)?"disabled":""); ?>>
                            <option value="">Select one option</option>
                            <?php
                                if(!empty($student_course_arr)){
                                    foreach($student_course_arr as $key => $value){
                                        echo "<option value='".$value['id']."'".($course_id == $value['id']?'selected':'').">".$value['course_name']." - ".ucwords(strtolower($value['name']))."</option>";
                                    }
                                }
                            ?>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="term" style="padding-left:5px;">Term</label>
                        <select class="browser-default custom-select" name="term" required>
                            <option value="">Select one option</option>
                            <option value="Jan-2020" <?php echo ($term == "Jan-2020") ? "selected" : "" ; ?> >Jan-2020</option>
                            <option value="Jul-2020" <?php echo ($term == "Jul-2020") ? "selected" : "" ; ?> >Jul-2020</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="status" style="padding-left:5px;">Course Status</label>
                        <select class="browser-default custom-select" name="status" required>
                            <option value="">Select one option</option>
                            <option value="Active" <?php echo ($status == "Active") ? "selected" : "" ; ?> >Active</option>
                            <option value="Defer" <?php echo ($status == "Defer") ? "selected" : "" ; ?> >Defer</option>
                        </select>
                        </div>
                        <input type="submit" name="submit" value="<?php echo (empty($id)?"Add Student Course Semester":"Edit Student Course Semester"); ?>" class="btn btn-primary btn-user btn-block">
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