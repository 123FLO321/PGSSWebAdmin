<?php

include_once "../config.php";

$file = $_GET["file"];
$fullFilename = PGSS_ROOT_DIR.'/logs/'.$file;

if (!unlink($fullFilename) === true) {
	http_response_code(500);
	echo "Failed to delete file.";
}
