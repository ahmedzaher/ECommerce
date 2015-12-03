<?php
require_once './MasterHeader.php';
$controller = new Controller();

session_start();
$admin = unserialize($_SESSION['admin']); 

$processedOrders = array();
$result = $controller->getAllProcessedOrders();
if($result != false)
	$processedOrders = $result;

$products = array();
$customers = array();
$nPocessedOrders= count($processedOrders);
for($i=0 ; $i < $nPocessedOrders; $i++){

	$customer = $controller->getCustomer( $processedOrders[$i]->Customerid  );
	array_push($customers, $customer);

	$product  = $controller->getProduct( $processedOrders[$i]->Productid  ); 
	array_push($products, $product);	
}
 

?>
<html>
<head>
	<title>Shipping Page</title> 
</head>

<body> 
<?php  include('AdminHeadBar.php');  ?>	
<form  method='POST'>
<?php

	if(count($processedOrders) == 0 )
		echo "<h4><center>No orders</center></h4>";

	for($i=0 ; $i<count($processedOrders); $i++) {
		echo " 
			  <fieldset>
			   <legend> Transaction ID  ".$processedOrders[$i]->transaction_id ."</legend>
			   <fieldset>
			   <table >
			   <legend> Customer ID  ".$customers[$i]->id ."</legend>
				   <tr><td>Name </td><td>".$customers[$i]->fname."</td><td>".$customers[$i]->lname."</td></tr>  
				   <tr><td>Shipping Address </td><td>".$customers[$i]->shipping_address."</td> </tr>  
				   <tr><td>Shipping City </td><td>".$customers[$i]->shipping_city."</td> </tr>  
				   <tr><td>Shipping State </td><td>".$customers[$i]->shipping_state."</td> </tr>  
				   <tr><td>Shipping zip </td><td>".$customers[$i]->shipping_zip."</td> </tr>  
			   </table>
			   </fieldset>
			  

				
				<fieldset>
					<legend>Billing Information</legend>
				<table>
					<tr><td>Billing Address</td><td><?php echo $customer->billing_address ;?></td></tr>
					<tr><td>Billing City</td><td><?php echo $customer->billing_city ;?></td></tr>
					<tr><td>Billing State</td><td><?php echo $customer->billing_state ;?></td></tr>
					<tr><td>Billing Zip</td><td><?php echo $customer->billing_zip ;?></td></tr>
				</table> 
				</fieldset>
				
		       

		       
		       <fieldset>
				<legend>Product Information</legend> 
				<table>
			   		<tr> <td>Quantity  </td><td>".$processedOrders[$i]->quantity."</td></tr>
		       		<tr> <td>Price </td><td>".$products[$i]->price."</td></tr>
		       		<tr> <td>Category </td><td>".$products[$i]->category."</td></tr>
		       		<tr> <td>Sub-Category </td><td>".$products[$i]->sub_category."</td></tr> 
 				</table>
 				</fieldset> 		 

		       <fieldset>
				<legend>Shipping Information</legend> 
				<table>
			   		<tr> <td>Tracking Number </td><td><input type='number' name = trackingNumber$i  ></td></tr>
		       		<tr> <td>Shipping Company </td><td><input type='text' name = shippingCompany$i   ></td></tr> 
		            <tr> <td><input type='submit' name = ship$i value='Ship'></td></tr> 	
 				</table>
 				</fieldset>

 				</fieldset>				
	        
 
		       <br><br>
			";
			if(isset($_POST['ship'.$i])){  
				$controller = new Controller();
				if( !isset($_POST['shippingCompany'.$i])  || !isset($_POST['trackingNumber'.$i]))
					echo "<script>window.alert('Fill Empty Fields !!!');</script>";

				else if($controller->ship(  $processedOrders[$i] , $_POST['shippingCompany'.$i] , $_POST['trackingNumber'.$i] ) == true){
					echo "<script>window.alert('Product Shipped Successfully');</script>";
					header('location: Shipping.php');
				} 
					
				else
					echo "<script>window.alert('Error Shipping !!!');</script>";
  
			}
		}


?>
</form>

 
 


 

</body>

</html>




