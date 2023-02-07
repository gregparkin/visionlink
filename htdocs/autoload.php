<?php

class Autoloader
{
    public static function ClassLoader(string $className)
    {
        $filePath = "../classes/$className.php";

        if (is_readable($filePath))
        {
            require $filePath;
        }
    }
}

spl_autoload_register('Autoloader::ClassLoader');

// You can define multiple autoloaders:
// spl_autoload_register('Autoloader::ServiceLoader');
// spl_autoload_register('Autoloader::ControllerLoader');
// etc...
