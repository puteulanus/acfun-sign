<?php
header("Content-type:text/html;charset=utf-8");
// 设定用户名密码
$username = '';// 用户名
$password = '';// 密码
// 模拟登陆获取cookie
$url = 'http://www.acfun.tv/login.aspx';
$data = 'username='.$username.'&password='.$password;
$ch = curl_init($url);
curl_setopt($ch,CURLOPT_HEADER,1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_REFERER,'http://www.acfun.tv/');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$content = curl_exec($ch);
curl_close($ch);
preg_match_all('/Set-Cookie:(.*;)/iU',$content,$str);
foreach ($str[1] as $key) {
    if (strpos($key,'deleted') == false){
        $cookie .= $key;
    }
}
// 使用cookie签到
$Referer = 'http://www.acfun.tv/member/';
$UserAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0';
$url = 'http://www.acfun.tv/member/checkin.aspx';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER[$UserAgent]);
curl_setopt($curl, CURLOPT_REFERER,$Referer);
curl_setopt($curl, CURLOPT_COOKIE, $cookie);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest"));
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_TIMEOUT, 30);
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$str = curl_exec($curl);
if (curl_errno($curl)) {
    echo 'Errno'.curl_error($curl);
}
curl_close($curl);
echo $str;
