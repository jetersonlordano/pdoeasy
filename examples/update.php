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
 * Atualiza o nome e o email do usuário com id = 1
 */
$conn->params = [
    'name' => 'Maria da Silva',
    'email' => 'mariadasilva@email.com',
    'id' => 8,
];
$conn->update('users', 'name = :name, email = :email');
$conn->where('id = :id');
$conn->limit(1);
$conn->exec(); // Retorna true ou false
