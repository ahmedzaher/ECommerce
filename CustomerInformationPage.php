<?php
require_once './MasterHeader.php'; 
$customer = unserialize($_SESSION['customer']);
if(isset( $_SESSION['admin']))
	$admin = unserialize($_SESSION['admin']);

if(isset($_POST["update"])) {
 
	$controller = new Controller();

	$updatedCustomer = new Customer($customer->id,$customer->email,$_POST["password"],$_POST["phone"],$_POST["fname"],$_POST["lname"],
	 					$_POST["shipping_address"],$_POST["shipping_city"],$_POST["shipping_state"],$_POST["shipping_zip"],
	 					$_POST["billing_address"],$_POST["billing_city"],$_POST["billing_state"],$_POST["billing_zip"] );
   
	$editResult= $controller->updateCustomer($updatedCustomer);


	if( $editResult == false) 		//Error Username Or Password
		$signUpError = "*Error Updating";
	
	else {
		echo "<script>window.alert('Successfully Updating') </script>";
		$_SESSION['customer'] =  serialize($updatedCustomer);
		$customer = $updatedCustomer;
		if(isset($_SESSION['admin']))
			echo "<script>location.href = 'AdminHomePage.php'; </script>";

		else
			echo "<script>location.href = 'CustomerHomePage.php'; </script>";

	 	
	}
}


?>

 
<form name="signupForm" method="POST">
<center>
<table >
<tr><td> Email  </td><td><i> <?php echo  $customer->email ; ?> </i></td></tr>
<tr><td> Password  </td><td><input name="password" type="password" required value=<?php echo  $customer->password; ?>  ></td></tr>
<tr><td> Phone: </td><td><input name="phone" type="text" required="required" required pattern="[0-9]{11,15}" 
											title="Please enter in a valid phone number "   
										   value= <?php echo  $customer->phone; ?>></td></tr>

<tr><td> First Name   </td><td><input name="fname" type="text" required pattern="[a-zA-Z ]{5,15}" 
									 title="Please enter in a valid name at least 5 letters Upper or Lower"  
									value=<?php echo  $customer->fname; ?>></td></tr>
<tr><td> Last Name  </td><td><input name="lname" type="text"  required pattern="[a-zA-Z ]{5,15}" 
									title="Please enter in a valid name at least 5 letters Upper or Lower"  
									value=<?php echo  $customer->lname; ?> ></td></tr>

<tr><td> Shipping Address   </td><td><input name="shipping_address" type="text"   required="required"  value=<?php echo  $customer->shipping_address; ?>></td></tr>
<tr><td> Shipping State   </td><td><input name="shipping_state" type="text"   required="required" value=<?php echo  $customer->shipping_state; ?> ></td></tr>
<tr><td> Shipping City   </td><td><input name="shipping_city" type="text" required="required" value=<?php echo  $customer->shipping_city; ?> ></td></tr>
<tr><td> Shipping Zip    </td><td><input name="shipping_zip" required="required" value=<?php echo $customer->shipping_zip; ?> ></td></tr>
<tr><td> Billing Address   <i>(Optional)</i> </td><td><input name="billing_address" type="text" value=<?php echo  $customer->billing_address; ?>  ></td></tr>
<tr><td> Billing City  <i>(Optional)</i> </td><td><input name="billing_city" type="text" value= <?php echo  $customer->billing_city; ?>  ></td></tr>
<tr><td> Billing State  <i>(Optional)</i>  </td><td><input name="billing_state" type="text" value=<?php echo  $customer->billing_state; ?> ></td></tr>
<tr><td> Billing Zip  <i>(Optional)</i> </td><td><input name="billing_zip" type="text" value=<?php echo  $customer->billing_zip; ?>   ></td></tr>
</table>
</center>
	<center><input type="submit" name = "update" value="Update" > </center></td>
</form>

 