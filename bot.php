<?php

error_reporting(0);
$botToken = ""; //BURAYA BOTFATHERDEN ALDIGINIZ BOTUNUZUN TOKENİNİ GİRİNİZ !
$website = "https://api.telegram.org/bot".$botToken;


$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);
$print = print_r($update);
$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];

if ((strpos($message, "!tiktok") === 0)||(strpos($message, "/tiktok") === 0)){
  $URL = substr($message, 8);
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://dogan.advertizing.us/api.php?q=$URL",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  $decode = json_decode($response);
  $videolink = $decode->link;
  $info = $decode->durum;
  if(strpos($info, 'true') !== false) {
      sendVideo($chatId, $videolink);
  }else{
      sendMessage($chatId, "<b>Lütfen linki kontrol edin ✘</b>");
  }
}else{
    sendMessage($chatId, "<b>Geçersiz Komut ✘</b>");
}
function sendMessage ($chatId, $message){
$url = $GLOBALS[website]."/sendMessage?chat_id=".$chatId."&text=".$message."&parse_mode=HTML";
file_get_contents($url);      
}
function sendVideo ($chatId, $videourl){
$url = $GLOBALS[website]."/sendVideo?chat_id=".$chatId."&video=".$videourl;
file_get_contents($url);      
}


?>
