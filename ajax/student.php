<?php 
include "../base.php";

$action = $_POST['action'];
$id = $_POST['data'];

if($action == "deletestudentprofile"){
    //CHECKING STUDENT COURSE RECORD
    $stmt = $conn->prepare("SELECT * FROM student_course WHERE profile_id = ?");
    $stmt -> bind_param("i",$id);
    $stmt -> execute();
    $result = $stmt->get_result();
    $stmt->close();

    if($result->num_rows > 0){
        echo "Unable to delete the student, because the student is taking the course.";
    }else{
        //GETTING LOGIN ID
        $stmt1 = $conn->prepare("SELECT * FROM student_profile WHERE id = ?");
        $stmt1->bind_param('i', $id);
        $stmt1 -> execute();
        $result = $stmt1->get_result();
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $login_id = $row['login_id'];
        }
        $stmt1->close();

        //DELETE STUDENT RECORD
        $stmt2 = $conn->prepare("DELETE FROM student_profile WHERE id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->close();

        //DELETE LOGIN RECORD
        $stmt3 = $conn->prepare("DELETE FROM login WHERE id = ?");
        $stmt3->bind_param("i", $login_id);
        $stmt3->execute();
        $stmt3->close();

        echo "Student has been successfully deleted.";
    }
}else if($action == "deletestudentcourse"){
    //CHECKING STUDENT SEMESTER RECORD
    $stmt = $conn->prepare("SELECT * FROM student_course_semester WHERE course_id = ? LIMIT 1");
    $stmt -> bind_param("i",$id);
    $stmt -> execute();
    $result = $stmt->get_result();
    $stmt->close();

    if($result->num_rows > 0){
        echo "Unable to delete the student course, because the student have the semester record.";
    }else{
        //DELETE STUDENT COURSE RECORD
        $stmt1 = $conn->prepare("DELETE FROM student_course WHERE id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $stmt1->close();

        echo "Student Course has been successfully deleted.";
    }
}else if($action == "deletestudentcoursesemester"){
    //CHECKING STUDENT SEMESTER SUBJECT RECORD
    $stmt = $conn->prepare("SELECT * FROM student_course_semester_subject WHERE semester_id = ? LIMIT 1");
    $stmt -> bind_param("i",$id);
    $stmt -> execute();
    $result = $stmt->get_result();
    $stmt->close();

    if($result->num_rows > 0){
        echo "Unable to delete the student course semester, because the student have the semester subject record.";
    }else{
        //DELETE STUDENT SEMESTER RECORD
        $stmt1 = $conn->prepare("DELETE FROM student_course_semester WHERE id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $stmt1->close();

        echo "Student Course Semester has been successfully deleted.";
    }
}else if($action == "deletestudentcoursesemestersubject"){
    //DELETE STUDENT SEMESTER SUBJECT RECORD
    $stmt1 = $conn->prepare("DELETE FROM student_course_semester_subject WHERE id = ?");
    $stmt1->bind_param("i", $id);
    $stmt1->execute();
    $stmt1->close();

    echo "Student Course Semester Subject has been successfully deleted.";
}else if($action == "load_semester"){
    //LOAD STUDENT SEMESTER RECORD
    $student_semester_arr = array();

	$stmt = $conn->prepare("SELECT * FROM student_course_semester WHERE course_id = ?");
    $stmt -> bind_param("i",$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->num_rows;
    if($total>0){
        while($row = $result->fetch_assoc()) {
            $student_semester_arr[] = $row;
        }
    }
    $stmt->close();
    
    echo json_encode($student_semester_arr);
}else if($action == "load_subject"){
    //LOAD STUDENT SUBJECT RECORD
    $student_semester_subject_arr = array();

	$stmt = $conn->prepare("SELECT A.*, B.semester, B.term, C.course_name, D.name FROM student_course_semester_subject A, student_course_semester B, student_course C, student_profile D WHERE A.semester_id = B.id AND B.course_id = C.id AND C.profile_id = D.id AND A.semester_id = ?");
    $stmt -> bind_param("i",$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->num_rows;
    if($total>0){
        while($row = $result->fetch_assoc()) {
            $student_semester_subject_arr[] = $row;
        }
    }
    $stmt->close();
    
    echo json_encode($student_semester_subject_arr);
}else{
    echo "Fail";
}
?>