<?php

include_once "../config.php";

$file = $_GET["file"];
$fullFilename = PGSS_ROOT_DIR.'/logs/'.$file;
$handle = fopen($fullFilename, "r");
if ($handle) {
	header('Content-Disposition: attachment; filename="'.$file.'"');
	header('Content-Type: text/plain');
	while (($line = fgets($handle)) !== false) {
		print $line;
	}
	fclose($handle);
} else {
	die("Failed to read log,");
}