<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit11dca7539adc66dec90225294de42c21
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Modules\\Communication\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Modules\\Communication\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit11dca7539adc66dec90225294de42c21::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit11dca7539adc66dec90225294de42c21::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}