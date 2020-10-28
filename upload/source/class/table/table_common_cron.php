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
 *      $Id: table_common_cron.php 30314 2012-05-22 03:12:44Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_cron extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_cron';
		$this->_pk    = 'cronid';

		parent::__construct();
	}

	public function fetch_nextrun($timestamp) {
		$timestamp = intval($timestamp);
		return DB::fetch_first('SELECT * FROM '.DB::table($this->_table)." WHERE available>'0' AND nextrun<='$timestamp' ORDER BY nextrun LIMIT 1");
	}

	public function fetch_nextcron() {
		return DB::fetch_first('SELECT * FROM '.DB::table($this->_table)." WHERE available>'0' ORDER BY nextrun LIMIT 1");
	}

	public function get_cronid_by_filename($filename) {
		return DB::result_first('SELECT cronid FROM '.DB::table($this->_table)." WHERE filename='$filename'");
	}


}

?>