<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with-&hearts; by Damian Schönberger
 *  *
 *  * @project     v2
 *  * @file        style.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  * @time        2:51
 *
 */

$mailProjectName = env('MAIL_PROJECT_NAME') ?: 'RED-Host';
$mailLogoUrl     = env('MAIL_LOGO_URL') ?: 'https://i.imgur.com/NVXW1Dc.png';
$mailImpressum   = env('MAIL_IMPRESSUM_URL') ?: '';
$mailAGB         = env('MAIL_AGB_URL') ?: '';
$mailDatenschutz = env('MAIL_DATENSCHUTZ_URL') ?: '';

/**
 * Baut den E-Mail-Body aus einem Satz von Variablen.
 *
 * Verfügbare Variablen (Platzhalter im Inhalts-String):
 *  - TITEL     : Überschrift
 *  - KICKER    : kleine rote Oberzeile (z.B. "Sicherheitshinweis")
 *  - INHALT    : Fließtext (Absätze mit \n getrennt)
 *  - CTA_LINK  : optionaler Button-Link
 *  - CTA_TEXT  : Button-Beschriftung (bei CTA_LINK erforderlich)
 *  - NOTIZ     : optionaler grauer Hinweistext unten
 *  - CODE      : optionaler großer Verifizierungscode (grauer Kasten)
 */
function mailTemplate($content, $title = '', $variables = []): string
{
    global $mailProjectName, $mailLogoUrl, $mailImpressum, $mailAGB, $mailDatenschutz;

    $variables['PROJEKT_NAME'] = $mailProjectName;

    foreach ($variables as $key => $value) {
        $content = str_replace('[' . strtoupper($key) . ']', $value, $content);
    }

    return '<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . ($title !== '' ?: $mailProjectName) . '</title>
</head>
<body style="margin:0; padding:0; background-color:#f0f0f0; font-family: Arial, Helvetica, sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0f0f0;">
    <tr>
        <td align="center" style="padding:40px 16px;">
            <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background-color:#ffffff; border-radius:12px; overflow:hidden;">

                <!-- Logo -->
                <tr>
                    <td style="padding:32px 40px 24px;">
                        <img src="' . $mailLogoUrl . '" alt="' . $mailProjectName . '" width="130" style="display:block; max-width:130px; height:auto;">
                    </td>
                </tr>

                <!-- Accent rule -->
                <tr>
                    <td style="padding:0 40px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="height:3px; background-color:#cc0000; border-radius:3px; font-size:0; line-height:0;">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:32px 40px 16px;">
                        ' . ($variables['KICKER'] !== '' ? '<p style="margin:0 0 8px; font-size:11px; letter-spacing:1px; color:#cc0000; font-weight:bold; text-transform:uppercase;">' . $variables['KICKER'] . '</p>' : '') . '
                        <h1 style="margin:0 0 20px; font-size:20px; line-height:1.35; color:#1a1a1a; font-weight:bold;">
                            ' . $variables['TITEL'] . '
                        </h1>
                        ' . nl2br($variables['INHALT']) . '
                    </td>
                </tr>

                <!-- Verify code -->
                ' . ($variables['CODE'] !== '' ? '
                <tr>
                    <td style="padding:20px 40px 0;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f7f7f7; border:1px solid #dddddd; border-radius:8px;">
                            <tr>
                                <td align="center" style="padding:24px; font-size:28px; letter-spacing:4px; font-weight:bold; color:#1a1a1a;">
                                    ' . $variables['CODE'] . '
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>' : '') . '

                <!-- CTA button -->
                ' . ($variables['CTA_LINK'] !== '' && $variables['CTA_TEXT'] !== '' ? '
                <tr>
                    <td style="padding:8px 40px 0;">
                        <table role="presentation" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="background-color:#cc0000; border-radius:6px;">
                                    <a href="' . $variables['CTA_LINK'] . '" style="display:inline-block; padding:12px 28px; font-size:14px; font-weight:bold; color:#ffffff; text-decoration:none; border-radius:6px;">
                                        ' . $variables['CTA_TEXT'] . '
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>' : '') . '

                <!-- Note -->
                ' . ($variables['NOTIZ'] !== '' ? '
                <tr>
                    <td style="padding:20px 40px 0;">
                        <p style="margin:0; font-size:13px; color:#777777; line-height:1.65;">
                            ' . $variables['NOTIZ'] . '
                        </p>
                    </td>
                </tr>' : '') . '

                <tr>
                    <td style="padding:28px 40px 36px;">
                        <p style="margin:0; font-size:14px; color:#333333;">
                            Team [PROJEKT_NAME]
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="padding:20px 40px; border-top:1px solid #dddddd;">
                        <p style="margin:0 0 12px; font-size:11px; color:#999999; line-height:1.6;">
                            Dies ist eine automatisierte E-Mail, bitte antworten Sie nicht auf diese E-Mail.
                        </p>
                        <p style="margin:0; font-size:11px; color:#999999; line-height:1.6;">
                            <a href="' . $mailImpressum . '" style="color:#999999; text-decoration:underline;">Impressum</a>
                            &nbsp;&bull;&nbsp;
                            <a href="' . $mailAGB . '" style="color:#999999; text-decoration:underline;">AGB</a>
                            &nbsp;&bull;&nbsp;
                            <a href="' . $mailDatenschutz . '" style="color:#999999; text-decoration:underline;">Datenschutzerklärung</a>
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>';
}

/**
 * Baut eine fertige E-Mail aus Betreff, Klartext und Variablen.
 * $variables = ['TITEL' =>, 'KICKER' =>, 'INHALT' =>, 'CTA_LINK' =>, 'CTA_TEXT' =>, 'NOTIZ' =>, ...]
 */
function mailBuild($subject, $altBody, $variables = []): array
{
    $variables += [
        'TITEL'    => '',
        'KICKER'   => '',
        'INHALT'   => '',
        'CTA_LINK' => '',
        'CTA_TEXT' => '',
        'NOTIZ'    => '',
        'CODE'     => '',
    ];

    return [
        'subject' => $subject,
        'alt'     => $altBody,
        'html'    => mailTemplate('', $subject, $variables),
    ];
}
