<?php
include_once("includes/configure.php");
if(!isset($_SESSION["loginType"]))
{
	header("Location: index.php");
	exit;
}
if(isset($_GET['id']) && $_GET['id'] != "")
{
	$bID = $_GET['id'];
	$bookingResult = mysqli_query($con,"SELECT * FROM bookings WHERE id = '".$bID."'");
	$bookingCount = mysqli_num_rows($bookingResult);
	if($bookingCount > 0)
	{
		$bookingRow = mysqli_fetch_array($bookingResult);
	}
}
if(isset($_POST["editbooking"]))
{
	if($_SESSION['loginType'] == "S")
	{
		$studentID = $_SESSION['loginID'];
		$studentSql = mysqli_query($con,"SELECT * FROM users WHERE id = '".$studentID."' and usertype='S'");
		$studentCount = mysqli_num_rows($studentSql);
		if($studentCount > 0)
		{
			$studentRow = mysqli_fetch_array($studentSql);
			$s_ID = $studentRow['s_l_ID'];
		}
		$studentName = $_REQUEST['studentname'];
		$studentEmail = $_REQUEST['studentemail'];
		$studentPhoneNumber = $_REQUEST['studentphonenumber'];
		$studentCourse = $_POST['course'];
		$intakeYear = $_POST['intakeyear'];
		$bookingDatetime = $_POST['bookingdatetime'];
		$purpose = $_POST['purpose'];
		$lecturerId = $_POST['lecturer'];
		$lecturerSql = mysqli_query($con,"SELECT * FROM users WHERE s_l_ID = '".$lecturerId."' and usertype='L'");
		$lecturerCount = mysqli_num_rows($lecturerSql);
		if($lecturerCount > 0)
		{
			$lecturerRow = mysqli_fetch_array($lecturerSql);
			$lecturerName = $lecturerRow['name'];
			$lecturerEmail = $lecturerRow['email'];
			$lecturerPhoneNumber = $lecturerRow['phonenumber'];
			$bookingSql = mysqli_query($con,"SELECT * FROM bookings WHERE studentid = '".$s_ID."' and lecturerid = '".$lecturerId."' and id != '".$bID."'");
			$bookingCount = mysqli_num_rows($bookingSql);
			if($bookingCount > 0)
			{
				$_SESSION['bookingExists'] = "You already have booked appointment with ".$lecturerName.". Please book appointment with other Lecturer.";
			}
			else
			{
				$bookingTimeSql = mysqli_query($con,"SELECT * FROM bookings WHERE studentid = '".$s_ID."' and bookingdatetime = '".$bookingDatetime."' and id != '".$bID."'");
				$bookingTimeCount = mysqli_num_rows($bookingTimeSql);
				if($bookingTimeCount > 0)
				{
					$_SESSION['bookingTimeExists'] = "You already have booked appointment at this time. Please book appointment with another time.";
				}
				else
				{
					$bookingLecturerSql = mysqli_query($con,"SELECT * FROM bookings WHERE lecturerid = '".$lecturerId."' and bookingdatetime = '".$bookingDatetime."' and id != '".$bID."'");
					$bookingLecturerCount = mysqli_num_rows($bookingLecturerSql);
					if($bookingLecturerCount > 0)
					{
						$_SESSION['bookingLecturerExists'] = "Lecturer ".$lecturerId." already booked with another student. Please book with another lecturer.";
					}
					else
					{
						if($bookingDatetime < date("Y-m-d h:i:s"))
						{
							$_SESSION['bookingDateInvalid'] = "Booking Date Invalid. You can not select past date and time.";
						}
						else
						{
							mysqli_query($con, "UPDATE bookings SET studentid = '".$s_ID."', studentname = '".$studentName."', studentemail = '".$studentEmail."', studentphonenumber = '".$studentPhoneNumber."', course = '".$studentCourse."', lecturerid = '".$lecturerId."', lecturername = '".$lecturerName."', lectureremail = '".$lecturerEmail."', lecturerphonenumber = '".$lecturerPhoneNumber."', intakeyear = '".$intakeYear."', bookingdatetime = '".$bookingDatetime."', purpose = '".$purpose."' WHERE id = '".$bID."'");
							$_SESSION['bookingEdit'] = "Booking Details Updated successfully!";
							$bID = $_GET['id'];
							$bookingResult = mysqli_query($con,"SELECT * FROM bookings WHERE id = '".$bID."'");
							$bookingCount = mysqli_num_rows($bookingResult);
							if($bookingCount > 0)
							{
								$bookingRow = mysqli_fetch_array($bookingResult);
							}
						}
					}
				}
			}
		}
		else
			$_SESSION['lecturerNotExists'] = "Lecturer ID not exist.";
				
	}
	else if($_SESSION['loginType'] == "L")
	{
		$sID = $_POST['studentid'];
		$lecturerID = $_SESSION['loginID'];
		$studentCourse = $_POST['course'];
		$intakeYear = $_POST['intakeyear'];
		$bookingDatetime = $_POST['bookingdatetime'];
		$purpose = $_POST['purpose'];
		$studentsSql = mysqli_query($con,"SELECT * FROM users WHERE s_l_ID = '".$sID."' and usertype = 'S'");
		$studentsCount = mysqli_num_rows($studentsSql);
		if($studentsCount > 0)
		{
			$studentsRow = mysqli_fetch_array($studentsSql);
			$studentName = $studentsRow['name'];
			$studentEmail = $studentsRow['email'];
			$studentPhoneNumber = $studentsRow['phonenumber'];
			$lecturerSql = mysqli_query($con,"SELECT * FROM users WHERE id = '".$lecturerID."' and usertype='L'");
			$lecturerCount = mysqli_num_rows($lecturerSql);
			if($lecturerCount > 0)
			{
				$lecturersRow = mysqli_fetch_array($lecturerSql);
				$lID = $lecturersRow['s_l_ID'];
				$lecturerName = $lecturersRow['name'];
				$lecturerEmail = $lecturersRow['email'];
				$lecturerPhoneNumber = $lecturersRow['phonenumber'];
			}
			$bookingSql = mysqli_query($con,"SELECT * FROM bookings WHERE studentid = '".$sID."' and lecturerid = '".$lID."' and id != '".$bID."'");
			$bookingCount = mysqli_num_rows($bookingSql);
			if($bookingCount > 0)
			{
				$_SESSION['bookingExists'] = "You already have booked appointment with ".$studentName.". Please book appointment with other Student.";
			}
			else
			{
				$bookingTimeSql = mysqli_query($con,"SELECT * FROM bookings WHERE lecturerid = '".$lID."' and bookingdatetime = '".$bookingDatetime."' and id != '".$bID."'");
				$bookingTimeCount = mysqli_num_rows($bookingTimeSql);
				if($bookingTimeCount > 0)
				{
					$_SESSION['bookingTimeExists'] = "You already have booked appointment at this time. Please book appointment with another time.";
				}
				else
				{
					$bookingTimeSql = mysqli_query($con,"SELECT * FROM bookings WHERE studentid = '".$sID."' and bookingdatetime = '".$bookingDatetime."' and id != '".$bID."'");
					$bookingTimeCount = mysqli_num_rows($bookingTimeSql);
					if($bookingTimeCount > 0)
					{
						$_SESSION['bookingStudentExists'] = "Student ".$sID." already booked appointment with another lecturer. Please book with another student.";
					}
					else
					{
						if($bookingDatetime < date("Y-m-d h:i:s"))
						{
							$_SESSION['bookingDateInvalid'] = "Booking Date Invalid. You can not select past date and time.";
						}
						else
						{
							mysqli_query($con, "UPDATE bookings SET studentid = '".$sID."', studentname = '".$studentName."', studentemail = '".$studentEmail."', studentphonenumber = '".$studentPhoneNumber."', course = '".$studentCourse."', lecturerid = '".$lID."', lecturername = '".$lecturerName."', lectureremail = '".$lecturerEmail."', lecturerphonenumber = '".$lecturerPhoneNumber."', intakeyear = '".$intakeYear."', bookingdatetime = '".$bookingDatetime."', purpose = '".$purpose."' WHERE id = '".$bID."'");
							$_SESSION['bookingEdit'] = "Booking Details Updated successfully!";				
							$bID = $_GET['id'];
							$bookingResult = mysqli_query($con,"SELECT * FROM bookings WHERE id = '".$bID."'");
							$bookingCount = mysqli_num_rows($bookingResult);
							if($bookingCount > 0)
							{
								$bookingRow = mysqli_fetch_array($bookingResult);
							}
						}
					}
				}
			}
		}
		else
			$_SESSION['studentNotExists'] = "Student ID not exist.";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Edit Bookings</title>
<link rel="stylesheet" href="css/jquery-ui.css">
<link href="css/styles.css" rel="stylesheet">
</head>
<body class="sb-nav-fixed">
	<?php include_once("includes/topheader.php"); ?>
	<div id="layoutSidenav">
		<?php include_once("includes/leftsidebar.php"); ?>
		<div id="layoutSidenav_content">
				<div class="container-fluid">
					<h1 class="mt-4">Edit Bookings</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Edit Bookings</li>
					</ol>
					<div class="row">
						<div class="col-lg-12">
							<div class="card shadow-lg border-0 rounded-lg">
								<div class="card-body">
								<?php if(isset($_SESSION['bookingExists']) && $_SESSION['bookingExists'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['bookingExists']."</div>"; } unset($_SESSION['bookingExists']); ?>
								<?php if(isset($_SESSION['studentNotExists']) && $_SESSION['studentNotExists'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['studentNotExists']."</div>"; } unset($_SESSION['studentNotExists']); ?>
								<?php if(isset($_SESSION['lecturerNotExists']) && $_SESSION['lecturerNotExists'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['lecturerNotExists']."</div>"; } unset($_SESSION['lecturerNotExists']); ?>
								<?php if(isset($_SESSION['bookingTimeExists']) && $_SESSION['bookingTimeExists'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['bookingTimeExists']."</div>"; } unset($_SESSION['bookingTimeExists']); ?>
								<?php if(isset($_SESSION['bookingLecturerExists']) && $_SESSION['bookingLecturerExists'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['bookingLecturerExists']."</div>"; } unset($_SESSION['bookingLecturerExists']); ?>
								<?php if(isset($_SESSION['bookingStudentExists']) && $_SESSION['bookingStudentExists'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['bookingStudentExists']."</div>"; } unset($_SESSION['bookingStudentExists']); ?>
								<?php if(isset($_SESSION['bookingDateInvalid']) && $_SESSION['bookingDateInvalid'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['bookingDateInvalid']."</div>"; } unset($_SESSION['bookingDateInvalid']); ?>
								<?php if(isset($_SESSION['bookingEdit']) && $_SESSION['bookingEdit'] != "") { echo "<br><div class='alert alert-success'>".$_SESSION['bookingEdit']."</div>"; } unset($_SESSION['bookingEdit']); ?>
								<?php if($_SESSION['loginType'] == "S") { ?>								
								<form name="EditBookingsForm" id="EditBookingsForm" method="post">
									<input type="hidden" name="studentname" id="studentname" value="<?=$bookingRow['studentname'];?>">
									<input type="hidden" name="studentemail" id="studentemail" value="<?=$bookingRow['studentemail'];?>">
									<input type="hidden" name="studentphonenumber" id="studentphonenumber" value="<?=$bookingRow['studentphonenumber'];?>">
									<div class="form-group">
										<label class="small mb-1" for="name">Student Name</label>
										<input class="form-control" id="name" name="name" type="text" placeholder="Name" value="<?=$bookingRow['studentname'];?>" disabled>
									</div>
									<div class="form-group">
										<label class="small mb-1" for="email">Student Email</label>
										<input class="form-control" id="email" type="email" name="email" placeholder="Student Email Address" value="<?=$bookingRow['studentemail'];?>" disabled>
									</div>
									<div class="form-group">
										<label class="small mb-1" for="phonenumber">Student Phone Number</label>
										<input class="form-control" id="phonenumber" name="phonenumber" type="text" placeholder="Student Phone Number" value="<?=$bookingRow['studentphonenumber'];?>" disabled>
									</div>
									<div class="form-group">
										<label class="small mb-1" for="lecturer">Lecturer</label>
										<input type="text" name="lecturer" id="lecturer" placeholder="Lecturer ID" class="form-control" value="<?=$bookingRow['lecturerid'];?>" required>
									</div>
									<div class="form-group">
										<label class="small mb-1" for="course">Course</label>
										<input class="form-control" id="course" name="course" type="text" placeholder="Course" value="<?=$bookingRow['course'];?>" required>
									</div>
									<div class="form-group">
										<label class="small mb-1" for="intakeyear">Intake Year</label>
										<input class="form-control" id="intakeyear" name="intakeyear" type="text" placeholder="Intake Year" value="<?=$bookingRow['intakeyear'];?>" required>
									</div>
									<div class="form-group">
										<label class="small mb-1" for="bookingdatetime">Booking Date & Time</label>
										<input class="form-control" type="datetime-local" id="bookingdatetime" name="bookingdatetime" value="<?=$bookingRow['bookingdatetime'];?>" required>
									</div>
									<div class="form-group">
										<label class="small mb-1" for="purpose">Purpose</label>
										<textarea class="form-control" id="purpose" name="purpose" placeholder="Purpose" required><?=$bookingRow['purpose'];?></textarea>
									</div>
									<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
										<input class="btn btn-primary" type="submit" name="editbooking" id="editbooking" value="Edit Booking" />
									</div>
								</form>
								<?php } else if($_SESSION['loginType'] == "L") { ?>
								<form name="EditBookingsForm" id="EditBookingsForm" method="post">
									<div class="form-group">
										<label class="small mb-1" for="lecturer">Lecturer</label>
										<select class="form-control" name="lecturer" id="lecturer" disabled>
											<option value="">Select Lecturer</option>
											<?php
											$lecturerSql = mysqli_query($con, "SELECT * from users where usertype = 'L'");
											$lecturerCount = mysqli_num_rows($lecturerSql);
											if($lecturerCount > 0)
											{
												while($lecturerRow = mysqli_fetch_array($lecturerSql))
												{
											?>
												<option value="<?=$lecturerRow['s_l_ID'];?>"><?=$lecturerRow['name'];?></option>
											<?php														
												}
											}
											?>
										</select>
										<script>document.getElementById("lecturer").value = "<?=$bookingRow['lecturerid'];?>";</script>
									</div>
									<div class="form-group">
										<label class="small mb-1" for="studentid">Student ID</label>
										<input type="text" name="studentid" id="studentid" placeholder="Student ID" class="form-control" value="<?=$bookingRow['studentid'];?>" required>
									</div>									
									<div class="form-group">
										<label class="small mb-1" for="course">Course</label>
										<input class="form-control" id="course" name="course" type="text" placeholder="Course" value="<?=$bookingRow['course'];?>" required>
									</div>
									<div class="form-group">
										<label class="small mb-1" for="intakeyear">Intake Year</label>
										<input class="form-control" id="intakeyear" name="intakeyear" type="text" placeholder="Intake Year" value="<?=$bookingRow['intakeyear'];?>" required>
									</div>
									<div class="form-group">
										<label class="small mb-1" for="bookingdatetime">Booking Date & Time</label>
										<input class="form-control" type="datetime-local" id="bookingdatetime" name="bookingdatetime" value="<?=$bookingRow['bookingdatetime'];?>" required>
									</div>
									<div class="form-group">
										<label class="small mb-1" for="purpose">Purpose</label>
										<textarea class="form-control" id="purpose" name="purpose" placeholder="Purpose" required><?=$bookingRow['purpose'];?></textarea>
									</div>
									<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
										<input class="btn btn-primary" type="submit" name="editbooking" id="editbooking" value="Edit Booking" />
									</div>
								</form>
								<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php include_once("includes/footer.php"); ?>
		</div>
	</div>
	<?php include_once("includes/footerfileincludes.php"); ?>
	<script type="text/javascript">
	$(function() {
		 $( "#studentid" ).autocomplete({
		   source: 'searchStudentID.php',
		 });
		 $( "#lecturer" ).autocomplete({
		   source: 'searchLecturerID.php',
		 });
	  });
	</script>
</body>
</html>