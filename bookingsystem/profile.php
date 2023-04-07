<?php
include_once("includes/configure.php");
if(!isset($_SESSION["loginType"]))
{
	header("Location: index.php");
	exit;
}
if(isset($_POST['updateprofile']))
{
	$profileId = $_GET['id'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$phonenumber = $_POST['phonenumber'];
	$profileResult = mysqli_query($con, "SELECT * FROM users WHERE email = '".$email."' and id != '".$_GET['id']."'");
	$profileCount = mysqli_num_rows($profileResult);
	if($profileCount > 0)
		$_SESSION['emailExists'] = "Email Address already exist. Please try with another Email Address.";
	else
	{
		$profileResult1 = mysqli_query($con, "SELECT * FROM users WHERE phonenumber = '".$phonenumber."' and id != '".$_GET['id']."'");
		$profileCount1 = mysqli_num_rows($profileResult1);
		if($profileCount1 > 0)
			$_SESSION['phoneExists'] = "Phone Number already exist. Please try with another Phone Number.";
		else
		{
			mysqli_query($con, "UPDATE users SET name = '".$name."', email = '".$email."', password = '".$password."', phonenumber = '".$phonenumber."' WHERE id = '".$profileId."'");
			$_SESSION['profileupdate'] = "Profile Updated Successfully!";
		}
	}
}
$profileResult = mysqli_query($con, "SELECT * FROM users WHERE id = '".$_GET['id']."'");
$profile = mysqli_fetch_array($profileResult);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Profile</title>
<link href="css/styles.css" rel="stylesheet">
</head>
    <body class="sb-nav-fixed">
        <?php include_once("includes/topheader.php"); ?>
        <div id="layoutSidenav">
            <?php include_once("includes/leftsidebar.php"); ?>
            <div id="layoutSidenav_content">
                    <div class="container-fluid">
						<h1 class="mt-4">Profile</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
						<div class="row">
							<div class="col-lg-12">
								<div class="card shadow-lg border-0 rounded-lg">
									<div class="card-body">
										<?php if(isset($_SESSION['emailExists']) && $_SESSION['emailExists'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['emailExists']."</div>"; } unset($_SESSION['emailExists']); ?>
										<?php if(isset($_SESSION['phoneExists']) && $_SESSION['phoneExists'] != "") { echo "<br><div class='alert alert-danger'>".$_SESSION['phoneExists']."</div>"; } unset($_SESSION['phoneExists']); ?>
										<?php if(isset($_SESSION['profileupdate']) && $_SESSION['profileupdate'] != "") { echo "<br><div class='alert alert-success'>".$_SESSION['profileupdate']."</div>"; } unset($_SESSION['profileupdate']); ?>
										<form name="ProfileForm" id="ProfileForm" method="post">
											<div class="form-group">
                                                <label class="small mb-1" for="name">Name</label>
                                                <input class="form-control" id="name" name="name" type="text" placeholder="Name" value="<?=$profile['name'];?>" required>
                                            </div>
											<div class="form-group">
                                                <label class="small mb-1" for="email">Email</label>
                                                <input class="form-control" id="email" type="email" name="email" placeholder="Email Address" value="<?=$profile['email'];?>" required>
                                            </div>
											<div class="form-group">
                                                <label class="small mb-1" for="password">Password</label>
                                                <div class="input-group">
													<input class="form-control" id="password" name="password" type="password" placeholder="Password" value="<?=$profile['password'];?>" required>
													<div class="input-group-append">
														<button class="btn btn-primary" type="button" id="togglePassword">Show</button>
													</div>
												</div>
                                            </div>
											<div class="form-group">
												<label class="small mb-1" for="phonenumber">Phone Number</label>
												<input class="form-control" id="phonenumber" name="phonenumber" type="text" placeholder="Phone Number" value="<?=$profile['phonenumber'];?>" required>
											</div>
											<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
												<input class="btn btn-primary" type="submit" name="updateprofile" id="updateprofile" value="Update Profile" />
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