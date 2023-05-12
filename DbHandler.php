<?php

class DbHandler
{

    private $conn;

    function __construct()
    {

        try {
            $host = "DESKTOP-5NU09AJ\SQLEXPRESS";
            $db = "PHP_Sessions_Test";

            $connOptions = array("Database" => $db, "CharacterSet" => "UTF-8");

            $this->conn = sqlsrv_connect($host, $connOptions);
            if (!$this->conn) {
                throw new Exception("Failed to connect to database");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function getConn()
    {
        return $this->conn;
    }

    function closeConn() {
        sqlsrv_close($this->conn);
    }
    function query($sql, $params=[]) {
        $stmt = sqlsrv_prepare ($this->conn, $sql, $params);
        if (!$stmt) {
            throw new Exception("Query error");
        }
        if (!sqlsrv_execute($stmt)) {
            throw new Exception("Query error");
        }
        return $stmt;
    } 

}




