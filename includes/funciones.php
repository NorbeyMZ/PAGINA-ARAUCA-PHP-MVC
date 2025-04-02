<?php

// Definir la constante correctamente en config.php o en el archivo adecuado
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo(string $actual, string $proximo): bool {
    if($actual !== $proximo){
        return true;
    }
    return false;
}

//revisa si esta utenticado
function  isAuth():void{
    if(!isset($_SESSION['login'])){
        header('location: /');
    }    
}

function isAdmin():void{
    if(!isset($_SESSION['admin'])){
        header('location: /');
    }
}