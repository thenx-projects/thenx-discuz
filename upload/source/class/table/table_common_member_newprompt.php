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
 *      $Id: table_common_member_newprompt.php 27449 2012-06-28 05:32:35Z liulanbo $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_member_newprompt extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_member_newprompt';
		$this->_pk    = 'uid';
		$this->_pre_cache_key = 'common_member_newprompt_';
		$this->_cache_ttl = 60;

		parent::__construct();
	}
	public function insert($uid, $data) {
		if(empty($uid) || empty($data)) {
			return false;
		}
		DB::insert($this->_table, array('uid' => intval($uid), 'data' => serialize($data)));
	}
}

?>