<?php

use Doctrine\Common\ClassLoader;

$mongoODMLocation = dirname(__DIR__) . DS . 'Vendor' . DS . 'mongodb_odm' . DS;
require  $mongoODMLocation . 'lib/vendor/doctrine-common/lib/Doctrine/Common/ClassLoader.php';

// ODM Classes
$classLoader = new ClassLoader('Doctrine\ODM\MongoDB', $mongoODMLocation . 'lib');
$classLoader->register();

// Common Classes
$classLoader = new ClassLoader('Doctrine\Common', $mongoODMLocation . 'lib/vendor/doctrine-common/lib');
$classLoader->register();

// MongoDB Classes
$classLoader = new ClassLoader('Doctrine\MongoDB', $mongoODMLocation . 'lib/vendor/doctrine-mongodb/lib');
$classLoader->register();

if (Configure::read('debug') === 8) {
	//TODO: Create a renderer instead of a handler
	$handler = Configure::read('Exception.handler');
	Configure::write('Exception.handler', function($exception) use ($handler){
		if ($exception instanceof \Doctrine\ODM\MongoDB\MongoDBException) {
			$exception = new CakeException(html_entity_decode($exception->getMessage()));
		}
		return call_user_func($handler, $exception);
	});
}