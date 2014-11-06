<?php
namespace SITEADMIN\Controller;
class IndexController extends CommonController {
    public function index(){
		$this->display();
		//echo "Hello ".session('uid');
    }
}