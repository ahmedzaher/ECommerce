<?php 
 $logedIn = false;
if ((isset($_SESSION['ACCESS_TYPE']) && $_SESSION['ACCESS_TYPE'] == "CUSTOMER")) { 
     $logedIn = true;
}
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
            <a class="navbar-brand" href="#">IT</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="shopping.php">Home</a></li>
                <?php if ($logedIn) { ?>
                    <li ><a  href="cart.php">Cart</a></li> 
                    <li><a href="checkout.php">Checkout</a></li> 
                    <li ><a href="order-tracking.php">Track Order</a></li> 
                <?php } ?>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <!-- view login button if not login  --> 
                <?php if ($logedIn) { ?>
                    <li><a href="" ><span class="glyphicon glyphicon-user"></span>&nbsp;My Account</a></li>
                    <li ><a id="logout-header-btn" class="nav-btn"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Log out</a></li> 
                <?php } else { ?>
                    <li><a id="login-header-btn"  class="nav-btn"><span class="glyphicon glyphicon-log-in"></span>&nbsp;Log in</a></li> 
                <?php } ?>
            </ul>

            


        </div>
        <!-- BEGIN LOGIN FORM-->
            <div id="logInForm" class="col-md-3 col-sm-4 col-xs-12 text-center loginForm" style="display:none" > 
                <form>
                <h3>Login to Your Account</h3>
                <div class="input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
                    <input  type="text" id='login-email' class="form-control  " placeholder="Your Email"  
                            title="Please enter in a valid email address: example@example.com"  autocomplete="off" >
                </div>
                <br>
                <div class="input-group "> 
                    <div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
                    <input type="password" id="login-password" class="form-control" placeholder="Your Password"  >
                </div> 
                <br>

                <div class="input-group" style="margin:auto" >
                    <button type = "button" class="btn btn-primary login-btn" >Log In</button>
                </div>
                <br>
                <div class="form-group log-switch"> 
                    <div style="border-top: 1px solid #888; padding-top:15px; font-size:85%" >
                        Don't have an account?  
                        <a  id="to-signup-btn" >
                            Sign Up Here
                        </a>
                    </div> 
                </div> 
                </form>
            </div>
            <!-- END LOGIN FORM-->


            <!-- BEGIN SIGNUP FORM-->
            <div id="signupForm"  class="col-md-3 col-sm-4  signupForm" style="display:none"> 
                <form class="form-inline">
                    <h3 class="text-center">Register For Free  </h3>
                    <div class="form-group">
                        <label >Email </label>  
                        <input type="text" id="signup-email" class="form-control "   
                               title="Please enter in a valid email address: example@example.com" autocomplete="off" >
                    </div>
                    <div class="form-group">
                        <label for="" >Password  </label> 
                        <input type="password"  id="signup-password"  class="form-control"   >
                    </div>
                    <div class="form-group">
                        <label >Confirm Password </label> 
                        <input type="password"  id="signup-confirm-password"  class="form-control"   >
                    </div>
                    <div class="form-group">
                        <label >Phone </label> 
                        <input type="text" id="signup-phone" class="form-control" pattern="[0-9]{11,15}" 
                               title="Please enter in a valid phone number "  >
                    </div>
                    <div class="form-group">
                        <label  >First Name </label> 
                        <input  type="text" id="signup-firstName"  class="form-control"  pattern="[a-zA-Z ]{5,15}" 
                                title="Please enter in a valid name at least 5 letters Upper or Lower" >
                    </div>
                    <div class="form-group">
                        <label  >Last Name </label> 
                        <input  type="text" id="signup-lastName" class="form-control"  pattern="[a-zA-Z ]{5,15}" 
                                title="Please enter in a valid name at least 5 letters Upper or Lower" >
                    </div>

                    <div class="input-group" style="width:100%" >
                        <button type = "button" class="btn btn-primary signup-btn" style="display:block;margin:auto" >Sign Up</button>
                    </div> 
                    <br><br> 


                    <div class="log-switch text-center">
                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                            Already have an account ? 
                            <a id="to-login-btn"  >
                                Log In
                            </a>
                        </div>
                        <br>
                    </div>
                </form>
            </div>

            <!-- END SIGN FORM-->
    </div>
</nav> 