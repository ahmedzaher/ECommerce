
<?php
 
require_once './Controller.php'; 

session_start();
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
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.css" rel="stylesheet">
        <link href="css/customeStyles.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
        <script src="js/jquery-1.11.3.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/customeScripts.js"></script>
    </head>
    <body  >
        <?php
        if (isset($_SESSION['ACCESS_TYPE']) && $_SESSION['ACCESS_TYPE'] === "ADMIN") {
            $admin = unserialize($_SESSION['admin']);
            require_once './AdminHeadBar.php';
        } else if (isset($_SESSION['ACCESS_TYPE']) && $_SESSION['ACCESS_TYPE'] === "CUSTOMER") {
            $customer = unserialize($_SESSION['customer']);
            require_once './CustomerHeadBar.php';
        }
        $controller = new Controller();
        ?>
        <div id="log" class="log">
            
        </div>
        <div id="wait" class="wait">
            <i class="fa fa-spinner fa-pulse fa-4x"></i>
        </div>