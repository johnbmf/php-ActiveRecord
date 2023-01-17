<?php

namespace Jonathan\PhpActiveRecord;

//Clase para instanciar clases unicas (como una conexion a BD).
class Singleton{

    private static $instancias = [];

    protected function __construct(){}

    protected function __clone(){}

    public function __wakeup()
    {
        throw new \Exception("No se puede unserializar un singleton");
    }

    //Metodo con el cual se adquiere la instancia de la clase que implementa Singleton.
    //En el array $instancias se guardan todas las instancias unicas de las clases que implementan Singleton.
    //Las clases que extiendan singleton deben instanciarse con este metodo en vez de crear el objeto con new.
    public static function getInstance() : static{
        $child = static::class;

        if (!isset(self::$instancias[$child])){
            self::$instancias[$child] = new static();
        }

        return self::$instancias[$child];
    }

}