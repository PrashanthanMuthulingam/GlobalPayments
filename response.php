<?php
session_start(); // Start the session
$referrer = $_SERVER['HTTP_REFERER'];

if (empty($_POST['hppResponse'])) {
    header('Location: ' . $referrer);
    exit();
}

$hppResponse = $originalHppResponse = $_POST['hppResponse'];

try {
    if (null === ($hppResponse = json_decode($hppResponse, true))) {
        throw new Exception();
    }

    foreach ($hppResponse as $k => $v) {
        try {
            $hppResponse[$k] = base64_decode($v);
        } catch (Exception $e) {
            /* */
        }
    }
}
catch (Exception $e) {
    $hppResponse = $originalHppResponse;
}

?><!DOCTYPE html>
<html>
<head>
    <title>HPP Demo Response</title>
    <meta charset="UTF-8">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <!-- MDB -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet"/>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<style>
.block-heading{
    padding-top: 50px;
    margin-bottom: 40px;
	text-align:center;
    
}
h2{font-weight:600;}
</style>

</head>
<body>
<div class="container" id="payment-container">

 <div class="row">
    
    <div class="block-heading">
        <?php
		
		//==============================================================================================
		
				//Save to Database: - Payment reference vs Order ID
				
				
		$user_email			= $hppResponse['HPP_CUSTOMER_EMAIL'];
		$amount				= $hppResponse['AMOUNT'];	
		$transaction_ID		= $hppResponse['ORDER_ID'];
		$contact_number		= $hppResponse['HPP_SHIPPING_PHONE'];
		$payment_message	= $hppResponse['MESSAGE'];
		
				
		// Database connection
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "warmup_payments";
		

			$conn = new mysqli($servername, $username, $password, $dbname);

			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}

			// Check if project_ref_id already exists
			$sql = "SELECT * FROM payments WHERE Transaction_ID = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("s", $transaction_ID);
			$stmt->execute();
			$result = $stmt->get_result();

			// If project_ref_id doesn't exist, insert a new row
			if ($result->num_rows == 0) {
				$invoice_number =  $_SESSION['invoice_number']; // Assign '1' to a variable
				$sql = "INSERT INTO payments (Invoice_Number, Email, Amount, Transaction_ID, Contact, Message) VALUES (?, ?, ?, ?, ?, ?)";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("ssdsss", $invoice_number, $user_email, $amount, $transaction_ID, $contact_number, $payment_message);
				$stmt->execute();
			}

		
			
		
		
		
		//==============================================================================================
		
		
		if (isset($hppResponse['MESSAGE']) && (strpos(strtolower($hppResponse['MESSAGE']), 'successful') !== false || strpos(strtolower($hppResponse['MESSAGE']), 'authorised') !== false)) {
			echo '<div class="successimg"><img src="https://cdni.iconscout.com/illustration/premium/thumb/mobile-card-payment-successful-5796098-4841252.png" alt="Success Icon" width="200"/></div>' . '<br/>';
			echo "<h2 class='text-primary'>Payment Successful!</h2>" . "<br />";
			// Assuming you have the user's email stored in a variable like $userEmail
			require 'send_email.php';
			$paymentDetails = "Amount: " . $hppResponse['AMOUNT'] . "\nTransaction ID: " . $hppResponse['ORDER_ID'];
			
			echo "<h4>Transaction ID: " . $hppResponse['ORDER_ID'] ."</h4>" . "<br />";
			
			$userEmail		= $hppResponse['HPP_CUSTOMER_EMAIL'];
//			sendPaymentConfirmationEmail($userEmail, $paymentDetails);
		} else {
			echo '<div class="successimg"><img src="https://png.pngtree.com/element_our/png/20181114/payment-failure-flat-icon-png_238383.jpg" alt="Success Icon" width="200"/></div>' . '<br/>';
			echo "<h2 class='text-danger'>Payment Not Successful.</h2>";
		}

        ?>
        <pre><?php  print_r($hppResponse); ?></pre>
		
	<div>
        <a href="<?php echo $referrer; ?>"><button type="button" class="btn btn-secondary">Try Again</button></a>
    </div>
		
    </div>

</div>	
	
</div>	
</body>
</html>
