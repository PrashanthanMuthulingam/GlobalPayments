<?php

session_start(); // Start the session

if(isset($_POST['invoice_number'])) {
    $_SESSION['invoice_number'] = $_POST['invoice_number'];
    echo "Session for Invoice Number created: " . $_SESSION['invoice_number'];
} else {
    echo "Invoice number not received";
}

?>
