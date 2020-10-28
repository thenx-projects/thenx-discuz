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
 *      $Id: table_common_devicetoken.php 31700 2012-09-24 03:46:59Z zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_devicetoken extends discuz_table {

	public function __construct() {
		$this->_table = 'common_devicetoken';
		$this->_pk = 'token';

		parent::__construct();
	}

	public function loginToken($deviceToken, $uid) {
		return DB::insert($this->_table, array(
			'uid' => $uid,
			'token' => $deviceToken,
		), false, true);
	}

	public function logoutToken($deviceToken, $uid) {
		return DB::query('DELETE FROM %t WHERE uid=%d AND token=%s', array($this->_table, $uid, $deviceToken));
	}

	public function clearToken($deviceToken) {
		return DB::query('DELETE FROM %t WHERE token=%s', array($this->_table, $deviceToken));
	}

}