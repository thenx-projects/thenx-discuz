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
 *      $Id: table_forum_activityapply.php 28709 2012-03-08 08:53:48Z liulanbo $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_activityapply extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_activityapply';
		$this->_pk    = 'applyid';

		parent::__construct();
	}
	public function fetch_info_for_user($uid, $tid) {
		return DB::fetch_first("SELECT * FROM %t WHERE tid=%d AND uid=%d", array($this->_table, $tid, $uid));
	}
	public function delete_for_user($uid, $tid) {
		DB::query("DELETE FROM %t WHERE tid=%d AND uid=%d", array($this->_table, $tid, $uid));
	}
	public function delete_by_tid($tids) {
		return DB::delete($this->_table, DB::field('tid', $tids));
	}
	public function delete_for_thread($tid, $applyids = array()) {
		if($applyids) {
			$pksql = " AND ".DB::field('applyid', $applyids);
		}
		DB::query("DELETE FROM %t WHERE tid=%d $pksql", array($this->_table, $tid));
	}
	public function fetch_count_for_thread($tid) {
		return DB::result_first("SELECT COUNT(*) FROM %t WHERE tid=%d AND verified='1'", array($this->_table, $tid));
	}
	public function fetch_all_for_thread($tid, $start = 0, $limit = 100, $uid = 0, $master = 0) {
		$verifiedsql = empty($master) ? ' AND verified=1' : '';
		if(intval($uid)) {
			$verifiedsql .= ' AND uid='.intval($uid);
		}
		return DB::fetch_all("SELECT * FROM %t WHERE tid=%d $verifiedsql ORDER BY dateline DESC".DB::limit($start, $limit), array($this->_table, $tid));
	}
	public function update_verified_for_thread($verified, $tid, $applyid) {
		DB::query("UPDATE %t SET verified=%d WHERE tid=%d AND applyid IN (%n)", array($this->_table, $verified, $tid, $applyid));
	}
}

?>