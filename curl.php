<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.vimeo.com/me/videos/'.$video_ID);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Authorization: Bearer 144538e01cdb3bd7c4e062b592e416af'
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$data = json_decode($result, true);	
curl_close($ch);


?>