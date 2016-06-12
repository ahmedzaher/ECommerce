<?php
require_once 'Model/Admin.php';
require_once 'Model/Customer.php';
require_once 'Model/Product.php';
require_once 'Model/Order.php';
require_once '../../DBController.php';
class Controller {
	private $dbController; 

	function Controller(){
		$this->dbController = new DBController();
	}
	function logInAdmin($username , $password){
		$selectedAdmin = $this->dbController->selectAdmin($username);
 			
		if($selectedAdmin == false)  //not found
			return false;

		if($selectedAdmin->password != $password ) //pw error
			return false;

		return $selectedAdmin;
	}
	function refreshStock(){
		
		
		$expiredOrders = $this->dbController->selectExpiredOrders();
		if($expiredOrders == false )
			return true;

		if( count($expiredOrders)  == 0 )
			return true;
 
		for($i=0 ; $i<count($expiredOrders) ; $i++ ){
			$cartProduct = $this->getProduct( $expiredOrders[$i]->Productid );
		//	$this->removeFromCart($expiredOrders[$i] , $cartProduct);
		}

		return true;
	}
	/*********************************************
		Filter
	**********************************************/

	function getAllCategories(){
		return $this->dbController->getCategories();
	}

	function getAllSubCategories(){ 
		return $this->dbController->getSubCategories();
	}

	/**********************************
		Customer
	***********************************/
	function logInCustomer($email , $password){
		$selectedCustomer = $this->dbController->selectCustomerByEmail($email);
 			
		if($selectedCustomer == false)  //not found
			return false;

		if($selectedCustomer->password != $password ) //pw error
			return false;

		return $selectedCustomer;
	}

	function getCustomer($id){
		return  $this->dbController->selectCustomerById($id);
	}

 
	function updateCustomer($customer){ 
		return $this->dbController->updateCustomer($customer);
	}

	function getAllCustomers(){
		return $this->dbController->selectAllCustomers();
	}

	/******************************************************
		Product
	****************************************************/
	function createProduct($product){
		if($product->quantity > 0 )
			$product->visible='1';
		else
			$product->visible='0';

		return $this->dbController->insertProduct($product);  // true / false

	}
 
        function getProducts($urlCategories, $urlSubCategories, $isVisable) { 
            $categories = "all";
            if($urlCategories != "all") {
                $categories = explode("|",$urlCategories);
            }
            $subCategories = "all";
            if($urlSubCategories != "all") {
                $subCategories = explode("|",$urlSubCategories);
            }            
            
            $products = Product::getProducts($this->dbController, $categories, $subCategories, $isVisable);
        
            return $products;
        }

	function updateProduct($product){ 
		if($product->quantity > 0 )
			$product->visible='1';
		else
			$product->visible='0';
 
		return Product::update($this->dbController);
	}



	function getProduct($productId){
		return Product::getProduct($this->dbController, $productId);
	}

	/**********************************
			Order Options
	**********************************/
	function getOrder($transaction_id) {
		return $this->dbController->selectOrder($transaction_id);
	}

	function getAllOrders(){
		return $this->dbController->selectAllOrders();
	}
	 
  
 	function ship($order , $shippingCompany , $trackingNumber) {
 		$order->shipped = "1";
 		$order->shipping_company = $shippingCompany;
 		$order->tracking_number = $trackingNumber;
 		if ($this->dbController->updateOrder($order) == false)
 			return false;

 		if ($this->dbController->setShippingTime($order) == false)
 			return false;

 		return true;
 		

 	}




}




?>