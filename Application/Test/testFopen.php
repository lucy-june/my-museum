<?php
//$myfile = fopen("http://localhost:63342/thinkphp_3.2.2_full/composer.json", "r") or die("Unable to open file!");
//$myfile = fopen("ftp://xjhdev:adc5320@202.120.40.140:221/docs/readme.txt", "r") or die("Unable to open file!");
//$myfile = fopen("ftp://xjhdev:adc5320@202.120.40.140:221/展馆展品数据资料/首页信息/展馆详情.txt", "r") or die("Unable to open file!");
//$myfile = fopen("ftp://xjhdev:adc5320@202.120.40.140:221/%D5%B9%B9%DD%D5%B9%C6%B7%CA%FD%BE%DD%D7%CA%C1%CF/%CA%D7%D2%B3%D0%C5%CF%A2/%D5%B9%B9%DD%CF%EA%C7%E9.txt","r") or die("Unable to open file!");

echo fread($myfile,1024);
fclose($myfile);
?>