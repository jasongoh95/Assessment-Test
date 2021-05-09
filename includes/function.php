<?php
/**
 * function validate return validate data.
*/
function validate($data){
    $data = htmlspecialchars(stripslashes(trim($data)));
    return $data;
}// End of function validate

/**
 * function invalidUsername return true or false.
*/
function invalidUsername($data){
    if ( !preg_match("/^[A-Za-z0-9]+$/", $data) ){
        return true;
    }else{
        return false;
    }
}// End of function invalidUsername

/**
 * function invalidFullname return true or false.
*/
function invalidFullname($data){
    if ( !preg_match("/^[A-Za-z ]+$/", $data) ){
        return true;
    }else{
        return false;
    }
}// End of function invalidFullname

/**
 * function invalidNationality return true or false.
*/
function invalidNationality($data){
    if ( !preg_match("/^[A-Za-z ]+$/", $data) ){
        return true;
    }else{
        return false;
    }
}// End of function invalidNationality

/**
 * function invalidCoursename return true or false.
*/
function invalidCoursename($data){
    if ( !preg_match("/^[A-Za-z ]+$/", $data) ){
        return true;
    }else{
        return false;
    }
}// End of function invalidCoursename

/**
 * function getCurrentStudentProfile return the student profile.
*/
function getCurrentStudentProfile($login_id)
{
    global $conn;
    $current_student_profile_arr = array();

	$stmt = $conn->prepare("SELECT * FROM student_profile WHERE login_id = ? limit 1");
    $stmt -> bind_param("i",$login_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->num_rows;
    if($total>0){
        while($row = $result->fetch_assoc()) {
            $current_student_profile_arr[] = $row;
        }
    }
    $stmt->close();
    return $current_student_profile_arr;
}// End of function getCurrentStudentProfile

/**
 * function getCurrentStudentSemester return the student semester record.
*/
function getCurrentStudentSemester($login_id)
{
    global $conn;
    $current_student_semester_arr = array();

	$stmt = $conn->prepare("SELECT A.*, B.course_name, C.name FROM student_course_semester A, student_course B, student_profile C WHERE A.course_id = B.id AND B.profile_id = C.id AND C.login_id = ?");
    $stmt -> bind_param("i",$login_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->num_rows;
    if($total>0){
        while($row = $result->fetch_assoc()) {
            $current_student_semester_arr[] = $row;
        }
    }
    $stmt->close();
    return $current_student_semester_arr;
}// End of function getCurrentStudentSemester

/**
 * function getCurrentStudentSemesterSubject return the student semester subject record.
*/
function getCurrentStudentSemesterSubject($login_id)
{
    global $conn;
    $current_student_semester_subject_arr = array();

	$stmt = $conn->prepare("SELECT A.*, B.semester, B.term, C.course_name, D.name FROM student_course_semester_subject A, student_course_semester B, student_course C, student_profile D WHERE A.semester_id = B.id AND B.course_id = C.id AND C.profile_id = D.id AND D.login_id = ?");
    $stmt -> bind_param("i",$login_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->num_rows;
    if($total>0){
        while($row = $result->fetch_assoc()) {
            $current_student_semester_subject_arr[] = $row;
        }
    }
    $stmt->close();
    return $current_student_semester_subject_arr;
}// End of function getCurrentStudentSemesterSubject

/**
 * function getLogin return the login information.
*/
function getLogin()
{
    global $conn;
    $login_arr = array();

	$stmt = $conn->prepare("SELECT * FROM login");
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->num_rows;
    if($total>0){
        while($row = $result->fetch_assoc()) {
            $login_arr[] = $row;
        }
    }
    $stmt->close();
    return $login_arr;
}// End of function getLogin

/**
 * function getStudentProfile return the student profile.
*/
function getStudentProfile()
{
    global $conn;
    $student_profile_arr = array();

	$stmt = $conn->prepare("SELECT * FROM student_profile");
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->num_rows;
    if($total>0){
        while($row = $result->fetch_assoc()) {
            $student_profile_arr[] = $row;
        }
    }
    $stmt->close();
    return $student_profile_arr;
}// End of function getStudentProfile

/**
 * function getStudentCourse return the student course.
*/
function getStudentCourse()
{
    global $conn;
    $student_course_arr = array();

	$stmt = $conn->prepare("SELECT A.*, B.name FROM student_course A, student_profile B WHERE A.profile_id = B.id");
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->num_rows;
    if($total>0){
        while($row = $result->fetch_assoc()) {
            $student_course_arr[] = $row;
        }
    }
    $stmt->close();
    return $student_course_arr;
}// End of function getStudentCourse

/**
 * function getStudentCourseSemester return the student course semester.
*/
function getStudentCourseSemester()
{
    global $conn;
    $student_course_semester_arr = array();

	$stmt = $conn->prepare("SELECT A.*, B.course_name, C.name FROM student_course_semester A, student_course B, student_profile C WHERE A.course_id = B.id AND B.profile_id = C.id");
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->num_rows;
    if($total>0){
        while($row = $result->fetch_assoc()) {
            $student_course_semester_arr[] = $row;
        }
    }
    $stmt->close();
    return $student_course_semester_arr;
}// End of function getStudentCourseSemester

/**
 * function getStudentCourseSemesterSubject return the student course subject.
*/
function getStudentCourseSemesterSubject()
{
    global $conn;
    $student_course_semester_subject_arr = array();

	$stmt = $conn->prepare("SELECT A.*, B.semester, B.term, C.course_name, D.name FROM student_course_semester_subject A, student_course_semester B, student_course C, student_profile D WHERE A.semester_id = B.id AND B.course_id = C.id AND C.profile_id = D.id");
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->num_rows;
    if($total>0){
        while($row = $result->fetch_assoc()) {
            $student_course_semester_subject_arr[] = $row;
        }
    }
    $stmt->close();
    return $student_course_semester_subject_arr;
}// End of function getStudentCourseSemesterSubject

?>