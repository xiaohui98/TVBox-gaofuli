<?php
header("Content-Type: text/html; charset=UTF-8");
libxml_use_internal_errors(true);

//建议php版本7 开启curl扩展
$typeid =$_GET["t"];
$page = $_GET["pg"];
$ids = $_GET["ids"];
$burl = $_GET["url"];
$wd = $_GET["wd"];
$ts = $_GET['ts'];


//===============================================基础配置开始===========================================
$web='https://javdb523.com';

//1=开启搜索  0=关闭搜索 默认关闭搜索（极品有验证码 开启无效，搜索框架仅供参考）
$searchable=1;


$gettype=1;

//$gettype=1时设置cookie有效，如不懂可以不填写(针对奈菲这样子的，就需要写入cookie才能访问)
$cookie='';

$movietype ='{"class":[{"type_id":1,"type_name":"有碼","catname":"tags?c10=1,6,7,2"},{"type_id":2,"type_name":"無碼","catname":"tags/uncensored?c10=1"},{"type_id":3,"type_name":"歐美","catname":"tags/western?c10=1"}]}';
//===============================================影视分类相关配置结束===========================

//取出影片ID的文本左边
$url1='/v/';

//取出影片ID的文本右边
$url2='';

//影视列表链接 {pageid}=页码  {typeid}=类目ID    如果$movietype的catname不为空的话，{typeid}会被自动替换为相应的catname内容
$liebiao=$web.'/{typeid}&page={pageid}';
//每页多少个影片
$num=40;

//xpath列表
$query="//div[contains(@class,'movie-list')]/div[@class='item']";

//取出影片的图片
$picAttr="//div[contains(@class,'movie-list')]/div[@class='item']//@src";

//取出影片的标题
$titleAttr="//div[contains(@class,'movie-list')]/div[@class='item']//a/div[@class='video-title']";

//取出影片的链接
$linkAttr="//div[contains(@class,'movie-list')]/div[@class='item']//a/@href";

//影视更新情况 例如：更新至*集
$query2 = "//div[contains(@class,'movie-list')]/div[@class='item']/a/div[@class='meta']";
$query3 = "//div[contains(@class,'movie-list')]/div[@class='item']/a/div[contains(@class,'cover')]";


//=====================苹果CMS通用模板修改以下内容即可=============================
//影片链接 {vodid}=影片ID 
$detail='https://us13.proxysite.com{vodid}';

//影片名称
$vodtitle="//div[@class='panel-block first-block']/span";

//影片类型
$vodtype="//div[@class='panel-block']/strong[text()='類別:']/following-sibling::span";

//取出影片图片 猫的详情图片显示在历史记录里（历史记录图片没有的话，就是这个没取对）
$vodimg="//div[@class='tile-images preview-images']/a/img/@src";

//取出影片简介
$vodtext="//h2/strong[@class='current-title']";

//取出影片年份
$vodyear="//div[@class='panel-block']/strong[text()='日期:']/following-sibling::span";

//取出影片主演
$vodactor="//div[@class='panel-block']/strong[text()='演員:']/following-sibling::span";

//取出影片导演
$voddirector="//div[@class='panel-block']/strong[text()='導演:']/following-sibling::span";

//取出影片地区
$vodarea="//div[@class='panel-block']/strong[text()='片商:']/following-sibling::span";

//播放地址名称 //div[contains(@class,'-panel__head') and contains(@class, 'clearfix')]/ul/li/a
//为了通用性，没有取出播放源名称，会xpath的可以自己填写进去 例子如上
$playname="//div[contains(@class,'module-tab-content')]//div[contains(@class,'module-tab-item tab-item')]/span/text()";

//播放地址 自动往下级尝试查找5次并取链接 如第二次就找到链接，就会从第二个下级中获取
$playurl="$detail";

//取出影片的全部播放链接  链接标识一般为href，不用修改
$linkAttr5='href';
//===============================================影视详情相关配置结束===========================







//===============================================影视搜索相关配置开始===========================
//=========下面把xpath规则的搜索屏蔽了，极品采用json的搜索结果========


//影片搜索返回结果 1=htm代码套用xpath规则   2=json结果
//$searchtype=1;
$searchtype=1;

//影片搜索 {wd}=搜索文字
//$searchtype=1的网址
//$search='https://www.jpysvip.net/vodsearch/-------------.html?wd={wd}&submit=';
//$searchtype=2的网址
//$search='https://www.jpysvip.net/index.php/ajax/suggest?mid=1&wd={wd}&limit=10';
//通用模板 $web=前面设置的网址
$search=$web.'/search?q={wd}';

//htm代码分析用xpath取影片，取出影片ID的文本左边
//$searchurl1='/voddetail/';
$searchurl1='/v/';

//htm代码分析用xpath取影片，取出影片ID的文本右边
//$searchurl2='.html';
//json直接返回影片ID，不用取值
$searchurl2='';

//xpath列表
//$searchquery='//ul[@class="myui-vodlist__media clearfix"]/li/div/a';
//json路径
$searchquery="//div[contains(@class,'movie-list')]/div[@class='item']";

//xpath规则取出影片的标题
//$searchtitleAttr='//ul[@class="myui-vodlist__media clearfix"]/li/div/a/@title';
//json取影片标题
$searchtitleAttr="//div[contains(@class,'movie-list')]/div[@class='item']//a/div[@class='video-title']";
$searchpicAttr="//div[contains(@class,'movie-list')]/div[@class='item']//@src";
//xpath规则取出影片的链接
//$searchlinkAttr='//ul[@class="myui-vodlist__media clearfix"]/li/div/a/@href';
//json取出影片的ID
$searchlinkAttr="//div[contains(@class,'movie-list')]/div[@class='item']//a/@href";

//xpath规则取影视更新情况 例如：更新至*集
//$searchquery2 = '//ul[@class="myui-vodlist__media clearfix"]/li/div/a/span[@class="pic-text text-right"]';
//json取影视更新情况 极品没有更新情况，所以留空
$searchquery2 ="//div[contains(@class,'movie-list')]/div[@class='item']/a/div[contains(@class,'cover')]";
//===============================================影视搜索相关配置结束===========================
//==============================================仅需修改以上代码↑=======================================








//==============================================以下内容的代码无需修改↓=======================================
//$weburl='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
if ($typeid<> null && $page<>null){
//==============================================读取影视列表开始=======================================
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
$aaa='https://us13.proxysite.com/includes/process.php?action=update';
$bbb=urlencode($liebiao);
$pdata='d='.$bbb.'&allowCookies=on';
$headerArray = array(
'Host: us13.proxysite.com',
'Connection: keep-alive',
//'Content-Length: 84',
'Cache-Control: max-age=0',
'Origin: https://us13.proxysite.com',
'Upgrade-Insecure-Requests: 1',
'Content-Type: application/x-www-form-urlencoded',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36',
'Sec-Fetch-User: ?1',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'Sec-Fetch-Site: same-origin',
'Sec-Fetch-Mode: navigate',
'Referer: https://us13.proxysite.com//',
//'Accept-Encoding: gzip, deflate, br',
'Accept-Language: zh-CN,zh;q=0.9',
'Cookie: PHPSESSID=cpj0e1df2nfg2jjrlibg2st0l1; c[fs1.app][/][PHPSESSID]=nftolbag6l6ipvvbb25gap9lph; c[shukriya90.com][/][nauid]=keoW5bgKXp4JHkWsZMNw; c[labadena.com][/][nauid]=98GjiY3Yhwltf1LCNH6F; c[admjmp.com][/][__cflb]=02DiuDFRFiBZBvMSLtqGxuZp8RQcjVh52Zwr4b3HRow24; c[fs1.app][/][kt_ips]=54.39.48.111%252C198.50.155.77; _ga_1DTX7D4FHE=GS1.1.1701589802.2.1.1701593893.0.0.0; __gads=ID=598cb74e32cbae80:T=1701586662:RT=1702109738:S=ALNI_MaJJ6AYg6Ttbs7q70u8dYUUpFsrQQ; __gpi=UID=00000d01c3ef7776:T=1701586662:RT=1702109738:S=ALNI_MaHHcRV53AnfYfccJ1BhwoS8Nd-qw; _gid=GA1.2.432646802.1702109765; _ga_ZPZ1ZJ9RFM=GS1.2.1702109819.3.0.1702109819.0.0.0; c[javdb523.com][/][list_mode]=h; c[javdb523.com][/][theme]=auto; c[javdb523.com][/][locale]=zh; c[javdb523.com][/][over18]=1; c[javdb523.com][/][_jdb_session]=LyJOUqwCWftX4rN0NbEO4KjhiYWgPDaLpBHSUgnuuWHaiTmOO6G%252FsFCsDeW%252F1YAnvGBJ5WG9UC%252F49NTSy%252FWbST8Wc9xSLbmtSybRpYW4FhNimC3cwk%252FcgVt26BCv7bVLvXnpqbEF4wFo4r2BAFnx1TvaYjeXUt21%252Bd0cBMl7VsItaOctvPKqjjphCszbsLVwDsr2DDbC3HugZt0%252FiXaoZeTyV1PechenNo5JB3fQWMjnhPzZRLCOK8ZiFIdEExpAX7sVef6zgi%252FhCsHZFRdgUSe4SoHW5VmAkkI8I8BjHO6zBpv%252BkS5UU4va--Y9fG3EXugk%252FhavP5--xIJ6Xpfpe2%252Bblcg9Ac6DnA%253D%253D; _ga_NHGYEQW4VX=GS1.1.1702109852.2.0.1702109852.0.0.0; _ga=GA1.1.2144560154.1701586656; c[yandex.ru][/][_yasc]=hlBQgrZPbGklbrnJP8D6GUMWOb47M5tCwueDM1ZDz6oFTmxuz%2BIOpJGqNOOjHmQP; c[yandex.ru][/][i]=nAOt27rhco0Tgieb13U3YShywphMFPuvUesmce59ndzI%2F75C%2Fx6aidjaA%2BVgws15V22G1Tg%2BNld0OZ3Zlnk8HP7FOHg%3D; c[yandex.ru][/][yandexuid]=6931121191702109873; _ym_uid=1702109874384383667; _ym_d=1702109874; c[mc.yandex.com][/][sync_cookie_csrf]=1035582693fake; c[yandex.com][/][_yasc]=oRbNFg2tC8JGLmleK8pHlUr7LposHAaqoqyRZ%2FT9LJdQEA0Vap3FSxQG19n3B4awJg%3D%3D; _ym_isad=2; c[mc.yandex.ru][/][sync_cookie_csrf]=1080808175fake; c[yandex.com][/][yandexuid]=6931121191702109873; c[yandex.com][/][yuidss]=6931121191702109873; c[yandex.com][/][i]=nAOt27rhco0Tgieb13U3YShywphMFPuvUesmce59ndzI%2F75C%2Fx6aidjaA%2BVgws15V22G1Tg%2BNld0OZ3Zlnk8HP7FOHg%3D; c[yandex.com][/][yp]=1702196279.yu.360843081702109877; c[yandex.com][/][ymex]=1704701879.oyu.360843081702109877; c[mc.yandex.com][/][sync_cookie_ok]=synced'
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $aaa);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $pdata);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArray);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl,  CURLOPT_FOLLOWLOCATION, 1);
    $out = curl_exec($curl);
    $Headers =  curl_getinfo($curl);
    curl_close($curl);
          if ($out != $Headers)
    $ccc=$Headers["url"];
$dom = new DOMDocument();
$html= mb_convert_encoding($out ,'HTML-ENTITIES',"UTF-8");

$dom->loadHTML($html);
$dom->normalize();
$xpath = new DOMXPath($dom);
$texts = $xpath->query($query2);
$bfs = $xpath->query($query3);

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
    $bf=$bfs->item($i)->nodeValue;
    $bf = replacestr($bf);
    $text = $text.' '.$bf;
    $link = $linkevents->item($i)->nodeValue;
    $title = $titleevents->item($i)->nodeValue;
    
    $pic = 'https://us13.proxysite.com'.$picevents->item($i)->nodeValue;

$link =base64_encode($link);
if($guolv==null){
	    $result=$result.'{"vod_id":"'.$link.'","vod_name":"'.$title.'","vod_pic":"'.$pic.'","vod_remarks":"'.$text.'"},';
    	$guolv=$guolv."{".$link."}";
}else if(strpos($guolv, "{".$link2."}")==0){
	    $result=$result.'{"vod_id":"'.$link.'","vod_name":"'.$title.'","vod_pic":"'.$pic.'","vod_remarks":"'.$text.'"},';
    	$guolv=$guolv."{".$link."}";
	}
 
}
$result=substr($result, 0, strlen($result)-1).']}';
echo $result;
//==============================================读取影视列表结束=======================================
}else if ($ids<> null){
$ids=base64_decode($ids);
$detail=str_replace("{vodid}",$ids,$detail);

$html = curl_get($detail);
$dom = new DOMDocument();
$html= mb_convert_encoding($html ,'HTML-ENTITIES',"UTF-8");
$dom->loadHTML($html);
$dom->normalize();
$xpath = new DOMXPath($dom);

if($vodtitle<>null){
$texts = $xpath->query($vodtitle);
$text = $texts->item(0)->nodeValue;

}

if($vodtype<>null){
$texts = $xpath->query($vodtype);
$type = $texts->item(0)->nodeValue;
$type = replacestr($type);
}

if($vodyear<>null){
$texts = $xpath->query($vodyear);
$year = $texts->item(0)->nodeValue;
$year = replacestr($year);
}
if($vodimg<>null){
$texts = $xpath->query($vodimg);
$img = 'https://us13.proxysite.com'.$texts->item(0)->nodeValue;
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
    $actor = $actor.$event1->nodeValue.',';
}
}
$actor = replacestr($actor);
if($vodtext<>null){
$texts = $xpath->query($vodtext);
$vodtext2 = $texts->item(0)->nodeValue;
$vodtext2 = replacestr($vodtext2);
}
if($vodtext2==null){
$vodtext2 =$actor;
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

    $fname="//div[@class='magnet-name column is-four-fifths']/a/span[@class='name']";
    $furl="//div[@class='buttons column']/button/@data-clipboard-text";
    $events = $xpath->query($fname);
    $fnameevents = $xpath->query($fname);
    $furlevents = $xpath->query($furl);
    for ($i = 0; $i < $events->length; $i++) {
    $event = $events->item($i);
    $fname = $fnameevents->item($i)->nodeValue;
    $furl = $furlevents->item($i)->nodeValue;

$content2.= $furl.'#';
}
if(strpos($html,'" type="video/mp4')>0){
$content1=getSubstr($html,'<source src="','" type="video/mp4');
if (substr($content1,0,2)=='//'){
	$content1 = 'http:'.$content1;}
$from=$text.'$$$磁力';
$content=$vodtext2.'$'.'https://us13.proxysite.com'.$content1.'$$$'.$content2;
$content=substr($content, 0, strlen($content)-1);
}else{
$from='磁力';
$content=$content2;
$content=substr($content, 0, strlen($content)-1);
}

//$from=substr($from, 0, strlen($from)-3);
//$content=substr($content, 0, strlen($content)-3);
$result= $result.'"vod_play_from":"'.$from.'",';
$result= $result.'"vod_play_url":"'.$content.'"}]}';

echo $result;
//==============================================读取影视信息结束

}else  if ($burl<> null){

echo  $output;

}else  if ($wd<> null){
//=============================以下是搜索代码=======================================================
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
$picevents= $xpath->query($searchpicAttr);
$linkevents= $xpath->query($searchlinkAttr);
$length=$events->length;
$result='{"code":1,"page":'.$page.',"pagecount":'. $page.',"total":'. $length.',"list":[';
for ($i = 0; $i < $events->length; $i++) {
    $event = $events->item($i);
    $text = $texts->item($i)->nodeValue;
    $link = $linkevents->item($i)->nodeValue;
    $title = $titleevents->item($i)->nodeValue;
    $pic=$picevents->item($i)->nodeValue;
    if($searchurl1<>null){
        $link2 =getSubstr($link,$searchurl1,$searchurl2);
    }else{
    $link2 =$link;
    }
    $result=$result.'{"vod_id":'.$link2.',"vod_name":"'.$title.'","vod_pic":"'.$pic.'","vod_remarks":"'.$text.'"},';
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
$pic =  $web.$pic;

if($searchquery2<>null){
$text = $arr_q1a[$i][$searchquery2];
$result=$result.'{"vod_id":"'.$link.'","vod_name":"'.$title.'","vod_pic":"'.$pic.'","vod_remarks":"'.$text.'"},';
}else{
$result=$result.'{"vod_id":"'.$link.'","vod_name":"'.$title.'","vod_pic":"'.$pic.'"},';
}
 }
 $result=substr($result, 0, strlen($result)-1).']}';
echo $result;
}
//==============================以上是搜索代码=======================================================
}else{
echo $movietype;
}

function curl_get($url){
$headerArray = array(
'Host: us13.proxysite.com',
'Connection: keep-alive',
'Cache-Control: max-age=0',
'Upgrade-Insecure-Requests: 1',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36',
'Sec-Fetch-User: ?1',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'Sec-Fetch-Site: same-origin',
'Sec-Fetch-Mode: navigate',
'Referer: https://us13.proxysite.com/',
//'Accept-Encoding: gzip, deflate, br',
'Accept-Language: zh-CN,zh;q=0.9',
'Cookie: PHPSESSID=cpj0e1df2nfg2jjrlibg2st0l1; c[fs1.app][/][PHPSESSID]=nftolbag6l6ipvvbb25gap9lph; c[shukriya90.com][/][nauid]=keoW5bgKXp4JHkWsZMNw; c[labadena.com][/][nauid]=98GjiY3Yhwltf1LCNH6F; c[admjmp.com][/][__cflb]=02DiuDFRFiBZBvMSLtqGxuZp8RQcjVh52Zwr4b3HRow24; c[fs1.app][/][kt_ips]=54.39.48.111%252C198.50.155.77; _ga_1DTX7D4FHE=GS1.1.1701589802.2.1.1701593893.0.0.0; __gads=ID=598cb74e32cbae80:T=1701586662:RT=1702109738:S=ALNI_MaJJ6AYg6Ttbs7q70u8dYUUpFsrQQ; __gpi=UID=00000d01c3ef7776:T=1701586662:RT=1702109738:S=ALNI_MaHHcRV53AnfYfccJ1BhwoS8Nd-qw; _gid=GA1.2.432646802.1702109765; _ga_ZPZ1ZJ9RFM=GS1.2.1702109819.3.0.1702109819.0.0.0; c[javdb523.com][/][list_mode]=h; c[javdb523.com][/][theme]=auto; c[javdb523.com][/][locale]=zh; c[javdb523.com][/][over18]=1; c[javdb523.com][/][_jdb_session]=LyJOUqwCWftX4rN0NbEO4KjhiYWgPDaLpBHSUgnuuWHaiTmOO6G%252FsFCsDeW%252F1YAnvGBJ5WG9UC%252F49NTSy%252FWbST8Wc9xSLbmtSybRpYW4FhNimC3cwk%252FcgVt26BCv7bVLvXnpqbEF4wFo4r2BAFnx1TvaYjeXUt21%252Bd0cBMl7VsItaOctvPKqjjphCszbsLVwDsr2DDbC3HugZt0%252FiXaoZeTyV1PechenNo5JB3fQWMjnhPzZRLCOK8ZiFIdEExpAX7sVef6zgi%252FhCsHZFRdgUSe4SoHW5VmAkkI8I8BjHO6zBpv%252BkS5UU4va--Y9fG3EXugk%252FhavP5--xIJ6Xpfpe2%252Bblcg9Ac6DnA%253D%253D; _ga=GA1.1.2144560154.1701586656; c[yandex.ru][/][_yasc]=hlBQgrZPbGklbrnJP8D6GUMWOb47M5tCwueDM1ZDz6oFTmxuz%2BIOpJGqNOOjHmQP; c[yandex.ru][/][i]=nAOt27rhco0Tgieb13U3YShywphMFPuvUesmce59ndzI%2F75C%2Fx6aidjaA%2BVgws15V22G1Tg%2BNld0OZ3Zlnk8HP7FOHg%3D; c[yandex.ru][/][yandexuid]=6931121191702109873; _ym_uid=1702109874384383667; _ym_d=1702109874; c[mc.yandex.com][/][sync_cookie_csrf]=1035582693fake; c[yandex.com][/][_yasc]=oRbNFg2tC8JGLmleK8pHlUr7LposHAaqoqyRZ%2FT9LJdQEA0Vap3FSxQG19n3B4awJg%3D%3D; _ym_isad=2; c[mc.yandex.ru][/][sync_cookie_csrf]=1080808175fake; c[yandex.com][/][yandexuid]=6931121191702109873; c[yandex.com][/][yuidss]=6931121191702109873; c[yandex.com][/][i]=nAOt27rhco0Tgieb13U3YShywphMFPuvUesmce59ndzI%2F75C%2Fx6aidjaA%2BVgws15V22G1Tg%2BNld0OZ3Zlnk8HP7FOHg%3D; c[yandex.com][/][yp]=1702196279.yu.360843081702109877; c[yandex.com][/][ymex]=1704701879.oyu.360843081702109877; c[mc.yandex.com][/][sync_cookie_ok]=synced; _ga_NHGYEQW4VX=GS1.1.1702109852.2.0.1702110488.0.0.0'
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    //curl_setopt($curl, CURLOPT_POST, 1);
    //curl_setopt($curl, CURLOPT_POSTFIELDS, $pdata);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArray);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($curl, CURLOPT_ACCEPT_ENCODING, "gzip");
    $out = curl_exec($curl);
    curl_close($curl);
    return $out;
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


function async_get_url($url_array, $wait_usec = 0)

{

if (!is_array($url_array))

return false;

$wait_usec = intval($wait_usec);

$data    = array();

$handle  = array();

$running = 0;

$mh = curl_multi_init(); // multi curl handler

$i = 0;

foreach($url_array as $url) {

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return don't print

curl_setopt($ch, CURLOPT_TIMEOUT, 30);

curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 302 redirect

curl_setopt($ch, CURLOPT_MAXREDIRS, 7);

curl_multi_add_handle($mh, $ch); // 把 curl resource 放进 multi curl handler 里

$handle[$i++] = $ch;

}

/* 执行 */

do {

curl_multi_exec($mh, $running);

if ($wait_usec > 0) /* 每个 connect 要间隔多久 */

usleep($wait_usec); // 250000 = 0.25 sec

} while ($running > 0);

/* 读取资料 */

foreach($handle as $i => $ch) {

$content  = curl_multi_getcontent($ch);

$data[$i] = (curl_errno($ch) == 0) ? $content : false;

}

/* 移除 handle*/

foreach($handle as $ch) {

curl_multi_remove_handle($mh, $ch);

}

curl_multi_close($mh);

return $data;

}

?>