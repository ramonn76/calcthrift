#!/usr/bin/env php
<?php


namespace tutorial\php;

error_reporting(E_ALL);

require_once __DIR__.'/../vendor/autoload.php';

use Thrift\ClassLoader\ThriftClassLoader;

$GEN_DIR = realpath(dirname(__FILE__)).'/gen-php';

$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', __DIR__ . '/../../lib/php/lib');
$loader->registerNamespace('shared', $GEN_DIR);
$loader->registerNamespace('tutorial', $GEN_DIR);
$loader->register();

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TPhpStream;
use Thrift\Factory\TTransportFactory;
use Thrift\Factory\TBinaryProtocolFactory;
use Thrift\Server\TServerSocket;
use Thrift\Server\TSimpleServer;

class CalculatorHandler implements \tutorial\CalculatorIf {
    protected $log = array();

    public function ping() {
        error_log("ping()");
    }

    public function hello(){
      error_log("ola mundo");
    }

    public function add($num1, $num2) {
        error_log("add({$num1}, {$num2})");
        return $num1 + $num2;
    }

    public function calculate($logid, \tutorial\Work $w) {
      error_log("calculate({$logid}, {{$w->op}, {$w->num1}, {$w->num2}})");
      switch ($w->op) {
        case \tutorial\Operation::ADD:
          $val = $w->num1 + $w->num2;
          break;
        case \tutorial\Operation::SUBTRACT:
          $val = $w->num1 - $w->num2;
          break;
        case \tutorial\Operation::MULTIPLY:
          $val = $w->num1 * $w->num2;
          break;
        case \tutorial\Operation::DIVIDE:
          if ($w->num2 == 0) {
            $io = new \tutorial\InvalidOperation();
            $io->whatOp = $w->op;
            $io->why = "Cannot divide by 0";
            throw $io;
          }
          $val = $w->num1 / $w->num2;
          break;
        default:
          $io = new \tutorial\InvalidOperation();
          $io->whatOp = $w->op;
          $io->why = "Invalid Operation";
          throw $io;
      }
  
      $log = new \shared\SharedStruct();
      $log->key = $logid;
      $log->value = (string)$val;
      $this->log[$logid] = $log;
  
      return $val;
    }
  
    public function getStruct($key) {
      error_log("getStruct({$key})");
      // This actually doesn't work because the PHP interpreter is
      // restarted for every request.
      //return $this->log[$key];
      return new \shared\SharedStruct(array("key" => $key, "value" => "PHP is stateless!"));
    }

    public function zip() {
        error_log("zip()");
    }
}
//header('Content-Type', 'application/x-thrift');
//if (php_sapi_name() == 'cli') {
//    echo "\r\n";
//}

$handler = new CalculatorHandler();
$processor = new \tutorial\CalculatorProcessor($handler);

$transportFactory = new TTransportFactory();
$protocolFactory = new TBinaryProtocolFactory(true, true);

$serverTransport = new TServerSocket('localhost', 9090);
$server = new TSimpleServer($processor, $serverTransport, $transportFactory, $transportFactory, $protocolFactory, $protocolFactory);

echo "Starting the server...\n";
$server->serve();