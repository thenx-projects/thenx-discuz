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
 *      $Id: table_connect_postfeedlog.php 31305 2012-08-09 06:36:16Z liudongdong $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_connect_postfeedlog extends discuz_table {

	public function __construct() {
		$this->_table = 'connect_postfeedlog';
		$this->_pk = 'flid';

		parent::__construct();
	}

	public function fetch_by_pid($pid) {

		return DB::fetch_first('SELECT * FROM %t WHERE pid=%d', array($this->_table, $pid));
	}

	public function update_by_pid($pid, $data) {
		$pid = dintval($pid);
		return DB::update($this->_table, $data, DB::field('pid', $pid));
	}
}