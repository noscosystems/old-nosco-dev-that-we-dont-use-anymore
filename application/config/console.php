<?php

    // Grab the main configuration file, because it also acts as a setup script.
    $config = require dirname(__FILE__) . '/main.php';

    /* ================================= *\
    |  Console Application Configuration  |
    \* ================================= */

    // This is the configuration for yiic console application. Any writable CConsoleApplication properties can be
    // configured here.
    return array(
        'basePath' => $config['basePath'],
        'name' => $config['name'],
        'sourceLanguage' => $config['sourceLanguage'],

        // Preloading 'log' component.
        'preload' => array('log'),

        // Command Map.
        'commandMap' => array(
            'migrate' => array(
                'class' => 'system.cli.commands.MigrateCommand',
                'migrationPath' => 'application.migrations',
                'migrationTable' => '{{migrations}}',
                'connectionID' => 'db',
                'interactive' => false,
            ),
            'merge' => array(
                'class' => '\\application\\commands\\MergeCommand',
                'mergePath' => 'application.migrations.merges',
                'mergeTable' => '{{merges}}',
                'interactive' => false,
            ),
            'index' => array(
                'class' => '\\application\\commands\\IndexCommand',
            ),
        ),

        // application components
        'components' => array(
            'db' => $config['components']['db'],
            'log' => $config['components']['log'],
        ),
    );
