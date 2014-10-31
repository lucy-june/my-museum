<?php
//$rawUrl= '展馆展品数据资料/首页信息/展馆详情.txt';
$rawUrl= '展馆展品数据资料/展品信息/第一层/第一展厅/明清木具/明朝藤椅/展品基本信息.csv';
$url= 'ftp://wxx:123456@127.0.0.1:21/'.urlencode(mb_convert_encoding($rawUrl,'gb2312','utf-8' ));
//$content = iconv("UTF-8", "gb2312",urlencode( $rawUrl));
//$url= 'ftp://xjhdev:adc5320@202.120.40.140:221/'.$content;
//echo $url;
$ch = curl_init();
$timeout = 5;
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$file_contents = curl_exec($ch);
curl_close($ch);
echo $file_contents;
echo '<br />';
echo mb_convert_encoding($file_contents,'utf-8','gb2312');
echo '<br />';
echo iconv( "utf-8","gb2312",$file_contents);
?>
