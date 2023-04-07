<?php
include_once("includes/configure.php");
if(!isset($_SESSION["loginType"]))
{
	header("Location: index.php");
	exit;
}
if(isset($_POST["addlecturer"]))
{
	$lecturerID = $_POST['lecturerid'];
	$lecturerName = $_POST['name'];
	$lecturerEmail = $_POST['email'];
	$lecturerPassword = $_POST['password'];
	$lecturerPhoneNumber = $_POST['phonenumber'];
	if(!filter_var($lecturerEmail, FILTER_VALIDATE_EMAIL))
		$_SESSION['invalidEmail'] = "Email address is not valid";
	if(strlen($lecturerPassword) < 3)
		$_SESSION['passwordShort'] = "Password should be more than 3 characters";
	$lecturerResult = mysqli_query($con,"SELECT * FROM users WHERE s_l_ID = '".$lecturerID."' and usertype = 'L'");
	$rowCount = mysqli_num_rows($lecturerResult);
	if($rowCount > 0)
		$_SESSION['lecturerIDExists'] = "Lecturer ID already exists. Please try with another ID.";
	else
	{
		$lecturerResult1 = mysqli_query($con,"SELECT * FROM users WHERE email = '".$lecturerEmail."'");
		$rowCount1 = mysqli_num_rows($lecturerResult1);
		if($rowCount1 > 0)
			$_SESSION['emailExists'] = "Email Address already exists. Please try with another Email Address.";
		else
		{
			$lecturerResult2 = mysqli_query($con,"SELECT * FROM users WHERE phonenumber = '".$lecturerPhoneNumber."'");
			$rowCount2 = mysqli_num_rows($lecturerResult2);
			if($rowCount2 > 0)
				$_SESSION['phoneExists'] = "Phone Number already exists. Please try with another Phone Number.";
			else
			{
				mysqli_query($con, "INSERT INTO users SET s_l_ID = '".$lecturerID."', name='".$lecturerName."', email='".$lecturerEmail."', password='".$lecturerPassword."', phonenumber='".$lecturerPhoneNumber."', usertype='L'");
				$_SESSION['lecturerAdd'] = "Lecturer added successfully!";
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Add Lecturer</title>
<link href="css/styles.css" rel="stylesheet">
</head>
<body class="sb-nav-fixed">
	<?php include_once("includes/topheader.php"); ?>
	<div id="layoutSidenav">
		<?php include_once("includes/leftsidebar.php"); ?>
		<div id="layoutSidenav_content">
				<div class="container-fluid">
					<h1 class="mt-4">Add Lecturer</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Add Lecturer</li>
					</ol>
					<div class="row">
						<div class="col-lg-12">
							<div class="card shadow-lg border-0 rounded-lg">
								<div class="card-body">
									<?php if(isset($_SESSION['lecturerIDExists']) && $_SESSION['lecturerIDExists'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['lecturerIDExists']."</div>"; } unset($_SESSION['lecturerIDExists']); ?>
									<?php if(isset($_SESSION['invalidEmail']) && $_SESSION['invalidEmail'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['invalidEmail']."</div>"; } unset($_SESSION['invalidEmail']); ?>
									<?php if(isset($_SESSION['emailExists']) && $_SESSION['emailExists'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['emailExists']."</div>"; } unset($_SESSION['emailExists']); ?>
									<?php if(isset($_SESSION['passwordShort']) && $_SESSION['passwordShort'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['passwordShort']."</div>"; } unset($_SESSION['passwordShort']); ?>
									<?php if(isset($_SESSION['phoneExists']) && $_SESSION['phoneExists'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['phoneExists']."</div>"; } unset($_SESSION['phoneExists']); ?>
									<?php if(isset($_SESSION['lecturerAdd']) && $_SESSION['lecturerAdd'] != "") { echo "<br><div class='alert alert-success'>".$_SESSION['lecturerAdd']."</div>"; } unset($_SESSION['lecturerAdd']); ?>
									<form name="AddLecturerForm" id="AddLecturerForm" method="post">
										<div class="form-group">
											<label class="small mb-1" for="lecturerid">Lecturer ID</label>
											<input class="form-control" id="lecturerid" name="lecturerid" type="text" placeholder="Lecturer ID" required>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="name">Name</label>
											<input class="form-control py-4" id="name" name="name" type="text" placeholder="Name" required>
										</div>										
										<div class="form-group">
											<label class="small mb-1" for="email">Email</label>
											<input class="form-control py-4" id="email" type="email" name="email" placeholder="Email Address" required>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="password">Password</label>
											<div class="input-group">
												<input class="form-control" id="password" name="password" type="password" placeholder="Password" required>
												<div class="input-group-append">
													<button class="btn btn-primary" type="button" id="togglePassword">Show</button>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="phonenumber">Phone Number</label>
											<input class="form-control py-4" id="phonenumber" name="phonenumber" type="text" placeholder="Phone Number" required>
										</div>
										<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
											<input class="btn btn-primary" type="submit" name="addlecturer" id="addlecturer" value="Add Lecturer" />
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
	<script>
	let passwordInput = document.getElementById('password');
	let togglePasswordButton = document.getElementById('togglePassword');
	togglePasswordButton.addEventListener('click', function() {
		let type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
		passwordInput.setAttribute('type', type);
		togglePasswordButton.innerText = type === 'password' ? 'Show' : 'Hide';
	});
	</script>
	<?php include_once("includes/footerfileincludes.php"); ?>
</body>
</html>