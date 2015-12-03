<?php
require_once './MasterHeader.php';
?>
<html>
<head>
<title>Successfull</title>
</head>
<body>
	<i>
		Thank you <?php echo $_SESSION['fname']." ".$_SESSION['lname']; ?><br>
		Your order has been submitted successfully.<br>
		You can track it using this transaction id <?php echo $_SESSION['transaction_id'];?>
	</i>
</body>
</html>