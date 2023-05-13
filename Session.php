<?php

require_once 'DbHandler.php';

class Session {
    private $db;

    function  __construct() {
        $this->db = new DbHandler();

        session_set_save_handler(
            array($this, "_open"),
            array($this, "_close"),
            array($this, "_read"),
            array($this, "_write"),
            array($this, "_destroy"),
            array($this, "_gc")
        );

        session_start();
    }

    public function _open() {
        if ($this->db->getConn()) {
            return true;
        }
        return false;
    }

    public function _close() {
        if ($this->db->closeConn()) {
            return true;
        }
        return false;
    }

    public function _read($id) {
        $sql = "SELECT Session_Data FROM Session WHERE Session_Id = ?";
        $params = array($id);
        $stmt = $this->db->query($sql, $params);
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if ($row) {
            return $row['Session_Data'];
        } else {
            return '';
        }
    }

    public function _write($id, $data) {

        $sql = "SELECT COUNT(*) AS count FROM Session WHERE Session_Id = ?";
        $params = array($id);
        $stmt = $this->db->query($sql, $params);
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if ($row['count'] == 1) {
            $sql = "UPDATE Session SET Session_Data = ?, Session_Expires = GETDATE() WHERE Session_Id = ?";
            $params = array($data, $id);
            $stmt = $this->db->query($sql, $params);
            if ($stmt) {
                return true;
            }
        } else {
            $sql = "INSERT INTO Session (Session_Id, Session_Data, Session_Expires) VALUES (?, ?, GETDATE())";
            $params = array($id, $data);
            $stmt = $this->db->query($sql, $params);
            if ($stmt) {
                return true;
            }
        }
    }

    public function _destroy($id) {
        $sql = "DELETE FROM Session WHERE Session_Id = ?";
        $params = array($id);
        $stmt = $this->db->query($sql, $params);
        if ($stmt) {
            return true;
        }
        return false;
    }

    public function _gc($max) {
        $expirationDate = date('Y-m-d H:i:s', strtotime('-' . $max . ' seconds'));
        $sql = "DELETE FROM Session WHERE Session_Expires < ?";
        $params = array($expirationDate);
        $stmt = $this->db->query($sql, $params);
        if ($stmt) {
            return true;
        } else {
            return false;
        }

    }




}