<div id="layoutSidenav_nav">
	<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
		<div class="sb-sidenav-menu">
			<div class="nav">
				<a class="nav-link" href="dashboard.php">Dashboard</a>
				<a class="nav-link" href="profile.php?id=<?=$_SESSION['loginID'];?>">Profile</a>				
				<?php if($_SESSION['loginType'] == 'S' || $_SESSION['loginType'] == 'L') { ?>
				<a class="nav-link" href="addbookings.php">Add Bookings</a>
				<a class="nav-link" href="appointments.php">Appointments</a>
				<?php } else if($_SESSION['loginType'] == 'A') { ?>
				<a class="nav-link" href="students.php">Students</a>
				<a class="nav-link" href="addstudents.php">Add Students</a>
				<a class="nav-link" href="lecturers.php">Lecturers</a>
				<a class="nav-link" href="addlecturers.php">Add Lecturer</a>
				<a class="nav-link" href="appointments.php">Appointments</a>
				<?php } ?>
				<a class="nav-link" href="logout.php">Logout</a>
			</div>
		</div>
		<div class="sb-sidenav-footer">
			<div class="small">Logged in as:</div>
			<?php if($_SESSION['loginType'] == "S") { echo "Student"; } else if($_SESSION['loginType'] == "L") { echo "Lecturer"; } else if($_SESSION['loginType'] == "A") { echo "Admin"; } ?>
		</div>
	</nav>
</div>