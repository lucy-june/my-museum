<?php

$tbl_admin = M('SITE_ADMIN');
$condition['SA_NAME_TX'] = 'test_admin';
$map['SA_STATE_TX_FX'] = 'ACT';
$user = $tbl_admin->where($condition)->find();

if(!$user){
	echo 'not found';
	return;
}
if($user['SA_PASSWORD_TX'] != md5('147258')){
	echo 'wrong password';
	return;
}

echo 'succeed';
?>