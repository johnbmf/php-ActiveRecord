<?php

namespace Jonathan\PhpActiveRecord;

use PDO;
use PDOException;

//Clase que maneja la conexion de la BD utilizando PDO Mysql.
//Return $conn (instancia de una conexion).
class Connection extends Singleton{

    //Variable que mantendra la conexion.
    private static $conn;

    //Variable que contiene configuraciones de la conexion con PDO.
    private static $PDO_OPTIONS = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    //Funcion para obtener la conexion a la BD.
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

            } catch (PDOException $e) {
                echo 'Error en la conexion: ' . $e->getMessage();
                return false;
            }
        }

        return true;
    }

    public static function getConn() : PDO{
        if (!isset(self::$conn)) {
            echo 'No existe una conexion seteada.\n';
        }

        return self::$conn;
    }

}