<?php

if (!extension_loaded('xhprof')) {
	$message = 'Warning! Unable to profile run, xhprof extension not loaded';
	trigger_error($message, E_WARNING);
	return false;
}

use lithium\core\Libraries;

/**
 * li3_xhprof config.  Valid options are:
 *     - `'collection'`: the name of the collection to use with the ProfilerRuns model
 *     - `'connection'`: name of the connection that will hold the runs data
 *     - `'namespace'`: each run is stored under a namespace, by default, the
 *                      app name is used.
 *     - '`sample'`: boolean, defaults to false.  If true, will use
 *
 * @see lithium/data/Connections::add()
 * @link http://php.net/manual/en/book.xhprof.php
 */
$config = Libraries::get('li3_xhprof');
$config += array(
	'collection' => true,
	'connection' => 'default',
	'namespace'  => basename(Libraries::get(true, 'path')), // li3 doesn't let us get the name :(
	'sample'     => false
);

// set the config back - is there a better way to persist this config?
// it seems like this works fairly well, need to turn off bootstrap to avoid
// an infinite loop
$config['bootstrap'] = false;
Libraries::add('li3_xhprof', $config);


?>