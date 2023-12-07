<?php
header("Content-Type: text/html; charset=UTF-8");
libxml_use_internal_errors(true);

//建议php版本7 开启curl扩展
$typeid =$_GET["t"];
$page = $_GET["pg"];
$ids = $_GET["ids"];
$burl = $_GET["url"];
$wd = $_GET["wd"];

$web='https://duanju.one';

$searchable=1;

$gettype=1;

$cookie='';

$historyimg='https://www.hjunkel.com/images/nopic2.gif';

$UserAgent='Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36';

$zhilian=1;
$url1='/vodplay/';
$url2='-1-1.html';

$html = curl_get($web,$gettype,$cookie);
$dom = new DOMDocument();
$html= mb_convert_encoding($html ,'HTML-ENTITIES',"UTF-8");
$dom->loadHTML($html);
$dom->normalize();
$xpath = new DOMXPath($dom);
    $syquery="//div[contains(@class,'module-item-cover')]";
    $sytitle="//div[contains(@class,'module-item-cover')]//img/@data-src";
    $sy_pic="//div[contains(@class,'module-item-cover')]//img/@alt";
    $sy_link="//div[contains(@class,'module-item-cover')]/div/a/@href";
    $sy_bz="//div[@class='module-item-text']";

    $events = $xpath->query($syquery);
    $sytitleevents = $xpath->query($sytitle);
    $sy_picevents = $xpath->query($sy_pic);
    $sy_linkevents = $xpath->query($sy_link);
    $sy_bzevents = $xpath->query($sy_bz);
    
$a=$events->length;
$result9='{"code":1,"page":1,"pagecount":1,"total":'.$a.',"list":[';
    for ($i = 0; $i < $events->length; $i++) {
    $event = $events->item($i);
    $title = $sytitleevents->item($i)->nodeValue;
    $pic = $sy_picevents->item($i)->nodeValue;
    $link = $sy_linkevents->item($i)->nodeValue;
    $link =getSubstr($link,$url1,$url2);
    $text = $sy_bzevents->item($i)->nodeValue;
    
    $result.='{"vod_id":"'.$link.'","vod_name":"'.$title.'","vod_pic":"'.$pic.'","vod_remarks":"'.$text.'"},';
}

$movietype = '"class":[{"type_id":1,"type_name":"抖剧"},{"type_id":2,"type_name":"快剧"},{"type_id":3,"type_name":"都市"},{"type_id":26,"type_name":"穿越"},{"type_id":25,"type_name":"逆袭"},{"type_id":27,"type_name":"虐恋"},{"type_id":28,"type_name":"重生"},{"type_id":32,"type_name":"其他"}]}';
    $result=$result9.substr($result, 0, strlen($result)-1).'],';
  //echo $result;  
    $movietype=$result.$movietype;

$movietype =  preg_replace('/[\x00-\x1F\x80-\x9F]/u', '', trim($movietype));

$liebiao='https://duanju.one/vodtype/{typeid}-{pageid}.html';

$query="//div[contains(@class,'module-item-cover')]";
$picAttr="//div[contains(@class,'module-item-cover')]//img/@data-src";
$titleAttr="//div[contains(@class,'module-item-cover')]//img/@alt";
$linkAttr="//div[contains(@class,'module-item-cover')]/div/a/@href";
$query2 = "//div[@class='module-item-text']";

$detail='https://duanju.one/voddetail/{vodid}-1-1.html';
$vodtitle="//div[contains(@class,'video-info-header')]/h1";
$vodtype="//div[@class='video-info-aux scroll-content']/a[1]";
$vodimg="//div[@class='video-cover']//img/@data-src";
$vodtext="//div[@class='video-info-items'][8]/div/span";
$vodyear="//div[contains(@class,'tag-link')]/following-sibling::a[1]/text()";
$vodactor="//main[@id='main']/div[1]/div[1]/div[3]/div[2]/div[2]/div[1]/a/text()";
$voddirector="//main[@id='main']/div[1]/div[1]/div[3]/div[2]/div[1]//a/text()";
$vodarea="//a[@class='tag-link']/following-sibling::a[2]/text()";
$playname="//div[contains(@class,'module-tab-content')]//div[contains(@class,'module-tab-item tab-item')]/span/text()";
$playurl="//div[@class='scroll-content']";
$linkAttr5='href';


$searchtype=2;
$search=$web.'/index.php/ajax/suggest?mid=1&wd={wd}&limit=150';
$searchurl1='';
$searchurl2='';
$searchquery='list';
$searchtitleAttr='name';
$searchlinkAttr='id';
$searchpicAttr='pic';
$searchquery2 ='';

$weburl='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
if ($typeid<> null && $page<>null){
$catname ='';
$arr=json_decode($movietype,true);
$arr_q1a=$arr['class'];
$m=count($arr_q1a);
 for($i=0;$i<$m;$i++){
 $type_id = $arr_q1a[$i]["type_id"];
 if($typeid==$type_id){
  $catname =  $arr_q1a[$i]["catname"];
  break;
 }
 }
if($catname==null){
$liebiao=str_replace("{typeid}",$typeid,$liebiao);
}else{
$liebiao=str_replace("{typeid}",$catname,$liebiao);
}
$liebiao=str_replace("{pageid}",$page,$liebiao);
$html = curl_get($liebiao,$gettype,$cookie);
$dom = new DOMDocument();
$html= mb_convert_encoding($html ,'HTML-ENTITIES',"UTF-8");
$dom->loadHTML($html);
$dom->normalize();
$xpath = new DOMXPath($dom);
$texts = $xpath->query($query2);
if($texts->length==0 && $query3<>null){
$texts = $xpath->query($query3);
}
$events = $xpath->query($query);
$picevents = $xpath->query($picAttr);
if ($picevents->length==0 && $picAttr2<>null){
$picevents = $xpath->query($picAttr2);
}
$titleevents= $xpath->query($titleAttr);
$linkevents= $xpath->query($linkAttr);
$length=$events->length;
$guolv='';
if ($adable==1 && $page==1){
$length=$length+1;
}
if ($length<$num)
{
$page2=$page;
}else{
$length=$length+1;
$page2=$page + 1;
}
$result='{"code":1,"page":'.$page.',"pagecount":'. $page2 .',"total":'. $length.',"list":[';
if ($adable==1 && $page==1){
    $result=$result.'{"vod_id":1,"vod_name":"'.$adtitle1.'","vod_pic":"'.$adpicurl.'","vod_remarks":"'.$adtitle2.'"},';
}
for ($i = 0; $i < $events->length; $i++) {
    $event = $events->item($i);
    $text = $texts->item($i)->nodeValue;
    $text = replacestr($text);
    $link = $linkevents->item($i)->nodeValue;
    $title = $titleevents->item($i)->nodeValue;
    $title = replacestr($title);
    $pic = $picevents->item($i)->nodeValue;
      if($url1<>null){
       $link2 =getSubstr($link,$url1,$url2);
    }else{
    $link2 =$link;
    }
    
    	if (substr($pic,0,2)=='//'){
	$pic = 'http:'.$pic;
	}else if (substr($pic,0,4)<>'http' && $pic<>null){
	$pic = $web.$pic;
	}

if($guolv==null){
	    $result=$result.'{"vod_id":"'.$link2.'","vod_name":"'.$title.'","vod_pic":"'.$pic.'","vod_remarks":"'.$text.'"},';
    	$guolv=$guolv."{".$link2."}";
}else if(strpos($guolv, "{".$link2."}")==0){
	    $result=$result.'{"vod_id":"'.$link2.'","vod_name":"'.$title.'","vod_pic":"'.$pic.'","vod_remarks":"'.$text.'"},';
    	$guolv=$guolv."{".$link2."}";
	}
 
}

$result=substr($result, 0, strlen($result)-1).']}';
echo $result;

}else if ($ids<> null){
$detail=str_replace("{vodid}",$ids,$detail);
$html = curl_get($detail,$gettype,$cookie);
$dom = new DOMDocument();
$html= mb_convert_encoding($html ,'HTML-ENTITIES',"UTF-8");
$dom->loadHTML($html);
$dom->normalize();
$xpath = new DOMXPath($dom);
if($vodtitle<>null){
$texts = $xpath->query($vodtitle);
$text = $texts->item(0)->nodeValue;
$text = replacestr($text);
}
if($vodtype<>null){
$texts = $xpath->query($vodtype);
$type = $texts->item(0)->nodeValue;
$type = replacestr($type);
}
if($vodtext<>null){
$texts = $xpath->query($vodtext);
$vodtext2 = $texts->item(0)->nodeValue;
$vodtext2 = replacestr($vodtext2);
}
if($vodyear<>null){
$texts = $xpath->query($vodyear);
$year = $texts->item(0)->nodeValue;
$year = replacestr($year);
}
if($vodimg<>null){
$texts = $xpath->query($vodimg);
$img = $texts->item(0)->nodeValue;

	if (substr($img,0,2)=='//'){
	$img = 'http:'.$img;
	}else if (substr($img,0,4)<>'http' && $img<>null){
	$img = $web.$img;
	}
}
if($img==null){
$img =$historyimg;
}
if($vodarea<>null){
$texts = $xpath->query($vodarea);
$area = $texts->item(0)->nodeValue;
$area = replacestr($area);
}
if($vodactor<>null){
$texts = $xpath->query($vodactor);
$actor ='';
for ($i = 0; $i < $texts->length; $i++) {
    $event1 = $texts->item($i);
    $actor = $actor.$event1->nodeValue.' ';
}
}
if($voddirector<>null){
$texts = $xpath->query($voddirector);
$director ='';
for ($i = 0; $i < $texts->length; $i++) {
    $event1 = $texts->item($i);
    $director = $director.$event1->nodeValue.' ';
}
}

$result='{"list":[{"vod_id":"'.$ids.'",';
if($text<>null){
$result=$result.'"vod_name":"'.$text.'",';
}
if($text==null){
$result=$result.'"vod_name":"'."片名获取失败".'",';
}
if($img<>null){
$result=$result.'"vod_pic":"'.$img.'",';
}
if($type<>null){
$result=$result.'"type_name":"'.$type.'",';
}

if($year<>null){
$result=$result.'"vod_year":"'.$year.'",';
}

if($actor<>null){
$result=$result.'"vod_actor":"'.$actor.'",';
}

if($director<>null){
$result=$result.'"vod_director":"'.$director.'",';
}
if($area<>null){
$result=$result.'"vod_area":"'.$area.'",';
}
if($vodtext2<>null){
$vodtext2=str_replace('"','\"',$vodtext2);
$result=$result.'"vod_content":"'.$vodtext2.'",';
}

$yuan = '';
$dizhi = '';

$text1 = $xpath->query($playname);
$text2 = $xpath->query($playurl);

if($text2->length==0){
$result= $result.'"vod_play_from":"'."原页面".'",';
$result= $result.'"vod_play_url":"'.$detail.'"}]}';
}else{
if($playname<>null){
for ($i = 0; $i < $text2->length; $i++) {
    $event1 = $text1->item($i);
    $bfyuan = $event1->nodeValue;
    $bfyuan = replacestr($bfyuan);
    $yuan = $yuan.$bfyuan.'$$$';
}
}

if($yuan==''){
for ($i = 0; $i < $text2->length; $i++) {
    $bfyuan =$i+1;
    $yuan = $yuan."播放源".$bfyuan.'$$$';
}
}
foreach ($text2 as $oObject) {
$dizhi2 = '';
        foreach($oObject->childNodes as $col){
        if ($col->hasChildNodes()){
            $link4 = $col->getAttribute($linkAttr5);
            if($link4<>null){
            $text4 = $col->nodeValue;
            $text4 = replacestr($text4);
	         if (substr($link4,0,4)<>'http' && $link4<>null){
	        $link4 = $web.$link4;
	        }
	        if($zhilian==1){
        $dizhi2 = $dizhi2.$text4.'$'.$weburl.'?url='.$link4.'#';
        }else{
        $dizhi2 = $dizhi2.$text4.'$'.$link4.'#';
        }
        }else{          
            foreach($col->childNodes as $col2){
            if ($col2->hasChildNodes()){
             $link4 = $col2->getAttribute($linkAttr5);
            if($link4<>null){
            $text4 = $col2->nodeValue;
            $text4 = replacestr($text4);
	         if (substr($link4,0,4)<>'http' && $link4<>null){
	        $link4 = $web.$link4;
	        }
          if($zhilian==1){
        $dizhi2 = $dizhi2.$text4.'$'.$weburl.'?url='.$link4.'#';
        }else{
        $dizhi2 = $dizhi2.$text4.'$'.$link4.'#';
        }
        }else{
           foreach($col2->childNodes as $col3){
            if ($col3->hasChildNodes()){
             $link4 = $col3->getAttribute($linkAttr5);
            if($link4<>null){
            $text4 = $col3->nodeValue;
            $text4 = replacestr($text4);
	         if (substr($link4,0,4)<>'http' && $link4<>null){
	        $link4 = $web.$link4;
	        }
          if($zhilian==1){
        $dizhi2 = $dizhi2.$text4.'$'.$weburl.'?url='.$link4.'#';
        }else{
        $dizhi2 = $dizhi2.$text4.'$'.$link4.'#';
        }
        }else{
           foreach($col3->childNodes as $col4){
            if ($col4->hasChildNodes()){
             $link4 = $col4->getAttribute($linkAttr5);
            if($link4<>null){
            $text4 = $col4->nodeValue;
            $text4 = replacestr($text4);
	         if (substr($link4,0,4)<>'http' && $link4<>null){
	        $link4 = $web.$link4;
	        }
          if($zhilian==1){
        $dizhi2 = $dizhi2.$text4.'$'.$weburl.'?url='.$link4.'#';
        }else{
        $dizhi2 = $dizhi2.$text4.'$'.$link4.'#';
        }
        }else{
        foreach($col4->childNodes as $col5){
            if ($col5->hasChildNodes()){
             $link4 = $col5->getAttribute($linkAttr5);
            if($link4<>null){
            $text4 = $col5->nodeValue;
            $text4 = replacestr($text4);
	         if (substr($link4,0,4)<>'http' && $link4<>null){
	        $link4 = $web.$link4;
	        }
          if($zhilian==1){
        $dizhi2 = $dizhi2.$text4.'$'.$weburl.'?url='.$link4.'#';
        }else{
        $dizhi2 = $dizhi2.$text4.'$'.$link4.'#';
        }}}}}}}}}}}}}}}}
        if($dizhi2==null){
                $dizhi=$dizhi.'无播放地址 请更换其他源$http'.'$$$';
        }else{
                $dizhi=$dizhi.substr($dizhi2, 0, strlen($dizhi2)-1).'$$$';
        }
    }
$result= $result.'"vod_play_from":"'.substr($yuan, 0, strlen($yuan)-3).'",';
$result= $result.'"vod_play_url":"'.substr($dizhi, 0, strlen($dizhi)-3).'"}]}';
}
echo $result;
}else  if ($burl<> null){

$html = curl_get($burl,$gettype,$cookie);
$content=getSubstr($html,'var player','</script>');
$content=getSubstr($content,'"url":"','",');
$content=str_replace("\/","/",$content);

if(strpos($content,"qq.com")>0 or strpos($content,"youku.com")>0 or strpos($content,"iqiyi.com")>0 or strpos($content,"mgtv.com")>0){
$content=$vip.$content;
}
echo  '<iframe src="'.$content.'" class="iframeStyle" id="myiframe" ></iframe>';

}else  if ($wd<> null){

if($searchable==0){
echo 'php中未开启搜索';
exit;
}
if($page==null){
$page=1;
}
$geturl =str_replace("{wd}",urlencode($wd),$search);
$geturl =str_replace("{page}",$page,$geturl);
$html = curl_get($geturl,$gettype,$cookie);
if($searchtype==1){
$dom = new DOMDocument();
$html= mb_convert_encoding($html ,'HTML-ENTITIES',"UTF-8");
$dom->loadHTML($html);
$dom->normalize();
$xpath = new DOMXPath($dom);
$texts = $xpath->query($searchquery2);
$events = $xpath->query($searchquery);
$titleevents= $xpath->query($searchtitleAttr);
$linkevents= $xpath->query($searchlinkAttr);
$length=$events->length;
$result='{"code":1,"page":'.$page.',"pagecount":'. $page.',"total":'. $length.',"list":[';
for ($i = 0; $i < $events->length; $i++) {
    $event = $events->item($i);
    $text = $texts->item($i)->nodeValue;
    $link = $linkevents->item($i)->nodeValue;
    $title = $titleevents->item($i)->nodeValue;
    if($searchurl1<>null){
        $link2 =getSubstr($link,$searchurl1,$searchurl2);
    }else{
    $link2 =$link;
    }
    $result=$result.'{"vod_id":'.$link2.',"vod_name":"'.$title.'","vod_remarks":"'.$text.'"},';
}
$result=substr($result, 0, strlen($result)-1).']}';
echo $result;
}else{
$arr=json_decode($html,true);
$arr_q1a=$arr[$searchquery];
$m=count($arr_q1a);
$result='{"code":1,"page":'.$page.',"pagecount":'. $page.',"total":'. $m.',"list":[';
 for($i=0;$i<$m;$i++){
 $title = $arr_q1a[$i][$searchtitleAttr];
$link =  $arr_q1a[$i][$searchlinkAttr];
$pic =  $arr_q1a[$i][$searchpicAttr];
if($searchquery2<>null){
$text = $arr_q1a[$i][$searchquery2];
$result=$result.'{"vod_id":'.$link.',"vod_name":"'.$title.'","vod_remarks":"'.$text.'"},';
}else{
$result=$result.'{"vod_id":'.$link.',"vod_name":"'.$title.'","vod_pic":"'.$pic.'"},';
}
 }
 $result=substr($result, 0, strlen($result)-1).']}';
echo $result;
}

}else{
echo $movietype;
}

function curl_get($url,$gettype2,$cookie2){

   if($gettype2==2){
    $data = file_get_contents($url);
    	return $data;
    }else{
        $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 20);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
    if($cookie2<>null){
    curl_setopt($curl, CURLOPT_COOKIE, $cookie2);
    }
    $ip=Rand_IP();
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$ip, 'CLIENT-IP:'.$ip));
    $data = curl_exec($curl);
    if (curl_error($curl)) {
        return "Error: ".curl_error($curl);
    } else {
	curl_close($curl);
	return $data;
    }
    }
}

function Rand_IP(){
    $ip2id= round(rand(600000, 2550000) / 10000); 
    $ip3id= round(rand(600000, 2550000) / 10000);
    $ip4id= round(rand(600000, 2550000) / 10000);
    $arr_1 = array("218","218","66","66","218","218","60","60","202","204","66","66","66","59","61","60","222","221","66","59","60","60","66","218","218","62","63","64","66","66","122","211");
    $randarr= mt_rand(0,count($arr_1)-1);
    $ip1id = $arr_1[$randarr];
    return $ip1id.".".$ip2id.".".$ip3id.".".$ip4id;
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