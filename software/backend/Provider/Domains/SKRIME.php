<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with ♥ by Damian Schönberger
 *  *
 *  * @project     RED-Host v2
 *  * @file        SKRIME.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        18.9.2026
 *  * @time        20:26
 *
 */


use GuzzleHttp\Client;

$skrime = new SKRIME();

class SKRIME extends Controller {

    public function getClient(): Client
    {
        $verify = filter_var(env('VERIFY_SSL', 'true'), FILTER_VALIDATE_BOOLEAN);

        return new Client([
            'base_uri'        => 'https://skrime.eu/api/',
            'allow_redirects' => false,
            'timeout'         => 30,
            'verify'          => $verify,
            'headers'         => [
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer '.env('SKRIME_KEY'),
            ],
        ]);
    }

    /*
     * Domains
     */

    public function checkDomainAvailability(string $domain): array
    {
        $payload = [
            'domain' => $domain,
        ];

        $client = $this->getClient();
        $response = $client->request('POST', 'domain/check', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getDomainPricelist(): array
    {
        $client = $this->getClient();
        $response = $client->request('GET', 'domain/pricelist');

        return json_decode($response->getBody()->getContents(), true);
    }

    public function orderDomain(
        string $domain,
        string $authcode,
        array $contact,
        string $tos,
        string $cancellation
    ): array
    {
        $payload = [
            'domain' => $domain,
            'authcode' => $authcode,
            'contact' => $contact,
            'nameserver' => ["nameserver01.eu", "nameserver02.eu", "nameserver03.eu", "nameserver04.eu", "nameserver05.eu", "nameserver06.eu"],
            'tos' => $tos,
            'cancellation' => $cancellation,
        ];

        $client = $this->getClient();
        $response = $client->request('POST', 'domain/order', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getNameservers(string $domain): array
    {
        $payload = [
            'domain' => $domain
        ];

        $client = $this->getClient();
        $response = $client->request('GET', 'domain/nameserver', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function changeNameservers(string $domain, array $nameservers): array
    {
        $payload = [
            'domain' => $domain,
            'nameserver' => $nameservers
        ];

        $client = $this->getClient();
        $response = $client->request('POST', 'domain/nameserver', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getDNSSEC(string $domain): array
    {
        $payload = [
            'domain' => $domain,
        ];

        $client = $this->getClient();
        $response = $client->request('GET', 'domain/dnssec', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function changeDNSSEC(string $domain, array $dnssec): array
    {
        $payload = [
            'domain' => $domain,
            'dnssec' => $dnssec
        ];

        $client = $this->getClient();
        $response = $client->request('POST', 'domain/dnssec', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function deactivateDNSSEC(string $domain): array
    {
        $payload = [
            'domain' => $domain,
        ];

        $client = $this->getClient();
        $response = $client->request('DELETE', 'domain/dnssec', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }


}