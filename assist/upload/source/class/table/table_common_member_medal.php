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
 *      $Id: table_common_member_medal.php 27772 2012-02-14 06:48:34Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_member_medal extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_member_medal';
		$this->_pk    = '';

		parent::__construct();
	}

	public function fetch_all_by_uid($uid) {
		return !empty($uid) ? DB::fetch_all('SELECT * FROM '.DB::table($this->_table).' WHERE '.DB::field('uid', $uid), 'medalid') : array();
	}

	public function delete_by_uid_medalid($uid, $medalid) {
		return !empty($uid) && !empty($medalid) ? DB::delete($this->_table, DB::field('uid', $uid).' AND '.DB::field('medalid', $medalid)) : false;
	}

	public function count_by_uid_medalid($uid, $medalid) {
		return DB::result_first('SELECT COUNT(*) FROM %t WHERE uid=%d AND medalid=%d', array($this->_table, $uid, $medalid));
	}
}

?>