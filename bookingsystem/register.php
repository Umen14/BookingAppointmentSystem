<?php
include_once("includes/configure.php");
if(isset($_SESSION['loginS']) || isset($_SESSION['loginL']) || isset($_SESSION['loginA']))
{
	header("Location: dashboard.php");
	exit;
}
if(isset($_POST["registerS"]))
{
	$studentID = $_POST['idS'];
	$studentName = $_POST['nameS'];
	$studentEmail = $_POST['emailS'];
	$studentPassword = $_POST['passwordS'];
	$studentConfirmPassword = $_POST['cpasswordS'];
	$studentPhoneNumber = $_POST['phonenumberS'];
	if(!filter_var($studentEmail, FILTER_VALIDATE_EMAIL))
		$_SESSION['invalidEmail'] = "Email address is not valid";
	if(strlen($studentPassword) < 3)
		$_SESSION['passwordShort'] = "Password should be more than 3 characters";
	if(strlen($studentConfirmPassword) < 3)
		$_SESSION['cPasswordShort'] = "Confirm Password should be more than 3 characters";
	if($studentPassword !== $studentConfirmPassword)
		$_SESSION['passwordNotMatch'] = "Password Does Not Match";
	$studentResult = mysqli_query($con,"SELECT * FROM users WHERE s_l_ID = '".$studentID."'");
	$rowCount = mysqli_num_rows($studentResult);
	if($rowCount > 0)
		$_SESSION['studentIDExists'] = "Student ID already exists. Please try with another Student ID.";
	else
	{
		$studentResult1 = mysqli_query($con,"SELECT * FROM users WHERE email = '".$studentEmail."'");
		$rowCount1 = mysqli_num_rows($studentResult1);
		if($rowCount1 > 0)
			$_SESSION['emailExists'] = "Email address already exists. Please try with another Email Address.";
		else
		{
			$studentResult2 = mysqli_query($con,"SELECT * FROM users WHERE phonenumber = '".$studentPhoneNumber."'");
			$rowCount2 = mysqli_num_rows($studentResult2);
			if($rowCount2 > 0)
				$_SESSION['phoneExists'] = "Phone Number already exists. Please try with another Phone Number.";
			else
			{
				mysqli_query($con, "INSERT INTO users SET s_l_ID = '".$studentID."', name='".$studentName."', email='".$studentEmail."', password='".$studentPassword."', phonenumber='".$studentPhoneNumber."', usertype='S'");
				$_SESSION['success'] = "You have registered successfully!";
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Register</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body
{
	background: url("images/logo.png") repeat;
}
</style>
</head>
<body class="bg-primary">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-5 p-5 mt-5" style="background: beige; border: 1px solid #000;">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="student-tab" data-bs-toggle="tab" data-bs-target="#student-tab-pane" type="button" role="tab" aria-controls="student-tab-pane" aria-selected="true">Student</button>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="student-tab-pane" role="tabpanel" aria-labelledby="student-tab" tabindex="0">
						<?php if(isset($_SESSION['studentIDExists']) && $_SESSION['studentIDExists'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['studentIDExists']."</div>"; } unset($_SESSION['studentIDExists']); ?>
						<?php if(isset($_SESSION['invalidEmail']) && $_SESSION['invalidEmail'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['invalidEmail']."</div>"; } unset($_SESSION['invalidEmail']); ?>
						<?php if(isset($_SESSION['emailExists']) && $_SESSION['emailExists'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['emailExists']."</div>"; } unset($_SESSION['emailExists']); ?>
						<?php if(isset($_SESSION['passwordShort']) && $_SESSION['passwordShort'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['passwordShort']."</div>"; } unset($_SESSION['passwordShort']); ?>
						<?php if(isset($_SESSION['cPasswordShort']) && $_SESSION['cPasswordShort'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['cPasswordShort']."</div>"; } unset($_SESSION['cPasswordShort']); ?>
						<?php if(isset($_SESSION['passwordNotMatch']) && $_SESSION['passwordNotMatch'] != "") { echo "<br><div class='alert alert-success'>".$_SESSION['passwordNotMatch']."</div>"; } unset($_SESSION['passwordNotMatch']); ?>
						<?php if(isset($_SESSION['phoneExists']) && $_SESSION['phoneExists'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['phoneExists']."</div>"; } unset($_SESSION['phoneExists']); ?>
						<?php if(isset($_SESSION['success']) && $_SESSION['success'] != "") { echo "<br><div class='alert alert-success'>".$_SESSION['success']."</div>"; } unset($_SESSION['success']); ?>
						<form name="StudentRegisterForm" id="StudentRegisterForm" method="post" class="pt-3 pb-3">
							<div class="form-group">
								<label class="small mb-1" for="idS">Student ID</label>
								<input class="form-control" id="idS" name="idS" type="text" placeholder="Student ID" required>
							</div>
							<div class="form-group">
								<label class="small mb-1" for="nameS">Name</label>
								<input class="form-control" id="nameS" name="nameS" type="text" placeholder="Name" required>
							</div>
							<div class="form-group">
								<label class="small mb-1" for="emailS">Email</label>
								<input class="form-control" id="emailS" name="emailS" type="email" placeholder="Email Address" required>
							</div>
							<div class="form-group">
								<label class="small mb-1" for="passwordS">Password</label>
								<div class="input-group">
									<input class="form-control" id="passwordS" name="passwordS" type="password" placeholder="Password" required>
									<div class="input-group-append">
										<button class="btn btn-primary" type="button" id="togglePasswordS">Show</button>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="small mb-1" for="cpasswordS">Confirm Password</label>
								<div class="input-group">
									<input class="form-control" id="cpasswordS" name="cpasswordS" type="password" placeholder="Confirm Password" required>
									<div class="input-group-append">
										<button class="btn btn-primary" type="button" id="toggleConfirmPasswordS">Show</button>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="small mb-1" for="phonenumberS">Phone Number</label>
								<input class="form-control" id="phonenumberS" name="phonenumberS" type="text" placeholder="Phone Number" required>
							</div>
							<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
								<span class="small">Already Registered? <a href="index.php">Login Here</a></span>
								<input class="btn btn-primary" type="submit" name="registerS" id="registerS" value="Register">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
	let passwordInputS = document.getElementById('passwordS');
	let togglePasswordButtonS = document.getElementById('togglePasswordS');
	togglePasswordButtonS.addEventListener('click', function() {
		let type = passwordInputS.getAttribute('type') === 'password' ? 'text' : 'password';
		passwordInputS.setAttribute('type', type);
		togglePasswordButtonS.innerText = type === 'password' ? 'Show' : 'Hide';
	});
	let confirmPasswordInputS = document.getElementById('cpasswordS');
	let toggleConfirmPasswordButtonS = document.getElementById('toggleConfirmPasswordS');
	toggleConfirmPasswordButtonS.addEventListener('click', function() {
		let type = confirmPasswordInputS.getAttribute('type') === 'password' ? 'text' : 'password';
		confirmPasswordInputS.setAttribute('type', type);
		toggleConfirmPasswordButtonS.innerText = type === 'password' ? 'Show' : 'Hide';
	});
	</script>
	<script src="js/jquery-3.5.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>