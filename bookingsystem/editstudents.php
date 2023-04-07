<?php
include_once("includes/configure.php");
if(!isset($_SESSION["loginType"]))
{
	header("Location: index.php");
	exit;
}
$sID = $_GET['id'];
if(isset($_POST["editstudent"]))
{
	$studentID = $_POST['studentid'];
	$studentName = $_POST['name'];
	$studentEmail = $_POST['email'];
	$studentPassword = $_POST['password'];
	$studentPhoneNumber = $_POST['phonenumber'];
	if(!filter_var($studentEmail, FILTER_VALIDATE_EMAIL))
		$_SESSION['invalidEmail'] = "Invalid Email Address";
	$studentResult = mysqli_query($con,"SELECT * FROM users WHERE s_l_ID = '".$studentID."' and usertype = 'S' and id != '".$sID."'");
	$rowCount = mysqli_num_rows($studentResult);
	if($rowCount > 0)
		$_SESSION['studentIDExists'] = "Student ID already exists. Please try with another Student ID";
	else
	{
		$studentResult1 = mysqli_query($con,"SELECT * FROM users WHERE email = '".$studentEmail."' and id != '".$sID."'");
		$rowCount1 = mysqli_num_rows($studentResult1);	
		if($rowCount1 > 0)
			$_SESSION['emailExists'] = "Email address already exists. Please try with another email address";
		else
		{
			$studentResult2 = mysqli_query($con,"SELECT * FROM users WHERE phonenumber = '".$studentPhoneNumber."' and id != '".$sID."'");
			$rowCount2 = mysqli_num_rows($studentResult2);	
			if($rowCount2 > 0)
				$_SESSION['phoneExists'] = "Phone Number already exists. Please try with another Phone Number.";
			else
			{
				mysqli_query($con, "UPDATE users SET s_l_ID='".$studentID."', name='".$studentName."', email='".$studentEmail."', password='".$studentPassword."', phonenumber='".$studentPhoneNumber."', usertype='S' where id = '".$sID."'");
				$_SESSION['success'] = "Student details updated successfully!";
			}
		}
	}
}
$studentsresult = mysqli_query($con, "SELECT * FROM users WHERE id = '".$sID."' and usertype = 'S'");
$studentscount = mysqli_num_rows($studentsresult);
if($studentscount > 0)
{
	$studentsrow = mysqli_fetch_assoc($studentsresult);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Edit Student</title>
<link href="css/styles.css" rel="stylesheet">
</head>
    <body class="sb-nav-fixed">
        <?php include_once("includes/topheader.php"); ?>
        <div id="layoutSidenav">
            <?php include_once("includes/leftsidebar.php"); ?>
            <div id="layoutSidenav_content">
				<div class="container-fluid">
					<h1 class="mt-4">Edit Student</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Edit Student</li>
					</ol>
					<div class="row">
						<div class="col-lg-12">
							<div class="card shadow-lg border-0 rounded-lg">
								<div class="card-body">
									<?php if(isset($_SESSION['studentIDExists']) && $_SESSION['studentIDExists'] != "") { echo "<br><div class='alert alert-danger p-2'>".$_SESSION['studentIDExists']."</div>"; } unset($_SESSION['studentIDExists']); ?>
									<?php if(isset($_SESSION['invalidEmail']) && $_SESSION['invalidEmail'] != "") { echo "<br><div class='alert alert-danger p-2'>".$_SESSION['invalidEmail']."</div>"; } unset($_SESSION['invalidEmail']); ?>
									<?php if(isset($_SESSION['emailExists']) && $_SESSION['emailExists'] != "") { echo "<br><div class='alert alert-danger p-2'>".$_SESSION['emailExists']."</div>"; } unset($_SESSION['emailExists']); ?>
									<?php if(isset($_SESSION['phoneExists']) && $_SESSION['phoneExists'] != "") { echo "<br><div class='alert alert-danger p-2'>".$_SESSION['phoneExists']."</div>"; } unset($_SESSION['phoneExists']); ?>
									<?php if(isset($_SESSION['success']) && $_SESSION['success'] != "") { echo "<br><div class='alert alert-success'>".$_SESSION['success']."</div>"; } unset($_SESSION['success']); ?>
									<form name="EditStudentForm" id="EditStudentForm" method="post">
										<div class="form-group">
											<label class="small mb-1" for="studentid">Student ID</label>
											<input class="form-control" id="studentid" name="studentid" type="text" placeholder="Student ID" value="<?=$studentsrow['s_l_ID'];?>" required>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="name">Name</label>
											<input class="form-control py-4" id="name" name="name" type="text" placeholder="Name" value="<?=$studentsrow['name'];?>" required>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="email">Email</label>
											<input class="form-control py-4" id="email" type="email" name="email" placeholder="Email Address" value="<?=$studentsrow['email'];?>" required>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="password">Password</label>
											<div class="input-group">
												<input class="form-control" id="password" name="password" type="password" placeholder="Password" value="<?=$studentsrow['password'];?>" required>
												<div class="input-group-append">
													<button class="btn btn-primary" type="button" id="togglePassword">Show</button>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="small mb-1" for="phonenumber">Phone Number</label>
											<input class="form-control py-4" id="phonenumber" type="text" name="phonenumber" placeholder="Phone Number" value="<?=$studentsrow['phonenumber'];?>" required>
										</div>
										<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
											<input class="btn btn-primary" type="submit" name="editstudent" id="editstudent" value="Edit Student" />
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
<?php } else { 
header("Location: dashboard.php");
} ?>