<?php

include_once 'config.php';
include_once 'lib/getHost.php';

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