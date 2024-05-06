<?php

/**
 * Obtiene la url del sitio que esta en las variables de entorno
 * @return string
 */
function url($ruta)
{
    return $_ENV['URL_SITIO']  . $ruta;
}


/**
 * Registra los modelos de la aplicación
 * @return void
 */
function registrarModelos()
{
    foreach (glob("app/modelos/*.php") as $archivoModelo) {
        require_once($archivoModelo);
    }
}

/**
 * Escribe la URL completa de un archivo en el servidor
 * @param string $tipo  Tipo de archivo (css, js, img)
 * @param string $archivo  Nombre del archivo (imagen.png, style.css)
 * @return string
 */
function asset($tipo, $archivo)
{
    echo  $_ENV['URL_SITIO'] . "/app/vistas/assets/" . $tipo . "/" . $archivo;
}

/**
 * Verifica si el usuario tiene el rol indicado
 * @param string $rol  Nombre del rol
 * @return void
 */
function verificarRol($rol)
{
    $usuario = obtenerSession("usuario");
    if (isset($usuario) && $usuario->rol != $rol) {
        header("Location:" . $_ENV['URL_SITIO'] . "/");
    }
}

/**
 * Verifica si el usuario cuenta con una session iniciada
 * @return void
 */
function verificarSesion()
{
    if (!isset($_SESSION["usuario"])) {
        header('Location: ' . $_ENV['URL_SITIO']);
    }
}

/**
 * Carga una vista en el navegador
 * @param string $controlador  Nombre del controlador (Index, Usuario, etc.)
 * @param string $accion  Nombre de la acción (index, crear, editar, etc.) Nota: si la acción es null, se cargará el archivo index.vista.php
 * @param array $parametros  Parámetros que se pasan a la vista
 * @param boolean $cargarNavbar  Indica si se debe cargar el navbar
 * @param boolean $cargarAssets  Indica si se deben cargar los assets
 * @return void
 */
function cargarVista($controlador, $accion = null, $parametros = [], $cargarNavbar = true, $cargarAssets = true)
{
    $nombreControlador = strtolower($controlador);
    $archivoControlador = __DIR__ . "/vistas/" . $nombreControlador . "/" . ($accion ? $accion . ".vista.php" : "index.vista.php");

    if ($cargarAssets) {
        require_once(__DIR__ . "/vistas/layouts/header.php");
    }

    if ($cargarNavbar) {
        require_once(__DIR__  . "/vistas/layouts/navbars.php");
    }

    if (file_exists($archivoControlador)) {
        if ($parametros) {
            extract($parametros);
        }
        require_once($archivoControlador);
    } else {
        require_once(__DIR__ . "/vistas/error/index.vista.php");
    }

    if ($cargarAssets) {
        require_once(__DIR__  . "/vistas/layouts/footer.php");
    }
}

/**
 * Obtiene un valor de la sesión
 * @param string $session  Nombre de la sesión
 * @return mixed
 */
function obtenerSession($session)
{
    return (isset($_SESSION[$session]) ? $_SESSION[$session] : null);
}


/**
 * Sube una imagen al servidor
 * @param string $nombreCampo  Nombre del campo del formulario
 * @param string $directorio  Nombre del directorio donde se guardará la imagen
 * @param string $nombreElemento  Nombre del elemento al que pertenece la imagen (usuario, equipo, etc.)
 * @return array
 */
function subirImagen($nombreCampo, $directorio, $nombreElemento)
{
    $uploadDirectory = __DIR__ . "/assets/images/" . $directorio . "/" . $nombreElemento . "/";

    if (!file_exists($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $nombresArchivos = array();

    foreach ($_FILES[$nombreCampo]['tmp_name'] as $key => $tmp_name) {
        $nombreArchivo = uniqid() . "_" . $_FILES[$nombreCampo]['name'][$key];
        $rutaArchivo = $uploadDirectory . $nombreArchivo;
        move_uploaded_file($tmp_name, $rutaArchivo);
        $nombresArchivos[] = $nombreArchivo; // Agregar el nombre al arreglo
    }

    return $nombresArchivos;
}


/**
 * Elimina un directorio y todos sus archivos del servidor
 * @param string $directorio  Nombre del directorio a eliminar
 * @param string $name  Nombre del elemento al que pertenece el directorio (usuario, equipo, etc.)
 * @return boolean
 */
function eliminarDirectorio($directorio, $name)
{
    $ruta = __DIR__ . "/assets/images/" . $directorio . "/" . $name;

    if (is_dir($ruta)) {
        $archivos = scandir($ruta);
        foreach ($archivos as $archivo) {
            if ($archivo != "." && $archivo != "..") {
                $archivo = $ruta . '/' . $archivo;
                if (is_dir($archivo)) {
                    eliminarDirectorio("Equipos", $archivo);
                } else {
                    unlink($archivo);
                }
            }
        }
        rmdir($ruta);
        return true;
    } else {
        return false;
    }
}


/**
 * Función para cargar un icono
 * @param string $icon Nombre del icono
 * @return string SVG del icono
 */
function icon($icon,  $class = "",  $style = "")
{
    $file = __DIR__ . "/vistas/assets/icons/" . $icon . ".svg";
    if (file_exists($file)) {
        $iconSvg =  file_get_contents($file);
        $iconSvg = str_replace('<svg', '<svg class="' . $class . '"', $iconSvg);
        $iconSvg = str_replace('<svg', '<svg style="' . $style . '"', $iconSvg);
        echo $iconSvg;
    } else {
        echo "Icono no encontrado";
    }
}

/**
 * Función para generar un token de seguridad
 * @return void
 */

function generarToken()
{
    if (!isset($_SESSION["crs_token"])) {
        $token = bin2hex(random_bytes(32)) . uniqid();
        $_SESSION["crs_token"] = $token;
    } else {
        $token = $_SESSION["crs_token"];
    }
}

/**
 * Función para validar el token de seguridad
 * @param string $token token de seguridad
 * @return boolean true si el token es válido, false si no lo es
 */

function validarToken($token)
{
    if ($token != $_SESSION["crs_token"]) {
        return false;
    }
    return true;
}


/**
 * Función para obtener el token de seguridad
 * @return string token de seguridad
 */
function token()
{
    return $_SESSION["crs_token"];
}
