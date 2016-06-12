<?php 
class Product {

    public $id;
    public $name;
    public $time;
    public $description;
    public $quantity;
    public $price;
    public $category;
    public $sub_category;
    public $visible;
    public $picture;

    function Product($_id, $_name, $_time, $_description, $_quantity, $_price, $_category, $_sub_category, $_picture, $_visible) {
        $this->id = $_id;
        $this->name = $_name;
        $this->time = $_time;
        $this->description = $_description;
        $this->quantity = $_quantity;
        $this->price = $_price;
        $this->category = $_category;
        $this->sub_category = $_sub_category;
        $this->picture = $_picture;
        $this->visible = $_visible;
    }

    public function update($dbController) {
 
    
        		$sql = "UPDATE product SET name = '$this->name', description = '$this->description', quantitiy = "
                                . "$this->quantity, price = $this->price, category = '$this->category', sub_category = "
                                . "'$this->sub_category', visible = '$this->visible', picture = '$this->picture'
          		WHERE id = $this->id "; 
                        
         return   $dbController->conn->query($sql);
        
    }
    public static function getProduct($dbController, $productId) {
            $sql = "SELECT * FROM product WHERE id = $productId";
            $result = $dbController->conn->query($sql);
           
            if($result->num_rows == 0 ) {
                    return false;
            }
            $row = $result->fetch_assoc();
            
            return new Product($row['id'], $row['name'] , $row['time'],$row['description'] , $row['quantitiy'] ,$row['price'] ,
                                             $row['category'] , $row['sub_category'] ,$row['picture'], $row['visible']  );
   
    }
    public static function getProducts($dbController, $categories, $subCategories, $isVisable) { //when isVisable is true 0 quantity products will be shown
        
        $condition = "1";
        if(! $isVisable ) {
            $condition = " visable='1'";
        }
         
        if($subCategories != "all") {
            $condition .= " AND ( sub_category = '$subCategories[0]'";
            for($i = 1 ; $i < count($subCategories) ; $i++ ){
                $condition .= " OR sub_category = '$subCategories[$i]'";
            }
            $condition .= ")";
        }
        else if($categories != "all") {
            $condition .= " AND ( category = '$categories[0]'";
            for($i = 1 ; $i < count($categories) ; $i++ ){
                $condition .= " OR category = '$categories[$i]'";
            }
            $condition .= ")";
        }
        if($isVisable === "false") {
            $condition .= " AND (visible = '1')";
        }
        $sql = "SELECT * FROM product WHERE $condition ";  
        $result = $dbController->conn->query($sql);
        
        if ($result->num_rows == 0) {
            return false;
        }
        $productsArray = array();
        while ($row = $result->fetch_assoc()) {
            $product = Product::rowToProduct($row);

            array_push($productsArray, $product);
        }
        return $productsArray;
    }
    
    public static function rowToProduct($row) {
        $product = new Product($row['id'],$row['name'], $row['time'], $row['description'], $row['quantitiy'], $row['price'], 
                $row['category'], $row['sub_category'], $row['picture'], $row['visible']);
        
        return $product;
    }

}

?>