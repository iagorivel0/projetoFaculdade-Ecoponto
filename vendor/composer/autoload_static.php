<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf452902bb580f1465c13bae24afe5a90
{
    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'src\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'src\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf452902bb580f1465c13bae24afe5a90::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf452902bb580f1465c13bae24afe5a90::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
