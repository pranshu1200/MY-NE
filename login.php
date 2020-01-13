<?php
	require('connect.php');
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	date_default_timezone_set('Asia/Calcutta');
	if(isset($_SESSION['username'])){
		echo '<script>window.location.href="home.php";</script>';
	}
	$email_error=""; $pass_error="";;
	if(isset($_POST['login'])){
		$error=false;
		$email=test_input($_POST['email']);
		$password=base64_encode(test_input($_POST['password']));
		
		if(empty($email)){
			$email_error="Email not entered";
			$error=true;
		}
		if(empty($password)){
			$pass_error="Password not entered";
			$error=true;
		}
		
		if(!$error){
			$search="SELECT * FROM users WHERE email='".$email."' AND password='".$password."';";
			$execute=mysqli_query($link,$search);
			$num=mysqli_num_rows($execute);
			$ans=mysqli_fetch_array($execute);
			if($ans)
			{
				$_SESSION['username']=$ans['username'];
				$_SESSION['email']=$ans['email'];
				echo '<script>alert("Welcome");window.location.href="home.php";</script>';
			}
			else{
				$error=true;
				echo "<script>alert('Invalid username or password');</script>";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/login_style.css">
	</head>
<body>
  <br><br><br><br>
  <div class="login">
  <div class="form">
    <form class="login-form" method="post">
      <input type="text" placeholder="Email-ID" name="email" value="<?php if(isset($_POST['login']))if($error)echo $email;?>">
      <span class="serror"><?php echo $email_error;?></span>
	  <br>
	  <input type="password" placeholder="password" name="password">
	  <br>
      <button type="submit" name="login" value="<?php if(isset($_POST['login']))if($error)echo $password;?>">LOGIN</button>
      <span class="serror"><?php echo $pass_error;?></span>
      <p class="message">Not registered?<a href="signup.php">Create account</a></p>
    </form>
  </div>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script  src="assets/js/index.js"></script>
</body>
</html>
