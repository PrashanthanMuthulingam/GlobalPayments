<?php

//print_r($_GET);
function generateHash($data, $secret)
{
    $toHash = [];
    $timeStamp           = !isset($data['TIMESTAMP']) ? "" : $data['TIMESTAMP'];
    $merchantId          = !isset($data['MERCHANT_ID']) ? "" : $data['MERCHANT_ID'];
    $orderId             = !isset($data['ORDER_ID']) ? "" : $data['ORDER_ID'];
    $amount              = !isset($data['AMOUNT']) ? "" : $data['AMOUNT'];
    $currency            = !isset($data['CURRENCY']) ? "" : $data['CURRENCY'];
    $payerReference      = !isset($data['PAYER_REF']) ? "" : $data['PAYER_REF'];
    $paymentReference    = !isset($data['PMT_REF']) ? "" : $data['PMT_REF'];
    $hppSelectStoredCard = !isset($data['HPP_SELECT_STORED_CARD']) ? "" : $data['HPP_SELECT_STORED_CARD'];
    $payRefORStoredCard  = empty($hppSelectStoredCard) ?  $payerReference : $hppSelectStoredCard;

    if (isset($data['CARD_STORAGE_ENABLE']) && $data['CARD_STORAGE_ENABLE'] === '1') {
        $toHash = [
            $timeStamp,
            $merchantId,
            $orderId,
            $amount,
            $currency,
            $payerReference,
            $paymentReference,
        ];
    } elseif ($payRefORStoredCard && empty($paymentReference)) {
        $toHash = [
            $timeStamp,
            $merchantId,
            $orderId,
            $amount,
            $currency,
            $payRefORStoredCard,
            ""
        ];
    } elseif ($payRefORStoredCard && !empty($paymentReference)) {
        $toHash = [
            $timeStamp,
            $merchantId,
            $orderId,
            $amount,
            $currency,
            $payRefORStoredCard,
            $paymentReference,
        ];
    } else {
        $toHash = [
            $timeStamp,
            $merchantId,
            $orderId,
            $amount,
            $currency,
        ];
    }

    return sha1(sha1(implode('.', $toHash)) . '.' . $secret);
}

//$json = file_get_contents(sprintf('./json/%s.json', $_GET['slug']));
//error_log('received: ' . $json);

//$data = json_decode($json);

$jsonTemplate = file_get_contents('json/process-a-payment.json');
$data = json_decode($jsonTemplate, true);

// Replace the data in the JSON template with the form data
$data["AMOUNT"] = $_GET['amount'] ?? $data["AMOUNT"];
//$data["CURRENCY"] = $_GET['currency'] ?? $data["CURRENCY"];
$data["HPP_CUSTOMER_EMAIL"] = $_GET['customer_email'] ?? $data["HPP_CUSTOMER_EMAIL"];
//$data["HPP_CUSTOMER_PHONENUMBER_MOBILE"] = $_GET['customer_phone'] ?? $data["HPP_CUSTOMER_PHONENUMBER_MOBILE"];


$response = array();
foreach ($data as $key => $value) {
    if (!$value) {
        continue;
    }
    $response[$key] = $value;
}

$response["ORDER_ID"] = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 22);
$response["TIMESTAMP"] = (new DateTime())->format("YmdHis");
$response["SHA1HASH"] = generateHash($response, 'secret');
$response["HPP_CAPTURE_ADDRESS"] = "True"; // Add this line to enable address capture


$jsonResponse = json_encode($response);

error_log('sending: ' . $jsonResponse);
echo $jsonResponse;
