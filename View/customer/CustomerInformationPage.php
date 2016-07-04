<?php
require_once '../MasterHeader.php'; 
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

 

    <div class="">
        <div class="col-md-3 col-xs-12 account-img">
            <img style="width:70%;margin-left:10%" src="../../imgs/user.png">
        </div>
        <div class="col-md-9 col-xs-12s account-fields">
            <form name="signupForm" method="POST" class="form-inline">
                <div class="account-field">
                    <label class="account-label">Email</label><span> <?php echo $customer->email; ?> </span>
                </div>
                <div class="account-field">
                    <label class="account-label">First Name</label><input class="form-control" name="fname" type="text" required pattern="[a-zA-Z ]{5,15}" 
                                                                          title="Please enter in a valid name at least 5 letters Upper or Lower"  
                                                                          value=<?php echo $customer->fname; ?>>
                </div>
                <div class="account-field">
                    <label class="account-label">Last Name</label><input class="form-control" name="lname" type="text" required pattern="[a-zA-Z ]{5,15}" 
                                                                          title="Please enter in a valid name at least 5 letters Upper or Lower"  
                                                                          value=<?php echo $customer->lname; ?>>
                </div>
                
                <div class="account-field">
                    <label class="account-label">Password</label><input class="form-control" name="password" type="password" required  
                                                                          value=<?php echo $customer->password; ?>>
                </div>
                
                <div class="account-field">
                    <label class="account-label">Phone</label><input class="form-control" name="phone" type="text" required pattern="[0-9]{11,15}" 
                                                                     title="Please enter in a valid phone number "   
                                                                     value= <?php echo $customer->phone; ?>>
                </div>
                <div class="account-field">
                    <label class="account-label">Shipping Address</label><input class="form-control" name="shipping_address" type="text" required  
                                                                     value= <?php echo $customer->shipping_address; ?>>
                </div>
                <div class="account-field">
                    <label class="account-label">Shipping State</label><input class="form-control" name="shipping_state" type="text" required  
                                                                     value= <?php echo $customer->shipping_state; ?>>
                </div>
                <div class="account-field">
                    <label class="account-label">Shipping City</label><input class="form-control" name="shipping_city" type="text" required  
                                                                     value= <?php echo $customer->shipping_city; ?>>
                </div>
                <div class="account-field">
                    <label class="account-label">Shipping Zip</label><input class="form-control" name="shipping_zip" type="text" required  
                                                                     value= <?php echo $customer->shipping_zip; ?>>
                </div>
                <div class="account-field">
                    <label class="account-label">Billing Address <i>(Optional)</i> </label><input class="form-control" name="billing_address" type="text"    
                                                                     value= <?php echo $customer->billing_address; ?>>
                </div>
                <div class="account-field">
                    <label class="account-label">Billing City <i>(Optional)</i> </label><input class="form-control" name="billing_city" type="text"    
                                                                     value= <?php echo $customer->billing_city; ?>>
                </div>
                <div class="account-field">
                    <label class="account-label">Billing State <i>(Optional)</i> </label><input class="form-control" name="billing_state" type="text"  
                                                                     value= <?php echo $customer->billing_state; ?>>
                </div>
                <div class="account-field">
                    <label class="account-label">Billing Zip <i>(Optional)</i> </label><input class="form-control" name="billing_zip" type="text"     
                                                                     value= <?php echo $customer->billing_zip; ?>>
                </div>
                
                <div style="position: relative;top: 10px;">
                    <input  style="position: absolute;left:10%" class="btn btn-success" type="submit" name = "update" value="Update" >
                    <a href="shopping.php"><input  style="position: absolute;right:20%;" class="btn btn-default " type="" name = "" value="Back" >  </a>
                </div>
                
            </form>
        </div>
    </div>
 
<script>
    $(".navbar-item").removeClass("active");
    $(".navbar-item").has("a[href='CustomerInformationPage.php']").addClass("active");
</script>
 

 <?php 
require_once '../MasterFooter.php';
?>