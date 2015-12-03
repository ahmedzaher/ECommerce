<?php
require_once './MasterHeader.php';
?>
 
 
<form method="POST">
Transaction ID : 
<input type="text"  name="transID" required  pattern="[0-9]{1,5}" title='Enter valid ID(numbers only)'>
<input type="submit" name="trackOrderButton" value="Track" >

</form> 

 
<?php 

$controller = new Controller();
 
$customer = unserialize($_SESSION['customer']);  

if(isset($_POST['trackOrderButton'])){ 
	$order = $controller->getOrder($_POST['transID']);
	if($order == false )
		echo "<center> <h4> Order not valid</h4> </center>"; 

	else if( $order->Customerid != $customer->id || $order->processed == "0")
		echo "<center> <h4> Order not availble</h4> </center>";

	else {

		$product = $controller->getProduct($order->Productid);

		echo "<table border='1'>
				<tr> <td>Product Name </td><td>$product->name</td> </tr>
				<tr> <td>Price </td><td>$product->price</td> </tr>
				<tr> <td>Quantity</td><td>$order->quantity</td> </tr>
				<tr> <td>Category</td><td>$product->category</td> </tr>
			 	<tr> <td>Sub-Category</td><td>$product->sub_category</td> </tr>
			 </table>";

		if($order->shipped == '1'){
			echo "<table border='1'>
				  <tr> <td>Shipping Date</td><td>$order->date_shipped</td> </tr>
				  <tr> <td>Shipping Company </td><td>$order->shipping_company</td> </tr>
				  <tr> <td>Tracking Number</td><td>$order->tracking_number</td> </tr>
				  </table>";
		}
		else {
			echo "<i><u>Not shipped yet</u></i>";
		}



	}
}
 

?>





