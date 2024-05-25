<?php
    include("connect.php");
    $val_id=urlencode($_POST['val_id']);
    $store_id=urlencode("jahan664e4ee30f771");
    $store_passwd=urlencode("jahan664e4ee30f771@ssl");
    $requested_url = ("https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php?val_id=".$val_id."&store_id=".$store_id."&store_passwd=".$store_passwd."&v=1&format=json");
    
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $requested_url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC
    
    $result = curl_exec($handle);
    
    $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    
    if($code == 200 && !( curl_errno($handle)))
    {
    
        # TO CONVERT AS ARRAY
        # $result = json_decode($result, true);
        # $status = $result['status'];
    
        # TO CONVERT AS OBJECT
        $result = json_decode($result);
    
        # TRANSACTION INFO
        $status = $result->status;
        $tran_date = $result->tran_date;
        $tran_id = $result->tran_id;
        $val_id = $result->val_id;
        $amount = $result->amount;
        $store_amount = $result->store_amount;
        $bank_tran_id = $result->bank_tran_id;
        $card_type = $result->card_type;
    
        # EMI INFO
        $emi_instalment = $result->emi_instalment;
        $emi_amount = $result->emi_amount;
        $emi_description = $result->emi_description;
        $emi_issuer = $result->emi_issuer;
    
        # ISSUER INFO
        $card_no = $result->card_no;
        $card_issuer = $result->card_issuer;
        $card_brand = $result->card_brand;
        $card_issuer_country = $result->card_issuer_country;
        $card_issuer_country_code = $result->card_issuer_country_code;
    
        # API AUTHENTICATION
        $APIConnect = $result->APIConnect;
        $validated_on = $result->validated_on;
        $gw_version = $result->gw_version;
        $registration_no= $_GET['registration_no'];
        $id= $_GET['id'];
        $sql="update department_approval set status='paid' where (id=$id && registration_no='$registration_no')";
        $result=mysqli_query($con,$sql);
    } else {
    
        echo "Failed to connect with SSLCOMMERZ";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Successful</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      background: #fff;
      padding: 40px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      text-align: center;
      max-width: 400px;
      width: 100%;
    }
    .container h1 {
      color: #4CAF50;
      font-size: 24px;
      margin-bottom: 20px;
    }
    .container p {
      color: #333;
      font-size: 18px;
      margin-bottom: 30px;
    }
    .container .button {
      background-color: #4CAF50;
      color: white;
      padding: 15px 20px;
      text-decoration: none;
      border-radius: 5px;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }
    .container .button:hover {
      background-color: #45a049;
    }
    .container .checkmark {
      width: 100px;
      height: 100px;
      margin: 0 auto 20px;
    }
    .checkmark-circle {
      stroke-dasharray: 166;
      stroke-dashoffset: 166;
      stroke-width: 2;
      stroke-miterlimit: 10;
      stroke: #4CAF50;
      fill: none;
      animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    .checkmark-check {
      transform-origin: 50% 50%;
      stroke-dasharray: 48;
      stroke-dashoffset: 48;
      stroke-width: 2;
      stroke: #4CAF50;
      fill: none;
      animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.6s forwards;
    }
    @keyframes stroke {
      100% {
        stroke-dashoffset: 0;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <svg class="checkmark" viewBox="0 0 52 52">
      <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
      <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
    </svg>
    <h1>Payment Successful!</h1>
    <p>Thank you for your payment. Your transaction was successful.</p>
    <a href="student-dashboard.php" class="button">Go to your dashboard</a>
  </div>
</body>
</html>
