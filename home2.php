<?php
	require('header.php');
	
	if(!isset($_SESSION['username'])){
		header('location:logout.php');
	}
	$color=array("success","danger","active","info","warning");
	$error=0;
	$erroro=false;
	$i=0;
	$user_email=$_SESSION['email'];
	$show=1;

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
		else if(isset($_POST['pay'])){
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
		if($erroro==false)
		$show=0;
		//echo "<script>alert('ORDER PLACED SUCCESSFULLY'); window.location.href='yourorder.php?id=$order_id'</script>";
		//echo "<script>window.location.href='payment.php'</script>";
		
	}
	
}
?>
<style>
hr {
	
  border-top: 1px solid red;
  height:30px;
  width:500px;
}

div.table-responsive{
	border:2px solid purple;
}
img {
  width: 100px;
  height: 100px;
  -webkit-transition: width 2s, height 2s; /* For Safari 3.1 to 6.0 */
  transition: width 2s, height 2s;
}

img:hover {
  width: 150px;
  height: 150px;
}

</style>
<br>
<div class="container" >
	<h1><center>ON OFFER</center></h1>
	<hr align="center">
	<div class="row">
		<?php
				if($num>0){
					while($result=mysqli_fetch_array($execute)){
			?>
		<div class="col-md-4"><img src="data:image/jpeg;base64,<?php echo base64_encode( $result['image'] ); ?>" width="100" height="100" /></div>
		<?php
					}
				}
			?>
	</div>
	<!---
	<div class="row">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
			<h1><center>ON OFFER</center></h1>
			<hr align="center">
			<tr class="default">
				<th>NAME</th>
				<th>PRICE</th>
				<th>IMAGE</th>
			</tr>
			<?php
				if($num>0){
					while($result=mysqli_fetch_array($execute)){
			?>
			<tr class="<?php echo $color[$i]; $i=($i+1)%5; ?>">
				<td><?php echo $result['name']; ?></td>
				<td><?php echo $result['price']; ?></td>
				<td><img src="data:image/jpeg;base64,<?php echo base64_encode( $result['image'] ); ?>" width="50" height="50" /></td>
			</tr>
			<?php
					}
				}
			?>
			
			</table>
		</div>
	</div>
	--->
	
	<br>
	<?php $i=0; ?>
	
	<div class="row">
		<form method="POST">
			<div class="table-responsive">
			<table class="table table-hover table-bordered">
			<tr class="default">
				<th>NAME</th>
				<th>PRICE</th>
				<th>COUNT AVAILABLE</th>
				<th>NO. OF ITEMS</th>
			</tr>
			<?php
				//$avail_item2="Select * from items where avail='1' and make_time!=0 and count>0;";
				$avail_item2="Select * from items where avail='1' and count>0;";
				$execute=mysqli_query($link, $avail_item2);
				$num=mysqli_num_rows($execute);
				if($num>0){
					while($result=mysqli_fetch_array($execute)){
			?>
			
			<tr>
					<td><?php echo $result['name'];?></td>
					<td><?php echo $result['price']; ?></td>
					<td><?php echo $result['count']; ?></td>
					<td><input type="text" class="form-control" name=<?php echo "'".$result['code']."_count'"; ?> id=<?php echo "'".$result['code']."_countid'"; ?>></td>
				</tr>
				<?php		
					}
				}
			?>
			</table>
			</div>
			<p>
			<center><input type="submit" class="btn btn-danger" name="placeorder" value="Place Order"></center>
			</p>
		</form>
	</div>
	
	<?php if($show==0) {?>
	<form method="POST">
		<input type="submit" class="btn btn-danger" name="pay" value="pay">
	</form>
	<p> pay <?php echo $price;?></p>
	<?php }?>
	
</div>
