<?php 
require_once '../MasterHeader.php';    
 
?>
  
<section class="cart">
    <div class="container">
        <div id="emptyCartMsg" class="text-center" style="display: none">Your cart is empty</div>
        <div class="cartOrders">
        </div>
    </div>
    <a href="checkout.php">
    <button class="btn btn-warning btn-lg" id="cartCheckoutBtn" style="display:none">Continue To Checkout</button>
    </a>
</section>
 
    
<script>
    $(".navbar-item").removeClass("active");
    $(".navbar-item").has("a[href='cart.php']").addClass("active");
    $(document).ready(function () {
        loadCartOrders();
    });
    function loadCartOrders() {
          $.get( "../../Controller/controller.php" + "?REQUEST=LOAD_CART", function (data) {
                if(data === "Empty"){
                    $("#emptyCartMsg").show();      
                }
                 else {
                     $('.cartOrders').html(data);
                     $("#cartCheckoutBtn").show();
                 }
                });      
    }
    function removeFromCart(orderId, orderQuantity, productId) {
        $.get( "../../Controller/controller.php", 
            { 
                REQUEST: "REMOVE_FROM_CART",
                orderId:orderId,
                orderQuantity:orderQuantity,
                productId:productId } ,
            function(data){ 
                if(data == "OK") {
                    showSuccess("Item removed");
                }
                else {
                    showError("error removing");
                }
                $("#"+orderId).remove();
                if($(".cartOrder").length === 0 ){
                    $("#cartCheckoutBtn").hide();
                    $("#emptyCartMsg").show(); 
                }
                
        });
    }
    
    </script>
<?php 
require_once '../MasterFooter.php';
?>