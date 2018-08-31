<?php

include_once '../config.php';
include_once '../lib/db.php';


$data = array();

$query = "
	SELECT device_uuid, MAX(timestamp) as max_timestamp 
	FROM device_location_history 
	GROUP BY device_uuid
";
$results = $db->query($query)->fetchAll(\PDO::FETCH_ASSOC);

foreach ($results as $result) {
	$deviceUUID = $result['device_uuid'];
	$maxTimestamp = $result['max_timestamp'];
	$lastTeleportDate = date('Y-m-d H:i:s', $maxTimestamp);
	$screenshotFile = PGSS_ROOT_DIR.'/web_img/Device_'.$deviceUUID.'.png';
	$lastScreenshotDate = date('Y-m-d H:i:s', filemtime($screenshotFile));
	$screenshotUrl = 'image/Device_'.$deviceUUID.'.png';

	$screenshotImage = '<img data-src="'.$screenshotUrl.'" style="max-height:400px">';
	$data[] = array($deviceUUID, $lastTeleportDate, $lastScreenshotDate, $screenshotImage);
}

header('Content-Type: application/json');
echo json_encode(array("data"=>$data));
