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
    $student_course_semester_arr = getStudentCourseSemester();

    //PARAMETER
    $id = !empty($_GET['id'])?($_GET['id']):"";
    $semester_id = !empty($_POST['semester_id'])?validate($_POST['semester_id']):"";
    $subject = !empty($_POST['subject'])?validate($_POST['subject']):"";
    $status = !empty($_POST['status'])?validate($_POST['status']):"";
    $grade = !empty($_POST['grade'])?validate($_POST['grade']):"";
    $submit = !empty($_POST['submit'])?validate($_POST['submit']):""; 
    $error = "";

    //WHEN SUBMIT
    if(!empty($submit)){
        if($submit == "Add Student Course Semester Subject"){
            if(empty($semester_id)){
                $error = "Course - Student - Semester - Term is required";
            }else if(empty($subject)){
                $error = "Subject is required";
            }else if(empty($status)){
                $error = "Subject Status is required";
            }else if(empty($grade)){
                $error = "Grade is required";
            }else{
                $stmt1 = $conn->prepare("INSERT INTO student_course_semester_subject (semester_id, subject, status, grade) VALUES (?, ?, ?, ?)");
                $stmt1->bind_param("ssss", $semester_id,$subject,$status,$grade);
                $stmt1->execute();
                $stmt1->close();

                echo "<script>
                    alert('Successfully Add Student Course Semester Subject');
                    window.location.replace('subject.php');
                </script>";
                exit();
            }
        }

        if($submit == "Edit Student Course Semester Subject"){
            if(empty($subject)){
                $error = "Subject is required";
            }else if(empty($status)){
                $error = "Subject Status is required";
            }else if(empty($grade)){
                $error = "Grade is required";
            }else{
                //UPDATE STUDENT COURSE SEMESTER
                $stmt = $conn->prepare("UPDATE student_course_semester_subject SET subject= ?, status = ?, grade = ? WHERE id = ?");
                $stmt->bind_param("sssi", $subject,$status,$grade,$id);
                $stmt->execute();
                $stmt->close();

                echo "<script>
                    alert('Successfully Edit Student Course Semester Subject');
                    window.location.replace('subject.php');
                </script>";
                exit();
            }
        }
    }

    if(!empty($id))
    {
        $stmt = $conn->prepare("SELECT * FROM student_course_semester_subject WHERE id = ?");
        $stmt -> bind_param("s",$id);
        $stmt -> execute();
        $result = $stmt->get_result();
        $stmt->close();

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $semester_id = $row['semester_id'];
            $subject = $row['subject'];
            $status = $row['status'];
            $grade = $row['grade'];
        }else{
            echo "<script>
                alert('Student Course Semester Subject Not Found');
                window.location.replace('subject.php');
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
                    <h1 class="h3 mb-4 text-gray-800"><?php echo (empty($id)?"Add Student Course Semester Subject":"Edit Student Course Semester Subject"); ?></h1>
                    
                    <form class="user" method="POST">
                        <div class="form-group">
                            <?php if(!empty($error)){ ?>
                                <p class="errormsg"><?php echo $error; ?></p> 
                            <?php } ?>
                        </div>
                        <div class="form-group">
                        <label for="semester_id" style="padding-left:5px;">Course - Student - Semester - Term</label>
                        <select class="browser-default custom-select" name="semester_id" required <?php echo (!empty($id)?"disabled":""); ?>>
                            <option value="">Select one option</option>
                            <?php
                                if(!empty($student_course_semester_arr)){
                                    foreach($student_course_semester_arr as $key => $value){
                                        echo "<option value='".$value['id']."'".($semester_id == $value['id']?'selected':'').">".$value['course_name']." - ".ucwords(strtolower($value['name']))." - ".ucwords(strtolower($value['semester']))." - ".ucwords(strtolower($value['term']))."</option>";
                                    }
                                }
                            ?>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="subject" style="padding-left:5px;">Subject</label>
                        <select class="browser-default custom-select" name="subject" required>
                            <option value="">Select one option</option>
                            <option value="module-a" <?php echo ($subject == "module-a") ? "selected" : "" ; ?> >module-a</option>
                            <option value="module-b" <?php echo ($subject == "module-b") ? "selected" : "" ; ?> >module-b</option>
                            <option value="module-c" <?php echo ($subject == "module-c") ? "selected" : "" ; ?> >module-c</option>
                            <option value="module-d" <?php echo ($subject == "module-d") ? "selected" : "" ; ?> >module-d</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="status" style="padding-left:5px;">Subject Status</label>
                        <select class="browser-default custom-select" name="status" required>
                            <option value="">Select one option</option>
                            <option value="Taken" <?php echo ($status == "Taken") ? "selected" : "" ; ?> >Taken</option>
                            <option value="Drop" <?php echo ($status == "Drop") ? "selected" : "" ; ?> >Drop</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="grade" style="padding-left:5px;">Grade</label>
                        <select class="browser-default custom-select" name="grade" required>
                            <option value="">Select one option</option>
                            <option value="A" <?php echo ($grade == "A") ? "selected" : "" ; ?> >A</option>
                            <option value="B" <?php echo ($grade == "B") ? "selected" : "" ; ?> >B</option>
                            <option value="C" <?php echo ($grade == "C") ? "selected" : "" ; ?> >C</option>
                            <option value="F" <?php echo ($grade == "F") ? "selected" : "" ; ?> >F</option>
                        </select>
                        </div>
                        <input type="submit" name="submit" value="<?php echo (empty($id)?"Add Student Course Semester Subject":"Edit Student Course Semester Subject"); ?>" class="btn btn-primary btn-user btn-block">
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