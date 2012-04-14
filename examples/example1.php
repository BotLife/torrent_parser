<?php

namespace PHP\BitTorrent;

require_once __DIR__ . '/../tests/bootstrap.php';
$file = __DIR__ . '/test.torrent';
$file = 'http://releases.ubuntu.com/11.10/ubuntu-11.10-server-amd64.iso.torrent';

$decoder = new Decoder(new Encoder());
$torrent = Torrent::createFromData(file_get_contents($file));
print_r($torrent->getMagnet());