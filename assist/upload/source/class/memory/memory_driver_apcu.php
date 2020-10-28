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
 *      $Id: memory_driver_apc.php 27635 2012-02-08 06:38:31Z zhangguosheng $
 */
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class memory_driver_apcu {

	public $cacheName = 'APCu';
	public $enable;

	public function env() {
		return function_exists('apcu_cache_info') && @apcu_cache_info();
	}

	public function init($config) {
		$this->enable = $this->env();
	}

	public function get($key) {
		return apcu_fetch($key);
	}

	public function set($key, $value, $ttl = 0) {
		return apcu_store($key, $value, $ttl);
	}

	public function rm($key) {
		return apcu_delete($key);
	}

	public function clear() {
		return apcu_clear_cache('user');
	}

	public function inc($key, $step = 1) {
		return apcu_inc($key, $step) !== false ? apcu_fetch($key) : false;
	}

	public function dec($key, $step = 1) {
		return apcu_dec($key, $step) !== false ? apcu_fetch($key) : false;
	}

}