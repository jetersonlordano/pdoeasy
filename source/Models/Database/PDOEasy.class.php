<?php

/**
 * Class PHPEasy
 * @author Jeterson Lordano <https://github.com/jetersonlordano>
 */

namespace Models\Database;

use PDO;
use PDOException;

class PDOEasy
{

    /** @var string */
    public $query;

    /**  @var array */
    public $params = [];

    /** @var string */
    public $db_name = DATA_BASE['db'];

    /** @var string */
    public $error;

    /** @var object */
    private $statement;

    /** @var object */
    private $connection;

    /**
     * SQL Select
     * @param string $table
     * @param string $columns
     * @param boolean $found_rows
     * @return void
     */
    public function select(string $table, string $columns = '*', bool $found_rows = false)
    {
        $this->query = "SELECT " . ($found_rows ? "SQL_CALC_FOUND_ROWS " : null) . "{$columns} FROM {$table}";
    }

    /**
     * SQL Insert
     * @param string $table
     * @return void
     */
    public function insert(string $table)
    {
        $columns = implode(", ", array_keys($this->params));
        $params = str_replace(', ', ', :', $columns);
        $this->query = "INSERT INTO {$table} ({$columns}) values (:{$params})";
    }

    /**
     * SQL Update
     * @param string $table
     * @param string $columns
     * @return void
     */
    public function update(string $table, string $columns)
    {
        $this->query = "UPDATE {$table} SET {$columns}";
    }

    /**
     * SQL Delete
     * @param string $table
     * @return void
     */
    public function delete(string $table)
    {
        $this->query = "DELETE FROM {$table}";
    }

    /**
     * SQL Join
     * @param string $table
     * @param string $primary_key
     * @param string $foreign_key
     * @param string $type
     * @return void
     */
    public function join(string $table, string $primary_key, string $foreign_key, string $type = 'INNER JOIN')
    {
        $this->query .= " {$type} {$table} ON {$primary_key} = {$foreign_key}";
    }

    /**
     * SQL Where
     * @param string $terms
     * @return void
     */
    public function where(string $terms)
    {
        $this->query .= (strpos($this->query, 'WHERE') === false ? " WHERE" : null) . " {$terms}";
    }

    /**
     * SQL Group
     * @param string $columns
     * @return void
     */
    public function group(string $group_by)
    {
        $this->query .= " GROUP BY {$group_by}";
    }

    /**
     * SQL ORDER
     * @param string $columns
     * @return void
     */
    public function order(string $order_by)
    {
        $this->query .= " ORDER BY {$order_by}";
    }

    /**
     * SQL Limit
     * @param integer $limit
     * @param integer $offset
     * @return void
     */
    public function limit(int $limit, int $offset = null)
    {
        $this->query .= " LIMIT {$offset}" . ($offset ? ', ' : null) . "{$limit}";
    }

    /**
     * @return array|null
     */
    public function fetchAll(): ?array
    {
        return $this->statement->fetchAll();
    }

    /**
     * @return int
     */
    public function rowCount(): int
    {
        return $this->statement->rowCount();
    }

    /**
     * Count Rows pagination
     * Use SQL_CALC_FOUND_ROWS in Select
     * @return integer
     */
    public function foundRows(): int
    {
        $this->query = "SELECT FOUND_ROWS()";
        $this->exec();
        return $this->fetchAll()[0]['FOUND_ROWS()'];
    }

    /**
     * SQL Execute
     * @return boolean
     */
    public function exec(): bool
    {

        $this->connection = $this->connection ?? $this->connect();

        if (!$this->query) {
            return $this->connection;
        }

        $this->statement = $this->connection->prepare($this->query);

        foreach ($this->params as $key => $value) {
            $this->statement->bindParam(":" . $key, $this->params[$key], PDO::PARAM_STR);
        }

        return $this->safe() ? $this->statement->execute() : false;
    }

    /**
     * @return boolean
     */
    private function safe(): bool
    {

        if (strpos($this->query, 'DELETE') === false && strpos($this->query, 'UPDATE') === false) {
            return true;
        }

        if (strpos($this->query, 'WHERE') === false) {
            $this->error = "Defina uma condição [WHERE] para está ação";
            return false;
        }

        if (strpos($this->query, 'LIMIT') === false) {
            $this->error = "Defina um limite [LIMIT] para está ação";
            return false;
        }

        return true;
    }

    /**
     * @return PDO||null
     */
    private function connect()
    {
        try {

            $PDO = new PDO('mysql:host=' . DATA_BASE['host'] . ";dbname={$this->db_name};",
                DATA_BASE['user'],
                DATA_BASE['psw'],
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_CASE => PDO::CASE_NATURAL,
                ]
            );

        } catch (PDOException $exception) {
            $this->error = $exception;
            return;
        }

        return $PDO;
    }
}
