<?php

namespace Model;

class Usuario extends ActiveRecord
{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $password2;
    public $password_actual;
    public $password_nuevo;
    public $token;
    public $confirmado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    // Validar el login de usuarios
    public function validarLogin()
    {
        switch (true) {
            case $this->validarEmail():
                break;
            case empty($this->password):
                self::$alertas['error'][] = 'El Password es Obligatorio.';
                break;
        }
        return self::$alertas;
    }

    // Validacion para cuentas nuevas
    public function validarNuevaCuenta()
    {
        switch (true) {
            case $this->validarNombres():
                break;
            case $this->validarEmail():
                break;
            case $this->validarPassword($this->password):
                break;
            case $this->password !== $this->password2:
                self::$alertas['error'][] = 'Los password no coinciden';
                break;
        }
        return self::$alertas;
    }

    public function validarNombres()
    {
        switch (true) {
            case empty($this->nombre):
                self::$alertas['error'][] = 'El Nombre es Obligatorio.';
                break;
            case !preg_match('/^[a-zA-Z\s]+$/', $this->nombre):
                self::$alertas['error'][] = 'El Nombre solo debe contener letras y espacios.';
                break;
            case strlen($this->nombre) > 100:
                self::$alertas['error'][] = 'El nombre no puede tener mas de 100 caracteres';
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
            case strlen($this->email) > 255:
                self::$alertas['error'][] = 'El Email no puede tener más de 255 caracteres.';
                break;
            case !filter_var($this->email, FILTER_VALIDATE_EMAIL):
                self::$alertas['error'][] = 'El Email no es Valido.';
                break;
        }
        return self::$alertas;
    }

    public function validarPassword($password)
    {
        switch (true) {
            case empty($password):
                self::$alertas['error'][] = 'El Password es Obligatorio.';
                break;
            case strlen($password) < 8:
                self::$alertas['error'][] = 'El Password debe tener al menos 8 caracteres.';
                break;
            case !preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password):
                self::$alertas['error'][] = 'La Contraseña debe contener al menos una letra mayúscula y una letra minúscula.';
                break;
            case !preg_match('/\d/', $password):
                self::$alertas['error'][] = 'La Contraseña debe contener al menos un número.';
                break;
            case !preg_match('/[^a-zA-Z\d\s]/', $password):
                self::$alertas['error'][] = 'La Contraseña debe contener al menos un carácter especial.';
                break;
        }
        return self::$alertas;
    }

    public function validarPerfil(): array
    {
        switch (true) {
            case $this->validarNombres():
                break;
            case $this->validarEmail():
                break;
        }
        return self::$alertas;
    }

    public function nuevoPassword(): array
    {
        switch (true) {
            case empty($this->password_actual):
                self::$alertas['error'][] = 'El Password Actual es Obligatorio';
                break;
            case $this->validarPassword($this->password_nuevo):
                break;
            case $this->password_nuevo !== $this->password2:
                self::$alertas['error'][] = 'Los password no coinciden';
                break;
            case $this->password_actual === $this->password_nuevo:
                self::$alertas['error'][] = 'La nueva contraseña debe ser diferente a la actual';
                break;
        }
        return self::$alertas;
    }

    // comprobar password
    public function comprobarPassword(): bool
    {
        return password_verify($this->password_actual, $this->password);
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
