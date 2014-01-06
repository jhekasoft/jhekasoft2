<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$config = array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Jhekasoft',
    // preloading 'log' component
    'preload' => array('log'),
    'aliases' => array(
        'bootstrap' => 'application.vendor.drmabuse.yii-bootstrap-3-module'
    ),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'bootstrap.components.BSHtml',
    ),
    'modules' => array(
        'bootstrap' => array(
            'class' => 'bootstrap.BootStrapModule'
        ),
        'revolute' => array(),
        'admin' => array(),
        'blog' => array(),
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'jheka',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                'post/<id:\d+>/<title:.*?>' => 'post/view',
                'posts/<tag:.*?>' => 'post/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'cache' => array(
            'class' => 'CDbCache',
        ),
        'db' => array(
            'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../data/jhekasoft.db',
            'tablePrefix' => 'jh_',
            'schemaCachingDuration' => 3600,
        ),
        // uncomment the following to use a MySQL database
        /*
          'db'=>array(
          'connectionString' => 'mysql:host=localhost;dbname=testdrive',
          'emulatePrepare' => true,
          'username' => 'root',
          'password' => '',
          'charset' => 'utf8',
          ),
         */
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
        'bsHtml' => array(
            'class' => 'bootstrap.components.BSHtml'
        )
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'jheka@mail.ru',
    ),
    'theme' => 'bootstrap',
);

function getEnabledModules($modulesConfig) {
    $enabledModules = array();
    if (is_array($modulesConfig)) {
        foreach ($modulesConfig as $moduleKey => $moduleValue) {
            if (is_string($moduleValue)) {
                $enabledModules[] = $moduleValue;
            } else {
                $enabledModules[] = $moduleKey;
            }
        }
    }

    return $enabledModules;
}

$enabledModules = getEnabledModules($config['modules']);

$modulesDir = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
foreach ($enabledModules as $enabledModule) {
    $moduleDir = $modulesDir . $enabledModule . DIRECTORY_SEPARATOR;
    $moduleConfigFile = $moduleDir . 'config' . DIRECTORY_SEPARATOR . 'main.php';
    if (is_dir($moduleDir) && is_file($moduleConfigFile)) {
        $config = CMap::mergeArray($config, require($moduleConfigFile));
    }
}

//var_dump($config);
//exit();

return $config;

