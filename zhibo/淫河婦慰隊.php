<?php
header("Content-Type: text/html; charset=UTF-8");
libxml_use_internal_errors(true);

$typeid =$_GET["t"];
$page = $_GET["pg"];
$ids = $_GET["ids"];
$wd = $_GET["wd"];

$web='https://avwto.com';
$sy='https://avwto.com/_next/data/Xmd0HtXiwPh5N2_5vq16n/zh-TW.json';
$sy = curl_get($sy);$sy=str_replace('],"uncensoredArticles":[',',',$sy);
$arr=json_decode($sy,true);
$arr1=$arr['pageProps']['longfilmHomeModuleItems']['0']['censoredArticles'];
$arr2=$arr['pageProps']['longfilmHomeModuleItems']['1']['censoredArticles'];
$data = array_merge($arr1, $arr2);
foreach ($data as $key => $value) {
    if ($value['id'] == 0) {
        unset($data[$key]);
    }
}
$data = array_values($data);
$m=count($data);
for($i=0;$i<$m;$i++){
$title=$data[$i]['title'];
$link=$data[$i]['uuid'];
$pic=$web.$data[$i]['cover']['url'];
$text=$data[$i]['videoLength'];
$text =  HMS($text);
$result.='{"vod_id":"'.$link.'","vod_name":"'.$title.'","vod_pic":"'.$pic.'","vod_remarks":"'.$text.'"},';
}
$result9='{"code":1,"page":1,"pagecount":1,"total":'.$m.',"list":[';
$result=$result9.substr($result, 0, strlen($result)-1).'],';
//echo $result;
$movietype='"class":[{"type_id":"6633310442594197b9f824d8e227b4d8","type_name":"中文字幕"},{"type_id":"4ecca30b0c3f46089473b280f524c190","type_name":"有碼"},{"type_id":"c5117184ab9e4255a2819a5a503a5fcd","type_name":"無碼"},{"type_id":"3f19ac6c5927479aba635bcc1caf7d33","type_name":"獨家AV"},{"type_id":"44785f50798d42168aa1272eef9ee2df","type_name":"熟女人妻"},{"type_id":"91e043b3788c4b0e87f710c3de8b0b0b","type_name":"多片合輯"},{"type_id":"670ca1f27a5140bb961ba6d9a89008f4","type_name":"素人"},{"type_id":"531d0b9bb53d45029c34a698a0165b6f","type_name":"歐美無碼"}]}';
$movietype=$result.$movietype;


if ($typeid<> null && $page<>null){
$arr=json_decode($movietype,true);
$arr_q1a=$arr['class'];
$m=count($arr_q1a);
 for($i=0;$i<$m;$i++){
 $type_id = $arr_q1a[$i]["type_id"];
  if($typeid==$type_id){
 $catname =  $arr_q1a[$i]["catname"];
  }
 }

$liebiao='https://avwto.com/_next/data/Xmd0HtXiwPh5N2_5vq16n/zh-TW/category/longfilm.json?tagUuid={typeid}&page={pageid}&path=longfilm';

$liebiao=str_replace("{typeid}",$typeid,$liebiao);
$liebiao=str_replace("{pageid}",$page,$liebiao);
//print_r($liebiao);
$html = curl_get($liebiao);
$html= mb_convert_encoding($html ,'HTML-ENTITIES',"UTF-8");
$arr=json_decode($html,true);
$arr_q1a=$arr['pageProps']['articles'];
$m=count($arr_q1a);

if($m<>null){
$page2=$page+1;
$length=$m+1;
}

$result='{"code":1,"page":'.$page.',"pagecount":'. $page2.',"total":'. $length.',"list":[';
 for($i=0;$i<$m;$i++){
$title = $arr_q1a[$i]['title'];
$title = str_replace("'","\'",$title);
$title = str_replace('"','\"',$title);
$link =  $arr_q1a[$i]['uuid'];
$text =  $arr_q1a[$i]['videoLength'];
$text =  HMS($text);
$vod_pic =  $web.$arr_q1a[$i]['cover']['url'];

$result=$result.'{"vod_id":"'.$link.'","vod_name":"'.$title.'","vod_pic":"'.$vod_pic.'","vod_remarks":"'.$text.'"},';
}
$result=substr($result, 0, strlen($result)-1).']}';
echo $result;
}else if ($ids<> null){
$detail="https://avwto.com/_next/data/Xmd0HtXiwPh5N2_5vq16n/zh-TW/article/$ids.json?uuid=$ids";
$html = curl_get($detail);
$arr=json_decode($html,true);
$title = $ids;
$text = $arr['pageProps']['seo']['description'];
$img = $web.$arr['pageProps']['article']['cover']['url'];
$actors = $arr['pageProps']['article']['actors'];
$a=count($actors);
for($i=0;$i<$a;$i++){
$actor.=$actors[$i]['name'].' ';
}
$dur = $arr['pageProps']['article']['videoLength'];
$num = ceil($dur / 6);
$content="http://192.168.1.105:8080/w/h/cesi.php?jx=https://avwto.com/api/v1/article-video-preview/$ids???$num.m3u8";

$result='{"list":[{"vod_id":"'.$ids.'",';
$result=$result.'"vod_name":"'.$title.'",';
$result=$result.'"vod_pic":"'.$img.'",';
$result=$result.'"vod_actor":"'.$actor.'",';
$result=$result.'"vod_content":"'.$text.'",';

$result= $result.'"vod_play_from":"'."$title".'",';
$result= $result.'"vod_play_url":"'.$content.'"}]}';
echo $result;
}else  if ($wd<> null){
$search='https://avwto.com/_next/data/Xmd0HtXiwPh5N2_5vq16n/zh-TW/search.json?k='.$wd.'&isLongfilm=1&page=2';
$html = curl_get($search);
$html= mb_convert_encoding($html ,'HTML-ENTITIES',"UTF-8");
$arr=json_decode($html,true);
$arr_q1a=$arr['pageProps']['articles'];
$m=count($arr_q1a);

if($m<>null){
$page2=$page+1;
$length=$m+1;
}

$result='{"code":1,"page":'.$page.',"pagecount":'. $page2.',"total":'. $length.',"list":[';
 for($i=0;$i<$m;$i++){
$title = $arr_q1a[$i]['title'];
$title = str_replace("'","\'",$title);
$title = str_replace('"','\"',$title);
$link =  $arr_q1a[$i]['uuid'];
$text =  $arr_q1a[$i]['videoLength'];
$text =  HMS($text);
$vod_pic =  $web.$arr_q1a[$i]['cover']['url'];

$result=$result.'{"vod_id":"'.$link.'","vod_name":"'.$title.'","vod_pic":"'.$vod_pic.'","vod_remarks":"'.$text.'"},';
}
$result=substr($result, 0, strlen($result)-1).']}';
echo $result;
}else{
echo $movietype;
}

function curl_get($url){

        $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 20);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
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
function HMS($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds / 60) % 60);
    $seconds = $seconds % 60;
 
    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
}
?>