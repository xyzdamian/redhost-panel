<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with-&hearts; by Damian Schönberger
 *  *
 *  * @project     v2
 *  * @file        404.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  * @time        15:35
 *
 */
http_response_code(404);
?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Seite nicht gefunden</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 16px;
        }
        .card {
            background-color: #ffffff;
            border-radius: 12px;
            max-width: 480px;
            width: 100%;
            padding: 48px 40px;
            text-align: center;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        }
        .code { font-size: 48px; font-weight: bold; color: #cc0000; }
        h1 { margin-top: 8px; font-size: 22px; color: #1a1a1a; }
        p { margin-top: 12px; font-size: 14px; color: #666666; line-height: 1.6; }
        a {
            display: inline-block;
            margin-top: 24px;
            padding: 12px 28px;
            background-color: #cc0000;
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="code">404</div>
        <h1>Seite nicht gefunden</h1>
        <p>Die angeforderte Seite existiert nicht oder wurde verschoben.</p>
        <a href="<?= env('URL') ?>">Zurück zur Startseite</a>
    </div>
</body>
</html>
