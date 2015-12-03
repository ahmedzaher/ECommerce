<?php
    require_once './MasterHeader.php';
    if(isset($_GET['ORDER']) && $_GET['ORDER'] === 'RequestSubCategories') { 
        echo '<script>document.write("");</script>';
        echo '<br><br>TEEEEEEEEEEEEEEEEEEEEEST<br><br>';
        ob_end_clean();
        $subCategories = $controller->getAllSubCategories($_GET['category']);
        for ($i = 0; $i < count($subCategories); $i++) {
            echo "<option value=$subCategories[$i]> $subCategories[$i]</option>";
         } 
         return;
    }
?>

<div id="filter"> 
    <select name='categorySelect' id="categorySelect">
        <option>All Categories</option> 
        <?php
            for ($i = 0; $i < count($categories); $i++) 
                echo "<option value=$categories[$i]> $categories[$i]</option>";
                                
        ?>
    </select> 
    <select name='subCategorySelect' id="subCategorySelect">
        <option>All Sub-Categories</option>
    </select>
    
     
</div>
<script>
    $(document).ready(function(){
       $('#categorySelect').change(function(){
            $.get(location.pathname+"?ORDER=RequestSubCategories&category="+$('#categorySelect').val(), function(data){
                console.log( data);
                $('#subCategorySelect').empty().text(data); 
        });
       });
    });
</script>
<html>
   
    <body>
    <filter>
        <fieldset>
            <legend>Filter Option</legend>
            <form name="filterForm" method="POST">
                <table>
                    <tr>
                        <td>Category</td>
                        <td>
                            <select name='categorySelect'>
                                <option>All Categories</option>
                                <?php
                                for ($i = 0; $i < count($categories); $i++) {
                                    echo "<option value=$categories[$i] ";
                                    if (isset($_POST['categorySelect']))
                                        if ($categories[$i] == $_POST['categorySelect'])
                                            echo "selected";
                                    echo "> $categories[$i]</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>  

                    <tr>
                        <td>SubCategory</td>
                        <td>
                            <select name='subCategorySelect'>
                                <option>All Sub-Categories</option>
<?php
if (isset($_POST['categorySelect']))
    $subCategories = $controller->getAllSubCategories($_POST['categorySelect']);
for ($i = 0; $i < count($subCategories); $i++) {
    echo "<option value=$subCategories[$i] ";
    if (isset($_POST['subCategorySelect']))
        if ($subCategories[$i] == $_POST['subCategorySelect'])
            echo "selected";
    echo "> $subCategories[$i]</option>";
}
?>		
                            </select>
                        </td>
                        <td><input type = "submit" name="refreshSubCategriesButton" value="Refresh"></td>
                    </tr> 
                    <tr><td><input type = "submit" name="filterButton" value="Filter" class='navButton'></td></tr>
                </table>
            </form>
        </fieldset>
        <br><br>
<?php
if (isset($_POST['refreshSubCategriesButton'])) {
    $selectedCategory = $_POST['categorySelect'];
    $subCategories = $controller->getAllSubCategories($selectedCategory);
}
if (isset($_POST['filterButton'])) {
    $selectedCategory = $_POST['categorySelect'];
    $selectedSubCategory = $_POST['subCategorySelect'];
    $products = array();
    $result = $controller->getProducts("DontShowHidden", $selectedCategory, $selectedSubCategory);
    if ($result != false)  //no products
        $products = $result;
}
?>
    </filter>
 