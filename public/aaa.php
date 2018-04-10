<?php
$content = file_get_contents("88233d9763ffd79a1529798c35b34c52_rsas-vulweb-V6.0R02F00.0804.dat");
//$content = trim($content,'1c72ac9790eb7c422bf742cbbfa8359');
$content = substr($content,0,-32);
//a6a31f21733fa1a382883c861bca9322
//$content = md5($content);
$content = file_put_contents('aaa',$content);
var_dump($content);exit;