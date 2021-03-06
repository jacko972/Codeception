<?php

require_once __DIR__ .'/vendor/UniversalClassLoader.php';

if (stream_resolve_include_path('vendor/autoload.php')) {
    $namespaceMap = require_once 'vendor/composer/autoload_namespaces.php';
    $classesMap = require_once 'vendor/composer/autoload_classmap.php';

    $loader = new UniversalClassLoader();
    $loader->registerNamespaces(
        array(
            'Codeception' => __DIR__ . '/src'
        )
    );
    $loader->registerNamespaces($namespaceMap);
    $loader->register(true);

    spl_autoload_register(
        function ($class) use ($classesMap) {
            if (isset($classesMap[$class])) {
                require $classesMap[$class];
            }
        },
        true
    );

} elseif (stream_resolve_include_path(__DIR__.'/../../autoload.php')) {
    require_once __DIR__ . '/../../autoload.php';
}

/** spike-fix for PHP 5.3 */
if (! interface_exists('JsonSerializable')) {
    interface JsonSerializable {
        function jsonSerialize();
    }
}

