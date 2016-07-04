<?php 

 
class Customer{
     
    public $id;
    public $email;
    public $password;
    public $phone;
    public $fname;
    public $lname;
    public $shipping_address;
    public $shipping_city;
    public $shipping_state;
    public $shipping_zip;
    public $billing_address;
    public $billing_city;
    public $billing_state;
    public $billing_zip;
     
    function __construct($_id,$_email,$_password,$_phone,$_fname,$_lname,
                        $_shipping_address,$_shipping_city,$_shipping_state,$_shipping_zip,
                        $_billing_address,$_billing_city,$_billing_state,$_billing_zip)
    {
        $this->id = $_id;
        $this->email = $_email;
        $this->password = $_password;
        $this->phone = $_phone;
        $this->fname = $_fname;
        $this->lname = $_lname;
        $this->shipping_address = $_shipping_address;
        $this->shipping_city = $_shipping_city;
        $this->shipping_state = $_shipping_state;
        $this->shipping_zip = $_shipping_zip;
        $this->billing_address = $_billing_address;
        $this->billing_city = $_billing_city;
        $this->billing_state = $_billing_state;
        $this->billing_zip = $_billing_zip;
     
    }
    
    public static function insert($dbController,$email,$password,$phone,$firstName,$lastName) {
        $sql = "INSERT INTO customer (email,password,phone,fname,lname,
            shipping_address,shipping_city,shipping_state,shipping_zip )
            VALUES('$email','$password','$phone','$firstName','$lastName', "
                . "'unspecified','unspecified','unspecified','unspecified')";
 
        return $dbController->conn->query($sql);
    }
    public static function getCustomerByEmail($dbController, $email) {
        $sql = "SELECT * FROM customer WHERE email = '$email'";
        $result = $dbController->conn->query($sql);
        if (($result->num_rows) == 0)
            return false;

        $row = $result->fetch_assoc();
        $selectedCustomer = new Customer($row["id"], $row["email"], $row["password"], $row["phone"], 
                $row["fname"], $row["lname"],
                $row["shipping_address"], $row["shipping_city"], $row["shipping_state"], $row["shipping_zip"],
                $row["billing_address"], $row["billing_city"], $row["billing_state"], $row["billing_zip"]);

        return $selectedCustomer;
    }

}
     
?>