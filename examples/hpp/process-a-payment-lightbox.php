<!DOCTYPE html>
<html>
<head>
    <title>HPP Lightbox Demo</title>
    <meta charset="UTF-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="./dist/rxp-js.js"></script>
    <script src="./helper.js"></script>
    <script>
	
	
	 RealexHpp.setHppUrl('https://pay.sandbox.realexpayments.com/pay');
	    $(document).ready(function () {
            $('#paymentForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.post("proxy-request.php", formData, function (jsonFromServerSdk) {
                    
					    console.log(jsonFromServerSdk); // Add this line
					RealexHpp.lightbox.init(
                        "payButtonId",
                        "./response.php", // merchant url
                        jsonFromServerSdk   // form data from server
                    );
					       // $('body').addClass('loaded');
                });
            });
        });
 /*       RealexHpp.setHppUrl('https://pay.sandbox.realexpayments.com/pay');
        // get the HPP JSON from the server-side SDK
        $(document).ready(function () {
            $.getJSON("./proxy-request.php?slug=process-a-payment", function (jsonFromServerSdk) {
                RealexHpp.lightbox.init(
                    "payButtonId",
                    "./response.php", // merchant url
                    jsonFromServerSdk   //form data
                );
                $('body').addClass('loaded');
            });
        });
		*/
    </script>
</head>
<body>

<form id="paymentForm" method="post">
    <input type="text" name="amount" placeholder="Amount" >
    <input type="text" name="currency" placeholder="Currency" >
    <input type="email" name="customer_email" placeholder="Customer Email" >
    <input type="text" name="billing_street1" placeholder="Billing Street 1" >
    <input type="text" name="billing_street2" placeholder="Billing Street 2">
    <input type="text" name="billing_city" placeholder="Billing City" >
    <input type="text" name="billing_postalcode" placeholder="Postal Code" >
    <input type="text" name="billing_country" placeholder="Country" >
    <input type="text" name="invoice_number" placeholder="Invoice Number" >
	        <select name="paymentMethod" id="paymentMethod">
            <option value="https://pay.sandbox.realexpayments.com/pay">Ecommerce</option>
           <!-- <option value="https://apis.sandbox.globalpay.com/ucp/hpp/transactions">Unified Payments</option> -->
        </select>
        <input type="submit" id="payButtonId" value="Checkout Now" />
</form>
<!--    <div class="method">
        <label for="paymentMethod">Payment Method: </label>
        <select name="paymentMethod" id="paymentMethod">
            <option value="https://pay.sandbox.realexpayments.com/pay">Ecommerce</option>
            <option value="https://apis.sandbox.globalpay.com/ucp/hpp/transactions">Unified Payments</option>
        </select>
    </div>
    <input type="submit" id="payButtonId" value="Checkout Now" />
	
-->	
</body>
</html>
