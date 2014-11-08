<?php
/*
 * 打印数组
 * $param array $array
 */
function p($array){
    dump($array,1,'',0);
}

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 */
function is_login(){
    $user = session('user');
    if (empty($user)) {
        return 0;
    } else {
        return $user['uid'];
    }
}

// 检测输入的验证码是否正确，$code为用户输入的验证码字符串
function check_verify($code, $id = ''){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

/**************************************************************
 *
 *  使用特定function对数组中所有元素做处理
 *  @param  string  &$array     要处理的字符串
 *  @param  string  $function   要执行的函数
 *  @return boolean $apply_to_keys_also     是否也应用到key上
 *  @access public
 *
 *************************************************************/
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    static $recursive_counter = 0;
    if (++$recursive_counter > 1000) {
        die('possible deep recursion attack');
    }
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            arrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function($value);
        }

        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
    $recursive_counter--;
}

/**************************************************************
 *
 *  将数组转换为JSON字符串（兼容中文）
 *  @param  array   $array      要转换的数组
 *  @return string      转换得到的json字符串
 *  @access public
 *
 *************************************************************/
function JSON($array) {
    arrayRecursive($array, 'urlencode', true);
    $json = json_encode($array);
    return urldecode($json);
}

function urlContent($base,$path,$file){
   $path='ITEM_ID/';
// 	$url = $base.urlencode(mb_convert_encoding($path.$file,'utf-8','gb2312'));
	header("content-Type: text/html; charset=Utf-8");
	$file='temp.txt';
	$url = $base.$path.$file;
    $ch = curl_init();
    $timeout = 5;
    $file1 = fopen("temp.txt", 'w');
    curl_setopt ($ch, CURLOPT_URL , 'ftp://202.120.61.44/ftp/Museum/Ftp/ITEM/temp.txt');
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FILE, $file1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_USERPWD, "admin:app123");
    $file_contents = curl_exec($ch);
    curl_close($ch);
    fclose($file1);

    return $result;

}

function getBase(){
    $base='http://202.120.61.44/museum/Ftp/';
    return $base;
}

function getServer() {
	$base_url ='http://202.120.61.44/museum/Ftp/';
	return $base_url;
}

/*select all objects*/
function findInTable($tableName, $condition) {
	$db = M($tableName);
	return $db->where($condition)->find();
}


?>