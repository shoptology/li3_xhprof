<?php

namespace li3_xhprof\models;

use lithium\core\Libraries;

class ProfilerRuns extends \lithium\data\Model {

	/**
	 * Schema from XHGUI:
	 * CREATE TABLE `details` (
	 *   `id` char(17) NOT NULL,
	 *   `url` varchar(255) default NULL,
	 *   `c_url` varchar(255) default NULL,
	 *   `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	 *   `server name` varchar(64) default NULL,
	 *   `perfdata` MEDIUMBLOB,
	 *   `type` tinyint(4) default NULL,
	 *   `cookie` BLOB,
	 *   `post` BLOB,
	 *   `get` BLOB,
	 *   `pmu` int(11) unsigned default NULL,
	 *   `wt` int(11) unsigned default NULL,
	 *   `cpu` int(11) unsigned default NULL,
	 *   `server_id` char(3) NOT NULL default 't11',
	 *   `aggregateCalls_include` varchar(255) DEFAULT NULL,
	 *   PRIMARY KEY  (`id`),
	 *   KEY `url` (`url`),
	 *   KEY `c_url` (`c_url`),
	 *   KEY `cpu` (`cpu`),
	 *   KEY `wt` (`wt`),
	 *   KEY `pmu` (`pmu`),
	 *   KEY `timestamp` (`timestamp`)
	 * ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
	 */
	protected $_schema = array(
		'_id' => array('type' => 'string'),
		'namespace' => array('type' => 'string'),
		'url' => array('type' => 'string'),
		'normalized' => array('type' => 'string'),
		'timestamp' => array('type' => 'timestamp'),
		'serverName' => array('type' => 'string'),
		'perfdata' => array('type' => 'object'),
		'type' => array('type' => 'integer'),
		'cookie' => array('type' => 'object'),
		'post' => array('type' => 'object'),
		'get' => array('type' => 'object'),
		'pmu' => array('type' => 'object'),
		'wt' => array('type' => 'object'),
		'cpu' => array('type' => 'object'),
		'serverId' => array('type' => 'string', 'default' => 't11'),
		'aggregateCallsInclude' => array('type' => 'string')
	);

	public $indexes = array(
		'url' => array('url'),
		'normalized' => array('normalized'),
		'cpu' => array('cpu'),
		'wt' => array('wt'),
		'pmu' => array('pmu'),
		'timestamp' => array('timestamp')
	);

	public static function __init() {
		$context = Libraries::get('li3_xhprof');
		static::config(array('connection' => $context['connection']));
		$self = static::_object();
		if ($context['collection'] !== true) {
			$self->_meta['source'] = $context['collection'];
		}
		$self->_meta['locked'] = true;
	}
	
}

?>