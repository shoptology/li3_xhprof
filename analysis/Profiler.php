<?php

namespace li3_xhprof\analysis;

use lithium\core\Environment;
use lithium\core\Libraries;

class Profiler extends \lithium\core\StaticObject {

	protected static $_config;

	public static $classes = array(
		'runs' => 'li3_xhprof\models\ProfilerRuns'
	);

	public static function config($key = null) {
		if (!isset(static::$_config)) {
			static::$_config = Libraries::get('li3_xhprof');
		}
		if (!empty($key)) {
			if (!isset(static::$_config[$key])) {
				return false;
			}
			return static::$_config[$key];
		}
		return static::$_config;
	}

	/**
	 * Enables the profiler
	 *
	 * Takes the same arguments as `xhprof_enable()`
	 * Note that if you want to capture the entire request handling
	 * You can add `xhprof_enable()` to the top of your bootstrap
	 * before you load lithium.  If you wait until this library has
	 * been loaded, then you miss a little bit.  However, that's
	 * probably not the part you care about profiling, so unless
	 * you're profiling the framework itself, I'd say it's safe
	 * to wait until this library is loaded and run `Profiler::enable()`
	 *
	 * @param integer $flags
	 * @param array $options
	 * @link http://php.net/xhprof_enable
	 */
	public static function enable($flags = -1, $options = array()) {
		if (!extension_loaded('xhprof')) {
			return false;
		}
		if (static::config('sample')) {
			xhprof_sample_enable();
			return true;
		}
		if ($flags === -1) {
			if (!Environment::is('production')) {
				$flags = XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY;
			} else {
				$flags = XHPROF_FLAGS_MEMORY;
			}
		}
		xhprof_enable($flags, $options);
		return true;
	}

	public static function disable() {
		if (!extension_loaded('xhprof')) {
			return false;
		}
		if (static::config('sample')) {
			return xhprof_sample_disable();
		}
		return xhprof_disable();
	}

	/**
	 * Save the data from the run to the database
	 *
	 * @param array $data xhprof data
	 * @param object $request a lithium request object, used to add info about the url
	 *     being profiled and other environment data.
	 * @param string $namespace The application name, defaults to the default library
	 * @return object Returns the saved document.
	 */
	public static function save($data, $options = array()) {
		$options += array(
			'namespace' => static::config('namespace'),
			'request' => null,
			'type' => 0
		);
		
		if (is_object($options['request'])) {
			$request = $options['request'];
			$options += array(
				'get' => $request->query,
				'post' => $request->data,
				'cookie' => $request->cookies,
				'url' => $request->to('url'),
				'normalized' => $request->url,
				'servername' => $request->get('env:server_name'),
				'timestamp' => $request->get('env:request_time'),
				'aggregateCallsInclude' => $request->get('env:xhprof_aggregateCalls_include')
			);
		}
		$options += array(
			'pmu' => isset($data['main()']['pmu']) ? $data['main()']['pmu'] : '',
			'wt' => isset($data['main()']['wt'])  ? $data['main()']['wt']  : '',
			'cpu' => isset($data['main()']['cpu']) ? $data['main()']['cpu'] : ''
		);
		if (empty($options['timestamp'])) {
			$options['timestamp'] = time();
		}

		$runs = static::$classes['runs'];
		$run = $runs::create($options);
		$run->perfdata = $data;
		$run->save();
		return $run;
	}
}

?>