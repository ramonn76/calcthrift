<?php

namespace tutorial\php;

error_reporting(E_ALL);

require_once __DIR__.'/../vendor/autoload.php';

use Thrift\ClassLoader\ThriftClassLoader;

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TPhpStream;
use Thrift\Factory\TTransportFactory;
use Thrift\Factory\TBinaryProtocolFactory;
use Thrift\Server\TServerSocket;
use Thrift\Server\TSimpleServer;

$GEN_DIR = realpath(dirname(__FILE__)).'/gen-php';

$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', __DIR__ . '/../../lib/php/lib');
$loader->registerNamespace('tutorial', $GEN_DIR);
$loader->register();

class HelloServiceHandler implements \tutorial\HelloServiceIf {
    protected $log = array();

    public function hello($nome ){
      error_log("O cliente ".$nome." disse alô!");
      return "NomeDoServidor";
    }

}

$handler = new HelloServiceHandler();
$processor = new \tutorial\HelloServiceProcessor($handler);

$transportFactory = new TTransportFactory();
$protocolFactory = new TBinaryProtocolFactory(true, true);

$serverTransport = new TServerSocket('localhost', 9090);
$server = new TSimpleServer($processor, $serverTransport, $transportFactory, $transportFactory, $protocolFactory, $protocolFactory);

echo "Starting the server...\n";
$server->serve();