<?php

namespace PHP\BitTorrent;

require_once __DIR__ . '/../tests/bootstrap.php';

$decoder = new Decoder(new Encoder());
$torrent = Torrent::createFromData(file_get_contents(__DIR__ . '/test.torrent'));
print_r($torrent->getAnnounce());