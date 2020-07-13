# PDOEasy

PDOEasy é uma classe PHP para realizar ações básicas em um banco de dados usando SQL de forma simplificada. A PDOEasy trata e valida todas as informações antes de cada ação na base de dados. A classe é uma abstração da extensão PDO do PHP que é reconhecida por ser muito segura e de fácil implementação.

## Configuration

Defina acima da instancia a seguinte constante com as configurações da base de dados que você quer conectar. 

```php
<?php

define('DATA_BASE', [
    'host' => 'localhost',
    'db' => 'tutoriais',
    'user' => 'root',
    'psw' => '',
]);

```

Seguindo uma boa pratica, você pode criar estas informações em arquivo de configuração do seu projeto.

### Lembre-se de baixar e incluir o arquivo 'PDOEasy.class.php' em seu projeto

## Examples

Você pode instanciar a PDOEasy apenas uma vez a cada arquivo para fazer um bom uso da memória.

```php
<?php

use Models\Database\PDOEasy;

$conn = new PDOEasy();

```

### SELECT

Um select simples para obter todos os dados da tabela "users"

```php
<?php

$conn->select('users');
$conn->exec();
$result = $conn->fetchAll();

```

O metodo exec() returna verdadeiro ou falso para a ação

## Exception

###### Use error() method to debug class

Use o metodo error() para debugar a classe

```php
<?php

var_dump($conn->error());

?>
```

## Author

- [Jeterson Lordano](https://github.com/jetersonlordano)
- [Website](https://www.jetersonlordano.com.br)