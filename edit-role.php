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
    $login_arr = getLogin();

    //PARAMETER
    $id = !empty($_GET['id'])?($_GET['id']):"";
    $role = !empty($_POST['role'])?validate($_POST['role']):"";
    $submit = !empty($_POST['submit'])?validate($_POST['submit']):""; 
    $error = "";

    //WHEN SUBMIT
    if(!empty($submit)){
        if(empty($role)){
            $error = "Role is required";
        }else{
            //UPDATE STUDENT
            $stmt = $conn->prepare("UPDATE login SET role= ? WHERE id = ?");
            $stmt->bind_param("si", $role,$id);
            $stmt->execute();
            $stmt->close();

            echo "<script>
                alert('Successfully Edit Role');
                window.location.replace('role.php');
            </script>";
            exit();
        }
    }

    if(!empty($id))
    {
        $stmt = $conn->prepare("SELECT * FROM login WHERE id = ? limit 1");
        $stmt -> bind_param("s",$id);
        $stmt -> execute();
        $result = $stmt->get_result();
        $stmt->close();

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $username = $row['username'];
            $role = $row['role'];
        }else{
            echo "<script>
                alert('User Not Found');
                window.location.replace('role.php');
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
                    <h1 class="h3 mb-4 text-gray-800">Edit Role</h1>
                    
                    <form method="POST">
                        <div class="form-group">
                            <?php if(!empty($error)){ ?>
                                <p class="errormsg"><?php echo $error; ?></p> 
                            <?php } ?>
                        </div>
                        <div class="form-group">
                        <label for="login_id" style="padding-left:5px;">Username</label>
                        <select class="browser-default custom-select" name="login_id" <?php echo (!empty($id)?"disabled":""); ?> required>
                            <option value="">Select one option</option>
                            <?php
                                if(!empty($login_arr)){
                                    foreach($login_arr as $key => $value){
                                        echo "<option value='".$value['id']."'".($username == $value['username']?'selected':'').">".$value['username']."</option>";
                                    }
                                }
                            ?>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="role" style="padding-left:5px;">Role</label>
                        <select class="browser-default custom-select" name="role" id="role" required>
                            <option value="">Select one option</option>
                            <option value="ADMIN" <?php echo ($role == "ADMIN") ? "selected" : "" ; ?> >Admin</option>
                            <option value="STUDENT" <?php echo ($role == "STUDENT") ? "selected" : "" ; ?> >Student</option>
                        </select>
                        </div>
                        <input type="submit" name="submit" value="Edit Role" class="btn btn-primary btn-user btn-block">
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

</body>

</html>

<?php
}else{
    header("Location: index.php");
    exit();
}
?>