<?php
require_once './MasterHeader.php';
$controller = new Controller();
 
$customer = unserialize($_SESSION['customer']);
$orders = array();

$ordersResult = $controller->getCustomerCart($customer); 
if($ordersResult != false )
	$orders=$ordersResult;


$products = array();
for($i = 0  ; $i < count($orders) ; $i++ ){ 
	$orderProduct = $controller->getProduct($orders[$i]->Productid); 
	array_push($products, $orderProduct);



 

} 

?>

 

<center>
<fieldset>
	<legend>Shipping Information</legend>
<table >
	<tr><td>Shipping Address</td><td><?php echo $customer->shipping_address ;?></td></tr>
	<tr><td>Shipping City</td><td><?php echo $customer->shipping_city ;?></td></tr>
	<tr><td>Shipping State</td><td><?php echo $customer->shipping_state ;?></td></tr>
	<tr><td>Shipping Zip</td><td><?php echo $customer->shipping_zip ;?></td></tr>
</table>
</fieldset>
</center>
<br>
<center>
<fieldset>
	<legend>Billing Information</legend>
<table>
	<tr><td>Billing Address</td><td><?php echo $customer->billing_address ;?></td></tr>
	<tr><td>Billing City</td><td><?php echo $customer->billing_city ;?></td></tr>
	<tr><td>Billing State</td><td><?php echo $customer->billing_state ;?></td></tr>
	<tr><td>Billing Zip</td><td><?php echo $customer->billing_zip ;?></td></tr>
</table>
</fieldset>
</center>
<br><br>

<fieldset>
<legend>Your Products</legend>
<form name="checkoutForm" method="POST">	
	<?php
	if(count($orders) == 0)
		echo "<center><h3>Your cart is empty </center></h3>";
	for($i=0 ; $i<count($orders) ; $i++) {
		echo " <fieldset>
			   <legend> Order ID  ".$orders[$i]->transaction_id ."</legend>
			   
			   <table > 
			   <tr> <td>Name </td><td>".$products[$i]->name."</td></tr>
			   <tr> <td>Description </td><td>".$products[$i]->description."</td></tr>
			   <tr> <td>Quantity In Stock </td><td>".$products[$i]->quantity."</td></tr>
			   <tr> <td>Quantity In Cart </td><td>".$orders[$i]->quantity."</td></tr>
		       <tr> <td>Price </td><td>".$products[$i]->price."</td></tr>
		       <tr> <td>Category </td><td>".$products[$i]->category."</td></tr>
		       <tr> <td>Sub-Category </td><td>".$products[$i]->sub_category."</td></tr> 
		       </table>
		        </fieldset>
		       <table >
		       <tr>  <td><input type='submit' name = purchase$i value='Purchase'> </td></tr>
		       </table>
		       </center>
		       <br><br> ";

			if(isset($_POST['purchase'.$i])){  
				if($controller->purchase( $orders[$i]) == true) { 
					$_SESSION['transaction_id'] = $orders[$i]->transaction_id;
					$_SESSION['fname'] = $customer->fname;
					$_SESSION['lname'] = $customer->lname;
					header('location: Successfull.php');
				}

				
				else
					echo "<script>window.alert('Error Purchasing !!!');</script>";	
 
				//header('location: CustomerHomePage.php');									
			}
		 

		} 

	?>

</fieldset>
</form>

</body>

</html>




