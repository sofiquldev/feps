<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8afe1dbd4da4df6f35dec5224e919216
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'FEPS\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'FEPS\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8afe1dbd4da4df6f35dec5224e919216::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8afe1dbd4da4df6f35dec5224e919216::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8afe1dbd4da4df6f35dec5224e919216::$classMap;

        }, null, ClassLoader::class);
    }
}