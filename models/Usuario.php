<?php

namespace Model;

use Classes\Email;

class Usuario extends ActiveRecord
{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $password2;
    public $token;
    public $confirmado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    // Validar el login de usuarios
    public function validarLogin(){
        switch (true) {
            case empty($this->email):
                self::$alertas['error'][] = 'El Email es Obligatorio.';
                break;
            case !filter_var($this->email, FILTER_VALIDATE_EMAIL):
                self::$alertas['error'][] = 'El Email no es Valido.';
                break;
            case empty($this->password):
                self::$alertas['error'][] = 'El Password es Obligatorio.';
                break;
        }
        return self::$alertas;
    }

    // Validacion para cuentas nuevas
    public function validadNuevaCuenta()
    {
        switch (true) {
            case empty($this->nombre):
                self::$alertas['error'][] = 'El Nombre es Obligatorio.';
                break;
            case !preg_match('/^[a-zA-Z\s]+$/', $this->nombre):
                self::$alertas['error'][] = 'El Nombre solo debe contener letras y espacios.';
                break;
            case empty($this->email):
                self::$alertas['error'][] = 'El Email es Obligatorio.';
                break;
            case !filter_var($this->email, FILTER_VALIDATE_EMAIL):
                self::$alertas['error'][] = 'El Email no es Valido.';
                break;
            case empty($this->password):
                self::$alertas['error'][] = 'El Password es Obligatorio.';
                break;
            case strlen($this->password) < 8:
                self::$alertas['error'][] = 'El Password debe tener al menos 8 caracteres.';
                break;
            case !preg_match('/[a-z]/', $this->password) || !preg_match('/[A-Z]/', $this->password):
                self::$alertas['error'][] = 'La Contraseña debe contener al menos una letra mayúscula y una letra minúscula.';
                break;
            case !preg_match('/\d/', $this->password):
                self::$alertas['error'][] = 'La Contraseña debe contener al menos un número.';
                break;
            case !preg_match('/[^a-zA-Z\d\s]/', $this->password):
                self::$alertas['error'][] = 'La Contraseña debe contener al menos un carácter especial.';
                break;
            case $this->password !== $this->password2:
                self::$alertas['error'][] = 'Los password no coinciden';
                break;
        }
        return self::$alertas;
    }

    public function validarEmail()
    {
        switch (true) {
            case empty($this->email):
                self::$alertas['error'][] = 'El Email es Obligatorio.';
                break;
            case !filter_var($this->email, FILTER_VALIDATE_EMAIL):
                self::$alertas['error'][] = 'El Email no es Valido.';
                break;
        }
        return self::$alertas;
    }

    public function validarPassword()
    {
        switch (true) {
            case empty($this->password):
                self::$alertas['error'][] = 'El Password es Obligatorio.';
                break;
            case strlen($this->password) < 8:
                self::$alertas['error'][] = 'El Password debe tener al menos 8 caracteres.';
                break;
            case !preg_match('/[a-z]/', $this->password) || !preg_match('/[A-Z]/', $this->password):
                self::$alertas['error'][] = 'La Contraseña debe contener al menos una letra mayúscula y una letra minúscula.';
                break;
            case !preg_match('/\d/', $this->password):
                self::$alertas['error'][] = 'La Contraseña debe contener al menos un número.';
                break;
            case !preg_match('/[^a-zA-Z\d\s]/', $this->password):
                self::$alertas['error'][] = 'La Contraseña debe contener al menos un carácter especial.';
                break;
        }
        return self::$alertas;
    }
    
    // Hashea el password
    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un token
    public function crearToken()
    {
        $this->token = md5(uniqid());
    }
}
