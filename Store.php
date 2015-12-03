<?php
require_once './MasterHeader.php';
$controller = new Controller();
$admin = $_SESSION['admin'];
$products = $controller->getProducts("showHidden" , "all" , "all");
?>
<html>
<head>
	<script>
	function addProduct() {
		location.href = "AddProduct.php"; 
	} 
	</script>
</head>

<body> 
	<button name="add" onClick = "addProduct()">Add New Product</button><br> <br>

		<legend>Store Products</legend>
	<form name="storeForm" method="POST">
		
		
			<?php
			for($i=0 ; $i<count($products) ; $i++) {
				echo "<table border='2'>
					  <tr> <td>Name </td><td>".$products[$i]->name."</td></tr>
					  <tr> <td>Description </td><td>".$products[$i]->description."</td></tr>
					  <tr> <td>Quantity </td><td>".$products[$i]->quantity."</td></tr>
				      <tr> <td>Price </td><td>".$products[$i]->price."</td></tr>
				      <tr> <td>Category </td><td>".$products[$i]->category."</td></tr>
				      <tr> <td>Sub-Category </td><td>".$products[$i]->sub_category."</td></tr> 
				      <tr><td><input type='submit' name=prod$i value='Update'></td></tr>
				      </table>
				      <br>
					";

					if(isset($_POST['prod'.$i])){ 
								$_SESSION['product']=serialize($products[$i] ); 
								echo "<script>location.href ='UpdateProduct.php';</script>";
							//	header('location:UpdateProduct.php');
					}

				}
					//<tr><td><button onClick='updateProduct($i);'>Update</button></td></tr>
			?>

 
	</form>
	</fieldset>
</body>

</html>