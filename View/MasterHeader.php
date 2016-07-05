
<?php
session_start();
require_once '../../Controller.php';  
$dbController = new DBController();
//$GLOBALS["ROOT_PATH"] = __DIR__;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-16">
        <link href="../../css/bootstrap.min.css" rel="stylesheet">
        <link href="../../css/font-awesome.css" rel="stylesheet">
        <link href="../../css/styles.css" rel="stylesheet">
        <link href="../../css/loading.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
        <script src="../../js/jquery-1.11.3.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
    </head>
    <body  >
        <?php
        if (isset($_SESSION['ACCESS_TYPE']) && $_SESSION['ACCESS_TYPE'] === "ADMIN") {
            $admin = unserialize($_SESSION['admin']);
            require_once './AdminHeadBar.php';
        } else  {
            
            require_once 'customer/customer-navbar.php';
        }
        $controller = new Controller();
        ?>

        <div class="loading-overlay" id="loading">
            <div class="sk-cube-grid">
                <div class="sk-cube sk-cube1"></div>
                <div class="sk-cube sk-cube2"></div>
                <div class="sk-cube sk-cube3"></div>
                <div class="sk-cube sk-cube4"></div>
                <div class="sk-cube sk-cube5"></div>
                <div class="sk-cube sk-cube6"></div>
                <div class="sk-cube sk-cube7"></div>
                <div class="sk-cube sk-cube8"></div>
                <div class="sk-cube sk-cube9"></div>
            </div>
        </div>

        <!-- Alerts-->
<div class="alert-msg"> </div> 
        
        