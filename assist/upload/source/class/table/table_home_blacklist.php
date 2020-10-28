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
 *      $Id: table_home_blacklist.php 30819 2012-06-21 07:51:49Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_home_blacklist extends discuz_table
{
	private $_buids = array();
	public function __construct() {

		$this->_table = 'home_blacklist';
		$this->_pk    = '';

		parent::__construct();
	}

	public function count_by_uid_buid($uid, $buid = 0) {
		$parameter = array($this->_table);
		$wherearr = array();
		if($uid) {
			$parameter[] = $uid;
			$wherearr[] = 'uid=%d';
		}
		if($buid) {
			$parameter[] = $buid;
			$wherearr[] = "buid=%d";
		}
		$wheresql = !empty($wherearr) && is_array($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';
		return DB::result_first("SELECT COUNT(*) FROM %t $wheresql", $parameter);
	}

	public function fetch_all_by_uid($uid, $start = 0, $limit = 0) {
		$data = array();
		$query = DB::query('SELECT * FROM %t WHERE uid=%d ORDER BY dateline DESC '.DB::limit($start, $limit), array($this->_table, $uid));
		while($value = DB::fetch($query)) {
			$data[$value['buid']] = $value;
		}
		return $data;
	}

	public function fetch_all_by_uid_buid($uid, $buids) {
		return DB::fetch_all('SELECT * FROM %t WHERE uid=%d AND buid IN(%n)', array($this->_table, $uid, $buids), 'buid');
	}

	public function delete_by_uid_buid($uid, $buid) {
		return DB::query('DELETE FROM %t WHERE uid=%d AND buid=%d', array($this->_table, $uid, $buid));
	}
}

?>