<?php
require_once './MasterHeader.php';


//load products
if (isset($_GET['ORDER']) && $_GET['ORDER'] === 'RequestProducts') {
    ob_end_clean();
    $products = $controller->getProducts($_GET['category'], $_GET['sub-category'], "false"); //false to hide 0 quantity products
    for ($i = 0; $i < count($products); $i++) {
        ?>
        <div class="productOuter col-md-4 col-sm-6">
            <div class="product col-md-offset-1 col-md-11 "> 
                <div class="productPicture" style=" ">
                    <img class="img-responsive" src='<?php echo $products[$i]->picture ?>'> 
                </div>
                <div class="productTitle" style=" ">
                    <?php echo $products[$i]->name ?>
                </div>
                <div class="productDescription" style=" ">
                    <?php echo nl2br($products[$i]->description) ?>
                </div> 
                <div class="productPrice" style=" ">
                    $ <?php echo $products[$i]->price ?>
                </div>

                <div class="productOrder" style="">
                    <button class="addToCartBtn btn btn-primary col-xs-offset-1 col-xs-10" product-id='<?php echo $products[$i]->id; ?>' quantity='<?php echo $products[$i]->id; ?>' >
                        <i class="fa fa-shopping-cart" style="margin-right:7px"></i>
                        Add To Cart
                    </button>
                </div>
            </div>
        </div>
        <?php
    }
    return;
}

//add to cart
if (isset($_GET['ORDER']) && $_GET['ORDER'] === 'AddToCart') {
    ob_end_clean();
    $result = $controller->addToCart($_GET['product-id'], 1); //1 refer to quantity
    if ($result == true) {
        echo 'OK';
    } else {
        echo 'FAILED';
    }
    return;
}

$categories = $controller->getAllCategories();
$subCategories = $controller->getAllSubCategories();
?>
<div class="container">
    <div id="filter" class="filter col-xs-2"> 
        <h3>Products</h3>
        <hr>
        <?php
        for ($i = 0; $i < count($categories); $i++) {
            echo "<div class='checkbox'><label><input type='checkbox' class='categoryFilter' value='$categories[$i]' >$categories[$i]</label></div>";
        }
        ?>
        <br>
        <h3>Brands</h3>

        <hr>
        <?php
        for ($i = 0; $i < count($subCategories); $i++) {
            echo "<div class='checkbox'> <label><input type='checkbox' class='subCategoryFilter' value='$subCategories[$i]' >$subCategories[$i]</label></div>";
        }
        ?>        
        <select name='categorySelect' id="categorySelect" class="form-control" style="display:none">
            <option value="all">All Categories</option> 
            <?php
            for ($i = 0; $i < count($categories); $i++) {
                echo "<option value='$categories[$i]'> $categories[$i]</option>";
            }
            ?>
        </select>  

        <select name='subCategorySelect' id="subCategorySelect" class="form-control" style="display:none">
            <option value="all">All Sub-Categories</option>
        </select>  
    </div>
    <div  class=" col-xs-offset-2  col-xs-10">
        <div id="products">

        </div>

    </div>
</div>
<script>
    $(document).ready(function () {
        loadProducts("all", "all");
    });
    //loadProducts
    function loadProducts(categoryFilterURL, subCategoryFilterURL) {
        $.get(location.pathname + "?ORDER=RequestProducts&category=" + categoryFilterURL + "&sub-category=" + subCategoryFilterURL,
                function (data) {
                    $('#products').empty().html(data);
                });
    }




</script>
<?php
require_once './MasterFooter.php';
?>
 
