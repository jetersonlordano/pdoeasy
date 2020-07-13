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
 * Inseri dados na tabela users
 */
$conn->params = [
    'name' => 'Jose',
    'email' => 'jose@email.com',
    'work_id' => 1
];
$conn->insert('users');
$conn->exec();