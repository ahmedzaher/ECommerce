<?php
  class DBController {
	public $conn;
	private	$servername; 
	private	$username ; 
	private	$password ; 
	private	$database ; 

	function DBController(){
		$this->servername = "localhost";
		$this->username = "root";
		$this->password = "";
		$this->database = "IT_Ecommerce";
		$this->conn = new mysqli($this->servername , $this->username , $this->password , $this->database);
		if($this->conn->connect_error)
			echo "<script> window.alert('Connecting To Database Failed');</script>"; 
	}
	function selectAdmin($_user_name){		
		$sql = "SELECT * FROM Admin WHERE user_name = '$_user_name'";  
		$result =  $this->conn->query($sql);  
		if( ($result->num_rows) == 0 )
			return false;

	 	$row = $result->fetch_assoc();	
	 	$selectedAdmin = new Admin($row['user_name'] , $row['password']);

	 	return $selectedAdmin;	
		} 
	/**************************************
		Filters
	*************************************/

	function getCategories(){
		$sql = "SELECT distinct category FROM Product "; 
		$result = $this->conn->query($sql);
		if($result->num_rows == 0)
			return false;

		$categories = array();
		while($row = $result->fetch_assoc() ){
			array_push($categories, $row['category']);
		}
        	return $categories;
	}
	function getSubCategories( ){
		$sql = "SELECT distinct  sub_category FROM Product";   
		$result = $this->conn->query($sql);
		if($result->num_rows == 0)
        		return false;
		$subCategories = array();
		while($row = $result->fetch_assoc() ){
			array_push($subCategories, $row['sub_category']);
		}

		return $subCategories;
	}
/***********************************************
	Customer
**************************************************/
	function selectCustomerByEmail($email){
		$sql = "SELECT * FROM Customer WHERE email = '$email'";
		$result = $this->conn->query($sql);
		if( ($result->num_rows) == 0 )
			return false;
	 	
	 	$row = $result->fetch_assoc();
	 	$selectedCustomer = new Customer($row["id"],$row["email"],$row["password"],$row["phone"],$row["fname"],$row["lname"],
	 									$row["shipping_address"],$row["shipping_city"],$row["shipping_state"],$row["shipping_zip"],
	 									$row["billing_address"],$row["billing_city"],$row["billing_state"],$row["billing_zip"] );

	 	return $selectedCustomer;
			 
	}
	function selectCustomerById($id){
		$sql = "SELECT * FROM Customer WHERE id = $id";
		$result = $this->conn->query($sql);
		if( ($result->num_rows) == 0 )
			return false;
	 	
	 	$row = $result->fetch_assoc();
	 	$selectedCustomer = new Customer($row["id"],$row["email"],$row["password"],$row["phone"],$row["fname"],$row["lname"],
	 									$row["shipping_address"],$row["shipping_city"],$row["shipping_state"],$row["shipping_zip"],
	 									$row["billing_address"],$row["billing_city"],$row["billing_state"],$row["billing_zip"] );

	 	return $selectedCustomer;
			 
	}

	function insertCustomer($customer){
		$sql = "INSERT INTO Customer (email,password,phone,fname,lname,
									  shipping_address,shipping_city,shipping_state,shipping_zip,
									  billing_address,billing_city,billing_state,billing_zip)
							
						VALUES('$customer->email','$customer->password','$customer->phone','$customer->fname','$customer->lname',
							'$customer->shipping_address','$customer->shipping_city','$customer->shipping_state','$customer->shipping_zip',
							'$customer->billing_address','$customer->billing_city','$customer->billing_state','$customer->billing_zip')";
 
		return $this->conn->query($sql);
 
	}	
	function updateCustomer($customer){ 
			$sql = "UPDATE Customer SET  
							password = '$customer->password',
							phone = '$customer->phone',
							fname = '$customer->fname',
							lname = '$customer->lname' ,
							shipping_address = '$customer->shipping_address',
							shipping_city = '$customer->shipping_city',
							shipping_state = '$customer->shipping_state',
							shipping_zip = '$customer->shipping_zip',
							billing_address = '$customer->billing_address',
							billing_city = '$customer->billing_city',
							billing_state = '$customer->billing_state',
							billing_zip = '$customer->billing_zip' 
						WHERE id = $customer->id "; 
         return $this->conn->query($sql);		
	}

	function selectAllCustomers(){
		$sql = "SELECT * FROM Customer";
		$result = $this->conn->query($sql);
		if($result->num_rows == 0 )
			return false;

		$customersArray = array();
		while ( $row = $result->fetch_assoc() ){
			$customer = new Customer($row["id"],$row["email"],$row["password"],$row["phone"],$row["fname"],$row["lname"],
	 								 $row["shipping_address"],$row["shipping_city"],$row["shipping_state"],$row["shipping_zip"],
	 								 $row["billing_address"],$row["billing_city"],$row["billing_state"],$row["billing_zip"] );

			array_push($customersArray, $customer);
		}
		return $customersArray;
	}
/***********************************************
	Product
**************************************************/
	function insertProduct($product) {
		$sql = "INSERT INTO Product (name,description,quantitiy,price,category,sub_category,visible,picture)
				VALUES ('$product->name','$product->description','$product->quantity',$product->price,
					'$product->category','$product->sub_category','$product->visible','imgs/products/$product->picture')";
		 
		return $this->conn->query($sql);			
	}

 
 
 

/**************************************************************************
		ORDERS
********************************************************/
	function selectExpiredOrders(){
		$sql = "SELECT * FROM Order_Processing WHERE time < ( now() - INTERVAL 1 HOUR ) AND processed = '0'";
//	$sql = "SELECT * FROM Order_Processing WHERE time < ( now() - INTERVAL 1 MINUTE ) ";
		$result = $this->conn->query($sql);
		if($result-> num_rows == 0)
			return false; 

		$expiredOrders = array();
		while( $row = $result->fetch_assoc() ) {
			$order = $this->selectOrder($row['transaction_id']);
			array_push($expiredOrders, $order);
		}

		return $expiredOrders;


	}
	function insertOrder($order){
			$sql = "INSERT INTO Order_Processing(Customerid,Productid,quantity,processed,shipped)
						VALUES ($order->Customerid,$order->Productid,$order->quantity,'$order->processed','$order->shipped' )"; 
 
			return $this->conn->query($sql); 
	}


	function deleteOrder($order){
		$sql = "DELETE FROM Order_Processing WHERE transaction_id = ".$order->transaction_id; 
		return $this->conn->query($sql); 
	}

	function updateOrder($order){
		$sql="UPDATE Order_Processing SET
			   		 quantity = $order->quantity,
			    	time = '$order->time',
			    	processed = '$order->processed',
			    	shipped = '$order->shipped',
			    	date_shipped = '$order->date_shipped',
			    	tracking_number = '$order->tracking_number',
			   		shipping_company = '$order->shipping_company'

			    WHERE transaction_id = $order->transaction_id ";   

		return $this->conn->query($sql);

	}

 	function selectOrder($id){
 		$sql = "SELECT * FROM Order_Processing WHERE transaction_id = $id";
 		$result = $this->conn->query($sql);
 		if($result-> num_rows == 0)
 			return false;

 		$row = $result->fetch_assoc();

 		$order = new Order(  $row['transaction_id'] , $row['Customerid'] , $row['Productid'] , $row['quantity'] ,
							$row['time'] ,$row['processed'] ,$row['shipped'] , $row['date_shipped'],
							$row['tracking_number']	, $row['shipping_company'] );

 		return $order;

 	}

	function selectAllOrders() {
		$sql = "SELECT * FROM Order_Processing ";
		$result = $this->conn->query($sql);

		if($result->num_rows == 0) 
			return false;  
			

		$ordersArray = array(); 
		while ($row = $result->fetch_assoc() ) {

			$order = new Order($row['transaction_id'] , $row['Customerid'] , $row['Productid'] , $row['quantity'] ,
								$row['time'] ,$row['processed'] ,$row['shipped'] , $row['date_shipped'],
								$row['tracking_number']	, $row['shipping_company'] );
 
 			array_push($ordersArray, $order);
		}
		return $ordersArray;
	} 	

	function setShippingTime($order){
		$sql = "UPDATE Order_Processing SET date_shipped = now() WHERE  transaction_id = $order->transaction_id ";
 
		return $this->conn->query($sql);
	}
}

 
?>