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
 *      $Id: table_myrepeats.php 31512 2012-09-04 07:11:08Z monkey $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_myrepeats extends discuz_table
{
	public function __construct() {

		$this->_table = 'myrepeats';
		$this->_pk    = '';

		parent::__construct();
	}

	public function fetch_all_by_uid($uid) {
		return DB::fetch_all("SELECT * FROM %t WHERE uid=%d", array($this->_table, $uid));
	}

	public function fetch_all_by_username($username) {
		return DB::fetch_all("SELECT * FROM %t WHERE username=%s", array($this->_table, $username));
	}

	public function fetch_all_by_uid_username($uid, $username) {
		return DB::fetch_all("SELECT * FROM %t WHERE uid=%d AND username=%s", array($this->_table, $uid, $username));
	}

	public function count_by_uid_username($uid, $username) {
		return DB::result_first("SELECT COUNT(*) FROM %t WHERE uid=%d AND username=%s", array($this->_table, $uid, $username));
	}

	public function delete_by_uid_usernames($uid, $usernames) {
		DB::query("DELETE FROM %t WHERE uid=%d AND username IN (%n)", array($this->_table, $uid, $usernames));
	}

	public function update_comment_by_uid_username($uid, $username, $value) {
		DB::query("UPDATE %t SET comment=%s WHERE uid=%d AND username=%s", array($this->_table, $value, $uid, $username));
	}

	public function update_locked_by_uid_username($uid, $username, $value) {
		DB::query("UPDATE %t SET locked=%d WHERE uid=%d AND username=%s", array($this->_table, $value, $uid, $username));
	}

	public function update_logindata_by_uid_username($uid, $username, $value) {
		DB::query("UPDATE %t SET logindata=%s WHERE uid=%d AND username=%s", array($this->_table, $value, $uid, $username));
	}

	public function update_lastswitch_by_uid_username($uid, $username, $value) {
		DB::query("UPDATE %t SET lastswitch=%d WHERE uid=%d AND username=%s", array($this->_table, $value, $uid, $username));
	}

	public function count_by_search($condition) {
		return DB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $condition));
	}

	public function fetch_all_by_search($condition, $start, $ppp) {
		return DB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY uid LIMIT %d, %d", array($this->_table, $condition, $start, $ppp));
	}

}

?>