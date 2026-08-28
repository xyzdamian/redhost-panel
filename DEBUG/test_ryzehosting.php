<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  * * Made in Koblenz with ♥ by Damian Schönberger
 *  *
 *  * @project     RED-Host v2
 *  * @file        test_ryzehosting.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  *
 *  * Terminal-Test: Ruft getKVMCatalog() der RyzeHosting-API auf
 *  * und gibt das Ergebnis als JSON aus.
 *  *
 *  * Aufruf: php debug/test_ryzehosting.php
 */

if (PHP_SAPI !== 'cli') {
    exit('Nur über das Terminal ausführbar (php debug/test_ryzehosting.php)' . PHP_EOL);
}

define('BASE_PATH', dirname(__DIR__) . '/');
require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'software/Kernel.php';
require BASE_PATH . 'software/backend/autoload.php';

try {
    $catalog = $ryzehosting->checkDomainAvailability('sda.de');

    $state  = $catalog['state'] ?? '?';
    $code   = $catalog['code'] ?? '?';
    $message = $catalog['message'] ?? '?';

    echo 'State: ' . $state . ' | Code: ' . $code . ' | Message: ' . $message . PHP_EOL . PHP_EOL;
    echo json_encode($catalog, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL;

    exit($state === 'success' ? 0 : 1);
} catch (Throwable $e) {
    echo '[FEHLER] ' . get_class($e) . ': ' . $e->getMessage() . PHP_EOL;

    if ($e instanceof \GuzzleHttp\Exception\ClientException) {
        $resp = $e->getResponse();
        if ($resp) {
            echo 'Antwort-Status: ' . $resp->getStatusCode() . PHP_EOL;
            echo 'Antwort-Body: ' . $resp->getBody() . PHP_EOL;
        }
    }
    exit(1);
}
