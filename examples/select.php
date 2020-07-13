<?php

define('DS', DIRECTORY_SEPARATOR);

define('DATA_BASE', [
    'host' => 'localhost',
    'db' => 'tutoriais',
    'user' => 'root',
    'psw' => '',
]);

require_once dirname(__DIR__) . DS . 'source' . DS . 'Models' . DS . 'Database' . DS . 'PDOEasy.class.php';

use Models\Database\PDOEasy;

$conn = new PDOEasy();

/**
 * Obter todos os dados da tabela users
 */

$conn->select('users');
$conn->exec();
$result = $conn->fetchAll();
var_dump($result);

/**
 * Obter o nome e o email dos usuário
 */
$conn->select('users', 'name, email');
$conn->exec();
$result = $conn->fetchAll();

/**
 * Obter o nome do usuário onde o id = 1
 */
$conn->select('users', 'name');
$conn->where('id = :id');
$conn->exec();
$user_name = $conn->fetchAll()[0]['name'] ?? null;

/**
 * Adicionar um limite o ordernar os dados
 */
$conn->select('users');
$conn->order('name ASC');
$conn->limit(2);
$result = $conn->fetchAll();

/**
 * Select com Join
 */
$conn->select('users u', 'u.name name, w.name profissao');
$conn->join('works w', 'w.id', 'u.work_id', 'INNER JOIN');
$conn->exec();
$resutl = $conn->fetchAll();

/**
 * Select com Limit e Offeset
 * SQL_CALC_FOUND_ROWS para fazer paginação
 */
$conn->select('users', '*', true);
$conn->limit(10, 0);
$conn->exec();
$result = $conn->fetchAll();

/**
 * Repete a query anterior sem o paramentro LIMIT
 */
$total_users = $conn->foundRows();