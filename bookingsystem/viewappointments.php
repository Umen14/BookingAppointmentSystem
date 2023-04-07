<?php
include_once("includes/configure.php");
if(!isset($_SESSION["loginType"]))
{
	header("Location: index.php");
	exit;
}
$bookingResult = mysqli_query($con,"SELECT * FROM bookings WHERE id = '".$_GET['id']."'");
$bookingCount = mysqli_num_rows($bookingResult);
if($bookingCount > 0)
{
	$bookingRow = mysqli_fetch_array($bookingResult);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>View Bookings</title>
<link href="css/styles.css" rel="stylesheet">
</head>
<body class="sb-nav-fixed">
	<?php include_once("includes/topheader.php"); ?>
	<div id="layoutSidenav">
		<?php include_once("includes/leftsidebar.php"); ?>
		<div id="layoutSidenav_content">
				<div class="container-fluid">
					<h1 class="mt-4">View Bookings</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
						<li class="breadcrumb-item active">View Bookings</li>
					</ol>
					<div class="row">
						<div class="col-lg-12">
							<div class="card shadow-lg border-0 rounded-lg">
								<div class="card-body">
									<form name="ViewBookingsForm" id="ViewBookingsForm">
										<div class="form-group">
											<label class="small mb-1" for="name">Student Name</label>
											<input class="form-control" id="name" name="name" type="text" placeholder="Name" value="<?=$bookingRow['studentname'];?>" disabled>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="email">Student Email</label>
											<input class="form-control" id="email" type="email" name="email" placeholder="Email Address" value="<?=$bookingRow['studentemail'];?>" disabled>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="phonenumber">Student Phone Number</label>
											<input class="form-control" id="phonenumber" name="phonenumber" type="text" placeholder="Phone Number" value="<?=$bookingRow['studentphonenumber'];?>" disabled>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="lecturer">Lecturer</label>
											<input class="form-control" id="lecturer" name="lecturer" type="text" placeholder="Lecturer" value="<?=$bookingRow['lecturername'];?>" disabled>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="course">Course</label>
											<input class="form-control" id="course" name="course" type="text" placeholder="Course" value="<?=$bookingRow['course'];?>" disabled>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="intakeyear">Intake Year</label>
											<input class="form-control" id="intakeyear" name="intakeyear" type="text" placeholder="Intake Year" value="<?=$bookingRow['intakeyear'];?>" disabled>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="bookingdatetime">Booking Date & Time</label>
											<input class="form-control" type="datetime-local" id="bookingdatetime" name="bookingdatetime" value="<?=$bookingRow['bookingdatetime'];?>" disabled>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="purpose">Purpose</label>
											<textarea class="form-control" id="purpose" name="purpose" placeholder="Purpose" disabled><?=$bookingRow['purpose'];?></textarea>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php include_once("includes/footer.php"); ?>
		</div>
	</div>
	<?php include_once("includes/footerfileincludes.php"); ?>
</body>
</html>