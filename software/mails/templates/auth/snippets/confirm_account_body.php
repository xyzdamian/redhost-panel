<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with-&hearts; by Damian Schönberger
 *  *
 *  * @project     v2
 *  * @file        confirm_account_body.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  * @time        2:48
 *
 */
?>

<!-- Body -->
<tr>
    <td style="padding:32px 40px 0;">
        <p style="margin:0 0 8px; font-size:11px; letter-spacing:1px; color:#cc0000; font-weight:bold; text-transform:uppercase;">
    Konto-Erstellung
        </p>
        <h1 style="margin:0 0 20px; font-size:20px; line-height:1.35; color:#1a1a1a; font-weight:bold;">
    Bestätigen Sie Ihre E-Mail-Adresse
</h1>
        <p style="margin:0 0 16px; font-size:14px; color:#333333; line-height:1.65;">
    Guten Tag, bitte verwenden Sie den folgenden Code, um die Registrierung Ihres Kontos abzuschließen:
        </p>
    </td>
</tr>

<!-- Verify code -->
<tr>
    <td style="padding:20px 40px 0;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f7f7f7; border:1px solid #dddddd; border-radius:8px;">
            <tr>
                <td align="center" style="padding:24px; font-size:28px; letter-spacing:4px; font-weight:bold; color:#1a1a1a;">
    [BESTAETIGUNGS_CODE]
                </td>
            </tr>
        </table>
    </td>
</tr>

<tr>
    <td style="padding:24px 40px 36px;">
        <p style="margin:0; font-size:13px; color:#777777; line-height:1.65;">
    Der Code ist 30 Minuten gültig. Sollten Sie diese E-Mail nicht angefordert haben, ignorieren Sie sie bitte.
        </p>
        <p style="margin:16px 0 0; font-size:14px; color:#333333;">
    Team [PROJEKT_NAME]
        </p>
    </td>
</tr>
