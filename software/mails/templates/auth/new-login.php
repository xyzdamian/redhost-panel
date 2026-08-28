<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with-&hearts; by Damian Schönberger
 *  *
 *  * @project     v2
 *  * @file        new-login.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  * @time        2:50
 *
 */

require __DIR__ . '/../style.php';

function template($data): array
{
    $subject = 'Neue Anmeldung erkannt';

    $altBody = 'Guten Tag ' . $data['user_name'] . ",\r\n"
        . 'wir haben eine neue Anmeldung bei Ihrem Konto registriert.' . "\r\n"
        . 'Zeitpunkt: ' . $data['login_time'] . "\r\n"
        . 'Gerät: ' . $data['login_device'] . "\r\n"
        . 'Standort: ' . $data['login_location'] . "\r\n"
        . 'IP-Adresse: ' . $data['login_ip'] . "\r\n\r\n"
        . 'Falls Sie das nicht waren: ' . $data['password_reset_link'] . "\r\n";

    return mailBuild('auth/snippets/new-login_body.php', $subject, $altBody, [
        'VORNAME'               => $data['user_name'],
        'ZEITPUNKT'             => $data['login_time'],
        'GERAET'                => $data['login_device'],
        'STANDORT'              => $data['login_location'],
        'IP_ADRESSE'            => $data['login_ip'],
        'PASSWORT_AENDERN_LINK' => $data['password_reset_link'],
    ]);
}
