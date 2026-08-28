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

function mailTemplate($contentFile, $title = '', $variables = []): string
{
    global $mailProjectName, $mailLogoUrl, $mailImpressum, $mailAGB, $mailDatenschutz;

    ob_start();
    include __DIR__ . '/' . $contentFile;
    $content = ob_get_clean();

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

                ' . $content . '

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

function mailBuild($snippetFile, $subject, $altBody, $variables = []): array
{
    global $mailProjectName;

    $variables['PROJEKT_NAME'] = $mailProjectName;

    return [
        'subject' => $subject,
        'alt'     => $altBody,
        'html'    => mailTemplate($snippetFile, $subject, $variables),
    ];
}
