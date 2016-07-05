<?php
require_once '../MasterHeader.php';
?>
<div class="container">
    
    <span style="font-size: 18px" > Transaction Number</span> &nbsp;&nbsp;
    <input type="text" style="display:inline;width:350px" class="transaction-id-input form-control"> &nbsp;
    <button id="filter-orders-btn" class="btn btn-success">Filter &nbsp;<i class="fa fa-filter"></i></button>
    <br>
    <br>
    <br>
    
<div class="order-tracing-div">

</div>
</div>
<script>
    $(".navbar-item").removeClass("active");
    $(".navbar-item").has("a[href='order-tracking.php']").addClass("active");
    $(document).ready(function () {
        showLoading();
        $.get("../../Controller/controller.php?REQUEST=TRACK_ORDERS", function (data) {
            if(data == "Failed") {
                
            }
            else {
                $(".order-tracing-div").html(data);
                filter(""); // show all
            }
            hideLoading();
            
        });
        
        $(".transaction-id-input").keydown(function(){
            setTimeout(function(){
                filter($(".transaction-id-input").val()) ;
            },50);
            
        });
        $("#filter-orders-btn").click( function(){
                filter($(".transaction-id-input").val()) ;
            } ); 
         
    });
    
    function filter(id) {
        id = id.trim();
        if (id == ""){
            $(".trarcked-order").show();
        }
        else {
            $(".trarcked-order").hide();
            $("#"+id).show();
        }
    }
</script>

<?php
require_once '../MasterFooter.php';
