<!DOCTYPE html>
<html>
<head>
  <title>Payment</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <!-- MDB -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet"/>


<style>
.payment-form{
	padding-bottom: 50px;
	font-family: 'Montserrat', sans-serif;
}

body{
	background-color: #f6f6f6;
}

.payment-form .content{
	box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.075);
	background-color: white;
}

.form-control {
     padding: 10px 12px 10px !important;
}
.payment-form .block-heading{
    padding-top: 50px;
    margin-bottom: 40px;
    text-align: center;
}

.payment-form .block-heading p{
	text-align: center;
	max-width: 420px;
	margin: auto;
	opacity:0.7;
}

.payment-form.dark .block-heading p{
	opacity:0.8;
}

.payment-form .block-heading h1,
.payment-form .block-heading h2,
.payment-form .block-heading h3 {
	margin-bottom:1.2rem;
	color: #3b99e0;
}

.payment-form form{
	border-top: 2px solid #5ea4f3;
	box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.075);
	background-color: #ffffff;
	padding: 0;
	max-width: 600px;
	margin: auto;
}

.payment-form .title{
	font-size: 1em;
	border-bottom: 1px solid rgba(0,0,0,0.1);
	margin-bottom: 2.2em;
	font-weight: 600;
	padding-bottom: 8px;
}



.payment-form .card-details{
	padding: 25px 25px 15px;
}

.payment-form .card-details label{
	font-size: 12px;
	font-weight: 600;
	margin-bottom: 15px;
	color: #79818a;
	text-transform: uppercase;
}

.payment-form .card-details button{
	margin-top: 0.6em;
	padding:12px 0;
	font-weight: 600;
}

.payment-form .date-separator{
 	margin-left: 10px;
    margin-right: 10px;
    margin-top: 5px;
}

@media (min-width: 576px) {
	.payment-form .title {
		font-size: 1.2em; 
	}


}
</style>

</head>
<body>




  <main class="page payment-page">
    <section class="payment-form dark">
      <div class="container">
        <div class="block-heading">
          <h2>Payment</h2>
          <p>Pay your invoice online</p>
        </div>
        <form id="paymentForm" action="process-a-payment-lightbox.php" method="get">

          <div class="card-details">
            <h3 class="title">Payment details</h3>
			
			<div id="error-message" style="color:red;"></div><br />
			
            <div class="row">
              <div class="form-group col-sm-12">
                <label for="card-holder-email">Card Holder Email</label>
                <input id="card-holder-email" type="email" name="customer_email" class="form-control" placeholder="Customer Email" aria-label="Card Holder Email" required>
				
              </div>

              <div class="form-group col-sm-7">
                <label for="invoice-number">Invoice Number</label>
                <input id="invoice-number" type="text" class="form-control"  name="invoice_number" placeholder="Invoice Number" aria-label="Invoice Number">
              </div>
              <div class="form-group col-sm-5">
                <label for="payment-amount">Payment Amount (£)</label>
                <input step="0.01" id="payment-amount" name="amount" type="number" class="form-control" placeholder="Payment Amount" min="0" aria-label="Card Holder">
              </div>
              <div class="form-group col-sm-12">
                <input type="submit" class="btn btn-lg btn-primary btn-block" id="payButtonId" value="PROCESS"/>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>
  </main>
</body>
<!--<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#paymentForm').submit(function(e) {
        var email = $('#card-holder-email').val();
        var invoiceNumber = $('#invoice-number').val();
        var amount = $('#payment-amount').val();
        var errorMessage = '';

        if (email === '' || !validateEmail(email)) {
            errorMessage += 'Please enter a valid email address.<br>';
        }

        if (invoiceNumber === '') {
            errorMessage += 'Please enter an invoice number.<br>';
        }

        if (amount <= 0) {
            errorMessage += 'Please enter a valid payment amount.<br>';
        }

        if(errorMessage !== '') {
            $('#error-message').html(errorMessage);
            e.preventDefault(); // Prevent form submission
            return false;
        } else {
            $('#error-message').html('');
        }
    });

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,4}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
});
</script>

</body>
</html>
