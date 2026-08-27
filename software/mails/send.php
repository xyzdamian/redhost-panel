<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with-&hearts; by Damian Schönberger
 *  *
 *  * @project     v2
 *  * @file        send.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  * @time        0:54
 *
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMail($user_email, $user_name, $mailContent, $mailSubject) {
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = true;
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = env('MAIL_HOST');
        $mail->SMTPSecure = env('MAIL_ENCRYPTION');
        $mail->SMTPAutoTLS = env('MAIL_ENCRYPTION_STARTTLS');
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->Port = env('MAIL_PORT');

        $mail->setFrom(env('MAIL_FROM'), env('MAIL_PROJECT_NAME'), '');
        $mail->addAddress($user_email, $user_name);

        $mail->CharSet = 'utf-8';
        $mail->isHTML(true);
        $mail->Subject = $mailSubject;
        $mail->Body = $mailContent;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return 'abc';
        return 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
    }
}