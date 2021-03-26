<?php
$home    = __DIR__;
$date    = date("Ymd_Hi");
$logDir  = "{$home}/data/worlds";
is_dir($logDir) || mkdir($logDir, 0777, true);
$logName = "{$logDir}/{$date}.log";
exec("{$home}/worlds.sh -c > {$logName}");
