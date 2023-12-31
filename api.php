<?php
error_reporting(0);
header('Content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
require_once('inc/require.php');
global $config;

$kind = $_POST['kind'];
$type = $_POST['type'];
$url = $_POST['url'];
$endtime = $_POST['endtime'];
$key = $_POST['key'];
if(empty($kind)) $kind = $_GET['kind'];
if(empty($type)) $type = $_GET['type'];
if(empty($url)) $url = $_GET['url'];
if(empty($endtime)) $endtime = $_GET['endtime'];
if(empty($key)) $key = $_GET['key'];

if (empty($kind)) $kind = $_SERVER['SERVER_NAME'];
if(isset($endtime) and $key != $config['key']){
    returnResult("", "Key错误");
    exit;
}elseif(empty($endtime)){
    $endtime = $config['urlendtime'];
}



if ($type == 'toLong') {
    $long_url = restoreUrl($url);
    returnResult($long_url);
} elseif ($type == 'toShort') {
    $long_url=urlencode($url);
    
    $short_url = '';
    $msg = '没有这个域!';
    
    foreach ($config['domain'] as $domain) {
        if($domain['state'] and $domain['url'] == $kind){

            $ddata = create_uri($url, $kind, $endtime);
            if($ddata['success']){
                $short_url = $ddata['url'];
            }else{
                $msg = $ddata['msg'];
            }
            break;

        }
    }

    returnResult($short_url, $msg);
} else {
    returnResult('');
}
