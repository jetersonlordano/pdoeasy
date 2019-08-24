<?php

/**
 * Config connection
 */
define('DBCONFIG', [
    'host' => 'localhost',
    'db' => 'mydb',
    'user' => 'root',
    'psw' => '',
]);

define('DS', DIRECTORY_SEPARATOR);

// Autoloader de classes
spl_autoload_register(
    function ($class) {
        $file = __DIR__  . DS . $class . '.class.php';
        $file = str_replace("\\", DS, $file);
        file_exists($file) ? include_once $file : die("Erro ao incluir: {$class}.class.php");
    }
);

use Database\PDOEasy;

/**
 * SELECT * FROM students
 */
$conn = new PDOEasy();
//$conn->select('students');
//$conn->exec();
//$students = $conn->fetchAll();

/**
 * SELECT std_id, std_name FROM students WHERE std_email = 'jetersonlordano@gmail.com' AND std_name = 'Jeterson' LIMIT 1
 */

/*
$terms = "WHERE std_email = :email AND std_name = :name LIMIT 1";
$values = ['email' => 'jetersonlordano@gmail.com', 'name' => 'Jeterson Lordano'];
$conn->select('students', 'std_id, std_name', $terms, $values);
$conn->exec();
$students = $conn->fetchAll();
 */

/**
 * SELECT std_name, crs_name FROM students INNER JOIN courses on courses.crs_id = students.std_course
 */

/*
$terms = "INNER JOIN courses on courses.crs_id = students.std_course";
$conn->select('students', 'std_name, crs_name', $terms);
$conn->exec();
$students = $conn->fetchAll();
 */
/**
 * Replace prefixes
 */
/*
$terms = "WHERE pfx_email = :email AND pfx_name = :name LIMIT 1";
$values = ['email' => 'jetersonlordano@gmail.com', 'name' => 'Jeterson Lordano'];
$conn->select('students', 'pfx_id, pfx_name', $terms, $values);
$conn->prefixes(['pfx_' => 'std_']);
$conn->exec();
$students = $conn->fetchAll();
 */

/**
 * Insert
 */

//$conn->insert('students', ['std_name' => 'José Carlos', 'std_email' => 'josecarlos@email.com']);
//$conn->exec();

/**
 * Update
 */
$terms = "std_name = :name, std_email = :email WHERE std_id = :id LIMIT 1";
$values = [
    'name' => 'Jeterson de Souza',
    'email' => 'novo@email.com',
    'id' => 1,
];
$conn->update('students', $terms, $values);
//$conn->exec();

/**
 * Delete
 */

$conn->delete('students', "WHERE std_id = :id LIMIT 1", [ 'id' => 1]);
//$conn->exec();