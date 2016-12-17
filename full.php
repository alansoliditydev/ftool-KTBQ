<?php
//Choiem1lan2 :v
if ($_POST["account_list"] != '' && isset($_POST["app_id"])){
  $app_id = $_POST["app_id"];

  $accounts = preg_split ("/\r\n|\n|\r/",$_POST['account_list']);
  $token_lists = '';

    foreach($accounts as $account)
    {
      $access_info = explode('|',$account);
      if (isset($access_info[0]) && isset($access_info[1]))
      {
      $email = $access_info[0];
      $pass = $access_info[1];
      if($app_id == 350685531728)
        {
          $token = json_decode(file_get_contents('https://'.getenv('DOMAIN_NAME').'/android.php?u='.$email.'&p='.$pass.''),true);
        }
      else if($app_id == 165907476854626)
        {
          $token = json_decode(file_get_contents('https://'.getenv('DOMAIN_NAME').'/ios.php?u='.$email.'&p='.$pass.''),true);
        }
      else if($app_id == 6628568379)
        {
          $token = json_decode(file_get_contents('https://'.getenv('DOMAIN_NAME').'/iphone.php?u='.$email.'&p='.$pass.''),true);
        }
      if(isset($token['access_token'])) $token_lists .= $token['access_token'].PHP_EOL;
      else $token_lists .= $token['error_msg'].PHP_EOL;
    }
    else {
      $token_lists .= 'Please fill the form with correct format'.PHP_EOL;
    }
}
  echo $token_lists;
}
else{
# echo $_POST['account_list'];
#echo $_POST['app_id'];
echo 'Please fill in enough information';
}
?>
