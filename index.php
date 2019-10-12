<?php
declare(ticks=1);
session_start();
require_once __DIR__ . '/vendor/autoload.php';

define("DEBUG" , true);

use EasyWeChat\Factory;

$appid = "wx1234b5de77f74a2e";
$secret = "c78f6dda22e8a4984a0d8ce299653f2f";
$options = [
    'app_id' => $appid ,
    'secret' => $secret ,
    'log'    => [
        'level' => 'debug' ,
        'file'  => '/tmp/easywechat.log' ,
    ]
];

$app = Factory::officialAccount($options);
$scope = !empty($_GET['scope']) ? $_GET['scope'] : 'snsapi_base';
$oauth = $app->oauth;

if( empty($_SESSION['wechat_user']) && !isset($_GET['code']) ) {
    $target = isset($_GET['target']) ? $_GET['target'] : '';
    $_SESSION['target'] = $target;
    $oauth->scopes([$scope])->redirect()->send();
}
// 获取 OAuth 授权结果用户信息
if( empty($_SESSION['wechat_user']) ) {
    //请求获取用户信息
    $user = $oauth->user();
    $_SESSION['wechat_user'] = $user->toArray();
    //将用户存储到数据库...
}

//跳转回的url
$target = $_SESSION['target'];
if( preg_match_all("/\?[a-zA-z0-9]{1,}=[a-zA-z0-9]{1,}/" , $target) ) {
    $target = $_SESSION['target'] . '&openid=' . $_SESSION['wechat_user']['id'];
}
else {
    $target = $_SESSION['target'] . '?openid=' . $_SESSION['wechat_user']['id'];
}
DEBUG ?: var_dump($_SESSION['wechat_user']);
unset($_SESSION['wechat_user']);
header('location:' . $target); // 跳转到 user/profile

