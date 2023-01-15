<?php

namespace Jonathan\PhpActiveRecord;

//La conexion estara gestionada por esta clase Connection para abstraerla del ActiveRecord.
use Jonathan\PhpActiveRecord\Connection;

class ActiveRecord{

    protected static $conn;

    public function __construct()
    {
        
    }


}