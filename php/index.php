<?php  
include 'function.php';
// p($_POST);die;
$obj=isset($_GET['c'])?($_GET['c']):'Index';

$obj.='Controller';

$c=new $obj;

$func=isset($_GET['a'])?$_GET['a']:'index';

$c->$func();