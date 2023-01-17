<?php

namespace Jonathan\PhpActiveRecord;

//La conexion estara gestionada por esta clase Connection para abstraerla del ActiveRecord.

class ActiveRecord{

    //Cada clase que extienda ActiveRecord debe definir el nombre de su tabla.
    protected static $tableName = '';

    //Cada clase que extienda ActiveRecord debe definir el nombre de sus columnas.
    protected static $dbCols = [];

    //Array para almacenar errores que se puedan producir en la ejecucion de CRUD.
    protected static $errors = [];

    public function __construct(){}

    //Busca todos los registros pertenecientes a una tabla.
    //Retorna un array con instancias de la clase que implementa ActiveRecord que representan los registros.
    public static function all(){
        $res = DatabaseManager::all(static::$tableName);
        $registers = [];
        foreach ($res as $value){
            $registers[] = static::toObject($value);
        }

        return $registers;
    }

    //Busca algun(os) registro(s) en particular.
    //Retorna un array con instancias de la clase que implementa ActiveRecord que representan los registros.
    public static function find(){}

    //Crea o actualiza un registro en la BD.
    //Retorna true o false dependiendo si se pudo crear o actualizar el registro correctamente.
    public function save(){}

    //Elimina algun(os) registro(s) en particular.
    //Retorna true o false dependiendo si se pudo eliminar el registro correctamente.
    public static function delete(){}

    //Elimina todos los registros.
    //Retorna true o false dependiendo si se pudo eliminar el registro correctamente.
    public static function deleteAll(){}

    //Convierte un array asociativo obtenido como resultado de una consulta a la BD a un objeto de la clase que extiende ActiveRecord
    //El array asociativo representa solo un registro de la BD.
    //Se debe iterar sobre con esta funcion en caso de tener mas registros como resultado de una consulta a la BD.
    //La clase que extiende ActiveRecord debe contar con propiedades que representen cada columna de su tabla en la BD.
    protected static function toObject($resArrayAssoc){
        $object = new static;

        foreach ($resArrayAssoc as $key => $value){
            if (property_exists($object, $key)){
                $object->$key = $value;
            }
        }

        return $object;
    }
}