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
    $turl2 = $weburl . "sreach/video?https://live.kuaishou.com/live_api/liveroom=" . $typeid . "&current=" . $page . "&every=10";
} else {

    $turl2 = "https://live.kuaishou.com/live_api/non-gameboard/list?pageSize=200&filterType=0&gameId=$typeid&keyword=&cursor=";

    $turl2 =curl_get2($turl2);

$arr=json_decode($turl2,true);
$cursor=$arr['data']['cursor'];

if ($page == '2') {

$turl2 = "https://live.kuaishou.com/live_api/non-gameboard/list?pageSize=200&filterType=0&gameId=$typeid&keyword=&cursor=$cursor";
$turl2 =curl_get2($turl2);
//
$arr=json_decode($turl2,true);
}
$cursor=$arr['data']['cursor'];
if ($page == '3') {

$turl2 = "https://live.kuaishou.com/live_api/non-gameboard/list?pageSize=200&filterType=0&gameId=$typeid&keyword=&cursor=$cursor";
$turl2 =curl_get2($turl2);
//
$arr=json_decode($turl2,true);
}
$cursor=$arr['data']['cursor'];
if ($page == '4') {

$turl2 = "https://live.kuaishou.com/live_api/non-gameboard/list?pageSize=200&filterType=0&gameId=$typeid&keyword=&cursor=$cursor";
$turl2 =curl_get2($turl2);
//
$arr=json_decode($turl2,true);
}
$cursor=$arr['data']['cursor'];
if ($page == '5') {

$turl2 = "https://live.kuaishou.com/live_api/non-gameboard/list?pageSize=200&filterType=0&gameId=$typeid&keyword=&cursor=$cursor";
$turl2 =curl_get2($turl2);
//
$arr=json_decode($turl2,true);
}
$cursor=$arr['data']['cursor'];


$arr_q1a=$arr['data']['list'];
$m=count($arr_q1a);
if($m<>null){
$page2=$page+1;
$length=$m+1;
}

$result='{"code":1,"page":'.$page.',"pagecount":'. $page2.',"total":'. $length.',"list":[';
 for($i=0;$i<$m;$i++){
$title = $arr_q1a[$i]['author']['name'];
if($title==null){
$title =  $arr_q1a[$i]['title'];
}
$link =  $arr_q1a[$i]['author']['id'];
if($link==null){
$link =  $arr_q1a[$i]['nextlink'];
$len1= strpos($link, 'ids=') + 4;
$link = substr($link,$len1,strlen($link)-$len1);
}
$text =  $arr_q1a[$i]['gameInfo']['name'];
if($text==null){
$text =  $arr_q1a[$i]['state'];
}
$vod_pic =  $arr_q1a[$i]['author']['avatar'];
if($vod_pic==null){
$vod_pic =  $arr_q1a[$i]['poster'];
}
$playl=$arr_q1a[$i]['playUrls']['0']['adaptationSet']['representation'];

$arr1=json_encode($playl,true);
$arr1=urlencode($arr1);

$link=$link.'@1@'.$title.'@2@'.$vod_pic.'@3@'.$arr1.'@4@';
$link=urlencode($link);

$result=$result.'{"vod_id":"'.$link.'","vod_name":"'.$title.'","vod_pic":"'.$vod_pic.'","vod_remarks":"'.$text.'"},';
}
$result=substr($result, 0, strlen($result)-1).']}';
}echo $result;


}else if ($ids<> null){

$ids=urldecode($ids);

$vod_id=strstr($ids,'@1@',true);
$vod_name=getSubstr($ids,'@1@','@2@');

$vod_pic=getSubstr($ids,'@2@','@3@');
$vod_actor=$vod_name;

$vod_director='江哥';

$vod_content='信江哥  得性福！！！';


$result='{"list":[{"vod_id":"'.$vod_id.'",';
$result=$result.'"vod_name":"'.$vod_name.'",';
$result=$result.'"vod_pic":"'.$vod_pic.'",';

$vod_year=$arr['data']['create_time'];

$result=$result.'"vod_year":"'.$vod_year.'",';

$vod_area=$arr['data']['vod_area'];

$result=$result.'"vod_area":"'.$vod_area.'",';

$type_name='';

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


if($vod_id<>null){
$play=getSubstr($ids,'@3@','@4@');
$play=urldecode($play);

$arr_q1a=json_decode($play,true);
$m=count($arr_q1a);
 for($i=0;$i<$m;$i++){
 $from = '江哥专用';
 $name=$arr_q1a[$i]['name'];
 $murl = $arr_q1a[$i]['url'];
$murl= $name.'$'.$murl.'#';

}

$vod_play_from=$vod_play_from.$from;
$vod_play_url=$vod_play_url.$murl;

}

$vod_play_url=substr($vod_play_url, 0, strlen($vod_play_url)-1);
$result= $result.'"vod_play_from":"'.$vod_play_from.'",';
$result= $result.'"vod_play_url":"'.$vod_play_url.'"}]}';
echo $result;


}else{
$url2='';

echo '{"class":[{"type_id":"1000002","type_name":"舞蹈"},{"type_id":"1000001","type_name":"明星"},{"type_id":"1000006","type_name":"颜值"},{"type_id":"1000005","type_name":"脱口秀"},{"type_id":"1000003","type_name":"音乐"},{"type_id":"1000007","type_name":"情感"},{"type_id":"1000004","type_name":"才艺"},{"type_id":"1000011","type_name":"美妆"},{"type_id":"1000019","type_name":"文玩"},{"type_id":"1000018","type_name":"母婴"},{"type_id":"1000008","type_name":"汽车"},{"type_id":"1000020","type_name":"购物"},{"type_id":"1000016","type_name":"健康"},{"type_id":"1000015","type_name":"田园"},{"type_id":"1000014","type_name":"旅游"},{"type_id":"1000012","type_name":"钓鱼"},{"type_id":"1000021","type_name":"媒体"},{"type_id":"1000024","type_name":"其他"},{"type_id":"1000010","type_name":"萌宠"},{"type_id":"1000009","type_name":"美食"},{"type_id":"1000023","type_name":"科普"},{"type_id":"1000022","type_name":"教育"}]}';

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
'Accept-Language: zh-CN,zh;q=0.9',
'Connection: keep-alive',
'Cookie: clientid=3; did=web_104d1d1b6e25f66d9020e876049e7791; client_key=65890b29; kpn=GAME_ZONE; ksliveShowClipTip=true; didv=1671165426000; kuaishou.live.bfb1s=7206d814e5c089a58c910ed8bf52ace5; SL_G_WPT_TO=zh-CN; SL_GWPT_Show_Hide_tmp=1; SL_wptGlobTipTmp=1',
'Host: live.kuaishou.com',
'Sec-Fetch-Mode: navigate',
'Sec-Fetch-Site: none',
'Sec-Fetch-User: ?1',
'Upgrade-Insecure-Requests: 1',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36'
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