<?php
namespace Areuka\Engine;

class DB {
    static $con = null;
    public static function getConnect(){
        $option = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];
        if(self::$con === null){
            self::$con = new \PDO("mysql:host=localhost;dbname=bimos2;charset=utf8mb4", "root", "", $option);
        }

        return self::$con;
    }

    public static function query($sql, $data = []){
        $q = self::getConnect()->prepare($sql);
        $q->execute($data);
        return $q;
    }

    public static function fetch($sql, $data = []){
        return self::query($sql, $data)->fetch();
    }

    public static function fetchAll($sql, $data = []){
        return self::query($sql, $data)->fetchAll();
    }

    public static function lastInsertId(){
        return self::getConnect()->lastInsertId();
    }
}