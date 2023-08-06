<?php

namespace tutorial\php;

error_reporting(E_ALL);

require_once __DIR__.'/../vendor/autoload.php';

use Thrift\ClassLoader\ThriftClassLoader;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\THttpClient;
use Thrift\Transport\TBufferedTransport;
use Thrift\Exception\TException;

$GEN_DIR = realpath(dirname(__FILE__)).'/gen-php';

$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', __DIR__ . '/../../lib/php/lib');
$loader->registerNamespace('tutorial', $GEN_DIR);
$loader->register();

try {
  $socket = new TSocket('localhost', 9090);
  $transport = new TBufferedTransport($socket, 1024, 1024);
  $protocol = new TBinaryProtocol($transport);
  $client = new \tutorial\HelloServiceClient($protocol);
  $transport->open();
  $clientName = "NomeDoCliente";
  $ret = $client->hello($clientName);
  print 'O Servidor '.$ret." disse alô.\n";
  $transport->close();

} catch (TException $tx) {
  print 'TException: '.$tx->getMessage()."\n";
}

?>
