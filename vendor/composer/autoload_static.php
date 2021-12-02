<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9d438d7b3bd508fdb7207c690508b95c
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Danilyer\\App\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Danilyer\\App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9d438d7b3bd508fdb7207c690508b95c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9d438d7b3bd508fdb7207c690508b95c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9d438d7b3bd508fdb7207c690508b95c::$classMap;

        }, null, ClassLoader::class);
    }
}
