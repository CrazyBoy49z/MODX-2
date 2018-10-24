<?php
// get the MODx server offset time in seconds
$server_offset_time = $modx->config['server_offset_time'];
if (!$server_offset_time) {
    $server_offset_time = 0;
}
// get the current time and apply the offset
$timestamp = time() + $server_offset_time;
// Set the current year
$today_year = date('Y', $timestamp);
return $today_year;