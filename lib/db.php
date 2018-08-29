<?php
include_once __DIR__."/Medoo.php";
use Medoo\Medoo;

$db = new Medoo([
	'database_type' => DB_TYPE,
	'database_name' => DB_NAME,
	'server' => DB_HOST,
	'username' => DB_USERNAME,
	'password' => DB_PASSWORD,
	'charset' => DB_CHARSET,
	'port' => DB_PORT,
	'socket' => DB_SOCKET,
]);
