<?php
// mb_internal_encoding("ISO-8859-1");
// if(!empty($_GET['test'])) die("Ok!");
require_once __DIR__.'/init.server.php';
//////////////////////////////////////////////////
$token = md5(uniqid(rand(), TRUE));
