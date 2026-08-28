<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with-&hearts; by Damian Schönberger
 *  *
 *  * @project     v2
 *  * @file        app.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  * @time        15:30
 *
 */

$views = BASE_PATH . 'resources/';
$sites = $views . 'sites/';

$uri  = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($uri, PHP_URL_PATH) ?: '/';
$path = rtrim($path, '/') ?: '/';

$route = $helper->protect($path);

switch ($route) {

    default: include($sites . "404.php"); break;

    // default
    case "/": include($sites . "start.php"); break;
    case "/start": include($sites . "start.php"); break;

    // dashboard
    case "/dash/charge": include($views . "customer/accounting/charge.php"); break;

}
