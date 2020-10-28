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
 *      $Id: table_forum_sofa.php 31637 2012-09-17 08:12:26Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_sofa extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_sofa';
		$this->_pk    = 'tid';

		parent::__construct();
	}

	public function range($start = 0, $limit = 20) {
		return DB::fetch_all('SELECT * FROM %t ORDER BY tid DESC %i', array($this->_table, DB::limit($start, $limit)), $this->_pk);
	}

	public function fetch_all_by_fid($fid, $start = 0, $limit = 20) {
		$fid = dintval($fid, true);
		return DB::fetch_all('SELECT * FROM %t WHERE fid=%d ORDER BY tid DESC %i', array($this->_table, $fid, DB::limit($start, $limit)), $this->_pk);
	}

}

?>