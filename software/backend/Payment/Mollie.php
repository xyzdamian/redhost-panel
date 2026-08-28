<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with ♥ by Damian Schönberger
 *  *
 *  * @project     RED-Host v2
 *  * @file        Mollie.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  * @time        20:34
 *
 */

use Mollie\Api\MollieApiClient;

$mollie = new Mollie();

class mollie extends Controller {

    private function apiClient(): MollieApiClient
    {
        $client = new MollieApiClient();
        $client->setApiKey(env('MOLLIE_KEY'));

        return $client;
    }

    public function getTransaction($id): array
    {
        $payment = $this->apiClient()->payments->get($id);

        return (array) $payment;
    }

    public function postPayment($amount, $description, $method = null): array
    {
        $appUrl = rtrim((string) env('APP_URL'), '/');

        $data = [
            'amount' => [
                'currency' => 'EUR',
                'value'    => number_format((float) $amount, 2, '.', ''),
            ],
            'description' => $description,
            'redirectUrl' => $appUrl . '/dash/charge',
            'cancelUrl'   => $appUrl . '/dash/charge',
        ];

        $webhookUrl = rtrim((string) env('WEBHOOK_URL'), '/');
        if ($webhookUrl !== '') {
            $data['webhookUrl'] = $webhookUrl . '/dash/charge';
        }

        if (!empty($method)) {
            $data['method'] = $method;
        }

        $payment = $this->apiClient()->payments->create($data);

        return [
            'id'  => $payment->id,
            'url' => $payment->getCheckoutUrl(),
        ];
    }
}
