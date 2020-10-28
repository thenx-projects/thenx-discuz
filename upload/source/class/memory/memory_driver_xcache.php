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
 *      $Id: memory_driver_xcache.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class memory_driver_xcache {

	public $cacheName = 'XCache';
	public $enable;

	public function env() {
		return function_exists('xcache_get');
	}

	public function init($config) {
		$this->enable = $this->env();
	}

	public function get($key) {
		return xcache_get($key);
	}

	public function set($key, $value, $ttl = 0) {
		return xcache_set($key, $value, $ttl);
	}

	public function rm($key) {
		return xcache_unset($key);
	}

	public function clear() {
		return xcache_clear_cache(XC_TYPE_VAR, 0);
	}

	public function inc($key, $step = 1) {
		return xcache_inc($key, $step);
	}

	public function dec($key, $step = 1) {
		return xcache_dec($key, $step);
	}

}