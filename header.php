<?php
	require('connect.php');
	
	function test_input($data){
		$data=trim($data);
		$data=stripslashes($data);
		$data=htmlspecialchars($data);
		return $data;
	}
	date_default_timezone_set('Asia/Calcutta');
?>
<style>

</style>
<script>
	
</script>
<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	</head>
	<body>
		<ul>
			<li><a href="index.html">Main Page</a></li>
  			<li><a href="home.php">Home</a></li>
  			<li><a href="changepass.php?animate=true">Change Password</a></li>
  			<li><a href="myorders.php">My Orders</a></li>
  			<li><a href="wallet.php">Show wallet amount</a></li>
  			<li><a href="logout.php">Sign Out</a></li>
  			
  			<li style="float:right;"><b><font color="white">Welcome <?php if(isset($_SESSION['username']))echo $_SESSION['username']; ?></b></font></li>
  		</ul>
	
