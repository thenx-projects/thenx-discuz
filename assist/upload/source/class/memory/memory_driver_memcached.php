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
 *      $Id: memory_driver_memcached.php 27449 2017-07-11 05:32:35Z ladyff $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class memory_driver_memcached
{
	public $cacheName = 'MemCached';
	public $enable;
	public $obj;

	public function env() {
		return extension_loaded('memcached');
	}
	public function init($config) {
		if (!$this->env()) {
			$this->enable = false;
			return;
		}
		if(!empty($config['server'])) {
			$this->obj = new Memcached;
			$this->obj->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
			$this->obj->setOption(Memcached::OPT_TCP_NODELAY, true);
			$this->obj->addServer($config['server'], $config['port']);
			$connect=$this->obj->set('connect', '1');
			$this->enable = $connect ? true : false;
		}
	}

	public function get($key) {
		return $this->obj->get($key);
	}

	public function getMulti($keys) {
		return $this->obj->getMulti($keys);
	}

	public function set($key, $value, $ttl = 0) {
		return $this->obj->set($key, $value, $ttl);
	}

	public function add($key, $value, $ttl = 0) {
		return $this->obj->add($key, $value, $ttl);
	}

	public function rm($key) {
		return $this->obj->delete($key);
	}

	public function clear() {
		return $this->obj->flush();
	}

	public function inc($key, $step = 1) {
		return $this->obj->increment($key, $step, $step);
	}

	public function incex($key, $step = 1) {
		return $this->obj->increment($key, $step);
	}

	public function dec($key, $step = 1) {
		return $this->obj->decrement($key, $step);
	}

	public function exists($key) {
		$this->obj->get($key);
		return \Memcached::RES_NOTFOUND !== $this->obj->getResultCode();
	}

}

?>