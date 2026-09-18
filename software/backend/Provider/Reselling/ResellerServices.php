<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with ♥ by Damian Schönberger
 *  *
 *  * @project     RED-Host v2
 *  * @file        ResellerServices.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        18.9.2026
 *  * @time        21:57
 *
 */


use GuzzleHttp\Client;

$resellerservices = new ResellerServices();

class ResellerServices extends Controller {

    public function getClient(): Client
    {
        $verify = filter_var(env('VERIFY_SSL', 'true'), FILTER_VALIDATE_BOOLEAN);

        return new Client([
            'base_uri'        => 'https://reseller-services.de/api/v1/',
            'allow_redirects' => false,
            'timeout'         => 30,
            'verify'          => $verify,
            'headers'         => [
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer '.env('RESELLERSERVICES_KEY'),
            ],
        ]);
    }

    public function getAvailableLocation(): array
    {
        $client = $this->getClient();
        $response = $client->request('GET', 'location');

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getInstanceDetails(string $rssId): array
    {
        $payload = [
            'id' => $rssId
        ];

        $client = $this->getClient();
        $response = $client->request('GET', 'instance/' . $rssId . '/show', [
            'json' => $payload
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function startInstance(string $rssId): array
    {
        $payload = [
            'id' => $rssId
        ];

        $client = $this->getClient();
        $response = $client->request('POST', 'instance/' . $rssId . '/start', [
            'json' => $payload
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function stopInstance(string $rssId): array
    {
        $payload = [
            'id' => $rssId
        ];

        $client = $this->getClient();
        $response = $client->request('POST', 'instance/' . $rssId . '/stop', [
            'json' => $payload
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function restartInstance(string $rssId): array
    {
        $payload = [
            'id' => $rssId
        ];

        $client = $this->getClient();
        $response = $client->request('POST', 'instance/' . $rssId . '/restart', [
            'json' => $payload
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getWhitelistEntries(string $rssId): array
    {
        $payload = [
            'id' => $rssId
        ];

        $client = $this->getClient();
        $response = $client->request('GET', 'instance/' . $rssId . '/whitelist', [
            'json' => $payload
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function addWhitelistEntry(string $rssId, string $ipAdress): array
    {
        $payload = [
            'id' => $rssId,
            'ip_address' => $ipAdress
        ];

        $client = $this->getClient();
        $response = $client->request('POST', 'instance/' . $rssId . '/whitelist', [
            'json' => $payload
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function deleteWhitelistEntry(string $rssId, string $whitelistEntryId): array
    {
        $payload = [
            'id' => $rssId,
            'whitelist' => $whitelistEntryId
        ];

        $client = $this->getClient();
        $response = $client->request('DELETE', 'instance/' . $rssId . '/whitelist/' . $whitelistEntryId);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function orderInstance(string $locationId, string $name): array
    {
        $payload = [
            'location_id' => $locationId,
            'name' => $name
        ];

        $client = $this->getClient();
        $response = $client->request('POST', 'order/instance', [
            'json' => $payload
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}