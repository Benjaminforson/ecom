<?php
function 
insertTransaction($amount, $mobile, $network, $email, $clienttransid, $userid)
{
    //insert transaction data
    sendMobileMoney($clienttransid, $mobile, $network, $amount);
}

function
insertAddress($user_id, $address, $city, $pincode, $firstname, $lastname, $mobile, $email){
    require_once("./dbh.inc.php");


    //Generate Client transaction ID
  
}

function deductUserAmount($new_revenue_totalamount, $new_revenue_previousbalance, $new_revenue_currentbalance, $new_revenue_pending, $userid)
{
    return "";
}

function updateTransaction($clientid, $status, $reason)
{
        // $message = "Dear $username, Payment for GHC$amount to GhProfit has been completed at $date. Financial Transaction Id: $clientid External Transaction Id: $mmtransid.";
        // sendSMS($mobile, $message);
    
}


function insertmmTransaction($clienttransid, $clientreference, $telcotransid, $transactionid, $status, $statusdate, $reason)
{
    
}


function gettrans($clientid)
{
    return "";
}

function getwithdrawn($clientid)
{
    
    return "";
}


function getmmtrans($clientid)
{
    return "";
}



function sendEmail($email, $message, $subject)
{
    return "This is a function for sending email";
}

function sendSMS($msisdn, $message)
{
    return "This is a function for sending sms";
}

function sendMobileMoney($clienttransid, $mobile, $network, $amount)
{
    return "This is a function for sending mobile money";
}

function sendCashOut($clienttransid, $mobile, $network, $amount)
{
    return "This is a function for initializing cashout";
}
