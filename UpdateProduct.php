<?php
require_once './MasterHeader.php';
$controller = new Controller();
//$categories = $controller->getCategories();

$product = unserialize($_SESSION['product']);  
if(isset($_POST['update'])){
 
	$updatedProduct = new Product($product->id,$_POST['name'],$_POST['description'],$_POST['quantity'],$_POST['price'],
					$_POST['category'],$_POST['sub_category'],$_POST['image'],"");

	$result = $controller->updateProduct($updatedProduct ); 
 
	if($result == true) {
		echo "<script> window.alert('Product Created Updated');</script>";
		echo "<script> location.href = 'Store.php' ;</script>"; 
	}
}


?>
 
<center>
<table >
<form name="updateForm" method="POST">  
<tr><td> Name  </td><td> <input name="name" type="text" required="required"  value= <?php echo $product->name; ?> > </td></tr>
<tr><td> Description   </td><td><textarea  name="description" row="4" cols="50" required="required" >
	   <?php echo $product->description ;?> </textarea></td></tr>
<tr><td> Quantity   </td><td><input name="quantity" type="number" min="0" required="required" value= <?php echo $product->quantity ;?>></td></tr>
<tr><td> Price   </td><td><input name="price" type="text" required="required" value= <?php echo $product->price ;?> 
					pattern="[0-9]{1,5}" title='not valid price' ></td></tr>
<tr><td> Category   </td>
	<td> 
		<select name="category">
			<?php
			/*
				for($i=0 ; $i<count($categories) ; $i++){
					echo "<option value=$categories[$i]> $categories[i]";
				}
			*/
			?>

		</select>
	</td>
	<td><input name="category" type="text" required="required"  value= <?php echo $product->category ;?> > </td>
</tr>

<tr><td>Sub-Category </td>
	<td> 
		<select name="category">
			<?php
			/*
				for($i=0 ; $i<count($subCategories) ; $i++){
					echo "<option value=$subCategories[$i]> $categories[i]";
				}
			*/
			?>

		</select>
	</td>
	<td><input name="sub_category" type="text" required="required"  value= <?php echo $product->sub_category ;?> ></td>

</tr>
<tr><td>Image </td> <td><input name="image" type="text"  ></td> </tr>
 
<tr><td><center><input type="submit" value="Update" name="update" > </tr>
</center></td><td><center><br> 
</body>
</html>