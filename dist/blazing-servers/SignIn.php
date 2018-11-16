<?php
$url = 'https://billing.blazingseollc.com/hosting/modules/addons/easy_auth/do.php?';

$data = [

    'username' => $_POST["username"],
    password => $_POST["password"],
    url => [
        'success' => 'https://billing.blazingseollc.com/hosting/clientarea.php', // to be redirected on successful sign in
        'fail' => 'https://billing.blazingseollc.com/hosting/clientarea.php' // to be redirected on sign in failure
    ],
    text => [
        'pending' => 'Loading...', // user will see on signing in
        'error' => 'Credentials are incorrect!' // will be shown only on failure and fail url is not defined
    ]
];


$data = base64_encode(json_encode($data));

//echo $data;

//$headTo = http_build_query($data);
//
echo  $url."data=".$data;
//
header("Location: ".$url."data=".$data );



