<?php
include_once("includes/configure.php");
if(!isset($_SESSION["loginType"]))
{
	header("Location: index.php");
	exit;
}
$studentResult = mysqli_query($con,"SELECT * FROM users WHERE id = '".$_SESSION['loginID']."'");
$studentCount = mysqli_num_rows($studentResult);
if($studentCount > 0)
{
	$studentRow = mysqli_fetch_array($studentResult);
}
if(isset($_POST["addbooking"]))
{
	if($_SESSION['loginType'] == "S")
	{
		$studentID = $_SESSION['loginID'];
		$studentSql = mysqli_query($con,"SELECT * FROM users WHERE id = '".$studentID."' and usertype='S'");
		$studentCount = mysqli_num_rows($studentSql);
		if($studentCount > 0)
		{
			$studentRow = mysqli_fetch_array($studentSql);
			$s_l_ID = $studentRow['s_l_ID'];
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
			$lecturerId = $_POST['lecturer'];
			$lecturerName = $lecturerRow['name'];
			$lecturerEmail = $lecturerRow['email'];
			$lecturerPhoneNumber = $lecturerRow['phonenumber'];
			$bookingSql = mysqli_query($con,"SELECT * FROM bookings WHERE studentid = '".$s_l_ID."' and lecturerid = '".$lecturerId."'");
			$bookingCount = mysqli_num_rows($bookingSql);
			if($bookingCount > 0)
			{
				$_SESSION['bookingExists'] = "You already have booked appointment with ".$lecturerName.". Please book appointment with other Lecturer.";
			}
			else
			{
				$bookingTimeSql = mysqli_query($con,"SELECT * FROM bookings WHERE studentid = '".$s_l_ID."' and bookingdatetime = '".$bookingDatetime."'");
				$bookingTimeCount = mysqli_num_rows($bookingTimeSql);
				if($bookingTimeCount > 0)
				{
					$_SESSION['bookingTimeExists'] = "You already have booked appointment at this time. Please book appointment with another time.";
				}
				else
				{
					$bookingLecturerSql = mysqli_query($con,"SELECT * FROM bookings WHERE lecturerid = '".$lecturerId."' and bookingdatetime = '".$bookingDatetime."'");
					$bookingLecturerCount = mysqli_num_rows($bookingLecturerSql);
					if($bookingLecturerCount > 0)
					{
						$_SESSION['bookingLecturerExists'] = "Lecturer ".$lecturerId." already booked with another student. Please select another date and time.";
					}
					else
					{
						if($bookingDatetime < date("Y-m-d h:i:s"))
						{
							$_SESSION['bookingDateInvalid'] = "Booking Date Invalid. You can not select past date and time.";
						}
						else
						{
							mysqli_query($con, "INSERT INTO bookings SET studentid = '".$s_l_ID."', studentname = '".$studentName."', studentemail = '".$studentEmail."', studentphonenumber = '".$studentPhoneNumber."', course = '".$studentCourse."', lecturerid = '".$lecturerId."', lecturername = '".$lecturerName."', lectureremail = '".$lecturerEmail."', lecturerphonenumber = '".$lecturerPhoneNumber."', intakeyear = '".$intakeYear."', bookingdatetime = '".$bookingDatetime."', purpose = '".$purpose."', status = 'Pending', bookingcreatedon = '".date("Y-m-d h:i:s")."'");
							$_SESSION['bookingAdd'] = "Booking added successfully!";
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
			$students = mysqli_fetch_array($studentsSql);
			$studentName = $students['name'];
			$studentEmail = $students['email'];
			$studentPhoneNumber = $students['phonenumber'];
			$lecturerSql = mysqli_query($con,"SELECT * FROM users WHERE id = '".$lecturerID."' and usertype = 'L'");
			$lecturerCount = mysqli_num_rows($lecturerSql);
			if($lecturerCount > 0)
			{
				$lecturer = mysqli_fetch_array($lecturerSql);
				$lID = $lecturer['s_l_ID'];
				$lecturerName = $lecturer['name'];
				$lecturerEmail = $lecturer['email'];
				$lecturerPhoneNumber = $lecturer['phonenumber'];
			}
			$bookingSql = mysqli_query($con,"SELECT * FROM bookings WHERE studentid = '".$sID."' and lecturerid = '".$lID."'");
			$bookingCount = mysqli_num_rows($bookingSql);
			if($bookingCount > 0)
			{
				$_SESSION['bookingExists'] = "You already have booked appointment with ".$studentName.". Please book appointment with other Student.";
			}
			else
			{
				$bookingTimeSql = mysqli_query($con,"SELECT * FROM bookings WHERE lecturerid = '".$lID."' and bookingdatetime = '".$bookingDatetime."'");
				$bookingTimeCount = mysqli_num_rows($bookingTimeSql);
				if($bookingTimeCount > 0)
				{
					$_SESSION['bookingTimeExists'] = "You already have booked appointment at this time. Please book appointment with another time.";
				}
				else
				{
					$bookingStudentSql = mysqli_query($con,"SELECT * FROM bookings WHERE studentid = '".$sID."' and bookingdatetime = '".$bookingDatetime."'");
					$bookingStudentCount = mysqli_num_rows($bookingStudentSql);
					if($bookingStudentCount > 0)
					{
						$_SESSION['bookingStudentExists'] = "Student ".$sID." already booked with another lecturer. Please select another Student.";
					}
					else
					{
						if($bookingDatetime < date("Y-m-d h:i:s"))
						{
							$_SESSION['bookingDateInvalid'] = "Booking Date Invalid. You can not select past date and time.";
						}
						else
						{
							mysqli_query($con, "INSERT INTO bookings SET studentid = '".$sID."', studentname = '".$studentName."', studentemail = '".$studentEmail."', studentphonenumber = '".$studentPhoneNumber."', course = '".$studentCourse."', lecturerid = '".$lID."', lecturername = '".$lecturerName."', lectureremail = '".$lecturerEmail."', lecturerphonenumber = '".$lecturerPhoneNumber."', intakeyear = '".$intakeYear."', bookingdatetime = '".$bookingDatetime."', purpose = '".$purpose."', status = 'Pending', bookingcreatedon = '".date("Y-m-d h:i:s")."'");
							$_SESSION['bookingAdd'] = "Booking added successfully!";
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
<title>Add Bookings</title>
<link rel="stylesheet" href="css/jquery-ui.css">
<link rel="stylesheet" href="css/styles.css">
</head>
<body class="sb-nav-fixed">
	<?php include_once("includes/topheader.php"); ?>
	<div id="layoutSidenav">
		<?php include_once("includes/leftsidebar.php"); ?>
		<div id="layoutSidenav_content">
				<div class="container-fluid">
					<h1 class="mt-4">Add Bookings</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Add Bookings</li>
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
									<?php if(isset($_SESSION['bookingAdd']) && $_SESSION['bookingAdd'] != "") { echo "<br><div class='alert alert-success'>".$_SESSION['bookingAdd']."</div>"; } unset($_SESSION['bookingAdd']); ?>
									<?php if($_SESSION['loginType'] == "S") { ?>
									<form name="AddBookingsForm" id="AddBookingsForm" method="post">
										<input type="hidden" name="studentname" id="studentname" value="<?=$studentRow['name'];?>">
										<input type="hidden" name="studentemail" id="studentemail" value="<?=$studentRow['email'];?>">
										<input type="hidden" name="studentphonenumber" id="studentphonenumber" value="<?=$studentRow['phonenumber'];?>">
										<div class="form-group">
											<label class="small mb-1" for="name">Student Name</label>
											<input class="form-control" id="name" name="name" type="text" placeholder="Name" value="<?=$studentRow['name'];?>" disabled>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="email">Student Email</label>
											<input class="form-control" id="email" type="email" name="email" placeholder="Email Address" value="<?=$studentRow['email'];?>" disabled>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="phonenumber">Student Phone Number</label>
											<input class="form-control" id="phonenumber" name="phonenumber" type="text" placeholder="Phone Number" value="<?=$studentRow['phonenumber'];?>" disabled>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="lecturer">Lecturer</label>
											<input type="text" name="lecturer" id="lecturer" placeholder="Lecturer ID" class="form-control">
										</div>
										<div class="form-group">
											<label class="small mb-1" for="course">Course</label>
											<input class="form-control" id="course" name="course" type="text" placeholder="Course" required>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="intakeyear">Intake Year</label>
											<input class="form-control" id="intakeyear" name="intakeyear" type="text" placeholder="Intake Year" required>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="bookingdatetime">Booking Date & Time</label>
											<input class="form-control" type="datetime-local" id="bookingdatetime" name="bookingdatetime" required>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="purpose">Purpose</label>
											<textarea class="form-control" id="purpose" name="purpose" placeholder="Purpose" required></textarea>
										</div>
										<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
											<input class="btn btn-primary" type="submit" name="addbooking" id="addbooking" value="Add Booking" />
										</div>
									</form>
									<?php } else if($_SESSION['loginType'] == "L") { ?>
									<form name="AddBookingsForm" id="AddBookingsForm" method="post">
										<div class="form-group">
											<label class="small mb-1" for="studentid">Student ID</label>
											<input type="text" name="studentid" id="studentid" placeholder="Student ID" class="form-control">
										</div>
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
													<option value="<?=$lecturerRow['id'];?>"><?=$lecturerRow['name'];?></option>
												<?php														
													}
												}
												?>
											</select>
											<script>document.getElementById("lecturer").value = "<?=$studentRow['id']?>";</script>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="course">Course</label>
											<input class="form-control" id="course" name="course" type="text" placeholder="Course" required>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="intakeyear">Intake Year</label>
											<input class="form-control" id="intakeyear" name="intakeyear" type="text" placeholder="Intake Year" required>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="bookingdatetime">Booking Date & Time</label>
											<input class="form-control" type="datetime-local" id="bookingdatetime" name="bookingdatetime" required>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="purpose">Purpose</label>
											<textarea class="form-control" id="purpose" name="purpose" placeholder="Purpose" required></textarea>
										</div>
										<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
											<input class="btn btn-primary" type="submit" name="addbooking" id="addbooking" value="Add Booking" />
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