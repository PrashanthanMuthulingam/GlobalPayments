<?php
session_start(); // Start the session



if(isset($_GET['invoice_number'])) {
    $_SESSION['invoice_number'] = $_GET['invoice_number'];
    
} 


?>

<!DOCTYPE html>
<html>
<head>
    <title>HPP Lightbox Demo</title>
    <meta charset="UTF-8">
	<!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <!-- MDB -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet"/>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="./dist/rxp-js.js"></script>
    <script src="./helper.js"></script>

<style>

body{background-color: #f6f6f6;font-family: 'Montserrat', sans-serif;}
#payment-module{margin: 5% auto;}
#card-module{
	background-color:#ffffff;
	border-top: 2px solid #5ea4f3;
	box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.075);
	background-color: #ffffff;
	padding: 0;
	margin: 5% auto;
	}
#payment-info{padding: 0 0 15px 35px;}
#payment-info-button{padding:45px;}		
.card-details{padding: 25px 25px 15px;}	
        #targetIframe {
            min-height: 600px;
            width:100%;
        }
h3.title{font-weight: 600;}		
</style>

</head>
<body>
<div class="container" id="payment-container">
 <div class="row">
  <div class="col-md-6" id="card-module">
    <div class="pb-3">
      
	  
	      <div class="card-details">
            <h3 class="title">Payment details</h3>
           
          </div>
	  
	  
    </div>
    <div class="row" id="payment-info">
      <div class="col-md-5">Customer Email:</div>
      <div class="col-md-7"><?php echo htmlspecialchars($_GET['customer_email']); ?></div>
    </div>
	
	<div class="row" id="payment-info">
      <div class="col-md-5">Amount to pay:</div>
      <div class="col-md-7">£<?php echo htmlspecialchars($_GET['amount']); ?></div>
    </div>
	
	<div class="row" id="payment-info">
      <div class="col-md-5">Invoice Number:</div>
      <div class="col-md-7"><?php echo htmlspecialchars($_GET['invoice_number']); ?></div>
    </div>
	
	<div class="row" id="payment-info-button">
    
        
        <select name="paymentMethod" id="paymentMethod" hidden>
            <option value="https://pay.sandbox.realexpayments.com/pay">Ecommerce</option>
           <!-- <option value="https://apis.sandbox.globalpay.com/ucp/hpp/transactions">Unified Payments</option> -->
        </select>
    
    <input type="submit" class="btn btn-lg btn-primary btn-block" id="payButtonId" value="Checkout Now" />
    </div>
				
  </div>
  <div class="col-md-6" id="payment-module"><iframe id="targetIframe" style="display:none;"></iframe></div>
</div>
</div>


</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<script>
$(document).ready(function() {
    $('#checkoutButton').click(function(e) {
        e.preventDefault(); // Prevents the default submit action
        var invoiceNumber = "<?php echo htmlspecialchars($_GET['invoice_number']); ?>";

        $.ajax({
            type: 'POST',
            url: 'create_session_invoice.php', 
            data: { invoice_number: invoiceNumber },
            success: function(response) {
                // Handle response from the server
                console.log(response);
            }
        });
    });
});

  

  RealexHpp.setHppUrl('https://pay.sandbox.realexpayments.com/pay');
    $(document).ready(function () {
        var queryString = new URLSearchParams(<?php echo json_encode($_GET); ?>).toString();
        var url = "./proxy-request.php?" + queryString;
        $.getJSON(url, function (jsonFromServerSdk) {
         //   RealexHpp.lightbox.init(
		 RealexHpp.embedded.init(
                "payButtonId",
				"targetIframe",
                "./response.php", // merchant url
                jsonFromServerSdk   //form data
            );
			
		// Hide the button after initializing the iframe
          //  $('#payButtonId').hide();
            $('body').addClass('loaded');
        });
    });
</script>



</html>
