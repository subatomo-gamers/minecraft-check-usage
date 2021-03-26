<?php

function main(array $argv): int
{
    $errorHandler = function ($errno, $errstr, $errfile, $errline) {
        if ($errno !== E_WARNING) {
            return;
        }
        throw new Exception($errstr);
    };
    try {
        set_error_handler($errorHandler);

        $configFile = __DIR__ . "/config.ini";
        $config     = parse_ini_file($configFile);
        $port       = $config["minecraft_port"] ?? null;
        if (!strlen($port)) {
            throw new Exception("Key 'minecraft_port' not found in '{$configFile}'");
        }
        if (!preg_match("/\\A[0-9]+\\z/", $port)) {
            throw new Exception("Invalid port number: '{$port}'");
        }

        $data   = pack("C", 0xFE);
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $buf    = "";
        socket_set_block($socket);
        socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, ["sec" => 3, "usec" => 0]);
        socket_connect($socket, "localhost", (int) $port);
        socket_send($socket, $data, 1, MSG_EOR);
        socket_recv($socket, $buf, 2048, MSG_WAITALL);
        socket_close($socket);
        restore_error_handler();

        $detail = mb_convert_encoding(substr($buf, 1), "UTF-8", "UTF-16BE");
        $parts  = explode("§", $detail);
        $count  = $parts[1] ?? 0;
        echo $count, PHP_EOL;
        return 0;
    } catch (Exception $e) {
        fputs(STDERR, "Failed to connect minecraft server." . PHP_EOL);
        fputs(STDERR, $e->getMessage() . PHP_EOL);
        return 1;
    }
}

$result = main($argv);
exit($result);
