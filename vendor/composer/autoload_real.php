<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit8afe1dbd4da4df6f35dec5224e919216
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit8afe1dbd4da4df6f35dec5224e919216', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit8afe1dbd4da4df6f35dec5224e919216', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit8afe1dbd4da4df6f35dec5224e919216::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
