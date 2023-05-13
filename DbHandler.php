<?php

class DbHandler {
    private $conn;

    function __construct() {

        $host = "DESKTOP-5NU09AJ\SQLEXPRESS";
        $db = "PHP_Sessions_Test";

        $connOptions = array("Database" => $db, "CharacterSet" => "UTF-8");
        $this->conn = sqlsrv_connect($host, $connOptions);
        if (!$this->conn) {
            throw new Exception("Error connecting to the database");
        }
    }

    public function getConn() {
        return $this->conn;
    }
    public function closeConn() {
        sqlsrv_close($this->conn);
    }
    public function query($sql, $params=[]){
        $stmt = sqlsrv_prepare($this->conn, $sql, $params);
        if(!$stmt){
            throw new Exception("Error executing query");
        }
        if (!sqlsrv_execute($stmt)) {
            throw new Exception("Error executing query");
        }
        return $stmt;
    }

}