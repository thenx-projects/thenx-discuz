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
 *      $Id: table_forum_onlinelist.php 27876 2012-02-16 04:28:02Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_onlinelist extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_onlinelist';
		$this->_pk    = '';

		parent::__construct();
	}
	public function fetch_all_order_by_displayorder() {
		return DB::fetch_all('SELECT * FROM %t ORDER BY displayorder', array($this->_table));
	}
	public function delete_all() {
		DB::query('DELETE FROM %t', array($this->_table));
	}

	public function delete_by_groupid($groupid) {
		$groupid = is_array($groupid) ? array_map('intval', (array)$groupid) : dintval($groupid);
		if($groupid) {
			return DB::delete($this->_table, DB::field('groupid', $groupid));
		}
		return 0;
	}

	public function update_by_groupid($groupid, $data) {
		$groupid = is_array($groupid) ? array_map('intval', (array)$groupid) : dintval($groupid);
		if($groupid && $data && is_array($data)) {
			return DB::update($this->_table, $data, DB::field('groupid', $groupid));
		}
		return 0;
	}
}

?>