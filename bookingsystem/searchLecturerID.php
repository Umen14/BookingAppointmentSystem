<?php
include_once("includes/configure.php");
if(!isset($_SESSION["loginType"]))
{
	header("Location: index.php");
	exit;
}
$term = mysqli_real_escape_string($con,$_GET['term']);
$query = mysqli_query($con,"SELECT * FROM users WHERE s_l_ID LIKE '$term%' and usertype='L'");
$result = [];
while($data = mysqli_fetch_array($query))
{
    $result[] = $data['s_l_ID'];
}
echo json_encode($result);
?>