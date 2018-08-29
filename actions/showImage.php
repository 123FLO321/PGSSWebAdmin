<?php

include_once '../config.php';

$file = basename(urldecode($_GET['file']));
$file = str_replace('..', '', $file);
$dir = 'web_img';

if (file_exists(PGSS_ROOT_DIR . '/web_img/' . $file)) {
	$contents = file_get_contents(PGSS_ROOT_DIR . '/web_img/' . $file);
	header('Content-type: image/png');
	echo $contents;
} else {
	header('Content-Type: text/plain');
	echo "Can not find image";
}

?>