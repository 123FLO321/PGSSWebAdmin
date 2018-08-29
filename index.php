<?php


if (directory() != '') {
	$subdirectory = '/'.directory().'/';
} else {
	$subdirectory = '/';
}
if (isset($_SERVER['HTTP_HOST'])) {
	if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
		define('HOST_URL', $_SERVER['HTTP_X_FORWARDED_PROTO'].'://'.$_SERVER['HTTP_HOST'].$subdirectory);
	} else if (isset($_SERVER['REQUEST_SCHEME'])) {
		define('HOST_URL', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$subdirectory);
	} else {
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
			define('HOST_URL', 'https://'.$_SERVER['HTTP_HOST'].$subdirectory);
		} else {
			define('HOST_URL', 'http://'.$_SERVER['HTTP_HOST'].$subdirectory);
		}
	}
}
## Subdirectory trick
function directory()
{
	##https://stackoverflow.com/questions/2090723/how-to-get-the-relative-directory-no-matter-from-where-its-included-in-php
	return substr(str_replace('\\', '/', realpath(dirname(__FILE__))), strlen(str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']))) + 1);
}



include_once 'config.php';

$page = isset($_GET['page']) ? $_GET['page']: 'home';

switch ($page) {
	case 'home':
		$pageTitle = "Home";
		break;
	case 'solvegyms':
		$pageTitle = "Solve Gyms";
		if (isset($_GET) && isset($_GET["id"])) {
			$id = $_GET["id"];
		} else {
			$id = NULL;
		}
		break;
	case 'solvepokemon':
		$pageTitle = "Solve Pokemon";
		if (isset($_GET) && isset($_GET["id"])) {
			$id = $_GET["id"];
		} else {
			$id = NULL;
		}
		break;
	case 'checkgyms':
		$pageTitle = "Check Gyms";
		break;
	case 'checkpokemon':
		$pageTitle = "Check Pokemon";
		break;
	case 'devices':
		$pageTitle = "Devices";
		break;
	case 'logs':
		$pageTitle = "Logs";
		break;
	case 'log':
		$pageTitle = "Log";
		$file = $_GET["file"];
		break;
	default:
		die("Unknown page.");
}

include_once 'views/top.php';
include_once 'views/'.$page.'.php';
include_once 'views/bot.php';