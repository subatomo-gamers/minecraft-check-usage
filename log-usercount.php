<?php
$home    = __DIR__;
$date    = date("Ymd_Hi");
$logDir  = "{$home}/data/usercount";
is_dir($logDir) || mkdir($logDir, 0777, true);
$logName = "{$logDir}/{$date}.log";
exec("{$home}/usercount.sh -c > {$logName}");
