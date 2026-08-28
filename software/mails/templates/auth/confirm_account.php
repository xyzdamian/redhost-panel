<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with-&hearts; by Damian Schönberger
 *  *
 *  * @project     v2
 *  * @file        confirm_account.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  * @time        2:50
 *
 */

require __DIR__ . '/../style.php';

function template($data): array
{
    $altBody = 'Ihr Bestätigungscode: ' . $data['verify_code'] . "\r\n";

    return mailBuild(
        'Bitte bestätigen Sie Ihre E-Mail-Adresse',
        $altBody,
        [
            'KICKER' => 'Konto-Erstellung',
            'TITEL'  => 'Bestätigen Sie Ihre E-Mail-Adresse',
            'INHALT' => 'Guten Tag, bitte verwenden Sie den folgenden Code, um die Registrierung Ihres Kontos abzuschließen:',
            'CODE'   => $data['verify_code'],
            'NOTIZ'  => 'Der Code ist 30 Minuten gültig. Sollten Sie diese E-Mail nicht angefordert haben, ignorieren Sie sie bitte.',
        ]
    );
}
