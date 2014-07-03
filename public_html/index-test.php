<?php

	ini_set('display_errors', 1);
	ini_set('error_reporting', -1);

    #defined('ENVIRONMENT') || define('ENVIRONMENT', 'develop');
    defined('PRODUCTION')  || define('PRODUCTION', false);

    require_once dirname(__FILE__) . '/index.php';
