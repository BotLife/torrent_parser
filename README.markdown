PHP BitTorrent
==============
**PHP BitTorrent** is a set of components that can be used to interact with torrent files (read+write) and encode/decode to/from the BitTorrent format.

Requirements
------------
PHP BitTorrent requires PHP 5.3.x or above. The recommended version is 5.3.2 or newer.

Installation
------------
PHP BitTorrent should be installed using [PEAR](http://pear.php.net/).

The PEAR channel (`pear.starzinger.net`) that is used to distribute PHP BitTorrent needs to be registered with the local PEAR environment.

    christer@aurora:~$ sudo pear channel-discover pear.starzinger.net
    Adding Channel "pear.starzinger.net" succeeded
    Discovery of channel "pear.starzinger.net" succeeded

This has to be done only once. Now, to install the package:

    christer@aurora:~$ sudo pear install stz/PHP_BitTorrent-beta
    downloading PHP_BitTorrent-0.2.0.tgz ...
    Starting to download PHP_BitTorrent-0.2.0.tgz (8,249 bytes)
    .....done: 8,249 bytes
    install ok: channel://pear.starzinger.net/PHP_BitTorrent-0.2.0

Using the PHP BitTorrent API
----------------------------
**Autoloader**

PHP BitTorrent does **not** come with its own autoloader, so you will need to use a PSR-0 compatible autoloader for everything to work as expected, or provide your own `require[_once]` statements. An example of such an autoloader can be found [here](https://gist.github.com/1234504).

**Encode PHP variables**

```php
<?php
$encoder = new PHP\BitTorrent\Encoder();

var_dump($encoder->encodeString('Some string')); // string(14) "11:Some string"
var_dump($encoder->encodeInteger(42)); // string(4) "i42e"
var_dump($encoder->encodeList(array(1, 2, 3)); // string(11) "li1ei2ei3ee"
var_dump($encoder->encodeDictionary(array('foo' => 'bar', 'bar' => 'foo')); // string(22) "d3:foo3:bar3:bar3:fooe"
```

There is also a convenience method simply called `encode` in the `PHP\BitTorrent\Encoder` class that can be used to encode all encodable variables (integers, strings and arrays).

**Decode BitTorrent encoded data**

```php
<?php
$encoder = new PHP\BitTorrent\Encoder();
$decoder = new PHP\BitTorrent\Decoder($encoder); // The decoder needs an encoder for some methods

var_dump($decoder->decodeString('11:Some string')); // string(11) "Some string"
var_dump($decoder->decodeInteger('i42e')); // int(42)
var_dump($decoder->decodeList('li1ei2ei3ee'); // array(3) { [0]=> int(1) [1]=> int(2) [2]=> int(3) }
var_dump($decoder->decodeDictionary('d3:foo3:bar3:bar3:fooe'); // array(2) { ["foo"]=> string(3) "bar" ["bar"]=> string(3) "foo" }
```

There is also a convenience method called `decode` that can decode any BitTorrent encoded data.

**Decode torrent files**

The decoder class also has a method for decoding a torrent file (which is an encoded dictionary):

```php
<?php
$encoder = new PHP\BitTorrent\Encoder();
$decoder = new PHP\BitTorrent\Decoder($encoder);

$decodedFile = $decoder->decodeFile('/path/to/file.torrent');
```

**Create new torrent files and open existing ones**

The `PHP\BitTorrent\Torrent` class represents a torrent file and can be used to create torrent files.

```php
<?php
$torrent = PHP\BitTorrent\Torrent::createFromPath('/path/to/files', 'http://tracker/announce.php');

$torrent->setComment('Some comment')
        ->save('/save/to/path/file.torrent');
```

The class can also load a torrent file:

```php
<?php
$torrent = PHP\BitTorrent\Torrent::createFromTorrentFile('/path/to/file.torrent');

$torrent->setAnnounce('http://tracker/announce.php') // Override announce in original file
        ->setComment('Some comment') // Override commend in original file
        ->save('/save/to/path/file.torrent'); // Save to a new file
```
