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
 *      $Id: table_forum_collectionteamworker.php 27781 2012-02-14 07:38:55Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_collectionteamworker extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_collectionteamworker';
		$this->_pk    = '';

		parent::__construct();
	}

	public function delete_by_ctid($ctid) {
		if(!$ctid) {
			return false;
		}
		return DB::delete($this->_table, DB::field('ctid', $ctid));
	}

	public function delete_by_ctid_uid($ctid, $uid) {
		if(!$ctid && !$uid) {
			return false;
		}

		$condition = array();

		if($ctid) {
			$condition[] = DB::field('ctid', $ctid);
		}

		if($uid) {
			$condition[] = DB::field('uid', $uid);
		}

		DB::delete($this->_table, implode(' AND ', $condition));
	}

	public function delete_by_uid($uid) {
		if(!$uid) {
			return false;
		}
		return DB::query("DELETE FROM %t WHERE %i", array($this->_table, DB::field('uid', $uid)));
	}

	public function fetch_all_by_ctid($ctid) {
		return DB::fetch_all("SELECT * FROM %t WHERE ctid=%d", array($this->_table, $ctid), 'uid');
	}

	public function count_by_ctid($ctid) {
		return DB::result_first("SELECT COUNT(*) FROM %t WHERE ctid=%d", array($this->_table, $ctid));
	}

	public function fetch_all_by_uid($uid) {
		return DB::fetch_all("SELECT * FROM %t WHERE uid=%d", array($this->_table, $uid), 'ctid');
	}

	public function update_by_ctid($ctid, $title) {
		if(!$ctid || is_array($title)) {
			return false;
		}
		return DB::update($this->_table, array('name'=>$title), DB::field('ctid', $ctid));
	}

	public function update($ctid, $uid, $data, $unbuffered = false, $low_priority = false) {
		if(!empty($data) && is_array($data) && $ctid && $uid) {
			return DB::update($this->_table, $data, DB::field('ctid', $ctid).' AND '.DB::field('uid', $uid), $unbuffered, $low_priority);
		}
		return !$unbuffered ? 0 : false;
	}
}

?>