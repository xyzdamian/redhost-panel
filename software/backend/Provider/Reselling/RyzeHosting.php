<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with ♥ by Damian Schönberger
 *  *
 *  * @project     RED-Host v2
 *  * @file        RyzeHosting.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  * @time        23:18
 *
 */

use GuzzleHttp\Client;

$ryzehosting = new RyzeHosting();

class ryzehosting extends Controller {

    public function getClient(): Client
    {
        $verify = filter_var(env('VERIFY_SSL', 'true'), FILTER_VALIDATE_BOOLEAN);

        return new Client([
            'base_uri'        => 'https://api.rzhst.net/api/v1/',
            'allow_redirects' => false,
            'timeout'         => 30,
            'verify'          => $verify,
            'headers'         => [
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer '.env('RYZEHOSTING_KEY'),
            ],
        ]);
    }

    /*
     * KVM Server
     */

    public function getKVMCatalog(): array
    {
        $client = $this->getClient();
        $response = $client->get('orders/kvm/catalog');

        return json_decode($response->getBody()->getContents(), true);
    }

    public function orderKVM(
        string $type,
        string $mode,
        ?string $packId = null,
        int $cores = 0,
        int $memory = 0,
        int $disk = 0,
        int $addresses4 = 0,
        int $addresses6 = 0,
        array $ownIpv4UnitUuids = [],
        array $ownIpv6UnitUuids = [],
        string $uplink = '',
        string $backup = '',
        string $serverOS = '',
        int $duration = 30,
        bool $agb = false,
        bool $widerruf = false,
        string $discountCode = ''
    ): array {
        $payload = [
            'type'              => $type,
            'mode'              => $mode,
            'packId'            => $packId,
            'cores'             => $cores,
            'memory'            => $memory,
            'disk'              => $disk,
            'addresses4'        => $addresses4,
            'addresses6'        => $addresses6,
            'ownIpv4UnitUuids'  => $ownIpv4UnitUuids,
            'ownIpv6UnitUuids'  => $ownIpv6UnitUuids,
            'uplink'            => $uplink,
            'backup'            => $backup,
            'serverOS'          => $serverOS,
            'duration'          => $duration,
            'agb'               => $agb,
            'widerruf'          => $widerruf,
            'discountCode'      => $discountCode,
        ];

        $client = $this->getClient();
        $response = $client->post('orders/kvm', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function powerKVMAction(string $action, string $ryzeId): array
    {
        $payload = [
            'action' => $action,
        ];

        $response = $this->getClient()->post('servers/' . $ryzeId . '/power', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getServerDetails(string $ryzeId): array
    {
        $client = $this->getClient();
        $response = $client->get('servers/' . $ryzeId);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getConsole(string $ryzeId): array
    {
        $payload = [
            'mode' => 'vnc'
        ];

        $client = $this->getClient();
        $response = $client->get('servers/' . $ryzeId . '/console', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function renewKVM(string $ryzeId, int $days): array
    {
        $payload = [
            'days' => $days,
        ];

        $response = $this->getClient()->post('servers/' . $ryzeId . '/renew', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function setPassword(string $ryzeId, string $password): array
    {
        $payload = [
            'password'        => $password,
            'password_repeat' => $password,
        ];

        $response = $this->getClient()->put('servers/' . $ryzeId . '/password', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getIPs(string $ryzeId): array
    {
        $client = $this->getClient();
        $response = $client->get('servers/' . $ryzeId . '/ips');

        return json_decode($response->getBody()->getContents(), true);
    }

    public function listOS(string $ryzeId): array
    {
        $client = $this->getClient();
        $response = $client->get('servers/' . $ryzeId . '/reinstall/os');

        return json_decode($response->getBody()->getContents(), true);
    }

    public function reinstallKVM(string $ryzeId, string $serverOS): array
    {
        $payload = [
            'serverOS' => $serverOS,
        ];

        $client = $this->getClient();
        $response = $client->post('servers/' . $ryzeId . '/reinstall', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getKVMStats(string $ryzeId, string $timeframe = 'day'): array
    {
        $response = $this->getClient()->get('servers/' . $ryzeId . '/metrics', [
            'query' => ['timeframe' => $timeframe],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /*
     * Domains
     */

    public function getDomainDetails(string $ryzeId): array
    {
        $client = $this->getClient();
        $response = $client->get('domains/' . $ryzeId);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getDNSRecords(string $ryzeId): array
    {
        $client = $this->getClient();
        $response = $client->get('domains/' . $ryzeId . '/dns');

        return json_decode($response->getBody()->getContents(), true);
    }

    public function setDNSRecords(string $domainUuid, array $records): array
    {
        $payload = [
            'records' => $records,
        ];

        $response = $this->getClient()->put('domains/' . $domainUuid . '/dns', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getNameservers(string $ryzeId): array
    {
        $client = $this->getClient();
        $response = $client->get('domains/' . $ryzeId . '/nameservers');

        return json_decode($response->getBody()->getContents(), true);
    }

    public function setNameservers(string $ryzeId, array $nameservers): array
    {
        $payload = [
            'nameservers' => $nameservers,
        ];

        $response = $this->getClient()->put('domains/' . $ryzeId . '/nameservers', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getDomainContact(string $ryzeId): array
    {
        $client = $this->getClient();
        $response = $client->get('domains/' . $ryzeId . '/contact');

        return json_decode($response->getBody()->getContents(), true);
    }

    public function setDomainContact(string $ryzeId, array $contact): array
    {
        $payload = [
            'contact' => $contact,
        ];

        $response = $this->getClient()->put('domains/' . $ryzeId . '/contact', []);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function setWhoisPrivacy(string $ryzeId, string $whoisPrivacy): array
    {
        $payload = [
            'privacy' => $whoisPrivacy,
        ];

        $response = $this->getClient()->post('domains/' . $ryzeId . '/whois', []);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getAuthcode(string $ryzeId): array
    {
        $client = $this->getClient();
        $response = $client->get('domains/' . $ryzeId . '/authcode');

        return json_decode($response->getBody()->getContents(), true);
    }

    public function renewDomain(string $ryzeId): array
    {
        $client = $this->getClient();
        $response = $client->post('domains/' . $ryzeId . '/renew');

        return json_decode($response->getBody()->getContents(), true);
    }

    public function orderDomain(
        string $action,
        string $domain,
        bool $agb = true,
        bool $wiederruf = true,
        string $authCode = '',
        array $nameserver = [],
        array $contact = [],
        bool $autoRenew = false
    ): array {
        $payload = [
            'action'      => $action,
            'domain'      => $domain,
            'agb'         => $agb,
            'wiederruf'   => $wiederruf,
            'authCode'    => $authCode,
            'nameserver'  => $nameserver,
            'contact'     => $contact,
            'autoRenew'   => $autoRenew,
        ];

        $response = $this->getClient()->post('orders/domain', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getDomainPricelist(): array
    {
        $client = $this->getClient();
        $response = $client->get('domain/pricelist');

        return json_decode($response->getBody()->getContents(), true);
    }

    public function checkDomainAvailability(string $domain): array
    {
        $payload = [
            'domain' => $domain,
        ];

        $client = $this->getClient();
        $response = $client->post('orders/domain/check', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

}