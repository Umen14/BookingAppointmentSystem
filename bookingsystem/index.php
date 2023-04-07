<?php
include_once("includes/configure.php");
if(isset($_SESSION['loginType']))
{
	header("Location: dashboard.php");
	exit;
}
if(isset($_POST["loginS"]))
{
	$errors= array();
	$studentEmail = $_POST["emailS"];
    $studentPassword = $_POST["passwordS"];
	if(!filter_var($studentEmail, FILTER_VALIDATE_EMAIL))
		array_push($errors, "Email address is not valid");
	if(strlen($studentPassword) < 3)
		array_push($errors,"Password should be more than 3 characters");
	if(count($errors) == 0)
	{
		$studentSql = mysqli_query($con,"SELECT * FROM users WHERE email = '".$studentEmail."' and usertype='S'");
		$studentData = mysqli_fetch_array($studentSql, MYSQLI_ASSOC);
		if($studentData)
		{
			$studentSql1 = mysqli_query($con,"SELECT * FROM users WHERE email = '".$studentEmail."' and password = '".$studentPassword."' and usertype='S'");
			$studentData1 = mysqli_fetch_array($studentSql1, MYSQLI_ASSOC);
			if($studentData1)
			{
				$_SESSION["loginID"] = $studentData1["id"];
				$_SESSION["loginName"] = $studentData1["name"];
				$_SESSION["loginType"] = $studentData1["usertype"];
				header("Location: dashboard.php");
				exit;
			}
			else
				echo"<div class='alert alert-danger'>Incorrect Password</div>";
		}
		else
			echo"<div class='alert alert-danger'>Email address does not exist. Please register your account</div>";
	}
}
if(isset($_POST["loginL"]))
{
	$errors= array();
	$lecturerEmail = $_POST["emailL"];
    $lecturerPassword = $_POST["passwordL"];
	if(!filter_var($lecturerEmail, FILTER_VALIDATE_EMAIL))
		array_push($errors, "Email address is not valid");
	if(strlen($lecturerPassword) < 3)
		array_push($errors,"Password should be more than 3 characters");
	if(count($errors) == 0)
	{
		$lecturerSql = mysqli_query($con,"SELECT * FROM users WHERE email = '".$lecturerEmail."' and usertype='L'");
		$lecturerData = mysqli_fetch_array($lecturerSql, MYSQLI_ASSOC);
		if($lecturerData)
		{
			$lecturerSql1 = mysqli_query($con,"SELECT * FROM users WHERE email = '".$lecturerEmail."' and password = '".$lecturerPassword."' and usertype='L'");
			$lecturerData1 = mysqli_fetch_array($lecturerSql1, MYSQLI_ASSOC);
			if($lecturerData1)
			{
				$_SESSION["loginID"] = $lecturerData1["id"];
				$_SESSION["loginName"] = $lecturerData1["name"];				
				$_SESSION["loginType"] = $lecturerData1["usertype"];
                header("Location: dashboard.php");
				exit;
			}
			else
				echo"<div class='alert alert-danger'>Incorrect Password</div>";
		}
		else
			echo"<div class='alert alert-danger'>Email address does not exist. Please register your account</div>";
	}
}
if(isset($_POST["loginA"]))
{
	$errors= array();
	$adminEmail = $_POST["emailA"];
    $adminPassword = $_POST["passwordA"];
	if(!filter_var($adminEmail, FILTER_VALIDATE_EMAIL))
		array_push($errors, "Email address is not valid");
	if(strlen($adminPassword) < 3)
		array_push($errors,"Password should be more than 3 characters");
	if(count($errors) == 0)
	{
		$adminSql = mysqli_query($con,"SELECT * FROM users WHERE email = '".$adminEmail."' and usertype='A'");
		$adminData = mysqli_fetch_array($adminSql, MYSQLI_ASSOC);
		if($adminData)
		{
			$adminSql1 = mysqli_query($con,"SELECT * FROM users WHERE email = '".$adminEmail."' and password = '".$adminPassword."' and usertype='A'");
			$adminData1 = mysqli_fetch_array($adminSql1, MYSQLI_ASSOC);
			if($adminData1)
			{
				$_SESSION["loginID"] = $adminData1["id"];
				$_SESSION["loginName"] = $adminData1["name"];
				$_SESSION["loginType"] = $adminData1["usertype"];
				header("Location: dashboard.php");
				exit;
			}
			else
				echo"<div class='alert alert-danger'>Incorrect Password</div>";
		}
		else
			echo"<div class='alert alert-danger'>Email address does not exist. Please register your account</div>";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Login</title>
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
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="lecturer-tab" data-bs-toggle="tab" data-bs-target="#lecturer-tab-pane" type="button" role="tab" aria-controls="lecturer-tab-pane" aria-selected="false">Lecturer</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin-tab-pane" type="button" role="tab" aria-controls="admin-tab-pane" aria-selected="false">Admin</button>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="student-tab-pane" role="tabpanel" aria-labelledby="student-tab" tabindex="0">
						<form name="StudentLoginForm" id="StudentLoginForm" method="post" class="pt-3 pb-3">
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
							<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
								<span class="small">Not Registered Yet? <a href="register.php">Register Here</a></span>
								<input class="btn btn-primary" type="submit" name="loginS" id="loginS" value="Login">
							</div>
						</form>
					</div>
					<div class="tab-pane fade" id="lecturer-tab-pane" role="tabpanel" aria-labelledby="lecturer-tab" tabindex="0">
						<form name="LecturerLoginForm" id="LecturerLoginForm" method="post" class="pt-3 pb-3">
							<div class="form-group">
								<label class="small mb-1" for="emailL">Email</label>
								<input class="form-control" id="emailL" name="emailL" type="email" placeholder="Email Address" required>
							</div>
							<div class="form-group">
								<label class="small mb-1" for="passwordL">Password</label>
								<div class="input-group">
									<input class="form-control" id="passwordL" name="passwordL" type="password" placeholder="Password" required>
									<div class="input-group-append">
										<button class="btn btn-primary" type="button" id="togglePasswordL">Show</button>
									</div>
								</div>
							</div>
							<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0 float-end">
								<input class="btn btn-primary" type="submit" name="loginL" id="loginL" value="Login">
							</div>
						</form>
					</div>
					<div class="tab-pane fade" id="admin-tab-pane" role="tabpanel" aria-labelledby="admin-tab" tabindex="0">
						<form name="AdminLoginForm" id="AdminLoginForm" method="post" class="pt-3 pb-3">
							<div class="form-group">
								<label class="small mb-1" for="emailA">Email</label>
								<input class="form-control" id="emailA" name="emailA" type="email" placeholder="Email Address" required>
							</div>
							<div class="form-group">
								<label class="small mb-1" for="passwordA">Password</label>
								<div class="input-group">
									<input class="form-control" id="passwordA" name="passwordA" type="password" placeholder="Password" required>
									<div class="input-group-append">
										<button class="btn btn-primary" type="button" id="togglePasswordA">Show</button>
									</div>
								</div>
							</div>
							<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0 float-end">
								<input class="btn btn-primary" type="submit" name="loginA" id="loginA" value="Login">
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
	let passwordInputL = document.getElementById('passwordL');
	let togglePasswordButtonL = document.getElementById('togglePasswordL');
	togglePasswordButtonL.addEventListener('click', function() {
		let type = passwordInputL.getAttribute('type') === 'password' ? 'text' : 'password';
		passwordInputL.setAttribute('type', type);
		togglePasswordButtonL.innerText = type === 'password' ? 'Show' : 'Hide';
	});
	let passwordInputA = document.getElementById('passwordA');
	let togglePasswordButtonA = document.getElementById('togglePasswordA');
	togglePasswordButtonA.addEventListener('click', function() {
		let type = passwordInputA.getAttribute('type') === 'password' ? 'text' : 'password';
		passwordInputA.setAttribute('type', type);
		togglePasswordButtonA.innerText = type === 'password' ? 'Show' : 'Hide';
	});
	</script>
	<?php include_once("includes/footerfileincludes.php"); ?>
</body>
</html>