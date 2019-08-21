<?php

use Database\PDOEasy;

define('DS', DIRECTORY_SEPARATOR);

define('DBCONFIG', [
    'host' => 'localhost',
    'db' => 'mydb',
    'user' => 'root',
    'psw' => '',
]);

// Autoloader de classes
spl_autoload_register(
    function ($class) {
        $file = __DIR__ . DS . 'Core' . DS . $class . '.class.php';
        $file = str_replace("\\", DS, $file);
        file_exists($file) ? include_once $file : die("Erro ao incluir: {$class}.class.php");
    }
);

/**
 * SELECT * FROM students
 */
$conn = new PDOEasy();
$conn->select('students');
$conn->exec();
$students = $conn->fetchAll();

/**
 * SELECT std_id, std_name FROM students WHERE std_email = 'jetersonlordano@gmail.com' AND std_name = 'Jeterson' LIMIT 1
 */
$terms = "WHERE std_email = :email AND std_name = :name LIMIT 1";
$values = ['email' => 'jetersonlordano@gmail.com', 'name' => 'Jeterson Lordano'];
$conn->select('students', 'std_id, std_name', $terms, $values);
$conn->exec();
$students = $conn->fetchAll();

/**
 * SELECT std_name, crs_name FROM students INNER JOIN courses on courses.crs_id = students.std_course
 */

$terms = "INNER JOIN courses on courses.crs_id = students.std_course";
$conn->select('students', 'std_name, crs_name', $terms);
$conn->exec();
$students = $conn->fetchAll();