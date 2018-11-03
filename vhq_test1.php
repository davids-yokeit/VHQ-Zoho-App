<?php


# Do the auth..
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://secure.myreceptionist.com.au/ofis/vh/Account/Logon",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HEADER => true,
    CURLOPT_POSTFIELDS => "returnUrl=returnUrl=/ofis/vh/&admin_username=vhqld&password=C00gee",
    CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",
        "Content-Type: application/x-www-form-urlencoded",
        "Postman-Token: 5a20bb74-4ae3-3d33-0ca9-ecf8c249653c"
    ),
));

$response = curl_exec($curl);

$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//  echo $response;

}

preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
$cookies = array();
foreach($matches[1] as $item) {
    parse_str($item, $cookie);
    $cookies = array_merge($cookies, $cookie);
}

//var_dump($cookies);

//echo "ds: ".$cookies["ASP_NET_SessionId"]."\n";




# Get the account data
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://secure.myreceptionist.com.au/ofis/vh/Home/GetClients?sort=&page=1&pageSize=50&group=&filter=",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    //CURLOPT_HEADER => true,
    CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",
        "Postman-Token: eb9c50f2-e969-8e6b-e85e-28f8eec945f1"
    ),
));
$cookieString = "ASP.NET_SessionId=".$cookies["ASP_NET_SessionId"]."; path=/; domain=.secure.myreceptionist.com.au; HttpOnly; Expires=Tue, 19 Jan 2038 03:14:07 GMT;";
curl_setopt($curl,CURLOPT_COOKIE,$cookieString);

$cookieString = ".ASPXAUTH=".$cookies["_ASPXAUTH"]."; path=/; domain=.secure.myreceptionist.com.au; Expires=Tue, 19 Jan 2038 03:14:07 GMT;";
curl_setopt($curl,CURLOPT_COOKIE,$cookieString);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    //echo $response;
}

$leads = json_decode($response, true);

var_dump($response);

print_r($leads);


