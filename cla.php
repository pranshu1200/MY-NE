<?php
if(!isset($_SESSION['username'])){
		header('location:logout.php');
	}
	$color=array("success","danger","active","info","warning");
	$error=0;
	$erroro=false;
	$i=0;
	$user_email=$_SESSION['email'];

	$query = "select * from users where email='$user_email' ";
	$run_query = mysqli_query($link,$query);
	$q = mysqli_fetch_array($run_query);
	$money = $q['wallet'];
	// echo "<script>alert('$money')</script>";

	$avail_item="Select * from items where avail='1' and count>0;";
	$execute=mysqli_query($link,$avail_item);
	$num=mysqli_num_rows($execute);
	
	if(isset($_POST['placeorder'])){

		$findcount="SELECT COUNT(*) AS ordercount FROM orders";
		$exe1=mysqli_query($link, $findcount);
		$res1=mysqli_fetch_array($exe1);
		$order_id=$res1['ordercount'];
		$order_id=$order_id+1;
  
		//$make_time=0;
		$price=0;
		$execute2=mysqli_query($link,$avail_item);
		$num2=mysqli_num_rows($execute2);
		if($num2>0){
			while($ans2=mysqli_fetch_array($execute2)){
				$str=$ans2['code']."_count";
				$count=test_input($_POST[$str]);
				
				if($count>$ans2['count']){
					$erroro=true;
					echo "<script>alert('ordering more than available');</script>";
					$make_time=0;
					break;
				}
				else if($count==0){
					continue;
				}
				/*if($count>ans2['count']){
					$erroro=true;
					echo "<script>alert('ordering more than available');</script>";
					
					break;
				}*/
				else{
				
				$price=$price+$count*$ans2['price'];
				}
			}
		}

		if($price>$money){
			echo "<script>alert('wallet money not sufficient')</script>";
		}
		else{
		$money=$money-$price;
		$query = "update users set wallet='$money' where email='$user_email' ";
		$run_query = mysqli_query($link,$query);
		//$insert_q="INSERT INTO orders(orderid,userid,make_time,price)VALUES(".$order_id.", '".$_SESSION['email']."', ".$make_time." ,".$price.")";
		$insert_q="INSERT INTO orders(userid,price) VALUES('".$_SESSION['email']."' ,".$price.")";
		//$insert_q="INSERT INTO orders(userid,make_time,price)VALUES('".$_SESSION['email']."', ".$make_time." ,".$price.")";
		if($erroro==false){
		if(mysqli_query($link,$insert_q)){
			
		}
		else{
			echo "<script>alert('ERROR in order entry');</script>";
			
		}
		$findcount="SELECT max(orderid) AS ordercount FROM orders";
		$execute1=mysqli_query($link,$findcount);
		$ans1=mysqli_fetch_array($execute1);
		$order_id=$ans1['ordercount'];
		
		$exe=mysqli_query($link,$avail_item);
		$no=mysqli_num_rows($exe);
		if($no>0 and $errro==false){
			while($res=mysqli_fetch_array($exe)){
				$str=$res['code']."_count";
				$count=test_input($_POST[$str]);
				if($count==0){
					continue;
				}
				$update_q="UPDATE items set count=count-".$count." where code=".$res['code'];
				mysqli_query($link,$update_q);
				$ins_q="INSERT INTO orderitems VALUES (".$order_id.", ".$res['code'].", ".$count.")";
				if(mysqli_query($link, $ins_q)){
					}
					else{
						echo "<script>alert('ERROR in orderitems entry table);</script>";
					}
			}
		}}
		//if($erroro==false)
		//echo "<script>alert('ORDER PLACED SUCCESSFULLY'); window.location.href='yourorder.php?id=$order_id'</script>";
		echo "<script>window.location.href='payment.php'</script>";
	}
}
?>
