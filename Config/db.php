<?php

class Database
{
    private static $bdd = null;

    private function __construct() {
    }
    private static $server = "localhost";
    private static $user = "root";
    private static $pass = "";
    private static $db = "idea";

    private static function conn(){
        $conn = new mysqli(self::$server, self::$user, self::$pass, self::$db);
        if ($conn){
            mysqli_set_charset($conn,"utf8");
            return $conn;
        }else{
            return false;
        }
    }

    private static function close_conn($conn){
        if ($conn){
            $conn->close();
        }
    }

    private static function scape($details, $conn){
        foreach ($details as $key => $value){
            $details[$key] = mysqli_real_escape_string($conn,$value);
        }
        return $details;
    }

    /*public static function getBdd() {
        if(is_null(self::$bdd)) {
        	$db = $this->db;
        	$user = $this->user;
        	$pass = $this->pass;
        	$server = $this->server;
            self::$bdd = new PDO("mysql:host=$server;dbname=$db", $user, $pass);
        }
        return self::$bdd;
    }*/

    public static function insert($table = "", $details = array()){
        $conn = self::conn();
        if ($conn){
            $details = self::scape($details, $conn);
            $cols = implode(",", array_keys($details));
            $vars = implode("','", $details);
            $sql = "INSERT INTO {$table} ($cols) VALUES ('{$vars}')";
            if ($conn->query($sql)){
                self::close_conn($conn);
                return true;
            }else{
                self::close_conn($conn);
                return false;
            }
        }
        return false;
    }

    public static function select($table = "", $condi = ""){
        $conn = self::conn();
        if ($conn){
            $sql = "SELECT * FROM $table";
            if (!empty($condi)){
                $sql .= " $condi";
            }
            if ($result = $conn->query($sql)){
                self::close_conn($conn);
                return $result;
            }
            self::close_conn($conn);
            return false;
        }
    }

    public static function update($table, $dets, $condi = ""){
        $conn = self::conn();
        $dets = self::scape($dets, $conn);
        $sql = "UPDATE $table SET ";
        $i = 0;
        foreach ($dets as $name => $value){
            $sql .= $name . " = '$value' ";
            $i++;
            if ($i !== count($dets)){
                $sql .= ",";
            }
        }
        $sql .= $condi;
        if ($conn->query($sql)){
            self::close_conn($conn);
            return true;
        }
        self::close_conn($conn);
        return false;
    }

    public static function delete($table, $condi)
    {
        $conn = self::conn();
        $sql = "DELETE FROM $table $condi";
        $conn->query($sql);
        self::close_conn($conn);
    }
}
?>