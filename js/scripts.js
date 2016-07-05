/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var access = 'guest';
 
$(document).ready(function () {  
       hideLoading();
     // view login form
     $(document).on('click','#login-header-btn',function(){ 
        if($("#logInForm").css("display") !== "none") {
            $("#logInForm").fadeOut("slow");
        } else if ($("#signupForm").css("display") !== "none") {
            $("#signupForm").fadeOut("slow");
        } else 
            $("#logInForm").fadeIn("slow");
    });
    
    $(document).on('click','#logout-header-btn',function(){ 
         $.post("../../Controller/controller.php",{REQUEST:"LOGOUT"},function(data){
                if( data === "Failed") {
                    showError("LOGOUT ERROR");
                    return;
                } 
                location.reload(false); 
                
            });
    });

    //switch from login form to signup form
    $("#to-signup-btn").click(function(){
        $("#logInForm").fadeOut("slow");
        $("#signupForm").fadeIn("slow");
    });

    //switch from signup form to login form
    $("#to-login-btn").click(function(){
        $("#signupForm").fadeOut("slow");
        $("#logInForm").fadeIn("slow");
    });


    //login validation and process 
    $(".login-btn").click(function(){
        var email = $("#login-email").val(); 
        var password = $("#login-password").val();
        var validationResult = checkLoginForm(email,password );
        if( validationResult["msg"] !== "OK") {
            
            showError(validationResult["msg"]);
        } else {
            $.post("../../Controller/controller.php",{REQUEST:"LOGIN",email:email,password:password},function(data){
                if( data === "Failed") {
                    showError("incorrect user");
                    return;
                }  
                location.reload(); 
                
            });
            
        }
    });
    

    //signup validation and process 
    $(".signup-btn").click(function(){
        var validationResult = [];
        validationResult = checkSignupForm();
        if( validationResult["msg"] != "OK") {
            
             showError(validationResult["msg"]);
        } 
       else {
            showLoading();
            $.post("../../Controller/controller.php",
                    {
                        REQUEST:"SIGNUP",
                        email:$("#signup-email").val(),
                        password:$("#signup-password").val(),
                        phone:$("#signup-phone").val(),
                        firstname:$("#signup-firstName").val(),
                        lastname:$("#signup-lastName").val()
                    },
                function(data){ 
                    if (data == "OK") {
                        showSuccess("Registered Successfully")
                    }
                    else {
                        showError("Rigistration Failed");
                        return;
                    }   
                    hideLoading();
            });
            
        }
    });
    $("#login-email , #signup-email").focusout(function(){
            if(isValidEmail ($(this).val()) ) {
                $(this).removeClass("notValid");
            } else {
                $(this).addClass("notValid");
            }
    });

    $("#phone").focusout(function(){
        if(isValidPhone() ($(this).val()) ) {
                $(this).removeClass("notValid");
            } else {
                $(this).addClass("notValid");
            }
    });

    $("#signup-confirm-password").focusout(function() {
        var password = $("#signup-password").val();
         var confirmPassword = $("#signup-confirm-password").val();
         
         if(isValidConfirmedPassword(password,confirmPassword)) {
             $(this).removeClass("notValid");
         } else {
              $(this).addClass("notValid");
         }
    });

     

  //END LOGIN AND SIGN UP SCRIPTS
  
 
    //add to cart button
    
    $(document).on('click', '.addToCartBtn', function () { 
        showLoading();
        var product_id = $(this).attr("product-id") ;
        var order_quantity = 1;
        $.post("../../Controller/controller.php",
        {
            REQUEST:"ADD_TO_CART",
            product_id: product_id ,
            order_quantity:order_quantity 
        },function(data){  
            if(data !== "OK") {
                showError(data); 
            }
            else {
                showSuccess("Item added to cart");
                loadProducts($('#categorySelect').val(), $('#subCategorySelect').val());
            }
            hideLoading();
        }); 
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

   
    
function showSuccess(msg) {

	$(".alert-msg").html( " <div class='alert alert-success'> "
		+"<a href='#' class='close' data-dismiss='alert'"
		+" aria-label='close'>&times;</a>"
		+"<strong>Success! </strong> "+ msg +" &nbsp;&nbsp; </div> ");
}
function showError(msg) {
	$(".alert-msg").html( " <div class='alert alert-danger '> "
		+"<a href='#' class='close' data-dismiss='alert'"
		+" aria-label='close'>&times;</a>"
		+"<strong>Error! </strong> "+ msg +"  &nbsp;&nbsp;</div> ");
}

function showLoading() {
    $(".loading-overlay").fadeIn(1000);
    $("body").css("overflow", "hide");

}

function hideLoading() {
    $(".loading-overlay").fadeOut(1000);
    $("body").css("overflow", "auto");
}