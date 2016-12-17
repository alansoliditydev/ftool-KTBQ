<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 12/17/2016
 * Time: 11:37 PM
 */

$user_agent['android'] = array(
    "Mozilla/5.0 (Linux; Android 5.0.2; Andromax C46B2G Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/37.0.0.0 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/60.0.0.16.76;]",
    "[FBAN/FB4A;FBAV/35.0.0.48.273;FBDM/{density=1.33125,width=800,height=1205};FBLC/en_US;FBCR/;FBPN/com.facebook.katana;FBDV/Nexus 7;FBSV/4.1.1;FBBK/0;]",
    "Mozilla/5.0 (Linux; Android 5.1.1; SM-N9208 Build/LMY47X) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.81 Mobile Safari/537.36",
    "Mozilla/5.0 (Linux; U; Android 5.0; en-US; ASUS_Z008 Build/LRX21V) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.8.0.718 U3/0.8.0 Mobile Safari/534.30",
    "Mozilla/5.0 (Linux; U; Android 5.1; en-US; E5563 Build/29.1.B.0.101) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.10.0.796 U3/0.8.0 Mobile Safari/534.30",
    "Mozilla/5.0 (Linux; U; Android 4.4.2; en-us; Celkon A406 Build/MocorDroid2.3.5) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1"
);
$user_agent['iphone'] = array(
    "Mozilla/5.0 (iPhone; CPU iPhone OS 9_2_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Mobile/13D15 Safari Line/5.9.5",
    "Mozilla/5.0 (iPhone; CPU iPhone OS 9_0_2 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Mobile/13A452 Safari/601.1.46 Sleipnir/4.2.2m",
    "Mozilla/5.0 (iPhone; CPU iPhone OS 9_3 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13E199 Safari/601.1",
    "Mozilla/5.0 (iPod; CPU iPhone OS 9_2_1 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) CriOS/45.0.2454.89 Mobile/13D15 Safari/600.1.4",
    "Mozilla/5.0 (iPhone; CPU iPhone OS 9_3 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13E198 Safari/601.1"
);
function cURL_iOS($url, $cookie = false, $PostFields = false,$useragent){
    // No need to insert key app and user agent
    $c = curl_init();
    $opts = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_FRESH_CONNECT => true,
        CURLOPT_USERAGENT => $useragent,
        CURLOPT_FOLLOWLOCATION => true
    );
    if($PostFields){
        $opts[CURLOPT_POST] = true;
        $opts[CURLOPT_POSTFIELDS] = $PostFields;
    }
    if($cookie){
        $opts[CURLOPT_COOKIE] = true;
        $opts[CURLOPT_COOKIEJAR] = $cookie;
        $opts[CURLOPT_COOKIEFILE] = $cookie;
    }
    curl_setopt_array($c, $opts);
    $data = curl_exec($c);
    curl_close($c);
    return $data;
}
function cURL_iphone($method = 'GET', $url = false, $data,$useragent){
//sign_creator($data);
    //print_r($data);
    $c = curl_init();
    $opts = array(
        CURLOPT_URL => ($url ? $url : BASE_URL).($method == 'GET' ? '?'.http_build_query($data) : ''),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => $useragent
    );
    if($method == 'POST'){
        $opts[CURLOPT_POST] = true;
        $opts[CURLOPT_POSTFIELDS] = $data;
    }
    curl_setopt_array($c, $opts);
    $d = curl_exec($c);
    curl_close($c);
    return $d;
}
function cURL_android($method = 'GET', $url = false, $data, $useragent){
//sign_creator($data);
    //print_r($data);
    $c = curl_init();
    $opts = array(
        CURLOPT_URL => ($url ? $url : BASE_URL).($method == 'GET' ? '?'.http_build_query($data) : ''),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => $useragent
    );
    if($method == 'POST'){
        $opts[CURLOPT_POST] = true;
        $opts[CURLOPT_POSTFIELDS] = $data;
    }
    curl_setopt_array($c, $opts);
    $d = curl_exec($c);
    curl_close($c);
    return $d;
}
function validate_token($app,$access_token,$useragent){
    $url = 'https://graph.facebook.com/1183620051668662/comments';
    $data = array(
        'message' => 'worked',
        'access_token' => $access_token
    );
    switch ($app){
        case 'iphone':
            $res_str = cURL_iphone('POST',$url,$data,$useragent);
            break;
        case 'android':
            $res_str = cURL_android('POST',$url,$data,$useragent);
            break;
    }
    $res = json_decode($res_str,true);
    if(isset($res['id'])){
        $data_return['status'] = 'ok';
        $data_return['message'] = 'Token verified!';
    }else{
        $data_return['status'] = 'error';
        $data_return['message'] = $res_str;
    }
    return $data_return;
}

?>