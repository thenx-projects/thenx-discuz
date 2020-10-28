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
 *      $Id: memory_driver_memcache.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class memory_driver_memcache {

	public $cacheName = 'MemCache';
	public $enable;
	public $obj;

	public function env() {
		return extension_loaded('memcache');
	}

	public function init($config) {
		if (!$this->env()) {
			$this->enable = false;
			return;
		}
		if (!empty($config['server'])) {
			$this->obj = new Memcache;
			if ($config['pconnect']) {
				$connect = @$this->obj->pconnect($config['server'], $config['port']);
			} else {
				$connect = @$this->obj->connect($config['server'], $config['port']);
			}
			$this->enable = $connect ? true : false;
		}
	}

	public function get($key) {
		return $this->obj->get($key);
	}

	public function getMulti($keys) {
		return $this->obj->get($keys);
	}

	public function set($key, $value, $ttl = 0) {
		return $this->obj->set($key, $value, 0, $ttl); // 不再使用MEMCACHE_COMPRESSED，因为不能increment
	}

	public function add($key, $value, $ttl = 0) {
		return $this->obj->add($key, $value, 0, $ttl);
	}

	public function rm($key) {
		return $this->obj->delete($key);
	}

	public function clear() {
		return $this->obj->flush();
	}

	public function inc($key, $step = 1) {
		if (!$this->obj->increment($key, $step)) {
			$this->set($key, $step);
		}
	}

	public function incex($key, $step = 1) {
		return $this->obj->increment($key, $step);
	}

	public function dec($key, $step = 1) {
		return $this->obj->decrement($key, $step);
	}

	public function exists($key) {
	    return $this->obj->get($key) !== FALSE;
    }

}

?>