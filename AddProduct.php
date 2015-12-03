<?php
require_once './MasterHeader.php';
$controller = new Controller();
//$categories = $controller->getCategories();

if(isset($_POST['create'])){
 
	$product = new Product(0,$_POST['name'],$_POST['description'],$_POST['quantity'],$_POST['price'],
					$_POST['category'],$_POST['sub_category'],$_POST['image'],"");

	$result = $controller->createProduct($product); 
	if($result == true) {
		echo "<script>window.alert('Product Created Successfully');</script>";
		echo "<script> location.href='Store.php' ;</script>";
	}
}


?>
 

<center>
<table >
<form name="createForm" method="POST"> 
 
<tr><td> Name  </td><td><input name="name" type="text" required="required"></td></tr>
<tr><td> Description   </td><td><textarea  name="description" row="8" cols="50" required="required"></textarea></td></tr>
<tr><td> Quantity   </td><td><input name="quantity" type="number" min="0" required="required"></td></tr>
<tr><td> Price   </td><td><input name="price" type="text" required="required" pattern="[0-9]{1,5}" title='not valid price'  ></td></tr>
<tr><td> Category   </td> <td><input name="category" type="text" required="required"></td> </tr>
<tr><td>Sub-Category </td> <td><input name="sub_category" type="text" required="required"></td> </tr>
<tr><td>Image </td> <td><input name="image" type="text"  ></td> </tr>
 
 
 
<tr><td><center><input type="submit" value="Create" name="create" ><center> </td></tr>
</form>
 </table>
</center>
</body>
</html>