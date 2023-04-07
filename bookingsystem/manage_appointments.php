<?php
include_once("includes/configure.php");
if(!isset($_SESSION["loginType"]))
{
	header("Location: index.php");
	exit;
}
if(isset($_GET['id']) && $_GET['id'] != "" && $_GET['status'] == 'approved')
{
	$bookingID = $_GET['id'];
	$lecturerID = $_GET['lid'];
	$bookingSql = mysqli_query($con,"SELECT * FROM bookings WHERE id = '".$bookingID."' and lecturerid = '".$lecturerID."'");
	$bookingCount = mysqli_num_rows($bookingSql);
	if($bookingCount > 0)
	{
		mysqli_query($con,"UPDATE bookings SET status = 'Approved' WHERE id = '".$bookingID."' and lecturerid = '".$lecturerID."'");
		$_SESSION['bookingApprove'] = "Booking Approved Successfully!";
		header("Location: appointments.php");
	}
}
else if(isset($_GET['id']) && $_GET['id'] != "" && $_GET['status'] == 'rejected')
{
	$bookingID = $_GET['id'];
	$lecturerID = $_GET['lid'];
	$bookingSql = mysqli_query($con,"SELECT * FROM bookings WHERE id = '".$bookingID."' and lecturerid = '".$lecturerID."'");
	$bookingCount = mysqli_num_rows($bookingSql);
	if($bookingCount > 0)
	{
		mysqli_query($con,"UPDATE bookings SET status = 'Rejected' WHERE id = '".$bookingID."' and lecturerid = '".$lecturerID."'");
		$_SESSION['bookingReject'] = "Booking Rejected Successfully!";
		header("Location: appointments.php");
	}
}
else if(isset($_GET['id']) && $_GET['id'] != "" && $_GET['status'] == 'delete')
{
	$bookingID = $_GET['id'];
	$bookingSql = mysqli_query($con,"SELECT * FROM bookings WHERE id = '".$bookingID."'");
	$bookingCount = mysqli_num_rows($bookingSql);
	if($bookingCount > 0)
	{
		mysqli_query($con,"DELETE from bookings WHERE id = '".$bookingID."'");
		$_SESSION['bookingDelete'] = "Booking Deleted Successfully!";
		header("Location: appointments.php");
	}
}
?>