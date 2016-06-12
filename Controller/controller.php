<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$GLOBALS["ROOT_PATH"] = "../".__DIR__;
require_once '../DBController.php';
require_once '../Model/Customer.php';
require_once '../Model/Product.php';
require_once '../Model/Order.php';
$dbController = new DBController();
if (isset($_POST["REQUEST"]) && $_POST["REQUEST"] == "SIGNUP") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];
    $firstName = $_POST["firstname"];
    $lastName = $_POST["lastname"];
    
    $customer = Customer::getCustomerByEmail( $dbController , $email);
     
    if($customer != false) {  //already exist 
            echo "Failed";
            return;
    } 
    
    if (! Customer::insert($dbController,$email,$password,$phone,$firstName,$lastName) ) {
        echo "Failed";
    }
    echo "OK";
      
}
if (isset($_POST["REQUEST"]) && $_POST["REQUEST"] == "LOGIN") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $customer = Customer::getCustomerByEmail( $dbController , $email);
    if ($customer == false || $customer->password != $password) {
        echo "Failed";
    } else {
        session_start();
        $_SESSION["ACCESS_TYPE"] = 'CUSTOMER';
        $_SESSION["customer"] = serialize($customer);
        echo $_SESSION["ACCESS_TYPE"] . "OK";
    }
}

if (isset($_POST["REQUEST"]) && $_POST["REQUEST"] == "LOGOUT") {
    session_start();
    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy();
}



if (isset($_GET["REQUEST"]) && $_GET["REQUEST"] == "LOAD_SHOPPING_PRODUCTS") {
    $categories = $_GET["category"];
    $subCategories = $_GET["sub-category"];

    if ($categories != "all") {
        $categories = explode("|", $categories);
    }

    if ($subCategories != "all") {
        $subCategories = explode("|", $subCategories);
    }

    $products = Product::getProducts($dbController, $categories, $subCategories, "false"); // false to hide zero quantity
    for ($i = 0; $i < count($products); $i++) {
        ?>
        <div class="productOuter col-md-4 col-sm-6">
            <div class="product col-md-offset-1 col-md-11 "> 
                <div class="productPicture" style=" ">
                    <img class="img-responsive" src='<?php echo "../../" . $products[$i]->picture ?>'> 
                </div>
                <div class="productTitle" style=" ">
        <?php echo $products[$i]->name; 
        ?>
                </div>
                <div class="productDescription" style=" ">
                    <?php echo nl2br($products[$i]->description) ?>
                </div> 
                <div class="productPrice" style=" ">
                    $ <?php echo $products[$i]->price ?>
                </div>

                <div class="productOrder" style="">
                    <button class="addToCartBtn btn btn-primary col-xs-offset-1 col-xs-10" product-id='<?php echo $products[$i]->id; ?>' quantity='<?php echo $products[$i]->id; ?>' >
                        <i class="fa fa-shopping-cart" style="margin-right:7px"></i>
                        Add To Cart
                    </button>
                </div>
            </div>
        </div>
        <?php
    }
}

if (isset($_GET["REQUEST"]) && $_GET["REQUEST"] == "LOAD_CART") {
    session_start();
    $customer = unserialize($_SESSION["customer"]);
    $cartOrder = Order::getCart($dbController, $customer->id);

    //no items in cart
    if ($cartOrder == false) {
        echo "Empty";
        return;
    }

    $cartProducts = $cartOrder->products;
     
    for ($i = 0; $i < count($cartProducts); $i++) {
        ?>
        <div class="cartOrder col-sm-offset-1 col-sm-10" id="<?php echo $cartOrder->transaction_id; ?>">

            <div class="cartOrderPic col-sm-2" >
                <img class="img-responsive" src='../../<?php echo $cartProducts[$i]->picture ?>'> 
            </div>
            <div class="carOrderTitle col-sm-6 ">
        <?php echo $cartProducts[$i]->name; ?>
            </div>
            <div class="cartOrderPrice  col-sm-2">
                <?php echo "$  " . $cartProducts[$i]->price; ?>
            </div>

            <div class="  col-md-2">
                <button class="btn btn-danger " onclick="removeFromCart(<?php
                echo $cartOrder->transaction_id . ",".$cartProducts[$i]->quantity."," . $cartProducts[$i]->id
                ?>)">Remove</button>
            </div>

        </div>
        <?php
    }
}

if (isset($_POST["REQUEST"]) && $_POST["REQUEST"] == "ADD_TO_CART") {
    session_start();
    $customer_id = unserialize($_SESSION["customer"])->id;
    $product_id = $_POST["product_id"];
    $order_quantity = $_POST["order_quantity"];
    $product = Product::getProduct($dbController, $product_id);
     
    if (Order::placeOrder($dbController, $customer_id, $product->id, $order_quantity) == false) { // create order row
        echo "Failed1";
        return;
    }

    $product->quantity = $product->quantity - $order_quantity;    //update Product quantity
    if ($product->quantity === 0)
        $product->visible = 0;

    if ($product->update($dbController) == false) {
        echo "Failed";
        return;
    }
    echo "OK";
    return;
}
if (isset($_GET["REQUEST"]) && $_GET["REQUEST"] == "REMOVE_FROM_CART") {
    session_start();
    $productId = $_GET["productId"];
    $orderId = $_GET["orderId"]; 
    $orderQuantity = $_GET["orderQuantity"];
    
    if (!Order::removeFromCart($dbController, $orderId , $productId , $orderQuantity)) {
        echo "Failed";
        return;
    }

     
    $product = Product::getProduct($dbController, $productId);

    $product->quantity += $orderQuantity;  // return product into stock
    $product->visible = 1;

    if (!$product->update($dbController)) {
        echo "Failed";
        return;
    }
    echo "OK";
}

if (isset($_GET["REQUEST"]) && $_GET["REQUEST"] == "PURCHASE") {
    session_start();
    $customer_id = unserialize($_SESSION["customer"])->id;
    $orders_ids = $_GET["ordersIds"]; 
    
    if (Order::purchase($dbController, $customer_id, $orders_ids)) {
        echo "OK";
    } else {
        echo "Failed";
    }
    return;
}

if (isset($_GET["REQUEST"]) && $_GET["REQUEST"] == "TRACK_ORDERS") { 
    session_start();
    $customer_id = unserialize($_SESSION["customer"])->id;

    $processedOrders = Order::getProcessedOrders($dbController, $customer_id);
    if($processedOrders == false ) {
        echo "Failed";
        return;
    }
    
    foreach ($processedOrders as $order) {
        ?>
        <div class="trarcked-order" id="<?php echo $order->transaction_id ?>">
            <div class="panel panel-success">
                <div class="panel-heading">
                    Transaction Number : <?php echo $order->transaction_id ?>
                </div>
                <div class="panel-body">
                    Order Date : <?php  echo date("l jS F Y", strtotime($order->time));   ?><br>
                    Order Time : <?php  echo date("h:i:s A", strtotime($order->time));   ?><br>
                    <br>
                    <?php if ($order->date_shipped == null) { ?> 
                Status : Not Shipped Yet ! <br>
        <?php } else { ?>
                Status : Shipped <br>
                Shipping Date : <?php echo date("l jS F Y", strtotime($order->date_shipped)); ?> <br>
                Shipping Time : <?php echo date("h:i:s A", strtotime($order->date_shipped)); ?> <br> 
               <!-- Shipping Company : <?php/* echo $order->shipping_company*/ ?> <br>  -->
            <?php } ?> 
                </div>
            </div> 
        

        </div> 

 
    <?php
    } 
}



