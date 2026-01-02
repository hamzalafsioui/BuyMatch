<?php

// Automatically load classes from the /classes directory
spl_autoload_register(function ($className) {
    
    $baseDir = __DIR__ . '/../classes/';

    
    $directories = [
        '',              
        'Repositories/', 
        'Interfaces/',   
        'Helpers/'
    ];

    foreach ($directories as $directory) {
        $file = $baseDir . $directory . $className . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
