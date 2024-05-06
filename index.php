<?php
session_start();

# Cargamos las variables de entorno para que puedan ser utilizadas en el sistema
# Requerimos los archivos de composer para la carga automática de las clases
require("vendor/autoload.php");

try {
    $env = \Dotenv\Dotenv::createImmutable(__DIR__);
    $env->safeLoad();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    die("Error: No se pudo cargar el archivo .env");
}

# Archivo de funciones auxiliares
require("app/auxiliares.php");

# Registrar los modelos de la base de datos para que puedan ser usados en el sistema
registrarModelos();

# Quitar la última barra inclinada de la URL si la tuviera
$_SERVER['REQUEST_URI'] = rtrim($_SERVER['REQUEST_URI'], "/");

# Obtener el prefijo de la URL para el proyecto
$urlProyecto = $_ENV["URL_PROYECTO"];
$urlProyecto = rtrim($urlProyecto, "/");

# Quitar el prefijo de la URL de la solicitud actual
$_SERVER['REQUEST_URI'] = str_replace($urlProyecto, '', $_SERVER['REQUEST_URI']);

# Analizar la URL para determinar qué controlador y qué método se debe ejecutar
if ($_SERVER['REQUEST_URI'] == "/" || $_SERVER['REQUEST_URI'] == "") {
    $nombreControlador = "LoginControlador";
    $archivoControlador = __DIR__ . "/app/controladores/" . $nombreControlador . ".php";
} else {
    # Verificar si la URL tiene parámetros (variables GET) y separarlos para
    # obtener la ruta del controlador
    $parametrosRequest = explode("?", $_SERVER['REQUEST_URI']);
    if (count($parametrosRequest) > 1) {
        $uriRequest = explode("/", $parametrosRequest[0]);
    } else {
        $uriRequest = explode("/", $_SERVER['REQUEST_URI']);
    }

    # Obtener el nombre del controlador y el archivo del controlador
    $nombreControlador = ucfirst($uriRequest[1] ?? "Login") . "Controlador";
    $archivoControlador = __DIR__ . "/app/controladores/" . $nombreControlador . ".php";
}

# Verificar si el archivo del controlador existe, si no, mostrar un error 404
if (!file_exists($archivoControlador)) {
    $nombreControlador = "ErrorControlador";
    $archivoControlador = __DIR__ . "/app/controladores/" . $nombreControlador . ".php";
}

# Incluir el archivo del controlador e instanciar el objeto
require_once($archivoControlador);
$controlador = new $nombreControlador();

# Verificar si un ID está presente en la URL
if (isset($uriRequest[3])) {
    $id = $uriRequest[3];
    $controlador->set_id($id);
}

# Verificar si hay alguna acción presente en la URL y llamar al método correspondiente
# del controlador mediante la función call_user_func_array que permite pasar un array
# de parámetros a la función, en lugar de pasarlos uno por uno.
if (isset($uriRequest[2])) {
    $accion = $uriRequest[2];
    $parametros = array_slice($uriRequest, 4);
    if (method_exists($controlador, $accion)) {
        call_user_func_array([$controlador, $accion], $parametros);
    } else {
        header("Location: " . url("error"));
    }
} else {
    # Si no hay acción presente en la URL, llamar al método index
    $controlador->index();
}
