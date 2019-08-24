# PDOEasy

###### PDOEasy is a PHP class for performing basic actions on a database using SQL in simplified form. PDOEasy handles and validates all information before each action in the database. The class is an abstraction of PHP's PDO extension that is recognized for being very safe and easy to implement.

PDOEasy é uma classe PHP para realizar ações básicas em um banco de dados usando SQL de forma simplificada. A PDOEasy trata e valida todas as informações antes de cada ação na base de dados. A classe é uma abstração da extensão PDO do PHP que é reconhecida por ser muito segura e de fácil implementação.

## Configuration

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

```sql
SELECT * FROM students
```

```php
<?php

$conn->select('students');
$conn->exec();
$students = $conn->fetchAll();

?>
```

###### Select id and table name students where email is mary@email.com and name is Mary

Selecionar o id e o nome da tabela students onde o email é mary@email.com e o nome é Mary

```sql
SELECT std_id, std_name FROM students WHERE std_email = 'mary@email.com' AND std_name = 'Mary' LIMIT 1
```

```php
<?php

$terms = "WHERE std_email = :email AND std_name = :name LIMIT 1";
$values = ['email' => 'mary@email.com', 'name' => 'Mary'];
$conn->select('students', 'std_id, std_name', $terms, $values);
$conn->exec();
$students = $conn->fetchAll();

?>
```

###### Join two or more tables

Fazer uma junção de duas ou mais tabelas

```sql
SELECT std_name, crs_name FROM students INNER JOIN courses on courses.crs_id = students.std_course
```

```php
<?php

$terms = "INNER JOIN courses on courses.crs_id = students.std_course";
$conn->select('students', 'std_name, crs_name', $terms);
$conn->exec();
$students = $conn->fetchAll();

?>
```

###### Insert data into students table

Inserir dados na tabela students

```php
<?php

$conn->insert('students', ['std_name' => 'José Carlos', 'std_email' => 'josecarlos@email.com']);
$conn->exec();

?>
```

###### Update data in students table

Atualizar dados na tabela students

```php
<?php

$terms = "std_name = :name, std_email = :email WHERE std_id = :id LIMIT 1";
$values = [
    'name' => 'Jhon',
    'email' => 'Jhon@email.com',
    'id' => 1,
];
$conn->update('students', $terms, $values);
$conn->exec();

?>
```

###### Delete data in students table

Deletar dados na tabela students

```php
<?php

$conn->delete('students', "WHERE std_id = :id LIMIT 1", [ 'id' => 1]);
$conn->exec();

?>
```
###### exec() method returns true or false for action

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