<?php
require_once '../MasterHeader.php';


 

//add to cart
if (isset($_GET['ORDER']) && $_GET['ORDER'] === 'AddToCart') {
    ob_end_clean();
    $result = $controller->addToCart($_GET['product-id'], 1); //1 refer to quantity
    echo $result;
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
    $(".navbar-item").removeClass("active");
    $(".navbar-item").has("a[href='shopping.php']").addClass("active");
    $(document).ready(function () {
        loadProducts("all", "all");
        
    });
    //loadProducts
    function loadProducts(categoryFilterURL, subCategoryFilterURL) {
        showLoading();
        $.get( "../../Controller/controller.php" + "?REQUEST=LOAD_SHOPPING_PRODUCTS&category=" + categoryFilterURL + "&sub-category=" + subCategoryFilterURL,
                function (data) {
                    $('#products').empty().html(data);
                    hideLoading();
                });
    }




</script>
<?php
require_once '../MasterFooter.php';
?>
 
