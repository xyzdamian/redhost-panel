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
    $altBody = 'Guten Tag ' . $data['user_name'] . ",\r\n"
        . 'wir haben eine neue Anmeldung bei Ihrem Konto registriert.' . "\r\n"
        . 'Zeitpunkt: ' . $data['login_time'] . "\r\n"
        . 'Gerät: ' . $data['login_device'] . "\r\n"
        . 'Standort: ' . $data['login_location'] . "\r\n"
        . 'IP-Adresse: ' . $data['login_ip'] . "\r\n\r\n"
        . 'Falls Sie das nicht waren: ' . $data['password_reset_link'] . "\r\n";

    $inhalt = 'wir haben eine neue Anmeldung bei Ihrem Konto registriert. Die Angaben zu dieser Sitzung finden Sie in der folgenden Übersicht:';

    return mailBuild(
        'Neue Anmeldung erkannt',
        $altBody,
        [
            'KICKER'   => 'Sicherheitshinweis',
            'TITEL'    => 'Neue Anmeldung erkannt',
            'INHALT'   => 'Guten Tag ' . $data['user_name'] . ',' . "\n" . $inhalt
                . "\n\n" . 'Zeitpunkt: ' . $data['login_time']
                . "\n" . 'Gerät: ' . $data['login_device']
                . "\n" . 'Standort: ' . $data['login_location']
                . "\n" . 'IP-Adresse: ' . $data['login_ip'],
            'CTA_LINK' => $data['password_reset_link'],
            'CTA_TEXT' => 'Passwort ändern',
            'NOTIZ'    => 'Wir empfehlen Ihnen außerdem, die Zwei-Faktor-Authentifizierung (2FA) zu aktivieren, um die Sicherheit Ihres Kontos zu erhöhen.',
        ]
    );
}
