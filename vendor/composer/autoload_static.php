<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit44735de1438195b07476468191f098de
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'DimSymfony\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'DimSymfony\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'DimSymfony\\Controller\\Admin\\AdminDimSymfonyConfigController' => __DIR__ . '/../..' . '/src/Controller/Admin/AdminDimSymfonyConfigController.php',
        'DimSymfony\\Controller\\Admin\\AdminDimSymfonyMainController' => __DIR__ . '/../..' . '/src/Controller/Admin/AdminDimSymfonyMainController.php',
        'DimSymfony\\Controller\\Admin\\DimSymfonyGestionRdvController' => __DIR__ . '/../..' . '/src/Controller/Admin/DimSymfonyGestionRdvController.php',
        'DimSymfony\\Form\\ConfigurationFormType' => __DIR__ . '/../..' . '/src/Form/ConfigurationFormType.php',
        'DimSymfony\\Form\\ConfigurationTextDataConfiguration' => __DIR__ . '/../..' . '/src/Form/ConfigurationTextDataConfiguration.php',
        'DimSymfony\\Form\\ConfigurationTextFormDataProvider' => __DIR__ . '/../..' . '/src/Form/ConfigurationTextFormDataProvider.php',
        'DimSymfony\\Service\\ItineraryService' => __DIR__ . '/../..' . '/src/Service/ItineraryService.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit44735de1438195b07476468191f098de::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit44735de1438195b07476468191f098de::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit44735de1438195b07476468191f098de::$classMap;

        }, null, ClassLoader::class);
    }
}
