<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with-&hearts; by Damian Schönberger
 *  *
 *  * @project     v2
 *  * @file        Site.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  * @time        0:29
 *
 */

$site = new Site();

class site extends Controller {

    public static function getURL(): string
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    }

    public function getWelcomeText($time): string
    {
        if($time >= 5 && $time <= 10){
            return '🌄 Guten Morgen';
        } elseif($time >= 10 && $time <= 12) {
            return '☀️ Guten Vormittag';
        } elseif($time >= 12 && $time <= 16) {
            return '🌞 Guten Mittag';
        } elseif($time >= 16 && $time <= 23) {
            return '🌇 Guten Abend';
        } elseif($time >= 23 || $time >= 0 && $time <= 5) {
            return '💤 Gute Nacht';
        } else {
            return 'Uhrzeit konnte nicht erfasst werden';
        }
    }
}