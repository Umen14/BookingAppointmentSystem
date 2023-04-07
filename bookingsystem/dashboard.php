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
<title>Dashboard - Booking System</title>
<link href="css/styles.css" rel="stylesheet">
</head>
<body class="sb-nav-fixed">
	<?php include_once("includes/topheader.php"); ?>
	<div id="layoutSidenav">
		<?php include_once("includes/leftsidebar.php"); ?>
		<div id="layoutSidenav_content">
			<div class="container-fluid">
				<h1 class="mt-4">Dashboard</h1>
				<ol class="breadcrumb mb-4">
					<li class="breadcrumb-item active">Dashboard</li>
				</ol>
				<div class="row">
					<?php if($_SESSION['loginType'] == "S") { ?>
					<div class="col-xl-3 col-md-6">
						<div class="card bg-primary text-white mb-4">
							<div class="card-body">Add Bookings</div>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<a class="small text-white stretched-link" href="addbookings.php">Add Bookings</a>
								<div class="small text-white"><i class="fas fa-angle-right"></i></div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-6">
						<div class="card bg-success text-white mb-4">
							<div class="card-body">Check Appoingments</div>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<a class="small text-white stretched-link" href="appointments.php">View Appointments</a>
								<div class="small text-white"><i class="fas fa-angle-right"></i></div>
							</div>
						</div>
					</div>							
					<?php } else if($_SESSION['loginType'] == "L") { ?>
					<div class="col-xl-3 col-md-6">
						<div class="card bg-primary text-white mb-4">
							<div class="card-body">Add Bookings</div>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<a class="small text-white stretched-link" href="addbookings.php">Add Bookings</a>
								<div class="small text-white"><i class="fas fa-angle-right"></i></div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-6">
						<div class="card bg-success text-white mb-4">
							<div class="card-body">Check Appoingments</div>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<a class="small text-white stretched-link" href="appointments.php">View Appointments</a>
								<div class="small text-white"><i class="fas fa-angle-right"></i></div>
							</div>
						</div>
					</div>
					<?php } else if($_SESSION['loginType'] == "A") { ?>
					<div class="col-xl-3 col-md-6">
						<div class="card bg-primary text-white mb-4">
							<div class="card-body">Students</div>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<a class="small text-white stretched-link" href="students.php">View Students</a>
								<div class="small text-white"><i class="fas fa-angle-right"></i></div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-6">
						<div class="card bg-success text-white mb-4">
							<div class="card-body">Lecturers</div>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<a class="small text-white stretched-link" href="lecturers.php">View Lecturers</a>
								<div class="small text-white"><i class="fas fa-angle-right"></i></div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-6">
						<div class="card bg-dark text-white mb-4">
							<div class="card-body">Appointments</div>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<a class="small text-white stretched-link" href="appointments.php">View Appointments</a>
								<div class="small text-white"><i class="fas fa-angle-right"></i></div>
							</div>
						</div>
					</div>							
				<?php } ?>							
				</div>
			</div>
			<?php include_once("includes/footer.php"); ?>
		</div>
	</div>
	<?php include_once("includes/footerfileincludes.php"); ?>
</body>
</html>