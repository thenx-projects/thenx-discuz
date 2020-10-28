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
 *      $Id: table_forum_threadprofile.php 31607 2012-09-13 08:38:40Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_threadprofile extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_threadprofile';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function fetch_all() {
		return DB::fetch_all('SELECT * FROM %t', array($this->table), $this->_pk);
	}

	public function reset_default($tpid) {
		DB::query("UPDATE %t SET `global`=0", array($this->table));
		DB::query("UPDATE %t SET `global`=1 WHERE id=%d", array($this->table, $tpid));
	}

}

?>