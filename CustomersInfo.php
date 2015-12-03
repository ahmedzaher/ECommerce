<?php
require_once './MasterHeader.php';
$controller = new Controller();
$customers = $controller->getAllCustomers();


?>

 
	<fieldset>
		<legend>All System Customers</legend>
	<form name="customersForm" method="POST">
		
			<?php
			for($i=0 ; $i<count($customers) ; $i++) {
				echo "<fieldset>
						<legend>Customer ".$customers[$i]->id."</legend>
					   	<table>
					  	<tr> <td>Name </td><td>".$customers[$i]->fname." ".$customers[$i]->lname."</td></tr>
					  	<tr> <td>E-mail </td><td>".$customers[$i]->email."</td></tr>
					  	<tr> <td>Phone </td><td>".$customers[$i]->phone."</td></tr>
				      	<tr> <td>Shipping Address </td><td>".$customers[$i]->shipping_address."</td></tr>
				      	<tr> <td>Shipping State </td><td>".$customers[$i]->shipping_city."</td></tr>
				      	<tr> <td>Shipping Zip </td><td>".$customers[$i]->shipping_state."</td></tr>
				      	<tr> <td>Shipping City </td><td>".$customers[$i]->shipping_zip."</td></tr>
				      	<tr> <td>Billing Address </td><td>".$customers[$i]->billing_address."</td></tr>
				      	<tr> <td>Billing City </td><td>".$customers[$i]->billing_city."</td></tr>
				      	<tr> <td>Billing State </td><td>".$customers[$i]->billing_state."</td></tr>
				      	<tr> <td>Billing Zip </td><td>".$customers[$i]->billing_zip."</td></tr> 
				      	<tr><td><input type='submit' name=cust$i value='Update'></td></tr>
				      </table>
					  </fieldset>
					";

					if(isset($_POST['cust'.$i])){ 
								$_SESSION['customer']=serialize($customers[$i] );
								echo "<script>location.href ='CustomerInformationPage.php';</script>";
							//	header('location:CustomerInformationPage.php');
					}

				} 
			?>

 
	</form>
 