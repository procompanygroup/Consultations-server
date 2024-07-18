<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use RtcTokenBuilder;
class AgoraTokenController extends Controller
{
    //
    public function generateToken($client_id,$expireTime,$channel)
    {
    // $class= new \RtcTokenBuilder;
     $appId = '994b5aa07c8142848dd9ec69b2e7a3cb';
// Need to set environment variable AGORA_APP_CERTIFICATE
$appCertificate ='3a7e5dba8e154897acf69b5470708709';

//$channelName = "7d72365eb983485397e3e3f9d460bdda";
$channelName = $channel;
//$uid = 2882341273;
$uid =$client_id;
//$uidStr = "2882341273";
$role = RtcTokenBuilder::RoleAttendee;
//$expireTimeInSeconds = 3600;
$expireTimeInSeconds = $expireTime;
$currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
$privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
// echo "App Id: " . $appId . PHP_EOL;
// echo "App Certificate: " . $appCertificate . PHP_EOL;
if ($appId == "" || $appCertificate == "") {
   // echo "Need to set environment variable AGORA_APP_ID and AGORA_APP_CERTIFICATE" . PHP_EOL;
   return "";
}

$token = RtcTokenBuilder::buildTokenWithUid($appId, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
//echo 'Token with int uid: ' . $token . PHP_EOL;

// $token = \RtcTokenBuilder::buildTokenWithUserAccount($appId, $appCertificate, $channelName, $uidStr, $role, $privilegeExpiredTs);
// echo 'Token with user account: ' . $token . PHP_EOL;
  return $token; 
}


}
