<?php
require("../includes/db.inc.php");
require_once('API_function.php');
require('function.php');

$data = $action = $login = $password = "";

if(!empty($_POST['data'])) $data = json_decode(opensslDecode(urlencode(trim($_POST["data"]))), true);

if(!empty($data)){
   isset($data['login'])?$login=$data['login']:"";
   isset($data['password'])?$password=$data['password']:"";
   isset($data['action'])?$action=$data['action']:"";
}

switch($action)
{
	case "getStudentCourseSemesterSubject":
		$response = getStudentCourseSemesterSubject($login,$password,$action);
		$response = json_encode($response);
		echo $response;
	break;

	default:
		$response = array(
			'Status' => 'Fail',
			'ErrorMessage' => 'Authentication Fail',
			'data' => ''
		);
		$response = json_encode($response);
		echo $response;
}
?>