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
<title>Students</title>
<link href="css/styles.css" rel="stylesheet">
<script src="js/all.min.js"></script>
</head>
<body class="sb-nav-fixed">
	<?php include_once("includes/topheader.php"); ?>
	<div id="layoutSidenav">
		<?php include_once("includes/leftsidebar.php"); ?>
		<div id="layoutSidenav_content">
			<div class="container-fluid">
				<h1 class="mt-4">Students</h1>
				<ol class="breadcrumb mb-4">
					<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
					<li class="breadcrumb-item active">Students</li>
				</ol>
				<div class="card mb-4">
					<div class="card-header">Students</div>
					<div class="card-body">
						<?php if(isset($_SESSION['studentDelete']) && $_SESSION['studentDelete'] != "") { echo "<br><div class='alert alert-success'>".$_SESSION['studentDelete']."</div>"; } unset($_SESSION['studentDelete']); ?>
						<div class="table-responsive">
							<table class="table table-bordered" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Student ID</th>
										<th>Name</th>
										<th>Email Address</th>
										<th>Phone Number</th>
										<?php if($_SESSION['loginType'] == 'A') { ?>
										<th>Action</th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
								<?php
									$studentsSql = mysqli_query($con, "SELECT * FROM users WHERE usertype='S'");
									$studentscount = mysqli_num_rows($studentsSql);
									if($studentscount > 0)
									{
										while($students = mysqli_fetch_array($studentsSql))
										{
								?>
									<tr>
										<td><?=$students['s_l_ID'];?></td>
										<td><?=$students['name'];?></td>
										<td><?=$students['email'];?></td>
										<td><?=$students['phonenumber'];?></td>
										<?php if($_SESSION['loginType'] == 'A') { ?>
										<td>
										<a href="editstudents.php?id=<?=$students['id']?>"><input class="btn btn-primary" type="button" name="edit" id="edit" value="EDIT"></a>
										<a href="manage_students.php?id=<?=$students['id']?>&status=delete" onclick="return confirm('Are you sure to delete this student?')"><input class="btn btn-danger" type="button" name="delete" id="delete" value="DELETE"></a>
									</td>
										<?php } ?>
									</tr>
								<?php 	}
									}
									else
									{
								?>
									<tr>
										<td align="center" colspan="5"><b>No Any Students.</b></td>
									</tr>
								<?php
									}
								?>
								</tbody>
							</table>
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