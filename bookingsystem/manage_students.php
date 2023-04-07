<?php
include_once("includes/configure.php");
if(!isset($_SESSION["loginType"]))
{
	header("Location: index.php");
	exit;
}
if(isset($_GET['id']) && $_GET['id'] != "" && $_GET['status'] == 'delete')
{
	$studentID = $_GET['id'];
	$studentSql = mysqli_query($con,"SELECT * FROM users WHERE id = '".$studentID."' and usertype = 'S'");
	$studentCount = mysqli_num_rows($studentSql);
	if($studentCount > 0)
	{
		mysqli_query($con,"DELETE from users WHERE id = '".$studentID."'");
		$_SESSION['studentDelete'] = "Student Deleted Successfully!";
		header("Location: students.php");
	}
}
?>