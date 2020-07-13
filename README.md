# PDOEasy

PDOEasy é uma classe PHP para realizar ações básicas em um banco de dados usando SQL de forma simplificada. A PDOEasy trata e valida todas as informações antes de cada ação na base de dados. A classe é uma abstração da extensão PDO do PHP que é reconhecida por ser muito segura e de fácil implementação.

## Configurações

Defina acima da instancia a seguinte constante com as configurações da base de dados que você quer conectar. 

```php

define('DATA_BASE', [
    'host' => 'localhost',
    'db' => 'tutoriais',
    'user' => 'root',
    'psw' => '',
]);

```

Seguindo uma boa pratica, você pode criar estas informações em arquivo de configuração do seu projeto.

### Lembre-se de baixar e incluir o arquivo 'PDOEasy.class.php' em seu projeto


## Como usar a PDOEasy

Você pode instanciar a PDOEasy apenas uma vez a cada arquivo para fazer um bom uso da memória.

```php

use Models\Database\PDOEasy;
$conn = new PDOEasy();

```
Caso precise se conectar a um bando de dados diferente basta passar o nome na variável __$conn->db_name = "outro_banco"__ logo apos instanciar o Objeto da classe.


Um select simples para obter todos os dados da tabela "users"

```php

$conn->select('users');
$conn->exec();
$result = $conn->fetchAll();

```

#### CRUD
Os principais métodos da __PDOEasy__ são (__select__, __insert__, __update__ e __delete__). Cada vez que um destes métodos é chamado inicia-se um novo comando __SQL__.

### Comando SQL.
O que a __PDOEasy__ faz, é facilitar a escrita do comando __SQL__. Você pode consultar a variável pública __$query__ para verificar como o comando __SQL__ está sendo escrito. Você também pode passar comandos direto na variável __$query__ caso precisa fazer algum comando mirabolante.

O método __exec()__ Executa o comando criando na variável __$query__ e retorna verdadeiro ou falso para a ação.

O método __fetchAll()__ retorna os dados de um __select__

O método __rowCount()__ retorna a quantidade de linhas afetadas pelo comando __SQL__


## Importante
Os métodos da classe devem ser passados na mesma ordem em que você escreveria um comando __SQL__. Exemplo:

##### Imagine o comando SQL
```sql

SELECT u.name nome, w.name profissao FROM users u
INNER JOIN works w on w.id = u.word_id
WHERE word_id = 1 ORDER BY u.name ASC LIMIT 3;

```

##### Com a PDOEasy você faz assim
```php

$conn->params = ['work_id' => 1]
$conn->select('users u', 'u.name nome, w.name profissao');
$conn->join('works w', 'w.id', 'u.work_id');
$conn->where('work_id = :work_id');
$conn->order('u.name ASC');
$comm->limit(3)
$conn->exec();

$result = $conn->fetchAll();

```


## Parametros seguros
Como a __PDOEasy__ é uma abstração da extensão __PDO__, Os parametros passados na query string devem ser seguros com palavras chaves utilizando dois pontos __:param__. Outro requisito da classe é que você deve passar os valores dos paramentros no formato de array e acima de todos os outro métodos, como no exemplo anterior.

## Exemplos de SELECT
Obter o nome e o email dos usuário

```php

$conn->select('users', 'name, email');
$conn->exec();
$result = $conn->fetchAll();

```

Obter o nome do usuário onde o id = 1
```php

$conn->select('users', 'name');
$conn->where('id = :id');
$conn->exec();
$user_name = $conn->fetchAll()[0]['name'] ?? null;

```

Adicionar um limite o ordernar os dados
```php

$conn->select('users');
$conn->order('name ASC');
$conn->limit(2);
$result = $conn->fetchAll();

```

Select com INNER JOIN
```php

$conn->select('users u', 'u.name name, w.name profissao');
$conn->join('works w', 'w.id', 'u.work_id', 'INNER JOIN');
$conn->exec();
$resutl = $conn->fetchAll();

```

Select com Limit e Offeset utilizando _SQL_CALC_FOUND_ROWS_ para fazer paginação
```php

$conn->select('users', '*', true);
$conn->limit(10, 0);
$conn->exec();
$result = $conn->fetchAll();

```

Repete a query anterior sem o paramentro LIMIT
```php

$total_users = $conn->foundRows();

```


## Exemplo de INSERT

Inseri dados na tabela users
```php

$conn->params = [
    'name' => 'Jose',
    'email' => 'jose@email.com',
    'work_id' => 1
];
$conn->insert('users');
$conn->exec();

```


## Exemplo de UPDATE

Atualiza o nome e o email do usuário onde id = 1
```php

$conn->params = [
    'name' => 'Maria da Silva',
    'email' => 'mariadasilva@email.com',
    'id' => 1,
];
$conn->update('users', 'name = :name, email = :email');
$conn->where('id = :id');
$conn->limit(1);
$conn->exec(); // Retorna true ou false

```


## Exemplo de DELETE

Delete simples na tabela users onde o usuário tem id = 8
```php

$conn->params = ['id' => 8];
$conn->delete('users');
$conn->where('id = :id');
$conn->limit(1);
$conn->exec();

```

### Nos comandos (update e delete) os métodos (where() e limit()) são obrigatórios.

## Exception

Use o metodo __error()__ para debugar a classe


## Author

- [Jeterson Lordano](https://github.com/jetersonlordano)
- [Website](https://www.jetersonlordano.com.br)
