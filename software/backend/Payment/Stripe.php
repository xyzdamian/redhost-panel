<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with ♥ by Damian Schönberger
 *  *
 *  * @project     RED-Host v2
 *  * @file        Stripe.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  * @time        20:57
 *
 */

use Stripe\StripeClient;

$stripe = new Stripe();

class stripe extends Controller {

    private function apiClient(): StripeClient
    {
        return new StripeClient(env('STRIPE_KEY'));
    }

    public function getClient(): StripeClient
    {
        return $this->apiClient();
    }

    public function getTransaction($id): array
    {
        $payment = $this->apiClient()->paymentIntents->retrieve($id);

        return json_decode(json_encode($payment), true);
    }

    public function postPayment($amount, $description, $method = null): array
    {
        $appUrl = rtrim((string) env('APP_URL'), '/');

        $params = [
            'line_items' => [
                [
                    'price_data' => [
                        'currency'     => 'eur',
                        'product_data' => ['name' => $description],
                        'unit_amount'  => (int) round(((float) $amount) * 100),
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode'            => 'payment',
            'success_url'     => $appUrl . '/dash/charge',
            'cancel_url'      => $appUrl . '/dash/charge',
        ];

        if (!empty($method)) {
            $params['payment_method_types'] = [$method];
        }

        $session = $this->apiClient()->checkout->sessions->create($params);

        return [
            'id'  => $session->id,
            'url' => $session->url,
        ];
    }
}
