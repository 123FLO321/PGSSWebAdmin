<?php

include_once "../config.php";

$file = $_GET["file"];
$fullFilename = PGSS_ROOT_DIR.'/logs/'.$file;
if (unlink($fullFilename) === true) {
	header('Location: /logs');
} else {
	echo "Failed to delete file.";
}
