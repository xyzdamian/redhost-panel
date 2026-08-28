<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with ♥ by Damian Schönberger
 *  *
 *  * @project     RED-Host v2
 *  * @file        test_mollie.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *
 * Terminal-Test: Erstellt eine Mollie Test-Zahlung über 1,00 EUR
 * und gibt den Checkout-Link aus.
 *
 * Aufruf: php DEBUG/test_mollie.php
 */

if (PHP_SAPI !== 'cli') {
    exit('Nur über das Terminal ausführbar (php DEBUG/test_mollie.php)' . PHP_EOL);
}

define('BASE_PATH', dirname(__DIR__) . '/');
require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'software/Kernel.php';
require BASE_PATH . 'software/backend/autoload.php';

try {
    $link = $mollie->postPayment(1.00, 'Mollie Test Zahlung');

    echo "Mollie Testzahlung (1,00 EUR) erfolgreich erstellt." . PHP_EOL;
    echo "Checkout-Link:" . PHP_EOL;
    echo $link . PHP_EOL;
} catch (Throwable $e) {
    echo "[FEHLER] " . get_class($e) . ": " . $e->getMessage() . PHP_EOL;
    exit(1);
}
