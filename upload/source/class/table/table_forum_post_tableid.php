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
 *      $Id: table_forum_post_tableid.php 28127 2012-02-23 02:31:37Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_post_tableid extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_post_tableid';
		$this->_pk    = 'pid';

		parent::__construct();
	}

	public function alter_auto_increment($auto_increment) {
		return DB::query("ALTER TABLE %t AUTO_INCREMENT=%d", array($this->_table, $auto_increment));
	}

	public function delete_by_lesspid($pid) {
		return DB::query("DELETE FROM %t WHERE pid<%d", array($this->_table, $pid));
	}

	public function fetch_max_id() {
		return DB::result_first('SELECT MAX(pid) FROM '.DB::table($this->_table));
	}
}

?>