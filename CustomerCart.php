<?php 
require_once './MasterHeader.php'; 
 if (isset($_GET['ORDER']) && $_GET['ORDER'] === 'RequestCartOrders') {
    ob_end_clean();
    $orders = array();
    $products = array();
    $orders = $controller->getCustomerCart($customer->id);
    if ($orders == false)
        return;
    
    for ($i = 0; $i < count($orders); $i++) {
        $orderProduct = $controller->getProduct($orders[$i]->Productid);
        array_push($products, $orderProduct);
    }
    
    for($i=0;$i<count($products); $i++ ) {
?>
<div class="cartOrder col-sm-offset-1 col-sm-10" id="<?php echo $orders[$i]->transaction_id; ?>">
 
        <div class="cartOrderPic col-sm-2" >
            <img class="img-responsive" src='<?php echo $products[$i]->picture ?>'> 
        </div>
        <div class="carOrderTitle col-sm-6 ">
            <?php echo $products[$i]->name; ?>
        </div>
        <div class="cartOrderPrice  col-sm-2">
              <?php echo "$  ".$products[$i]->price; ?>
        </div>
         
  <div class="  col-md-2">
      <button class="btn btn-danger " onclick="removeFromCart(<?php echo $orders[$i]->transaction_id.
              ",".$orders[$i]->quantity.",". $orders[$i]->Productid?>)">Remove</button>
  </div>

</div>
<?php
    }
    
    return;
}

if(isset($_POST["ORDER"]) && $_POST["ORDER"]=== "RemoveCartItem") {
      ob_end_clean();
 
    echo $controller->removeCartItem($_POST["orderId"],$_POST["orderQuantity"] ,$_POST["productId"] ) ;

    return;
}
?>

 
  
<section class="cart">
    <div class="container">
        <div id="emptyCartMsg" class="text-center" style="display: none">Your cart is empty</div>
        <div class="cartOrders">
        </div>
    </div>
    <button class="btn btn-warning btn-lg" id="cartCheckoutBtn" style="display:none">Continue To Checkout</button>
</section>
<form name="cartForm" method="POST" style="display:none">	
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
		       <tr> 
		       		<td><input type='submit' name=update$i value='Update'></td>

	       	   		<td><input type='number' name=quantity$i value ='".$orders[$i]->quantity."' 
	       	   							min='1' max='" .($orders[$i]->quantity + $products[$i]->quantity)."' required></td>
		      		<td> Units</td>

		       </tr>
		       <tr>  <td><input type='submit' name = remove$i value='Remove'></td></tr> </tr>

		       </table>
		       
		       <br><br>
			";
			if(isset($_POST['update'.$i])){  
				if($controller->updateCart(  $orders[$i] , $products[$i] ,$_POST['quantity'.$i]) == true) 
					echo "<script>window.alert('Quantity updated');</script>";
				else
					echo "<script>window.alert('Error Updating !!!');</script>";

				echo "<script>window.location.replace('CustomerCart.php');</script>";
			}

			if(isset($_POST['remove'.$i])){  
					$controller->removeFromCart(  $orders[$i] , $products[$i]);
					echo "<script>window.alert('Product removed from your cart');</script>";
					echo "<script>window.location.replace('CustomerCart.php');</script>";
			}

		} 
	?>


</form>
    
<script>
    $(document).ready(function () {
        loadCartOrders();
    });
    function loadCartOrders() {
          $.get(location.pathname + "?ORDER=RequestCartOrders", function (data) {
                if(data === ""){
                    $("#emptyCartMsg").show();      
                }
                 else {
                     $('.cartOrders').html(data);
                     $("#cartCheckoutBtn").show();
                 }
                });      
    }
    function removeFromCart(orderId, orderQuantity, productId) {
        $.post(location.pathname, 
            { 
                ORDER: "RemoveCartItem",
                orderId:orderId,
                orderQuantity:orderQuantity,
                productId:productId } ,
            function(data){
                 
                if(data == 1) {
                    alert("Item removed");
                }
                else {
                    alert("error removing");
                }
                $("#"+orderId).remove();
                if($(".cartOrder").length === 0 )
                    $("#cartCheckoutBtn").hide();
                
        });
    }
    
    </script>
<?php 
require_once './MasterFooter.php';
?>