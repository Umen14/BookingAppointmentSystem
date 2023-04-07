<?php
	ob_start();
	session_start();
	ini_set("display_errors","off");
	$con = mysqli_connect("localhost","root","","bookingappointment");
?>