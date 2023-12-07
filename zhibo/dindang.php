<?php
header("Content-Type: text/html; charset=UTF-8");
libxml_use_internal_errors(true);

$typeid =$_GET["t"];
$page = $_GET["pg"];
$ids = $_GET["ids"];
$wd = $_GET["wd"];


$aaa='https://b.zxtx9.com/api.php/provide/vod?ac=list';
$aaa = curl_get($aaa);
$arr1=json_decode($aaa,true);
$bbb='https://b.zxtx9.com/api.php/provide/vod?ac=detail';
$bbb = curl_get($bbb);
$arr2=json_decode($bbb,true);
$arr=array_replace($arr1,$arr2);
$movietype = json_encode($arr, true);
$movietype=str_replace("img.test.com","ddd.ztxh-bj.com",$movietype);
$movietype=str_replace(".jpg",".dat",$movietype);

if ($typeid<> null && $page<>null){
$liebiao='https://b.zxtx9.com/api.php/provide/vod?ac=detail&t='.$typeid.'&pg='.$page;
$result = curl_get($liebiao);
$result=str_replace("img.test.com","ddd.ztxh-bj.com",$result);
$result=str_replace(".jpg",".dat",$result);
echo $result;
}else if ($ids<> null){
$detail='https://b.zxtx9.com/api.php/provide/vod?ac=detail&ids='.$ids;
$result = curl_get($detail);
$result=str_replace("img.test.com","ddd.ztxh-bj.com",$result);
$result=str_replace(".jpg",".dat",$result);
$result=str_replace("ddb.ztxh","dda.ztxh",$result);
echo $result;
}else  if ($wd<> null){
$search='https://b.zxtx9.com/api.php/provide/vod?ac=detail&wd='.$wd;
$result = curl_get($search);
$result=str_replace("img.test.com","ddd.ztxh-bj.com",$result);
$result=str_replace(".jpg",".dat",$result);
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

?>