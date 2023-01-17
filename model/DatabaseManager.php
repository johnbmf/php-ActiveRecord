<?php

namespace Jonathan\PhpActiveRecord;

use PDO;
use PDOException;

//Clase que maneja la conexion y operaciones en la BD utilizando PDO Mysql.
class DatabaseManager extends Singleton{

    //Variable que mantendra la conexion.
    private static $conn;

    //Variable que contiene la whitelist de nombres de tablas para poder consultar.
    private static $whiteListTables = [];

    //Variable que contiene configuraciones de la conexion con PDO.
    private static $PDO_OPTIONS = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    //Funcion para setear la conexion a la BD.
    //Crea una nueva conexion si es que no se ha creado una instancia previamente.
    //Retorna true si existe o se creo una conexion exitosa. Retorna false si no se pudo realizar la conexion.
    //Se puede cambiar posteriormente para leer parametros con ENV.
    public static function setConn($hostname = 'localhost', $dbname = '', $user = 'root', $pass = '', $charset = 'utf8mb4') : bool{
        if (!isset(self::$conn)) {
            try {
                $ConnStringPDO = 'mysql:host=' . $hostname . '; dbname=' . $dbname . '; charset=' . $charset;
                self::$conn = new PDO($ConnStringPDO, $user, $pass);

                foreach (self::$PDO_OPTIONS as $key => $value){
                    self::$conn->setAttribute($key, $value);
                }

                try {
                    $result = self::$conn->query('SHOW TABLES');
                    self::$whiteListTables = $result->fetchAll(PDO::FETCH_COLUMN);
                } catch (\Throwable $e) {
                    echo 'Error recuperando los nombres de las tablas de la base de datos: ' . $e->getMessage();
                }

            } catch (PDOException $e) {
                echo 'Error en la conexion: ' . $e->getMessage();
                return false;
            }
        }
        return true;
    }

    //Funcion para obtener la conexion a la BD.
    public static function getConn() : PDO{
        if (!isset(self::$conn)) {
            echo 'No existe una conexion seteada.';
        }

        return self::$conn;
    }

    //Funcion para buscar todos los registros de una tabla especifica de la bd.
    //Retorna un array asociativo con todos los registros.
    //Los cuales a su vez son un array asociativo con cada registro de la tabla.
    public static function all($tableName) : array{
        $res = [];

        if (in_array($tableName, self::$whiteListTables)){
            $query = "SELECT * FROM {$tableName}";
            $stmt = self::$conn->prepare($query);
            $stmt->execute();

            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;
        }

        return $res;
    }

}