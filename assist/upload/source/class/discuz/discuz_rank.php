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
 *      $Id: discuz_rank.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class discuz_rank extends discuz_base
{
	public $name = '';

	public function __construct($name) {
		if($name) {
			$this->name = $name;
		} else {
			throw new Exception('The property "'.get_class($this).'->name" is empty');
		}
	}

	public function fetch_list($order = 'DESC', $start = 0, $limit = 0) {
		return C::t('common_rank')->fetch_list($this->name, $order, $limit);
	}

	public function fetch_rank($key) {
		return C::t('common_rank')->fetch_rank($this->name, $key);
	}

	public function set($key, $value) {
		return C::t('common_rank')->insert($this->name, $key, $value);
	}

	public function inc($key, $value) {
		return C::t('common_rank')->inc($this->name, $key, $value);
	}

	public function dec($key, $value) {
		return C::t('common_rank')->dec($this->name, $key, $value);
	}

	public function clear() {
		return C::t('common_rank')->delete($this->name);
	}

	public function rm($key) {
		return $key ? C::t('common_rank')->delete($this->name, $key) : false;
	}

}

?>