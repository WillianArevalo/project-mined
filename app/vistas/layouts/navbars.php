<?php
$usuario = obtenerSession("usuario");
if ($usuario) {
    require_once __DIR__ . "/navbar/navbar-" . $usuario->rol . ".php";
} else {
    header("Location:" . url("/"));
}
