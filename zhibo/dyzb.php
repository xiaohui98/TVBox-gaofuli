<?php
header("Content-Type: text/html; charset=UTF-8");


$typeid =$_GET["t"];
$page = $_GET["pg"];
$ids = $_GET["ids"];
$type = $_GET["type"];
$wd = $_GET["wd"];




$weburl = '';
if ($typeid<> null && $page<>null or $wd<> null){
if($page==null){
$page=1;
}
$turl2 = '';
if ($wd <> null) {
    $turl2 = $weburl . "sreach/video?title=" . $typeid . "&current=" . $page . "&every=10";
} else {

    $offset=($page-1)*50;
    $turl2 = "https://live.douyin.com/webcast/web/partition/detail/room/?aid=6383&app_name=douyin_web&live_id=1&device_platform=web&language=zh-CN&cookie_enabled=true&screen_width=998&screen_height=562&browser_language=zh-CN&browser_platform=Win32&browser_name=Chrome&browser_version=79.0.3945.79&count=50&offset=$offset&partition=$typeid&partition_type=2&req_from=1";

    $turl2 =curl_get2($turl2);
$arr=json_decode($turl2,true);
//echo $turl2;
$arr_q1a=$arr['data']['data'];
$m=count($arr_q1a);
if($m<>null){
$page2=$page+1;
$length=$m+1;
}

$result='{"code":1,"page":'.$page.',"pagecount":'. $page2.',"total":'. $length.',"list":[';
 for($i=0;$i<$m;$i++){
$title = $arr_q1a[$i]['room']['owner']['nickname'];
if($title==null){
$title =  $arr_q1a[$i]['title'];
}
$link =  $arr_q1a[$i]['room']['id_str'];
$rid =  $arr_q1a[$i]['web_rid'];
$pid =  $arr_q1a[$i]['room']['stream_url']['hls_pull_url_map']['FULL_HD1'];
$link = $rid.'%26room_id_str%3D'.$link.'vvvvv'.$pid;
if($link==null){
$link =  $arr_q1a[$i]['nextlink'];
$len1= strpos($link, 'ids=') + 4;
$link = substr($link,$len1,strlen($link)-$len1);
}
$text =  $arr_q1a[$i]['room']['title'];
if($text==null){
$text =  $arr_q1a[$i]['state'];
}
$vod_pic =  $arr_q1a[$i]['room']['cover']['url_list']['0'];
if($vod_pic==null){
$vod_pic =  $arr_q1a[$i]['coverUrl'];
}

$result=$result.'{"vod_id":"'.$link.'","vod_name":"'.$title.'","vod_pic":"'.$vod_pic.'","vod_remarks":"'.$text.'"},';
}
$result=substr($result, 0, strlen($result)-1).']}';
}echo $result;


}else if ($ids<> null){
    $pid=strstr($ids,'vvvvv');
    $pid=str_replace('vvvvv',"",$pid);
$ids=strstr($ids,'vvvvv',true);
$ids=urldecode($ids);
    $turl2 = "https://live.douyin.com/webcast/room/web/enter/?aid=6383&app_name=douyin_web&live_id=1&device_platform=web&language=zh-CN&enter_from=web_live&cookie_enabled=true&screen_width=998&screen_height=562&browser_language=zh-CN&browser_platform=Win32&browser_name=Chrome&browser_version=79.0.3945.79&web_rid=7309824059863878450&enter_source=&is_need_double_stream=false";

$turl2 =curl_get2($turl2);
$arr=json_decode($turl2,true);

$vod_id=$arr['data']['data']['0']['id_str'];
$vod_name=$arr['data']['data']['0']['title'];

$vod_pic=$arr['data']['data']['0']['cover']['url_list']['0'];
$vod_actor=$vod_name;

$vod_director='江哥';

$vod_content='信江哥  得性福！！！';


$result='{"list":[{"vod_id":"'.$vod_id.'",';
$result=$result.'"vod_name":"'.$vod_name.'",';
$result=$result.'"vod_pic":"'.$vod_pic.'",';

$vod_year='create_time';

$result=$result.'"vod_year":"'.$vod_year.'",';

$vod_area='vod_area';

$result=$result.'"vod_area":"'.$vod_area.'",';

$type_name='vod_area';

$result=$result.'"type_name":"'.$type_name.'",';

if($vod_actor==null){
$vod_actor='江哥传媒';
}
$result=$result.'"vod_actor":"'.$vod_actor.'",';
if($vod_director==null){
$vod_director='江哥传媒';
}
$result=$result.'"vod_director":"'.$vod_director.'",';
$result=$result.'"vod_content":"'.$vod_content.'",';
$vod_play_from='';
$vod_play_url='';


 $from = '江哥专用';
 $murl = $arr['data']['data']['0']['stream_url']['flv_pull_url'];
 //print_r($murl);
 //$qxd = $arr['data']['data']['0']['stream_url']['default_resolution'];
 //$burl="http://192.168.1.100:8080/php/dyzb.php".'?url='.$murl;
 $murl = json_encode($murl,true);
$murl = str_replace('":"',"$",$murl);$murl = str_replace('","',"#",$murl);
$murl = str_replace('{"',"",$murl);$murl = str_replace('"}',"",$murl);
$murl=str_replace("\/","/",$murl);
$result= $result.'"vod_play_from":"'.$from.'",';
$result= $result.'"vod_play_url":"'.$murl.'"}]}';
echo $result;
}
else{
$url2='';
echo '{"class":[{"type_id":"2726","type_name":"舞蹈"},{"type_id":"2707","type_name":"音乐"},{"type_id":"2836","type_name":"情感"},{"type_id":"2842","type_name":"语音互动"},{"type_id":"2742","type_name":"户外"},{"type_id":"2791","type_name":"运动"},{"type_id":"2786","type_name":"美食"},{"type_id":"2751","type_name":"旅行"},{"type_id":"2823","type_name":"时尚"},{"type_id":"2800","type_name":"教育"},{"type_id":"2756","type_name":"人文艺术"}]}';
}


function curl_get($url){
  $header = array(
       'Accept: */*',
       'Accept-Language: zh-cn',
       'Referer: '.$url,
       'User-Agent: '.$UserAgent2,
       'Content-Type: application/x-www-form-urlencoded'
    );
        $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 20);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt ($curl, CURLOPT_HTTPHEADER , $header);
    curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent2);
    if($cookie2<>null){
    curl_setopt($curl, CURLOPT_COOKIE, $cookie2);
    }
    $data = curl_exec($curl);
    if (curl_error($curl)) {
        return "Error: ".curl_error($curl);
    } else {
	curl_close($curl);
	return $data;
    }
}

function curl_get2($url){
  $header = array(
'cookie: ttwid=1%7CT7Ucxsanob5ltbIIv6wFaTDhNIjb_u4EMVLhHYPRg5w%7C1670680176%7Cb88545b5e3626ad911958b91daa4e108294257e98ab761cc06ec19d4b752e5b6; passport_csrf_token=2bbcb20be414b1bb77796d14ae3c8c05; passport_csrf_token_default=2bbcb20be414b1bb77796d14ae3c8c05; home_can_add_dy_2_desktop=%221%22; odin_tt=422b990c6cfba4562b1d5d56a0bf9198d9a013e4a2fc50512830090cd2f4ef15d19c1a0e261745968e27bcdeab10225bfa5510f46e43b3fd98bf3a662ad0c6779185dca2a89cebbb9158d6f87b0aa7ac; csrf_session_id=6025a759f119fa5347a98ab694c835a1; xgplayer_user_id=497570667146; ttcid=bf3f9fbfbdc54e128077a0f18ab749e516; download_guide=%223%2F20221210%22; x-jupiter-uuid=16706887206645540; tt_scid=nr6crJztsPJVSlS4Bz7pmRpnglnqEYVmlVZUrIn7GmaQFzijI1h.-DL-nIipgL1q46fd; msToken=rHhbQ08pW8D9JMVjQGdZDILwmwpaA2gyx2vWeqlIZx4wxu0kQFEIny399hI3jZoWHMuwbuX_OxQPD-4JbvDUxB4UJfbQHQb3OckDoV-xi0smUzg1_WSIqHoYnrkHQT8=; msToken=y0ORQJ8TOWDiH-9lXQJSbuSvfZFtQA6QQ8VzGHt6uwZGpBbW8ZF01hmdNBuLyzJ1vhsSzces0lKxJg1MCrtSj9-O6ApbowAzFquVIptLucXCAGDFCzL12X6Vsvzz6iE=; __ac_nonce=06394be18003a3e4c67e3; __ac_signature=_02B4Z6wo00f01us..HQAAIDAPiRYL8PEvMLrH.jAANlorLfXjFQcsSSXXrC8iphL9NwTTcafKmtSjgCDB6Fec2hczk76.RcFPJ5La8cgXMkyQhwAlFg.O7ppSjBD5.14nHiOla6fUCZRnBL431; live_can_add_dy_2_desktop=%220%22',
'referer: https://live.douyin.com/',
'sec-fetch-mode: cors',
'sec-fetch-site: same-origin',
'user-agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36',
'x-secsdk-csrf-token: 000100000001078659b3c0b93aecc57cea5996b431fb8b44ad8fe877ddb2d269d9634dce2749172f7de22506551d'
    );
        $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 20);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt ($curl, CURLOPT_HTTPHEADER , $header);

    $data = curl_exec($curl);
    if (curl_error($curl)) {
        return "Error: ".curl_error($curl);
    } else {
	curl_close($curl);
	return $data;
    }
}

function curl_get3($url){
  $header = array(
       'Accept: */*',
       'Accept-Language: zh-cn',
       'Referer: http://k8b6.m72b.com/',
       'User-Agent: Mozilla/5.0 (Linux; Android 11; RMX2117 Build/RP1A.200720.011; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/96.0.4664.104 Mobile Safari/537.36 Html5Plus/1.0 (Immersed/36.666668)',
       'Content-Type: application/x-www-form-urlencoded'
    );
        $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 20);
    curl_setopt($curl, CURLOPT_NOBODY, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt ($curl, CURLOPT_HTTPHEADER , $header);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; Android 11; RMX2117 Build/RP1A.200720.011; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/96.0.4664.104 Mobile Safari/537.36 Html5Plus/1.0 (Immersed/36.666668)');
    curl_exec($curl);
    if (curl_error($curl)) {
        return "Error: ".curl_error($curl);
    } else {
  $info = curl_getinfo($curl,CURLINFO_EFFECTIVE_URL);
	curl_close($curl);
	return $info;
    }
}


function getSubstr($str, $leftStr, $rightStr) 
{
if($leftStr<>null && $rightStr<>null){
$left = strpos($str, $leftStr);
$right = strpos($str, $rightStr,$left+strlen($left));
if($left < 0 or $right < $left){
return '';
}
return substr($str, $left + strlen($leftStr),$right-$left-strlen($leftStr));
}else{
$str2=$str;
if($leftStr<>null){
$str2=str_replace($leftStr,'',$str2);
}
if($rightStr<>null){
$str2=str_replace($rightStr,'',$str2);
}
return $str2;
}
}

function replacestr($str2){
$test2=$str2;
$test2=str_replace("	","",$test2);
$test2=str_replace(" ","",$test2);
$test2 = preg_replace('/\s*/', '', $test2);
return $test2;
}

?>