# Hello World em Thrift

Este é um simples projeto "Hello World" em Thrift, mostrando como criar um serviço de servidor e cliente usando a linguagem PHP.

## Pré-requisitos

Certifique-se de ter o Thrift instalado em seu sistema. Você pode baixar o Thrift em [thrift.apache.org](https://thrift.apache.org/download).

## Passos para executar o projeto

1. Execute o seguinte comando para instalar as dependências do projeto:
   ```
   composer install
   ```
2. Navegue para a pasta "src" do projeto.

3. Execute o comando abaixo para gerar o código PHP a partir do arquivo "tutorial.thrift":

   ```
   thrift --gen php:server -r ../tutorial.thrift
   ```

   Isso criará o código PHP necessário para implementar o servidor.

  
3. Em um terminal, execute o servidor PHP executando o seguinte comando:

   ```
   php server.php
   ```

   O servidor estará pronto para receber solicitações.

4. Em outro terminal, execute o cliente PHP usando o comando:

   ```
   php client.php
   ```

   O cliente enviará uma solicitação para o servidor e receberá a resposta "Hello World" do serviço Thrift.

## Descrição do projeto

O arquivo "tutorial.thrift" contém a definição do serviço "Hello World" em Thrift:

```thrift
namespace php tutorial

service HelloWorld {
  string helloWorld()
}
```

O serviço "HelloWorld" possui um único método chamado "helloWorld", que retorna uma string contendo "Hello World".

O arquivo "server.php" implementa o servidor PHP que responde à solicitação do cliente.

```php
<?php
require_once 'gen-php/tutorial/HelloWorld.php';

class HelloWorldHandler implements \tutorial\HelloWorldIf {
  public function helloWorld() {
    return "Hello World";
  }
}

$handler = new HelloWorldHandler();
$processor = new \tutorial\HelloWorldProcessor($handler);

$transport = new \Thrift\Transport\TPhpStream(TPhpStream::MODE_R | TPhpStream::MODE_W);
$protocol = new \Thrift\Protocol\TBinaryProtocol($transport, true, true);

$transport->open();
$processor->process($protocol, $protocol);
$transport->close();
```

O arquivo "client.php" implementa o cliente PHP que faz uma solicitação ao servidor.

```php
<?php
require_once 'gen-php/tutorial/HelloWorld.php';

$socket = new \Thrift\Transport\TSocket('localhost', 9090);
$transport = new \Thrift\Transport\TBufferedTransport($socket);
$protocol = new \Thrift\Protocol\TBinaryProtocol($transport);

$client = new \tutorial\HelloWorldClient($protocol);

$transport->open();
$response = $client->helloWorld();
$transport->close();

echo "Resposta do servidor: " . $response . "\n";
```

Este projeto demonstra a simplicidade de criar um serviço básico em Thrift usando a linguagem PHP. Você pode expandir este exemplo para criar serviços mais complexos e realizar comunicação entre diferentes plataformas de maneira fácil e eficiente.