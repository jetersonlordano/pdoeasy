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

/**
 * Delete simples na tabela users
 */
$conn = new PDOEasy();
$conn->params = ['id' => 8];

$conn->delete('users');
$conn->where('id = :id');
$conn->limit(1);
$conn->exec();