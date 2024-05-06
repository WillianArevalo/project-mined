<?php

require_once "app/basedatos/conexion.php";

class LoginControlador
{

    private $conn;
    private $id;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function index()
    {
        generarToken();
        cargarVista("login", "index", [], false, true);
    }

    public function validar()
    {
        if (isset($_POST["email"])  && isset($_POST["password"]) && isset($_POST["_token"])) {
            $token = $_POST["_token"];
            if (validarToken($token) == false) {
                echo json_encode(["status" => 404, "title" => "Error", "message" => "Token no válido"]);
                return;
            }
            $usuarioModelo = new Usuario($this->conn);
            $email = $_POST["email"];
            $password = $_POST["password"];
            $usuario = $usuarioModelo->search_by_email($email);
            if ($usuario) {
                if (password_verify($password, $usuario->pass)) {
                    $_SESSION["usuario"] = $usuario;
                    echo json_encode(["status" => 200, "title" => "¡Exito!", "message" => "Usuario autenticado", "url" => url("/dashboard")]);
                } else {
                    echo json_encode(["status" => 404, "title" => "Error", "message" => "Contraseña incorrecta"]);
                }
            } else {
                echo json_encode(["status" => 404, "title" => "Error", "message" => "Usuario no encontrado"]);
            }
        } else {
            echo json_encode(["status" => 404, "title" => "Error", "message" => "Datos incompletos"]);
        }
    }
}
