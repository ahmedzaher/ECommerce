<?php
include("Controller.php");
session_start();
$signUpError=""; 

if(isset($_POST["signup"])) {
 
	$controller = new Controller();
	$customer = new Customer(0,$_POST["email"],$_POST["password"],$_POST["phone"],$_POST["fname"],$_POST["lname"],
	 					$_POST["shipping_address"],$_POST["shipping_city"],$_POST["shipping_state"],$_POST["shipping_zip"],
	 					$_POST["billing_address"],$_POST["billing_city"],$_POST["billing_state"],$_POST["billing_zip"] );
  
	$signUpResult= $controller->signUpCustomer( $customer);


	if( $signUpResult == false) 		//Error Username Or Password
		$signUpError = "*Already Exist";
	
	else {
		echo "<script>window.alert('Successfully Signed Up') </script>";
		echo "<script>location.href = 'index.php'; </script>";

	 	
	}
}




?>

<html>
<head>
	<title>Sign Up New Customer</title>
</head>
<style type="text/css">
@import "css/buttons.css";
</style>
<body >
	<div>
    	<span style="color: #FF0000;"><?php echo $signUpError;?></span>  
     </div>
<center>
<table >
<form name="signupForm" method="POST">

<tr><td> Email  </td><td><input name="email" type="text"  required pattern="[a-zA-Z]{3,}@[a-zA-Z]{3,}[.]{1}[a-zA-Z]{2,}" 
										title="Please enter in a valid email address: example@example.com"></td></tr>

<tr><td> Password  </td><td><input name="password" type="password" required  ></td></tr>
<tr><td> Phone: </td><td><input name="phone" type="tel" required pattern="[0-9]{11,15}" 
									title="Please enter in a valid phone number "  ></td></tr>

<tr><td> First Name   </td><td><input name="fname" type="text"   required pattern="[a-zA-Z ]{5,15}" 
										title="Please enter in a valid name at least 5 letters Upper or Lower" ></td></tr>

<tr><td> Last Name  </td><td><input name="lname" required pattern="[a-zA-Z ]{5,15}" 
										title="Please enter in a valid name at least 5 letters Upper or Lower"
										type="text"   required="required" ></td></tr>

<tr><td> Shipping Address   </td><td><input name="shipping_address" class="form-control"
type="text"   required="required" ></td></tr>
<tr><td> Shipping State   </td><td><input name="shipping_state" class="form-control"
type="text" class="form-control"  required="required" ></td></tr>
<tr><td> Shipping City   </td><td><input name="shipping_city"
type="text"  class="form-control" required="required" ></td></tr>
<tr><td> Shipping Zip    </td><td><input name="shipping_zip"
type="text"  class="form-control" required="required" ></td></tr>
<tr><td> Billing Address   <i>(Optional)</i> </td><td><input name="billing_address"
type="text" class="form-control" ></td></tr>
<tr><td> Billing City  <i>(Optional)</i> </td><td><input name="billing_city"
type="text" class="form-control" ></td></tr>
<tr><td> Billing State  <i>(Optional)</i>  </td><td><input name="billing_state"
type="text" class="form-control" ></td></tr>
<tr><td> Billing Zip  <i>(Optional)</i> </td><td><input name="billing_zip"
type="text" class="form-control" ></td></tr>

<tr>
	<td><center> <input type="submit" name = "signup" value="Sign Up" class = 'navButton'> </center></td>
	<td> <center> <input type="Reset" class = 'navButton'> </center> </td>
</tr> 
</</table>
</body>
</html>