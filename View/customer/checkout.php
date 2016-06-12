<?php
require_once '../MasterHeader.php';

$customer = unserialize($_SESSION["customer"]);
$cartOrder = Order::getCart($dbController, $customer->id);

//no items in cart
if ($cartOrder == false) {
    $cartOrder = [];
}
?>
<div class="customerInfo col-sm-3 col-xs-1">
    <div class="panel panel-info ">
        <div class="panel-heading">Customer Information</div>
        <div class="panel-body"> 
            <span style="color:rgba(85, 85, 85, 0.71);">Name : </span> &nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;
            <span style="font-size: 17px;"><?php echo $customer->fname . " " . $customer->lname; ?> </span>
             <br><br>
             
             <span style="color:rgba(85, 85, 85, 0.71);">Phone :</span> &nbsp;&nbsp;
            <input type="text" class="form-control" style="display: inline;width:auto;" value="<?php echo $customer->phone; ?>">
            <br><br>
            <span style="color:rgba(85, 85, 85, 0.71);">Shipping Address :</span> &nbsp;&nbsp;
            
            <textarea style="margin: 0px; height: 95px; width: 276px;" class="form-control">
                <?php echo $customer->shipping_address; ?>
            </textarea>
        </div>


    </div>
</div>

<div class="col-sm-7 col-xs-12">
    <div class="panel panel-info  ">
  <div class="panel-heading">Order Summary</div>
  <div class="panel-body">  
<?php

 $cartProducts = array();
if($cartOrder != false) {
    $cartProducts = $cartOrder->products; 
}
$totalPrice = 0;
for ($i = 0; $i < count($cartProducts); $i++) { 
    $totalPrice += $cartProducts[$i]->price * $cartProducts[$i]->quantity;
    ?>
    <div class="checkout-order" id="<?php echo $cartOrder->transaction_id; ?>">

        <div class="" style="font-size: 17px;font-style: italic">
            <?php echo $cartProducts[$i]->name; ?>
        </div>
        <div class="" style="color:rgba(85, 85, 85, 0.71);">
            <?php echo "$  " . $cartProducts[$i]->price; ?>
        </div>
        <div class="" style="color:rgba(85, 85, 85, 0.71);">
            <?php 
                $q = $cartProducts[$i]->quantity;
                echo $q;                
                echo  ($q > 1)?" Units":" Unit" ;
            ?>  
        </div>
        <hr>



    </div>
    <?php 
}

if (count($cartProducts) == 0) {
    echo "<div class='text-center'>No item in your cart to purchase</div>";
}
else {
?>
      <div style="font-size: 17px;color:rgb(51, 127, 183);font-style: italic">
          Total Price : $ <?php echo $totalPrice; ?>
      </div>

<br> 
<button class="btn btn-info purchase-btn">Purchase</button>
&nbsp;&nbsp;
<a href="cart.php"><button class="btn ">Back To Cart</button></a>
<?php }
?>
</div>
</div>
<script>
    $(".purchase-btn").click(function () {
        var ordersIds = "";
        for (var i = 0; i < $(".checkout-order").length; i++) {
            ordersIds += $($(".checkout-order")[i]).attr('id');
            if (i < $(".checkout-order").length - 1) {
                ordersIds += "|";
            }
        }

        $.get("../../Controller/controller.php?REQUEST=PURCHASE&ordersIds=" + ordersIds, function (data) {
            if (data === "OK") {
                alert("Done");

            } else {
                alert("Failed");
            }
            document.location.assign("shopping.php");
        });
    });
</script>
