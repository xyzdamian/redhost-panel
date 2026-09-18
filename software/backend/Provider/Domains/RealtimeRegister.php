<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with ♥ by Damian Schönberger
 *  *
 *  * @project     RED-Host v2
 *  * @file        RealtimeRegister.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        18.9.2026
 *  * @time        22:56
 *
 */


use GuzzleHttp\Client;

$realtimeregister = new RealtimeRegister();

class RealtimeRegister extends Controller {

    public function getClient(): Client
    {
        $verify = filter_var(env('VERIFY_SSL', 'true'), FILTER_VALIDATE_BOOLEAN);

        return new Client([
            'base_uri'        => 'https://api.yoursrs.com/',
            'allow_redirects' => false,
            'timeout'         => 30,
            'verify'          => $verify,
            'headers'         => [
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => 'ApiKey '.env('REALTIMEREGISTER_KEY'),
            ],
        ]);
    }
}