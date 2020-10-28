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
 *      $Id: table_forum_statlog.php 31920 2012-10-24 09:18:33Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_statlog extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_statlog';
		$this->_pk    = 'logdate';

		parent::__construct();
	}

	public function fetch_all_by_logdate($start, $end, $fid) {
		return DB::fetch_all('SELECT * FROM %t WHERE logdate>=%s AND logdate<=%s AND type=1 AND fid=%d ORDER BY logdate ASC', array($this->_table, $start, $end, $fid));
	}

	public function fetch_all_rank_by_logdate($date) {
		return DB::fetch_all('SELECT * FROM %t WHERE logdate=%s AND type=1 ORDER BY value DESC', array($this->_table, $date));
	}

	public function fetch_all_by_fid_type($fid, $type=1) {
		return DB::fetch_all("SELECT * FROM %t WHERE fid=%d AND type=%d", array($this->_table, $fid, $type));
	}

	public function fetch_min_logdate_by_fid($fid) {
		return DB::result_first("SELECT MIN(logdate) FROM %t WHERE fid=%d", array($this->_table, $fid));
	}

	public function insert_stat_log($date) {
		return DB::query("REPLACE INTO %t (logdate, fid, `type`, `value`) SELECT %s, fid, 1, todayposts FROM %t WHERE `type` IN ('forum', 'sub') AND `status`<>'3'", array($this->_table, $date, 'forum_forum'));
	}


}

?>