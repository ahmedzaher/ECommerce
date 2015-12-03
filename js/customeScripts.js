/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var access = 'guest';
$(document).ready(function () {
    $('#signUpLink').click(function () {
        $('#logInForm').hide();
        $('#signUpForm').fadeIn('slow');
    });
    $('#logInLink').click(function () {
        $('#signUpForm').hide();
        $('#logInForm').fadeIn();
    });
    //add to cart button
    $(document).on('click', '.addToCartBtn', function () {
        $.get(location.pathname + "?ORDER=AddToCart&product-id=" + $(this).attr("product-id"), function (data) {
            loadProducts($('#categorySelect').val(), $('#subCategorySelect').val());
        });
    });

    $(document).ajaxStart(function () {
        $('#wait').show();
    }).ajaxComplete(function () {
        $('#wait').hide();
    });
    $('.categoryFilter').change(function () {
        var categoriesURL = getCategoryFilterURL();
        var subCategoriesURL = getSubCategoryFilterURL();
        loadProducts(categoriesURL, subCategoriesURL);
    });
    $('.subCategoryFilter').change(function () {
        var categoriesURL = getCategoryFilterURL();
        var subCategoriesURL = getSubCategoryFilterURL();
        loadProducts(categoriesURL, subCategoriesURL);
    });
    function getCategoryFilterURL() {
        var categoriesURL = "";
        for (var i = 0; i < $('.categoryFilter').length; i++) {
            if ($('.categoryFilter')[i].checked === true) {
                categoriesURL += $('.categoryFilter')[i].value + "|";
            }
        }
        if (categoriesURL === "") {
            categoriesURL = "all";
        }
        console.log("1" + categoriesURL);
        return categoriesURL;
    }
    function getSubCategoryFilterURL() {
        var subCategoriesURL = "";
        for (var i = 0; i < $('.subCategoryFilter').length; i++) {
            if ($('.subCategoryFilter')[i].checked === true) {
                subCategoriesURL += $('.subCategoryFilter')[i].value + "|";
            }
        }
        if (subCategoriesURL === "") {
            subCategoriesURL = "all";
        }

        return subCategoriesURL;
    }

}); 
