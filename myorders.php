<?php
	require('header.php');
	if(!isset($_SESSION['username'])){
		header('location:logout.php');
	}
	$color=array("success","danger","active","info","warning");
	$i=0;
	//$qry="SELECT orderid,make_timeprice,order_issue from orders where userid='".$_SESSION['email']."'";
	$qry="SELECT orderid,price,order_issue,served from orders where userid='".$_SESSION['email']."'";
	$execute=mysqli_query($link,$qry);
	$num=mysqli_num_rows($execute);
?>
<style>
div.table-responsive{
	border:2px solid purple;
}
hr {
	
  border-top: 1px solid red;
  height:30px;
  width:500px;
}
</style>
<br>
<div class="container">
	<div class="row">
		<h3><center><b>ORDERS LIST FOR YOU</b></center></h3>
		<hr align="center">
		<div class="table-responsive">

			<table class="table table-bordered table-hover">
			<tr>
			<th>ORDER ID</th>
			<th>PRICE</th>
			<th>ORDER_ISSUE_TIME</th>
			<th>SERVE STATUS</th>
			</tr>
			<?php
			if($num>0){
				while($result=mysqli_fetch_array($execute)){
				
			?>
			<tr class="<?php echo $color[$i]; $i=($i+1)%5; ?>">
			<td><a href="yourorder.php?id=<?php echo $result['orderid']; ?>"><?php echo $result['orderid']; ?></a></td>
			<td><?php echo $result['price']; ?></td>
			<td><?php echo $result['order_issue']; ?></td>
			<td><?php if ($result['served']==1) echo "served" ;else echo "unserved"?></td>
			<?php
				}
			?>
			<?php
				}
			?>
			</tr>
		</table>
	</div>
	</div>
</div>
