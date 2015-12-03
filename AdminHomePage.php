  
  
<?php 
require_once './MasterHeader.php';
$admin =  unserialize($_SESSION['admin']);
echo "<h4> Welcome, $admin->user_name</h4>";
?>
<center>
<table>
<tr><td><button  onClick="goToStore()" class ="homeButton">Products Store</button></td></tr>
<tr><td> <button  onClick="goToCustomers()" class ="homeButton">Customers Information</button> </td></tr>
<tr><td> <button  onClick="goToShipping()" class ="homeButton">Shipping Page</button> </td></tr>
<tr><td> <button   onClick="logOut()" class ="homeButton">Log Out</button> </td></tr> 
</table>
</center>
<script>
  function goToStore() {
  	location.href ="Store.php";
  }
    function goToCustomers() {
  	location.href ="CustomersInfo.php";
  }
    function goToShipping() {
  	location.href ="Shipping.php";
  }
    function logOut() {
  		location.href ="logout.php";
  }
</script>
