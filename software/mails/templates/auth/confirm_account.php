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
    $subject = 'Bitte bestätigen Sie Ihre E-Mail-Adresse';

    $altBody = 'Ihr Bestätigungscode: ' . $data['verify_code'] . "\r\n";

    return mailBuild('auth/snippets/confirm_account_body.php', $subject, $altBody, [
            'BESTAETIGUNGS_CODE' => $data['verify_code'],
    ]);
}
