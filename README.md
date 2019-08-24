# PDOEasy

###### PDOEasy is a PHP class for performing basic actions on a database using SQL in simplified form. PDOEasy handles and validates all information before each action in the database. The class is an abstraction of PHP's PDO extension that is recognized for being very safe and easy to implement.

PDOEasy é uma classe PHP para realizar ações básicas em um banco de dados usando SQL de forma simplificada. A PDOEasy trata e valida todas as informações antes de cada ação na base de dados. A classe é uma abstração da extensão PDO do PHP que é reconhecida por ser muito segura e de fácil implementação.

## Installation

###### Set above the following constant with the database settings you want to connect.

Defina acima da instancia a seguinte constante com as configurações da base de dados que você quer conectar. 

```php
<?php

define('DBCONFIG', [
    'host' => 'localhost',
    'db' => 'mydb',
    'user' => 'root',
    'psw' => '',
]);

?>
```

###### Following good practice, you can create this information in your project's configuration file.
Seguindo uma boa pratica, você pode criar estas informações em arquivo de configuração do seu projeto.

## Examples

###### You can instantiate PDOEasy only once per file to make good memory use.

Você pode instanciar a PDOEasy apenas uma vez a cada arquivo para fazer um bom uso da memória.

```php
<?php

use Database\PDOEasy;
$conn = new PDOEasy();

?>
```

### SELECT

###### Select all data from students table

Selecionar todos os dados da tabela students

```bash
SELECT * FROM students
```

```php
<?php

$conn->select('students');
$conn->exec();
$students = $conn->fetchAll();

?>
```