<?php
include_once("includes/configure.php");
if(!isset($_SESSION["loginType"]))
{
	header("Location: index.php");
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Appointments</title>
<link href="css/styles.css" rel="stylesheet">
<script src="js/all.min.js"></script>
</head>
<body class="sb-nav-fixed">
	<?php include_once("includes/topheader.php"); ?>
	<div id="layoutSidenav">
		<?php include_once("includes/leftsidebar.php"); ?>
		<div id="layoutSidenav_content">
			<div class="container-fluid">
				<h1 class="mt-4">Appointments</h1>
				<ol class="breadcrumb mb-4">
					<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
					<li class="breadcrumb-item active">Appointments</li>
				</ol>
				<div class="card mb-4">
					<div class="card-header">Appointments</div>					
					<div class="card-body">
						<?php if(isset($_SESSION['bookingApprove']) && $_SESSION['bookingApprove'] != "") { echo "<br><div class='alert alert-success'>".$_SESSION['bookingApprove']."</div>"; } unset($_SESSION['bookingApprove']);
						if(isset($_SESSION['bookingReject']) && $_SESSION['bookingReject'] != "") { echo "<br><div class='alert alert-success'>".$_SESSION['bookingReject']."</div>"; } unset($_SESSION['bookingReject']);
						if(isset($_SESSION['bookingEdit']) && $_SESSION['bookingEdit'] != "") { echo "<br><div class='alert alert-success'>".$_SESSION['bookingEdit']."</div>"; } unset($_SESSION['bookingEdit']);
						if(isset($_SESSION['bookingDelete']) && $_SESSION['bookingDelete'] != "") { echo "<br><div class='alert alert-success'>".$_SESSION['bookingDelete']."</div>"; } unset($_SESSION['bookingDelete']); ?>
						<?php if($_SESSION['loginType'] == "A") { ?>
						<div class="table-responsive">
							<table class="table table-bordered" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Appointment Date</th>
										<th>Student Name</th>
										<th>Student Email Address</th>
										<th>Student Phone Number</th>
										<th>Lecturer Name</th>
										<th>Lecturer Email Address</th>
										<th>Lecturer Phone Number</th>
										<th>Course</th>
										<th>Status</th>
										<th style="text-align: center;">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$bookingsSql = mysqli_query($con, "SELECT * FROM bookings order by id desc");
								$bookingscount = mysqli_num_rows($bookingsSql);
								if($bookingscount > 0)
								{
									while($bookings = mysqli_fetch_array($bookingsSql))
									{
								?>
									<tr>
										<td><?=$bookings['bookingdatetime'];?></td>
										<td><?=$bookings['studentname'];?></td>
										<td><?=$bookings['studentemail'];?></td>
										<td><?=$bookings['studentphonenumber'];?></td>
										<td><?=$bookings['lecturername'];?></td>
										<td><?=$bookings['lectureremail'];?></td>
										<td><?=$bookings['lecturerphonenumber'];?></td>
										<td><?=$bookings['course'];?></td>
										<td><?=$bookings['status'];?></td>
										<td>
										<a href="viewappointments.php?id=<?=$bookings['id'];?>"><input class="btn btn-success" type="button" name="view" id="view" value="VIEW"></a>
									</tr>
								<?php
									}
								}
								else
								{
								?>
									<tr>
										<td align="center" colspan="10"><b>No Any Bookings.</b></td>
									</tr>
								<?php
								}
								?>
								</tbody>
							</table>
						</div>
						<?php } else if($_SESSION['loginType'] == "L") { ?>
						<div class="table-responsive">
							<table class="table table-bordered" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Appointment Date</th>
										<th>Student Name</th>
										<th>Student Email Address</th>
										<th>Student Phone Number</th>
										<th>Course</th>
										<th>Status</th>
										<th style="text-align: center;">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$lecturerSql = mysqli_query($con, "SELECT * FROM users WHERE id = '".$_SESSION['loginID']."' and usertype='L'");
								$lecturerCount = mysqli_num_rows($lecturerSql);
								if($lecturerCount > 0)
								{
									$lecturerRow = mysqli_fetch_array($lecturerSql);
									$lID = $lecturerRow['s_l_ID'];
									$bookingsSql = mysqli_query($con, "SELECT * FROM bookings WHERE lecturerid = '".$lID."' order by id desc");
									$bookingscount = mysqli_num_rows($bookingsSql);
									if($bookingscount > 0)
									{
										while($bookings = mysqli_fetch_array($bookingsSql))
										{
								?>
									<tr>
										<td><?=$bookings['bookingdatetime'];?></td>
										<td><?=$bookings['studentname'];?></td>
										<td><?=$bookings['studentemail'];?></td>
										<td><?=$bookings['studentphonenumber'];?></td>
										<td><?=$bookings['course'];?></td>
										<td><?=$bookings['status'];?></td>
										<td>
										<?php if($bookings['status'] != "Approved" && $bookings['status'] != "Rejected") { ?>
										<a href="manage_appointments.php?id=<?=$bookings['id'];?>&lid=<?=$lID;?>&status=approved" onclick="return confirm('Are you sure to accept this booking?')"><input class="btn btn-success" type="button" name="accept" id="accept" value="ACCEPT"></a>
										<a href="manage_appointments.php?id=<?=$bookings['id'];?>&lid=<?=$lID;?>&status=rejected" onclick="return confirm('Are you sure to reject this booking?')"><input class="btn btn-danger" type="button" name="edit" id="edit" value="REJECT"></a>
										<?php } ?>
										<a href="editappointments.php?id=<?=$bookings['id'];?>"><input class="btn btn-primary" type="button" name="edit" id="edit" value="EDIT"></a>
										<a href="manage_appointments.php?id=<?=$bookings['id'];?>&status=delete" onclick="return confirm('Are you sure to delete this appointment?')"><input class="btn btn-danger" type="button" name="delete" id="delete" value="DELETE"></a>
										</td>
									</tr>
								<?php
										}
									}
									else
									{
									?>
									<tr>
										<td align="center" colspan="7"><b>No Any Bookings.</b></td>
									</tr>
									<?php
									}
								}
								?>
								</tbody>
							</table>
						</div>
						<?php } else if($_SESSION['loginType'] == "S") { ?>
						<div class="table-responsive">
							<table class="table table-bordered" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Appointment Date</th>
										<th>Lecturer Name</th>
										<th>Lecturer Email Address</th>
										<th>Lecturer Phone Number</th>
										<th>Course</th>
										<th>Intake Year</th>
										<th>Status</th>
										<th style="text-align: center;">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$studentSql = mysqli_query($con, "SELECT * FROM users WHERE id = '".$_SESSION['loginID']."'");
								$studentsCount = mysqli_num_rows($studentSql);
								if($studentsCount > 0)
								{
									$student = mysqli_fetch_array($studentSql);
									$s_ID = $student['s_l_ID'];
								}
								$bookingsSql = mysqli_query($con, "SELECT * FROM bookings WHERE studentid = '".$s_ID."' order by id desc");
								$bookingsCount = mysqli_num_rows($bookingsSql);
								if($bookingsCount > 0)
								{
									while($bookings = mysqli_fetch_array($bookingsSql))
									{
								?>
									<tr>
										<td><?=$bookings['bookingdatetime'];?></td>
										<td><?=$bookings['lecturername'];?></td>
										<td><?=$bookings['lectureremail'];?></td>
										<td><?=$bookings['lecturerphonenumber'];?></td>
										<td><?=$bookings['course'];?></td>
										<td><?=$bookings['intakeyear'];?></td>
										<td><?=$bookings['status'];?></td>
										<td>
										<a href="editappointments.php?id=<?=$bookings['id'];?>"><input class="btn btn-primary" type="button" name="edit" id="edit" value="EDIT"></a>
										<a href="manage_appointments.php?id=<?=$bookings['id'];?>&status=delete" onclick="return confirm('Are you sure to delete this booking?')"><input class="btn btn-danger" type="button" name="delete" id="delete" value="DELETE"></a>
										</td>
									</tr>
								<?php
									}
								}
								else
								{
								?>
									<tr>
										<td align="center" colspan="8"><b>No Any Appointments.</b></td>
									</tr>
								<?php
								}
								?>
								</tbody>
							</table>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php include_once("includes/footer.php"); ?>
		</div>
	</div>
	<?php include_once("includes/footerfileincludes.php"); ?>
</body>
</html>