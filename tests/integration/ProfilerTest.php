<?php

namespace li3_xhprof\tests\integration;

use li3_xhprof\analysis\Profiler;

class ProfilerTest extends \lithium\test\Unit {

	public function setUp() {}

	public function testRun() {
		Profiler::enable();
		$array = array();
		for ($i = 0; $i < 100; $i++) {
			array_push($array, $i);
		}
		$data = Profiler::disable();
		Profiler::save($data);
	}

	public function tearDown() {}


}

?>