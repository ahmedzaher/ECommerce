<?php
require_once './MasterHeader.php';

$loginError = "";
$spaceError = "";
$controller = new Controller();

$controller->refreshStock();

if (isset($_POST["login"])) {
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $spaceError = "*Fill Empty Fields";
    }

    $controller = new Controller();

    $accessType = substr($_POST["email"], strpos($_POST["email"], "@") + 1) === 'it-admin' ? 'admin' : 'customer';

    $user = "";
    if ($accessType == 'admin')   //log in as admin
        $user = $controller->logInAdmin($_POST["email"], $_POST["password"]);


    else if ($accessType == 'customer') //log in as customer
        $user = $controller->logInCustomer($_POST["email"], $_POST["password"]);


    if ($user == false)  //Error Username Or Password
        $loginError = "*LogIn Error";

    else {

        if ($accessType == 'admin') {
            $_SESSION["ACCESS_TYPE"] = 'ADMIN';
            $_SESSION["admin"] = serialize($user);
            header('location: AdminHomePage.php');
        } else if ($accessType == 'customer') {
            $_SESSION["ACCESS_TYPE"] = 'CUSTOMER';
            $_SESSION["customer"] = serialize($user);
            header('location: Shopping.php');
        }
    }
}
$signUpError=""; 

if(isset($_POST["signup"])) {
 
	$controller = new Controller();
	$customer = new Customer(0,$_POST["regEmail"],$_POST["regPassword"],$_POST["regPhone"],$_POST["regFName"],$_POST["regLName"],
	 					$_POST["shipping_address"],$_POST["shipping_city"],$_POST["shipping_state"],$_POST["shipping_zip"],
	 					$_POST["billing_address"],$_POST["billing_city"],$_POST["billing_state"],$_POST["billing_zip"] );
  
        if(substr($_POST["regEmail"], strpos($_POST["regEmail"], "@") + 1) === 'it-admin') {
            $signUpError = "Not valid"; 
        }
        else {
            $signUpResult= $controller->signUpCustomer( $customer);


            if( $signUpResult == false) 		//Error Username Or Password
                    $signUpError = "*Already Exist";

            else {
                    echo "<script>window.alert('Successfully Signed Up') </script>";
                    echo "<script>location.href = 'index.php'; </script>"; 
            }
        }
}
?>

<div id="index" class="text-center"> 
        <div class="row text-center">
            <div>  
                <span style="color: #FF0000;"><?php echo $loginError; ?></span>
                <span style="color: #FF0000;"><?php echo $signUpError;?></span>
                <span style="color: #FF0000;"><?php echo $spaceError; ?></span>
            </div> 

            <div id="logInForm" class="col-sm-4 col-sm-offset-4" >
                <form name="login" method="POST" class="form-inline" > 
                    <h3>Login to Your Account</h3>
                    <div class="input-group col-sm-11 ">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
                        <input name="email" type="text" id='txtEmail' class="form-control   " placeholder="your email" pattern="[a-zA-Z0-9_.-]{3,}@[a-zA-Z]{3,}[.]{1}[a-zA-Z0-9_.-]{3,}{2,}" 
                               title="Please enter in a valid email address: example@example.com" autocomplete="autocomplete">
                    </div>
                    <br>
                    <div class="input-group col-sm-11"> 
                        <div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
                        <input name="password" type="password" id='txtEmail' class="form-control  " id="password" >
                    </div> 
                    <br>

                    <div class="input-group col-sm-8">
                        <button type = "Submit" Name = "login" class="btn btn-primary" >Log In</button>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-md-12 control">
                            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                Don't have an account! 
                                <a id="signUpLink"   >
                                    Sign Up Here
                                </a>
                            </div>
                        </div>
                    </div>
                </form>  
            </div>
            <div id="signUpForm"  class="col-sm-6 col-sm-offset-3" style="display:none">
                <form name="signup" method="POST" class="form-horizontal" > 
                    <h3>Register For Free  </h3>
                    <div class="form-group">
                        <label for="regEmail" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-8">
                            <input name="regEmail" type="text" id="regEmail" class="form-control " required pattern="[a-zA-Z0-9_.-]{3,}@[a-zA-Z]{3,}[.]{1}[a-zA-Z0-9_.-]{3,}{2,}" 
                                   title="Please enter in a valid email address: example@example.com"  >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="regPassword" class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-8">
                            <input name="regPassword" id="regPassword" type="password" class="form-control" required  >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="regPhone" class="col-sm-3 control-label">Phone</label>
                        <div class="col-sm-8">
                            <input name="regPhone" type="tel" required class="form-control" pattern="[0-9]{11,15}" 
                                   title="Please enter in a valid phone number "  >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="regFName" class="col-sm-3 control-label">First Name</label>
                        <div class="col-sm-8">
                            <input name="regFName" type="text"   class="form-control" required pattern="[a-zA-Z ]{5,15}" 
                                   title="Please enter in a valid name at least 5 letters Upper or Lower" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="regLName" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-8">
                            <input name="regLName" class="form-control" required pattern="[a-zA-Z ]{5,15}" 
                                   title="Please enter in a valid name at least 5 letters Upper or Lower"
                                   type="text"   required="required" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="regShippingAddress" class="col-sm-3 control-label">Shipping Address</label>
                        <div class="col-sm-8">
                            <input name="shipping_address" id="regShippingAddress" class="form-control"
                                   type="text"   required="required" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="regBillingAddress" class="col-sm-3 control-label">Billing Address (Optional)</label>
                        <div class="col-sm-8">
                            <input name="billing_address" id="regBillingAddress" class="form-control"
                                   type="text"  >
                        </div>
                    </div>

                    <div class="input-group col-sm-12">
                        <button type = "Submit" name = "signup" class="btn btn-success" >Register</button>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 control">
                            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                
                                <a id="logInLink"  >
                                    Log In
                                </a>
                            </div>
                        </div>
                    </div>

            </div>
        </div>

    </div>
</div>

</div> 
</div>
<?php
require_once './MasterFooter.php';
?>