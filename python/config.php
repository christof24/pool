<?php
$db['host'] =  'localhost' ;
$db['username'] =  'root' ;
$db['password'] =  'password' ;
$db['db'] =  'pool' ;

// MySQL connection;
$connect = mysql_connect($db['host'], $db['username'], $db['password'] );
$select_db = mysql_select_db( $db['db'], $connect );
//$db = false;
?>