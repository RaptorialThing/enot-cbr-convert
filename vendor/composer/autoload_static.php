<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6951a71204b85ab5e3cfc7c6d9357a6c
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6951a71204b85ab5e3cfc7c6d9357a6c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6951a71204b85ab5e3cfc7c6d9357a6c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6951a71204b85ab5e3cfc7c6d9357a6c::$classMap;

        }, null, ClassLoader::class);
    }
}