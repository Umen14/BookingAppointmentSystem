<?php
include_once("includes/configure.php");
if(!isset($_SESSION["loginType"]))
{
	header("Location: index.php");
	exit;
}
if(isset($_GET['id']) && $_GET['id'] != "" && $_GET['status'] == 'delete')
{
	$lecturerID = $_GET['id'];
	$lecturerSql = mysqli_query($con,"SELECT * FROM users WHERE id = '".$lecturerID."' and usertype = 'L'");
	$lecturerCount = mysqli_num_rows($lecturerSql);
	if($lecturerCount > 0)
	{
		mysqli_query($con,"DELETE from users WHERE id = '".$lecturerID."'");
		$_SESSION['lecturerDelete'] = "Lecturer Deleted Successfully!";
		header("Location: lecturers.php");
	}
}
?>