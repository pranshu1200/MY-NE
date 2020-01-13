
<?php
	require('header.php');
	if(!isset($_SESSION['username'])){
		header('location:logout.php');
	}
	$color = array("success", "danger", "active", "info", "warning");
	$i=0;
	
	if(isset($_GET['id'])){
		$orderid=$_GET['id'];
	}
	$qry = "SELECT * from orderitems o NATURAL JOIN items i where o.orderid=$orderid order by o.orderid";
	
	$exe = mysqli_query($link, $qry);
?>

<br><br>
<div class="container">
<div class="row">
<table class="table table-responsive table-hover table-bordered">
	<h3><center><b>Current Order</b></center></h3>
	<a href='admin/report.php?id=<?php echo "$orderid"; ?> ' target="_blank"><i class="fa fa-print" id='icon' style="font-size:24px;float:right;margin:10px;"></i></a>
	<tr class="default">
		<th>Item</th>
		<th>Quantity</th>
		<th>Item Total Price</th>
	</tr>
<?php
	$num = mysqli_num_rows($exe);
	$amount=0; $make_time=0;
	if($num>0){
		$pr=0;
		while($result=mysqli_fetch_array($exe)){
?>
	<?php //$make_time +=  ($result['quantity']*$result['tt_make']);?>
	<tr class="<?php echo $color[$i]; $i=($i+1)%5; ?>">
		<td><?php echo $result['name']; ?></td>
		<td><?php echo $result['quantity']; ?></td>
		<td><?php  $price=$result['quantity']*$result['price']; 
		echo $price; 
		$amount+=$price;?></td>
	</tr>
<?php
		}
	}
	
	
?>
</table>
</div>
<div class="row">
	<h4 style="float:right;"><b>Total Price: <?php echo $amount; ?></b></h4><br><br>
	
</div>

</div>

