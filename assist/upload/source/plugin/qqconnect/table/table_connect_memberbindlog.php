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
 *      $Id: table_connect_memberbindlog.php 29265 2012-03-31 06:03:26Z yexinhao $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_connect_memberbindlog extends discuz_table {

	public function __construct() {
		$this->_table = 'connect_memberbindlog';
		$this->_pk = 'mblid';

		parent::__construct();
	}

	public function count_uid_by_openid_type($openid, $type) {
		$count = (int) DB::result_first('SELECT count(DISTINCT uid) FROM %t WHERE uin=%s AND type=%d', array($this->_table, $openid, $type));
		return $count;
	}

	public function fetch_all_by_openids($openids, $start = 0, $limit = 0) {
		$result = array();
		if($openids) {
			$result = DB::fetch_all('SELECT * FROM '.DB::table($this->_table).' WHERE '.DB::field('uin', $openids).' ORDER BY dateline DESC '.DB::limit($start, $limit));
		}
		return $result;
	}

	public function fetch_all_by_uids($uids, $start = 0, $limit = 0) {
		$result = array();
		if($uids) {
			$result = DB::fetch_all('SELECT * FROM '.DB::table($this->_table).' WHERE '.DB::field('uid', $uids).' ORDER BY dateline DESC '.DB::limit($start, $limit));
		}
		return $result;
	}
}