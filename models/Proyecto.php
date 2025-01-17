<?php

namespace Model;

class Proyecto extends ActiveRecord
{
    protected static $tabla = 'proyectos';
    protected static $columnasDB = ['id', 'proyecto', 'url', 'propietarioId'];
    public $id;
    public $proyecto;
    public $url;
    public $propietarioId;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->proyecto = $args['proyecto'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->propietarioId = $args['propietarioId'] ?? null;
    }

    // public function validarProyecto()
    // {
    //     switch (true) {
    //         case empty($this->proyecto):
    //             self::$alertas['error'][] = 'El nombre del proyecto es Obligatorio';
    //             break;
    //         case !preg_match('/^[a-zA-Z0-9\s\-_]+$/', $this->proyecto):
    //             self::$alertas['error'][] = 'El nombre del proyecto solo puede contener letras, números, espacios, guiones y guiones bajos.';
    //             break;
    //         case strlen($this->proyecto) > 60:
    //             self::$alertas['error'][] = 'El nombre del proyecto no puede tener mas de 60 caracteres';
    //             break;
    //     }
    //     return self::$alertas;
    // }
}
