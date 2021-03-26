<?php

$configFile = __DIR__ . "/config.ini";
$config     = parse_ini_file($configFile);
$mcDir      = $config["minecraft_dir"] ?? null;
if (!strlen($mcDir)) {
    throw new Exception("Key 'minecraft_dir' not found in '{$configFile}'");
}
if (!is_dir($mcDir)) {
    throw new Exception("Directory not found: '{$mcDir}'");
}
$worlds = yaml_parse_file("{$mcDir}/plugins/Multiverse-Core/worlds.yml");
$names  = array_keys($worlds["worlds"]);
sort($names);

foreach ($names as $name) {
    echo $name, PHP_EOL;
}
