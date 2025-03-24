<?php
spl_autoload_register(function ($className) {
    // Posibles directorios donde buscar las clases
    $directories = [
        __DIR__ . '/../controllers/',
        __DIR__ . '/../models/',
        __DIR__ . '/../middleware/',
        __DIR__ . '/../config/' // Agregar el directorio config/
    ];

    // Manejo especial para la clase Database
    if ($className === 'Database') {
        $file = __DIR__ . '/conexion.php'; // Ruta específica para Database
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    // Búsqueda estándar para otras clases
    foreach ($directories as $directory) {
        $file = $directory . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Cargar las dependencias de Composer
require_once __DIR__ . '/../vendor/autoload.php';
?>