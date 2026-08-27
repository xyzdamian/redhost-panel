<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with-&hearts; by Damian Schönberger
 *  *
 *  * @project     v2
 *  * @file        Helper.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  * @time        0:29
 *
 */


$helper = new Helper();

class helper extends Controller {

    public static function protect($string): string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }



    public static function timeAgo($timestamp): string
    {
        $time = strtotime($datetime);
        $diff = time() - $time;

        if ($diff < 60) return 'gerade eben';
        if ($diff < 3600) return floor($diff / 60) . ' Min';
        if ($diff < 86400) return floor($diff / 3600) . ' Std';
        return date('d.m.Y', $time);
    }

}