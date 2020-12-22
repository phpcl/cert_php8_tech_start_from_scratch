<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6b1e6109ea17c78866b6bc81c3d49254
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SimpleHtml\\' => 11,
        ),
        'P' => 
        array (
            'PhpTraining\\' => 12,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SimpleHtml\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/SimpleHtml',
        ),
        'PhpTraining\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/PhpTraining',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6b1e6109ea17c78866b6bc81c3d49254::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6b1e6109ea17c78866b6bc81c3d49254::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6b1e6109ea17c78866b6bc81c3d49254::$classMap;

        }, null, ClassLoader::class);
    }
}
