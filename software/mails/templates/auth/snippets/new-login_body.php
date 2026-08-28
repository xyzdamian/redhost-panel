<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with-&hearts; by Damian Schönberger
 *  *
 *  * @project     v2
 *  * @file        new-login_body.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  * @time        2:49
 *
 */


?>

<!-- Body -->
<tr>
    <td style="padding:32px 40px 0;">
        <p style="margin:0 0 8px; font-size:11px; letter-spacing:1px; color:#cc0000; font-weight:bold; text-transform:uppercase;">
            Sicherheitshinweis
        </p>
        <h1 style="margin:0 0 20px; font-size:20px; line-height:1.35; color:#1a1a1a; font-weight:bold;">
            Neue Anmeldung erkannt
        </h1>
        <p style="margin:0 0 16px; font-size:14px; color:#333333; line-height:1.65;">
            Guten Tag [VORNAME],
        </p>
        <p style="margin:0; font-size:14px; color:#333333; line-height:1.65;">
            wir haben eine neue Anmeldung bei Ihrem RED-Host-Konto registriert. Die Angaben zu dieser Sitzung finden Sie in der folgenden Übersicht.
        </p>
    </td>
</tr>

<!-- Session table -->
<tr>
    <td style="padding:24px 40px 0;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #dddddd; border-radius:8px;">
            <tr>
                <td style="padding:12px 16px; border-bottom:1px solid #dddddd; font-size:13px; color:#777777; width:40%; border-top-left-radius:8px;">Zeitpunkt</td>
                <td style="padding:12px 16px; border-bottom:1px solid #dddddd; font-size:13px; color:#1a1a1a; text-align:right; border-top-right-radius:8px;">[ZEITPUNKT]</td>
            </tr>
            <tr>
                <td style="padding:12px 16px; border-bottom:1px solid #dddddd; font-size:13px; color:#777777;">Gerät</td>
                <td style="padding:12px 16px; border-bottom:1px solid #dddddd; font-size:13px; color:#1a1a1a; text-align:right;">[GERAET]</td>
            </tr>
            <tr>
                <td style="padding:12px 16px; border-bottom:1px solid #dddddd; font-size:13px; color:#777777;">Standort</td>
                <td style="padding:12px 16px; border-bottom:1px solid #dddddd; font-size:13px; color:#1a1a1a; text-align:right;">[STANDORT]</td>
            </tr>
            <tr>
                <td style="padding:12px 16px; font-size:13px; color:#777777; border-bottom-left-radius:8px;">IP-Adresse</td>
                <td style="padding:12px 16px; font-size:13px; color:#1a1a1a; text-align:right; border-bottom-right-radius:8px;">[IP_ADRESSE]</td>
            </tr>
        </table>
    </td>
</tr>

<!-- CTA -->
<tr>
    <td style="padding:28px 40px 0;">
        <p style="margin:0 0 16px; font-size:14px; color:#333333; line-height:1.65;">
            Falls Sie das nicht waren, ändern Sie bitte umgehend Ihr Passwort:
        </p>
        <table role="presentation" cellpadding="0" cellspacing="0">
            <tr>
                <td style="background-color:#cc0000; border-radius:6px;">
                    <a href="[PASSWORT_AENDERN_LINK]" style="display:inline-block; padding:12px 28px; font-size:14px; font-weight:bold; color:#ffffff; text-decoration:none; border-radius:6px;">
                        Passwort ändern
                    </a>
                </td>
            </tr>
        </table>
    </td>
</tr>

<!-- 2FA note -->
<tr>
    <td style="padding:24px 40px 0;">
        <p style="margin:0; font-size:13px; color:#777777; line-height:1.65;">
            Wir empfehlen Ihnen außerdem, die Zwei-Faktor-Authentifizierung (2FA) zu aktivieren, um die Sicherheit Ihres Kontos zu erhöhen.
        </p>
    </td>
</tr>

<tr>
    <td style="padding:28px 40px 36px;">
        <p style="margin:0; font-size:14px; color:#333333;">
            Team [PROJEKT_NAME]
        </p>
    </td>
</tr>
