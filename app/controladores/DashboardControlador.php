<?php

class DashboardControlador
{
    public function index()
    {
        verificarSesion();
        verificarRol("admin");
        cargarVista("dashboard", "index", [], true);
    }
}
