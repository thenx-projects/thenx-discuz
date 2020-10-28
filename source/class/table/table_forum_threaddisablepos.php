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
 *      $Id: table_forum_threaddisablepos.php 27449 2012-03-01 05:32:35Z liulanbo $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_forum_threaddisablepos extends discuz_table {

	private $enable_set = false;

	/*
	 * memory支持Set的情况下，所有的数据保存于一个Set下
	 */
	public function __construct() {
		$this->_table = 'forum_threaddisablepos';
		$this->_pk    = 'tid';
		$this->_pre_cache_key = 'forum_threaddisablepos_';
		$this->_cache_ttl = 0;
		parent::__construct();

		// 依赖set
		// 不影响原_allowmem变量，这样在没有Set的情况下，还能使用原来的缓存加速方案
		$this->enable_set = $this->_allowmem && C::memory()->gotset;
	}

	public function truncate() {
		if (!$this->enable_set) {
			DB::query("TRUNCATE ".DB::table('forum_threaddisablepos'));
		}
		return memory('rm', 'idx_threaddisablepos', $this->_pre_cache_key);
	}

	public function insert($data, $return_insert_id = false, $replace = false, $silent = false) {
		if (!$this->enable_set) {
			return parent::insert($data, $return_insert_id, $replace, $silent);
		}
		return memory('sadd', 'idx_threaddisablepos', $data['tid'], 0, $this->_pre_cache_key);
	}

	public function fetch($id, $force_from_db = false) {
		if (!$this->enable_set) {
			return parent::fetch($id, $force_from_db);
		}
		return memory('sismember', 'idx_threaddisablepos', $id, 0, $this->_pre_cache_key);
	}

}

?>