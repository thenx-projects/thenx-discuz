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
 *      $Id: table_common_admincp_member.php 27740 2012-02-13 10:05:22Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_admincp_member extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_admincp_member';
		$this->_pk    = 'uid';

		parent::__construct();
	}

	public function update_cpgroupid_by_cpgroupid($val, $data) {
		if(!is_array($data)) {
			return null;
		}
		return DB::update('common_admincp_member', $data, DB::field('cpgroupid', $val));
	}

	public function count_by_uid($uid) {
		return DB::result_first("SELECT count(*) FROM %t WHERE uid=%d", array($this->_table, $uid));
	}

	public function fetch_all_uid_by_gid_perm($gid, $perm) {
		return DB::fetch_all("SELECT uid FROM %t am LEFT JOIN %t ap ON am.cpgroupid=ap.cpgroupid WHERE am.cpgroupid=%d OR ap.perm=%s", array($this->_table, 'common_admincp_perm', $gid, $perm));
	}

	public function fetch_perm_by_uid_perm($uid, $perm) {
		return DB::result_first("SELECT ap.perm FROM %t am LEFT JOIN %t ap ON ap.cpgroupid=am.cpgroupid WHERE am.uid=%d AND ap.perm=%s", array($this->_table, 'common_admincp_perm', $uid, $perm));
	}
}

?>