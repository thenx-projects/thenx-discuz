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
 *      $Id: table_common_patch.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_patch extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_patch';
		$this->_pk    = 'serial';

		parent::__construct();
	}

	public function fetch_all() {
		return DB::fetch_all("SELECT * FROM ".DB::table($this->_table));
	}

	public function fetch_max_serial() {
		return DB::result_first("SELECT serial FROM ".DB::table($this->_table)." ORDER BY serial DESC LIMIT 1");
	}

	public function update_status_by_serial($status, $serial, $condition = '') {
		return DB::query("UPDATE ".DB::table($this->_table)." SET ".DB::field('status', $status)." WHERE ".DB::field('serial', $serial, $condition));
	}

	public function fetch_needfix_patch($serials) {
		return DB::fetch_all("SELECT * FROM ".DB::table($this->_table)." WHERE ".DB::field('serial', $serials)." AND status<=0");
	}

	public function fetch_patch_by_status($status) {
		return DB::fetch_all("SELECT * FROM ".DB::table($this->_table)." WHERE ".DB::field('status', $status));
	}
}

?>