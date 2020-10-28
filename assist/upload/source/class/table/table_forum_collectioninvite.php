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
 *      $Id: table_forum_collectioninvite.php 27779 2012-02-14 07:33:17Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_collectioninvite extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_collectioninvite';
		$this->_pk    = '';

		parent::__construct();
	}


	public function fetch_by_ctid_uid($ctid, $uid) {
		return DB::fetch_first('SELECT * FROM %t WHERE ctid=%d AND uid=%d', array($this->_table, $ctid, $uid));
	}

	public function delete_by_ctid_uid($ctid, $uid) {
		$condition = array();

		if($ctid) {
			$condition[] = DB::field('ctid', $ctid);
		}

		if($uid) {
			$condition[] = DB::field('uid', $uid);
		}

		if(!count($condition)) {
			return false;
		}

		DB::delete($this->_table, implode(' AND ', $condition));
	}

	public function delete_by_ctid($ctid) {
		return DB::delete($this->_table, DB::field('ctid', $ctid));
	}

	public function delete_by_dateline($dateline) {
		if(!is_numeric($dateline)) {
			return false;
		}
		return DB::delete($this->_table, DB::field('dateline', $dateline, '<='));
	}
}

?>