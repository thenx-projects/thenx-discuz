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
 *      $Id: table_forum_promotion.php 27863 2012-02-16 02:53:12Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_promotion extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_promotion';
		$this->_pk    = 'ip';

		parent::__construct();
	}

	public function count_by_uid($uid) {
		$uid = dintval($uid, is_array($uid) ? true : false);
		if(!empty($uid)) {
			$parameter = array($this->_table, $uid);
			$where = is_array($uid) ? 'uid IN(%n)' : 'uid=%d';
			return DB::result_first("SELECT COUNT(*) FROM %t WHERE $where", $parameter);
		}
		return 0;
	}
	public function delete_all() {
		return DB::query("DELETE FROM %t", array($this->_table));
	}

}

?>