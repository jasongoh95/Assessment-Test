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

    //PARAMETER
    $id = !empty($_GET['id'])?($_GET['id']):"";
    $fullname = !empty($_POST['fullname'])?validate($_POST['fullname']):"";
    $dob = !empty($_POST['dob'])?validate($_POST['dob']):"";
    $nationality = !empty($_POST['nationality'])?validate($_POST['nationality']):"";
    $phone = !empty($_POST['phone'])?validate($_POST['phone']):"";
    $username = !empty($_POST['username'])?validate($_POST['username']):"";
    $password = !empty($_POST['password'])?validate($_POST['password']):"";
    $submit = !empty($_POST['submit'])?validate($_POST['submit']):""; 
    $error = "";
    $role = "STUDENT";
    $continue = true;

    //WHEN SUBMIT
    if(!empty($submit)){
        if($submit == "Add Student"){
            if(empty($fullname)){
                $error = "Full name is required";
            }else if(!empty($fullname)&&invalidFullname($fullname)){
                $error = "Fullname should only contain Uppercase and lowercase letters. e.g. Jason Goh";
            }else if(empty($dob)){
                $error = "Date of Birth is required";
            }else if(empty($nationality)){
                $error = "Nationality is required";
            }else if(!empty($nationality)&&invalidNationality($nationality)){
                $error = "Nationality should only contain Uppercase and lowercase letters. e.g. Malaysian";
            }else if(empty($phone)){
                $error = "Phone is required";
            }else if(empty($username)){
                $error = "Username is required";
            }else if(!empty($username)&&invalidUsername($username)){
                $error = "Username should only contain Uppercase, lowercase letters and number. e.g. Jason95";
            }else if(empty($password)){
                $error = "Password is required";
            }else{
                //MD5 PASSWORD
                $password = md5($password);
    
                //CHECKING DUPLICATE USERNAME
                $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
                $stmt -> bind_param("s",$username);
                $stmt -> execute();
                $result = $stmt->get_result();
                $stmt->close();
    
                if($result->num_rows === 1){
                    $continue = false;
                    $error = "Username is already register in our system";
                }
    
                if($continue){
                    try {
                        $conn->autocommit(FALSE); //turn on transactions
                        $stmt1 = $conn->prepare("INSERT INTO login (username, password, role) VALUES (?, ?, ?)");
                        $stmt1->bind_param("sss", $username,$password,$role);
                        $stmt1->execute();
                        $login_id = $conn->insert_id;
                        $stmt1->close();

                        $stmt2 = $conn->prepare("INSERT INTO student_profile (login_id, name, dob, nationality, phone) VALUES (?, ?, ?, ?, ?)");
                        $stmt2->bind_param("sssss", $login_id,$fullname,$dob,$nationality,$phone);
                        $stmt2->execute();
                        $stmt2->close();
                        $conn->autocommit(TRUE); //turn off transactions + commit queued queries
                    } catch(Exception $e) {
                        $conn->rollback(); //remove all queries from queue if error (undo)
                        throw $e;
                    }
    
                    echo "<script>
                        alert('Successfully Add Student');
                        window.location.replace('student.php');
                    </script>";
                    exit();
                }
    
            }
        }

        if($submit == "Edit Student"){
            if(empty($fullname)){
                $error = "Full name is required";
            }else if(!empty($fullname)&&invalidFullname($fullname)){
                $error = "Fullname should only contain Uppercase and lowercase letters. e.g. Jason Goh";
            }else if(empty($dob)){
                $error = "Date of Birth is required";
            }else if(empty($nationality)){
                $error = "Nationality is required";
            }else if(!empty($nationality)&&invalidNationality($nationality)){
                $error = "Nationality should only contain Uppercase and lowercase letters. e.g. Malaysian";
            }else if(empty($phone)){
                $error = "Phone is required";
            }else{
                //UPDATE STUDENT
                $stmt = $conn->prepare("UPDATE student_profile SET name = ?, dob= ?, nationality = ?, phone = ? WHERE id = ?");
                $stmt->bind_param("ssssi", $fullname,$dob,$nationality,$phone,$id);
                $stmt->execute();
                $stmt->close();

                echo "<script>
                    alert('Successfully Edit Student');
                    window.location.replace('student.php');
                </script>";
                exit();
            }
        }
    }

    if(!empty($id))
    {
        $stmt = $conn->prepare("SELECT * FROM student_profile WHERE id = ?");
        $stmt -> bind_param("s",$id);
        $stmt -> execute();
        $result = $stmt->get_result();
        $stmt->close();
        
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $fullname = $row['name'];
            $dob = $row['dob'];
            $nationality = $row['nationality'];
            $phone = $row['phone'];
        }else{
            echo "<script>
                alert('Student Not Found');
                window.location.replace('student.php');
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
                    <h1 class="h3 mb-4 text-gray-800"><?php echo (empty($id)?"Add Student":"Edit Student"); ?></h1>
                    
                    <form class="user" method="POST">
                        <div class="form-group">
                            <?php if(!empty($error)){ ?>
                                <p class="errormsg"><?php echo $error; ?></p> 
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="fullname" name="fullname" value="<?php echo $fullname; ?>"
                                placeholder="Full Name" pattern="[A-Za-z ]+" title="Fullname should only contain Uppercase and lowercase letters. e.g. Jason Goh" required>
                        </div>
                        <div class="form-group">
                            <label for="birthday" style="padding-left:5px;">Date of birth</label>
                            <input type="date" class="form-control form-control-user" id="dob" name="dob" value="<?php echo $dob; ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="nationality" name="nationality" value="<?php echo $nationality; ?>"
                                placeholder="Nationality" pattern="[A-Za-z ]+" title="Nationality should only contain Uppercase and lowercase letters. e.g. Malaysian" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="phone" name="phone" value="<?php echo $phone; ?>"
                                placeholder="Phone Number" maxlength="20" onkeypress="return isNumberKey(event)" required>
                        </div>
                        <?php if(empty($id)){ ?>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="username" name="username" 
                                placeholder="Username" pattern="[A-Za-z0-9]+" title="Username should only contain Uppercase, lowercase letters and number. e.g. Jason95" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="password" name="password" 
                                placeholder="Password" required>
                        </div>
                        <?php } ?>
                        <input type="submit" name="submit" value="<?php echo (empty($id)?"Add Student":"Edit Student"); ?>" class="btn btn-primary btn-user btn-block">
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