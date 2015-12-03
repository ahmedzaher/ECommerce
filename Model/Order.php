<?php

class Order {

    public $transaction_id, $Customerid, $Productid, $quantity, $time, $processed, $shipped, $date_shipped,
            $tracking_numbe, $shipping_company;

    function Order($_transaction_id, $_Customerid, $_Productid, $_quantity, $_time, $_processed, $_shipped, $_date_shipped, $_tracking_number, $_shipping_company) {
        $this->transaction_id = $_transaction_id;
        $this->Customerid = $_Customerid;
        $this->Productid = $_Productid;
        $this->quantity = $_quantity;
        $this->time = $_time;
        $this->processed = $_processed;
        $this->shipped = $_shipped;
        $this->date_shipped = $_date_shipped;
        $this->tracking_number = $_tracking_number;
        $this->shipping_company = $_shipping_company;
    }

    public static function getCustomerCart($dbController, $customerId) {
        $sql = "SELECT * FROM Order_Processing WHERE Customerid = $customerId AND processed = '0' ";
        $result = $dbController->conn->query($sql);
        if ($result->num_rows == 0) {
            return false;
        }
        $ordersArray = array();
        while ($row = $result->fetch_assoc()) {
            $order = new Order($row['transaction_id'], $row['Customerid'], $row['Productid'], $row['quantity'], $row['time'],
                    $row['processed'], $row['shipped'], $row['date_shipped'], $row['tracking_number'], $row['shipping_company']);
            array_push($ordersArray, $order);
        }
        return $ordersArray;
    }
    
    public static function delete($dbController, $orderId) {
        $sql = "DELETE FROM Order_Processing WHERE transaction_id = $orderId";
        return $dbController->conn->query($sql);
    }
}

?>