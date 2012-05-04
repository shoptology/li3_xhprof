<?php

namespace li3_xhprof\controllers;

use li3_xhprof\models\ProfilerRuns;
use lithium\action\DispatchException;

class ProfilerRunsController extends \lithium\action\Controller {

	public function index() {
		$profilerRuns = ProfilerRuns::all();
		return compact('profilerRuns');
	}

	public function view() {
		$profilerRun = ProfilerRuns::first($this->request->id);
		return compact('profilerRun');
	}

	public function add() {
		$profilerRun = ProfilerRuns::create();

		if (($this->request->data) && $profilerRun->save($this->request->data)) {
			return $this->redirect(array('ProfilerRuns::view', 'args' => array($profilerRun->id)));
		}
		return compact('profilerRun');
	}

	public function edit() {
		$profilerRun = ProfilerRuns::find($this->request->id);

		if (!$profilerRun) {
			return $this->redirect('ProfilerRuns::index');
		}
		if (($this->request->data) && $profilerRun->save($this->request->data)) {
			return $this->redirect(array('ProfilerRuns::view', 'args' => array($profilerRun->id)));
		}
		return compact('profilerRun');
	}

	public function delete() {
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			$msg = "ProfilerRuns::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}
		ProfilerRuns::find($this->request->id)->delete();
		return $this->redirect('ProfilerRuns::index');
	}
}

?>