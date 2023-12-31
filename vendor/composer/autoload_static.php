<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite6f275b4a790826666a8a0f14bfdce25
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twilio\\' => 7,
        ),
        4 => 
        array (
            '48530\\Generator\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twilio\\' => 
        array (
            0 => __DIR__ . '/..' . '/twilio/sdk/src/Twilio',
        ),
        '48530\\Generator\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInite6f275b4a790826666a8a0f14bfdce25::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite6f275b4a790826666a8a0f14bfdce25::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite6f275b4a790826666a8a0f14bfdce25::$classMap;

        }, null, ClassLoader::class);
    }
}
