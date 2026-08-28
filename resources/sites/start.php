<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with ♥ by Damian Schönberger
 *  *
 *  * @project     v2
 *  * @file        start.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  * @time        15:35
 *
 */
$title = 'RED-Host v2';
$message = 'In Entwicklung';
$subtext = 'Das neue RED-Host Panel wird derzeit entwickelt und ist bald verfügbar.';
?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RED-Host</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --red: #e3001b;
            --red-light: #ff4d5e;
            --ink: #14161c;
            --muted: #6b7280;
            --bg: #121212;
        }

        html, body { height: 100%; }

        body {
            font-family: 'Inter', 'Segoe UI', Arial, Helvetica, sans-serif;
            background:
                    radial-gradient(circle at 12% 10%, rgba(227, 0, 27, 0.08), transparent 42%),
                    radial-gradient(circle at 90% 85%, rgba(227, 0, 27, 0.06), transparent 45%),
                    var(--bg);
            color: var(--ink);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 16px;
            position: relative;
            overflow: hidden;
        }

        /* soft floating shapes for depth */
        body::before, body::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.5;
            z-index: 0;
            animation: float 14s ease-in-out infinite;
        }
        body::before {
            width: 280px; height: 280px;
            background: rgba(227, 0, 27, 0.18);
            top: -60px; left: -60px;
        }
        body::after {
            width: 220px; height: 220px;
            background: rgba(255, 190, 60, 0.18);
            bottom: -50px; right: -50px;
            animation-delay: -7s;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(24px, 18px) scale(1.06); }
        }

        .card {
            position: relative;
            z-index: 1;
            background: #f6f7fb;
            border-radius: 20px;
            max-width: 480px;
            width: 100%;
            padding: 52px 40px 44px;
            text-align: center;
            box-shadow:
                    0 1px 2px rgba(20, 22, 28, 0.04),
                    0 16px 40px rgba(20, 22, 28, 0.08);
            border: 1px solid rgba(20, 22, 28, 0.05);
            animation: rise 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes rise {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .logo {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 0.3px;
            color: var(--ink);
        }
        .logo span { color: var(--red); }

        .kicker {
            margin-top: 26px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--red);
            font-weight: 700;
            padding: 6px 14px;
            border: 1px solid rgba(227, 0, 27, 0.2);
            border-radius: 999px;
            background: rgba(227, 0, 27, 0.06);
        }
        .kicker::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--red);
            box-shadow: 0 0 0 0 rgba(227, 0, 27, 0.5);
            animation: pulse 1.8s infinite;
        }
        @keyframes pulse {
            0%   { box-shadow: 0 0 0 0 rgba(227, 0, 27, 0.45); }
            70%  { box-shadow: 0 0 0 8px rgba(227, 0, 27, 0); }
            100% { box-shadow: 0 0 0 0 rgba(227, 0, 27, 0); }
        }

        h1 {
            margin-top: 18px;
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--ink);
        }

        p {
            margin-top: 14px;
            font-size: 14.5px;
            color: var(--muted);
            line-height: 1.7;
        }

        .progress {
            margin-top: 34px;
            width: 100%;
            height: 6px;
            border-radius: 999px;
            background: rgba(20, 22, 28, 0.07);
            overflow: hidden;
            position: relative;
        }
        .progress-fill {
            position: absolute;
            top: 0; left: 0;
            height: 100%;
            width: 40%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--red), var(--red-light));
            animation: loading 2.2s ease-in-out infinite;
        }
        @keyframes loading {
            0%   { left: -40%; }
            100% { left: 100%; }
        }

        footer {
            margin-top: 30px;
            font-size: 11.5px;
            color: rgba(20, 22, 28, 0.3);
            letter-spacing: 0.3px;
        }

        @media (max-width: 480px) {
            .card { padding: 40px 26px 34px; }
            h1 { font-size: 24px; }
        }
    </style>
</head>
<body>
<div class="card">
    <div class="logo"><img src="https://i.imgur.com/x3XHIc0.png" width="256"></div>
    <div class="kicker">Status</div>
    <h1><?= $message ?></h1>
    <p><?= $subtext ?></p>
    <div class="progress"><div class="progress-fill"></div></div>
</div>
</body>
</html>
