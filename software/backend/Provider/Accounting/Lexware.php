<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with ♥ by Damian Schönberger
 *  *
 *  * @project     RED-Host v2
 *  * @file        Lexware.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        30.8.2026
 *  * @time        2:36
 *
 */


use GuzzleHttp\Client;

$lexware = new Lexware();

class Lexware extends Controller {

    public function getClient(): Client
    {
        $verify = filter_var(env('VERIFY_SSL', 'true'), FILTER_VALIDATE_BOOLEAN);

        return new Client([
            'base_uri'        => 'https://api.lexware.io/',
            'allow_redirects' => false,
            'timeout'         => 30,
            'verify'          => $verify,
            'headers'         => [
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer '.env('LEXWARE_KEY'),
            ],
        ]);
    }

}