<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with-&hearts; by Damian Schönberger
 *  *
 *  * @project     v2
 *  * @file        KVM.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *  * @time        15:5
 *
 */


use ProxmoxVE\Proxmox;

$kvm = new KVM();

class kvm extends Controller {

    public function getServerCredentials($nodeid): array
    {
        $stmt = self::db()->prepare('SELECT * FROM nodes WHERE id = :nodeid LIMIT 1');
        $stmt->execute([':nodeid' => $nodeid]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: [];
    }

    public function getIPv4($vmid): array
    {
        $stmt = self::db()->prepare('SELECT * FROM ipv4_adresses WHERE service = :vid LIMIT 1');
        $stmt->execute([':vid' => $vmid]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: [];
    }

    public function getIPv6($vmid): array
    {
        $stmt = self::db()->prepare('SELECT * FROM ipv6_adresses WHERE service = :vid LIMIT 1');
        $stmt->execute([':vid' => $vmid]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: [];
    }



}