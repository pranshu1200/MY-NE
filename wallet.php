<?php
	require('header.php');
	if(!isset($_SESSION['username'])){
		header('location:logout.php');
	}
	$user_email=$_SESSION['email'];
	$query = "select wallet from users where email='$user_email' ";
	$run_query = mysqli_query($link,$query);
	$q = mysqli_fetch_array($run_query);
	$money = $q['wallet'];
	
?>
<b><center><h2>YOUR BALANCE IS</h2></center></b>
<h3><center><font color="blue"><?php echo $money."rupees"?></font></center></h3>
<center><img src="money.jpeg"></center>
<p align="center">contact the admin at our center to refill more money into the wallet </p> 
<a href="home.php"><center>back to home</a></center>

