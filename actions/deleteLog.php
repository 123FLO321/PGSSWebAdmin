<?php

include_once "../config.php";
include_once '../lib/getHost.php';

$file = $_GET["file"];
$fullFilename = PGSS_ROOT_DIR.'/logs/'.$file;

if (unlink($fullFilename) === true) {
	header('Location: '.HOST_URL.'logs');
} else {
	echo "Failed to delete file.";
}
