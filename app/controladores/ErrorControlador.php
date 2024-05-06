<?php

class ErrorControlador
{
    public function index()
    {
        cargarVista("error", "index", [], false, true);
    }
}
