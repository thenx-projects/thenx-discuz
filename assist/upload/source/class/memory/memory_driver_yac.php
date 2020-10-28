<?php
/*
 *
 *  * Copyright 2012-2020 the original author or authors.
 *  *
 *  * Licensed under the Apache License, Version 2.0 (the "License");
 *  * you may not use this file except in compliance with the License.
 *  * You may obtain a copy of the License at
 *  *
 *  *      https://www.apache.org/licenses/LICENSE-2.0
 *  *
 *  * Unless required by applicable law or agreed to in writing, software
 *  * distributed under the License is distributed on an "AS IS" BASIS,
 *  * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  * See the License for the specific language governing permissions and
 *  * limitations under the License.
 *
 */

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: memory_driver_yac.php 27635 2017-02-02 17:02:46Z NaiXiaoxIN $
 */
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class memory_driver_yac {

	public $cacheName = 'Yac';
	private $object = null;
	public $enable;

	public function env() {
		return extension_loaded('Yac');
	}

	public function init($config) {
		$this->enable = $this->env();
		if ($this->enable) {
			$this->object = new yac();
		}
	}

	public function get($key) {
		return $this->object->get($key);
	}

	public function getMulti($keys) {
		$result = $this->object->get($keys);
		foreach ($result as $key => $value) {
			if ($value === false) {
				unset($result[$key]);
			}
		}
		return $result;
	}

	public function set($key, $value, $ttl = 0) {
		return $this->object->set($key, $value, $ttl);
	}

	public function rm($key) {
		return $this->object->delete($key);
	}

	public function clear() {
		return $this->object->flush();
	}

	public function inc($key, $step = 1) {
		$old = $this->get($key);
		if (!$old) {
			return false;
		}
		return $this->set($key, $old + $step);
	}

	public function dec($key, $step = 1) {
		$old = $this->get($key);
		if (!$old) {
			return false;
		}
		return $this->set($key, $old - $step);
	}

}