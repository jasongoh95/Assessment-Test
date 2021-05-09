<?php 
function getStudentCourseSemesterSubject($login,$password,$action)
{
	global $conn;
	$bContinue = true;
	
	if(empty($login))
	{
 
		$arrResult['Status'] = "Fail";
		$arrResult['ErrorMessage'] = "Login is empty";
		$arrResult['data'] = "";
 
		$bContinue = false;
	}
	
	if(empty($password))
	{
		$arrResult['Status'] = "Fail";
		$arrResult['ErrorMessage'] = "Password is empty";
		$arrResult['data'] = "";
 
		$bContinue = false;
	}

	if($bContinue){
		
        $student_course_semester_subject_arr = array();

        $stmt = $conn->prepare("SELECT A.*, B.semester, B.term, C.course_name, D.name FROM student_course_semester_subject A, student_course_semester B, student_course C, student_profile D WHERE A.semester_id = B.id AND B.course_id = C.id AND C.profile_id = D.id");
        $stmt->execute();
        $result = $stmt->get_result();
        $total = $result->num_rows;
        if($total>0){
            while($row = $result->fetch_assoc()) {
                $student_course_semester_subject_arr[] = $row;
            }

            $arrResult['Status'] = "Success";
			$arrResult['ErrorMessage'] = "";
			$arrResult['data'] = $student_course_semester_subject_arr;
        }else{
            $arrResult['Status'] = "Success";
			$arrResult['ErrorMessage'] = "No Record Found.";
			$arrResult['data'] = "";
        }
        $stmt->close();
	}

	return $arrResult;
}
?>