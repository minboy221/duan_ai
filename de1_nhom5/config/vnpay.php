<?php

return [
    'tmn_code' => env('VNP_TMNCODE', 'TCB00001'),
    'hash_secret' => env('VNP_HASHSECRET', 'ABCDEF1234567890ABCDEF1234567890'),
    'url' => env('VNP_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
    'return_url' => env('VNP_RETURNURL', ''),
    'ipn_url' => env('VNP_IPNURL', ''),
];
