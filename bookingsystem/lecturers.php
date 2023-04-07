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
<title>Lecturers</title>
<link href="css/styles.css" rel="stylesheet">
<script src="js/all.min.js"></script>
</head>
    <body class="sb-nav-fixed">
        <?php include_once("includes/topheader.php"); ?>
        <div id="layoutSidenav">
            <?php include_once("includes/leftsidebar.php"); ?>
            <div id="layoutSidenav_content">
				<div class="container-fluid">
					<h1 class="mt-4">Lecturers</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Lecturers</li>
					</ol>
					<div class="card mb-4">
						<div class="card-header">Lecturers</div>
						<div class="card-body">
							<?php if(isset($_SESSION['lecturerDelete']) && $_SESSION['lecturerDelete'] != "") { echo "<br><div class='alert alert-success'>".$_SESSION['lecturerDelete']."</div>"; } unset($_SESSION['lecturerDelete']); ?>
							<div class="table-responsive">
								<table class="table table-bordered" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>Lecturer ID</th>
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
										$lecturersSql = mysqli_query($con, "SELECT * FROM users WHERE usertype='L'");
										$lecturerscount = mysqli_num_rows($lecturersSql);
										if($lecturerscount > 0)
										{
											while($lecturers = mysqli_fetch_array($lecturersSql))
											{
									?>
										<tr>
											<td><?=$lecturers['s_l_ID'];?></td>
											<td><?=$lecturers['name'];?></td>
											<td><?=$lecturers['email'];?></td>
											<td><?=$lecturers['phonenumber'];?></td>
											<?php if($_SESSION['loginType'] == 'A') { ?>
											<td>
											<a href="editlecturers.php?id=<?=$lecturers['id']?>"><input class="btn btn-primary" type="button" name="edit" id="edit" value="EDIT"></a>
											<a href="manage_lecturers.php?id=<?=$lecturers['id']?>&status=delete" onclick="return confirm('Are you sure to delete this lecturer?')"><input class="btn btn-danger" type="button" name="delete" id="delete" value="DELETE"></a>
										</td>
											<?php } ?>
										</tr>
									<?php 	}
										}
										else
										{
									?>
										<tr>
											<td align="center" colspan="5"><b>No Any Lecturers.</b></td>
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