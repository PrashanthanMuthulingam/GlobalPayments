<?php
require 'vendor/autoload.php'; // Include the SendGrid library installed via Composer

use SendGrid\Mail\Mail;

function sendPaymentConfirmationEmail($toEmail, $paymentDetails) {
    $email = new Mail();
    $email->setFrom("prashanthanmuthulingam@warmup.com", "Warmup Plc");
    $email->setSubject("Payment Confirmation");
    $email->addTo($toEmail);
 //   $email->addContent("text/plain", "Your payment was successful. Here are the details:\n" . $paymentDetails);

    // HTML Content
    $htmlContent = "<html><body>";
    $htmlContent .= "<h1 style='color: #5e9ca0;'>Payment Details</h1>";
    $htmlContent .= "<p style='color: #626262;'>" . nl2br($paymentDetails) . "</p>";
    $htmlContent .= "</body></html>";

    $email->addContent("text/html", $htmlContent);


    // Replace 'your_sendgrid_api_key' with your actual SendGrid API Key
    $sendgrid = new \SendGrid('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');

    try {
        $response = $sendgrid->send($email);
        return $response;
    } catch (Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
        return null;
    }
}
?>
