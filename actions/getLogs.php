<?php

include_once '../config.php';

$data = array();

$files = array_diff(scandir(PGSS_ROOT_DIR.'/logs'), array('.', '..'));
foreach ($files as $file) {
	if ((substr($file, - 4) !== '.log')) {
		continue;
	} else {
		$splited = explode('_', $file);

		if ($splited[2] === 'raidscan.log') {
			$type = 'raidscan';
			$device = '';
		} else if ($splited[3] === 'xcodebuild.log') {
			$type = 'xcodebuild';
			$device = $splited[2];
		} else {
			continue;
		}

		$time = $splited[0].' '.str_replace('-', ':', $splited[1]);

		$size = number_format(filesize(PGSS_ROOT_DIR.'/logs/'.$file) / 1048576, 2);

		$buttons =  '<a href="log/'.$file.'" role="button" class="btn btn-success">View</a>'.
					'<a href="download/log/'.$file.'" role="button" class="btn btn-primary">Download</a>'.
					'<a onclick="deleteLog(\''.$file.'\',this)" role="button" class="btn btn-danger" style="color:white;">Delete</a>';
		$data[] = array($time, $type, $device, $size.' MB', $buttons);
	}

}

header('Content-Type: application/json');
echo json_encode(array("data"=>$data));