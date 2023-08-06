# Hello World em Thrift

Este é um simples projeto "Hello World" em Thrift, mostrando como criar um serviço de servidor e cliente usando a linguagem PHP.

## Pré-requisitos

Certifique-se de ter o Thrift e o composer instalados em seu sistema.
No sistema ubuntu basta executar os commandos:
```
sudo apt install composer 
```

e:

```
sudo apt install thrift-compiler
```

Caso use outros sistemas, acesse: [thrift.apache.org](https://thrift.apache.org/download) e [getcomposer.org](https://getcomposer.org/). 

## Passos para executar o projeto

1. Após clonar e entrar dentro da pasta, execute o seguinte comando para instalar as dependências do projeto:
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

   Deve aparecer uma mensagem de saudação tanto no terminal do servidor quando no terminal do cliente.

## Descrição do projeto

Este projeto demonstra a implementação de um serviço "Hello World" usando o Apache Thrift na linguagem PHP.

### Arquivo "tutorial.thrift"

O arquivo `tutorial.thrift` contém a definição do serviço "HelloService" em Thrift:

```thrift
namespace php tutorial

service HelloService {
   string hello(1:string nome),
}
```

O serviço "HelloService" possui um único método chamado "hello", que recebe uma string "nome" como parâmetro e retorna uma string com a mensagem "NomeDoServidor". Além disso, o serviço está definido dentro do namespace `tutorial`.

### Arquivo "server.php"

O arquivo `server.php` implementa o servidor PHP que responde às solicitações do cliente.

O servidor utiliza uma implementação do serviço "HelloService" definido no arquivo `tutorial.thrift`. A classe `HelloServiceHandler` é responsável por tratar as chamadas do cliente e implementar a lógica do serviço.

```php
class HelloServiceHandler implements \tutorial\HelloServiceIf {
    protected $log = array();

    public function hello($nome) {
      error_log("O cliente ".$nome." disse alô!");
      return "NomeDoServidor";
    }
}
```

No método `hello`, a mensagem do cliente é registrada no log do servidor e a resposta "NomeDoServidor" é retornada.

O servidor utiliza os recursos do Thrift para configurar a comunicação, incluindo a criação de um socket, a definição do protocolo de comunicação (TBinaryProtocol), e a criação de um TSimpleServer para atender às solicitações do cliente.

### Arquivo "client.php"

O arquivo `client.php` implementa o cliente PHP que faz uma solicitação ao servidor.

O cliente utiliza a implementação gerada pelo Thrift para se comunicar com o serviço "HelloService". Ele se conecta ao servidor usando um socket e envia a string "NomeDoCliente" como parâmetro para o método `hello` do serviço.

```php
$client = new \tutorial\HelloServiceClient($protocol);
$transport->open();
$clientName = "NomeDoCliente";
$ret = $client->hello($clientName);
print 'O Servidor disse: ' . $ret . "\n";
$transport->close();
```

O cliente recebe a resposta do servidor e imprime a mensagem recebida.