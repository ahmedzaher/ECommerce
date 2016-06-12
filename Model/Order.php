<?php

class Order {

    public $transaction_id ,$products, $time,  $date_shipped,  $shipping_company;
     

     function __construct($_transaction_id, $_time, $_date_shipped, $_shipping_company, $products) {
        $this->transaction_id = $_transaction_id; 
        $this->time = $_time; 
        $this->date_shipped = $_date_shipped; 
        $this->shipping_company = $_shipping_company;
        $this->products = $products; 
    }

 
     
    public static function delete($dbController, $orderId) {
        $sql = "DELETE FROM order_processing WHERE transaction_id = $orderId";
        return $dbController->conn->query($sql);
    }
    
    public static function purchase($dbController, $customerId, $ordersIds) {
        $ordersIdsArray = explode("|", $ordersIds); 
        $sqlCondition = "(";
        for ($i = 0; $i < count($ordersIdsArray); $i++) {

            $sqlCondition .= " transaction_id=$ordersIdsArray[$i]";
            if ($i < count($ordersIdsArray) - 1)
                $sqlCondition .=" OR";
        }
        if ($sqlCondition !== "(") {
            $sqlCondition .= ") AND";
        } else
            $sqlCondition = "";


        $sqlCondition .= " Customerid = '$customerId' ";
         
        $sql = "UPDATE order_processing SET processed = 1 , shipped = 1, date_shipped = now()  WHERE $sqlCondition";
        
        return $dbController->conn->query($sql);
    }
    public static function getProcessedOrders($dbController, $customerId) {
        $sql = "SELECT * FROM order_processing WHERE customerid = $customerId AND processed = '1' ";
        $result = $dbController->conn->query($sql); 
        
        if ($result->num_rows == 0) {
            return false;
        }
        $ordersArray = array();
        while ($row = $result->fetch_assoc()) {
           $order = new Order($row['transaction_id'], $row['time'], $row['date_shipped'] , $row['shipping_company'],null);
            array_push($ordersArray, $order);
        }
        return $ordersArray;
    }
    
    public static function placeOrder($dbController, $customerId, $productId, $productQuantity) { 
        // search for customer cart order
        $sql = "SELECT * FROM order_processing WHERE customerid = $customerId AND processed = '0' ";
        $result = $dbController->conn->query($sql);  
        //case of new order 
        if ($result->num_rows == 0) {
           $sql = "INSERT INTO order_processing(customerid,productid,quantity,processed,shipped)
						VALUES ($customerId,$productId,$productQuantity,0,0)"; 
           $dbController->conn->query($sql); 
           $transactionId =  $dbController->conn->insert_id;; // get last id
        // case of exist order
        } else {
            $row = $result->fetch_assoc();
            $transactionId = $row['transaction_id']; 
                            
        }
        
        //add product to cart
        $sql = "SELECT * FROM order_product WHERE transaction_id = $transactionId AND product_id = $productId";
        $result = $dbController->conn->query($sql);
        //case of new product
        if ($result->num_rows == 0) {
            
            $sql = "INSERT INTO order_product VALUES ($transactionId,$productId,$productQuantity)";
        }
        //case of exist product
        else {
            $row = $result->fetch_assoc();
            $productQuantity += $row['product_quantity'];
            $sql = "UPDATE order_product SET product_quantity = $productQuantity "
                    . "WHERE transaction_id =$transactionId AND product_id = $productId";
        }
         
        return $dbController->conn->query($sql);
         
    }
    
    public static function removeFromCart($dbController, $orderId , $product_id) {
        
        $sql = "DELETE FROM order_product WHERE transaction_id = $orderId AND product_id = $product_id";
        $dbController->conn->query($sql); 
              
        return true;
    }
    
    public static function getCart($dbController, $customerId) {
        // select transaction
        $sql = "SELECT * FROM order_processing WHERE processed = 0 AND customerid = $customerId";     
        $result = $dbController->conn->query($sql); 
         
        if ($result->num_rows == 0) {
            return false;
        }
        
        $row = $result->fetch_assoc();
        $transaction_id = $row["transaction_id"];
        $time = $row["time"];  
          
        //select transaction products
        $sql = "SELECT * FROM order_product WHERE transaction_id = $transaction_id"; 
        $result = $dbController->conn->query($sql);  
        
        if ($result->num_rows == 0) {
            return false;
        }
        $orderProducts = array();
        while($row = $result->fetch_assoc()) { 
            $orderProductId = $row["product_id"];
            
            $sql = "SELECT * FROM product WHERE id = $orderProductId";
            $result2 = $dbController->conn->query($sql); 
            $row2 = $result2->fetch_assoc();
             
            $orderProduct = Product::rowToProduct($row2);
            
            $orderProduct->quantity = $row["product_quantity"]; 
            array_push($orderProducts, $orderProduct);
            
        } 
         
         
        $cart = new Order($transaction_id, $time, null , null , $orderProducts); 
        return $cart;
        
    }

}
 