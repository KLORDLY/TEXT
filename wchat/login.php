<?php

//声明code，用来前台传过来的code，code是用户的登录凭证（有效期五分钟）。开发者需要在开发者服务器后台调用 auth.code2Session，使用 code 换取 openid （用户唯一标识）和 session_key （会话密钥）等信息
$code=$_GET["code"];
//获取addid（小程序开发者文档获取）
$appid="wx4f7011956fa7834a";
//获取secret（小程序开发者文档获取）
$secret="9b31bfe0cb03e567f322de942b660784";
//api,调用的调用 auth.code2Session接口地址,然后把对应的地方换成{...}
$api="https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";

//获取Get请求
   function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
    curl_setopt($curl, CURLOPT_URL, $url);
    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
    }

//发送的代码,把api发送到服务器
$str=httpGet($api);

//发送完输出str
echo $str;

?>