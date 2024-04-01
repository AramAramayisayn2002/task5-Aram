<?php

class Database
{
    protected $pdo;
    protected $tableName;
    protected $query;
    protected $queryResult;

    public function __construct($server_host, $db_name, $username, $password)
    {
        try {
            $dsn = "mysql:host=$server_host;dbname=$db_name";
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit();
        }
    }

    public function insert($post)
    {
        $keys = implode(", ", array_keys($post));
        $values = implode(", ", array_fill(0, count($post), "?"));
        $this->query = "INSERT INTO " . $this->tableName . " ($keys) VALUES ($values)";
        $statement = $this->pdo->prepare($this->query);
        $statement->execute(array_values($post));
        return $this;
    }

    public function select()
    {
        $this->query = "SELECT * FROM " . $this->tableName;
        return $this;
    }

    public function delete()
    {
        $this->query = "DELETE FROM " . $this->tableName;
        return $this;
    }

    public function update($post)
    {
        $setClause = implode(", ", array_map(function ($key) {
            return "$key = ?";
        }, array_keys($post)));

        $this->query = "UPDATE " . $this->tableName . " SET $setClause";
        $statement = $this->pdo->prepare($this->query);
        $statement->execute(array_values($post));
        return $this;
    }

    public function where($fieldName, $operator, $value)
    {
        if (strpos($this->query, "WHERE")) {
            $this->query .= " AND $fieldName $operator $value";
        } else {
            $this->query .= " WHERE $fieldName $operator $value";
        }
        return $this;
    }

    public function limit($count)
    {
        $this->query .= " LIMIT $count";
        return $this;
    }

    public function offset($count)
    {
        $this->query .= " OFFSET $count";
        return $this;
    }

    public function execute()
    {
        $statement = $this->pdo->prepare($this->query);
        $statement->execute();
        $this->queryResult = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this;
    }

    public function numRows()
    {
        return $this->queryResult ? count($this->queryResult) : false;
    }

    public function fetchAssoc()
    {
        return $this->queryResult ? current($this->queryResult) : false;
    }

    public function fetchAssocs()
    {
        return $this->queryResult;
    }
}
