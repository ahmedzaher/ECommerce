<?php 
require_once './MasterHeader.php';
$customer = unserialize( $_SESSION['customer'] );
echo "<h4> Welcome, ".$customer->fname."</h4>"; 
?>

<html>
<head>
<title> Customer Home Page</title>

</head>
<script>
  function startShopping() {
    location.href ="Shopping.php";
    }

  function goToCart() {
      location.href ="CustomerCart.php";
    }
    function goToCheckout() {
      location.href ="Checkout.php";
  }
    function editInformation() {
    location.href ="CustomerInformationPage.php";
  }
    function trackOrders() {
    location.href ="OrderTracking.php";
  }

  function goOut(){  
      location.href ="logout.php";
  }
 
</script>
<style>
 @import "css/buttons.css";
</style>

<body >

<center>
<table > 
<tr><td><center><input type="button" name="Start_Shopping " value="Start Shopping" onClick="startShopping();" class ="homeButton"> </center></td></tr>
<tr><td><center><input type="button" name="My_Cart" value="My Cart" onClick="goToCart();" class ="homeButton"></center></td></tr>
<tr><td><center><input type="button" name="checkoutButton" value=" Checkout " onClick="goToCheckout();" class ="homeButton"></center></td></tr>
<tr><td><center><input type="button" name="My_Account" value="My Account " onClick="editInformation();" class ="homeButton"> </center></td></tr>
<tr><td><center><input type="button" name="Track_Orders " value="Track Orders " onClick="trackOrders();"class ="homeButton"></center></td></tr>
<tr><td><center><input type="submit" name="Logout" value="Log Out" onClick="goOut();" class ="homeButton"> </center></td></tr>
</table>
</center>
<?php 
require_once './MasterFooter.php'; 
?>