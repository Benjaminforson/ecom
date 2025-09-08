<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}
// require_once('./includes/dbh.php');
// $id = $_SESSION['id'];
// $clientid = $_SESSION['clienttransid'];
// $phone = $_SESSION['phone'];
// // get user information from user table
// $stmt_user_info = $conn->prepare("SELECT * FROM transactions WHERE clientid ='$clientid' AND phone = '$phone'");
// $stmt_user_info->execute();
// $user_info_result = $stmt_user_info->get_result();
// while ($user_info_row = $user_info_result->fetch_assoc()) {
//     $reason       =    $user_info_row['reason'];
// }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/checkout-payment.css">
    <link rel="stylesheet" href="./assets/css/ball.css">
    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/site.webmanifest">
    <title>GhProft | Checkout</title>
</head>

<body>
    <!--begin::Main-->
    <div class="container">
        <div class="authentication">
            <div class="content">
                <a href="#" class="logo-link">
                    <img alt="Logo" src="./images/logos/vector/checkout-payment.svg" class="logo-img">
                    <h1 class="logo-img" style="color: white;">GhProfit Pay</h1>
                </a>
                <!--end::Logo-->
                <!--begin::Wrapper-->
                <div class="wrapper">
                    <!--begin::Logo-->
                    <h1 class="wrapper-logo">Payment Request Initiated</h1>
                    <!--end::Logo-->
                    <!--begin::Message-->
                    <div class="wrapper-message">
                        <div class="wrapper-message-link">Please dial *800*0*1234#</div>
                        <br>Please dial the otp and follow the prompt on your mobile phone 
                    </div>
                    <div  class="redirecting"></div>
                    <div style="margin: 10px;" class="loading">
                    <img src="./css/ajax-loader.gif" alt="">
                    </div>
                    <!--end::Message-->
                    <!--begin::Action-->
                    <div class="action">
                        <a href="payment" class="action-link mb-10">
                            <<< Dashboard</a>
                    </div>
                    <!--end::Action-->
                    <!--begin::Action-->
                    <div class="action-down">
                        <span class="action-span">Having trouble?</span>
                        <a href="#" class="action-link">Contact Support</a>
                    </div>
                    <!--end::Action-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <div class="footer">
                <!--begin::Links-->
                <div class="footer-link">
                    <a href="#" class="text-muted text-hover-primary px-2">About</a>
                    <a href="#" class="text-muted text-hover-primary px-2">Support</a>
                    <a href="#" class="text-muted text-hover-primary px-2">Purchase</a>
                </div>
                <!--end::Links-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Authentication - Error 404-->
    </div>
    <!--end::Main-->

    <!--end::Body-->
</body>
<script src="./js/vendor/jquery-3.5.1.min.js"></script>
<script src="./js/payment.js"></script>
</html>