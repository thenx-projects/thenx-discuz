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
 *      $Id: table_common_admincp_perm.php 27773 2012-02-14 06:49:55Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_admincp_perm extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_admincp_perm';
		$this->_pk    = '';

		parent::__construct();
	}

	public function fetch_all_by_cpgroupid($cpgroupid) {
		return $cpgroupid ? DB::fetch_all('SELECT * FROM %t WHERE cpgroupid=%d', array($this->_table, $cpgroupid)) : array();
	}

	public function delete_by_cpgroupid_perm($cpgroupid, $perm = null) {
		return $cpgroupid ? DB::delete($this->_table, DB::field('cpgroupid', $cpgroupid).($perm ? ' AND '.DB::field('perm', $perm) : '')) : false;
	}

	public function fetch_all_by_perm($perm) {
		return $perm ? DB::fetch_all('SELECT * FROM %t WHERE `perm`=%s', array($this->_table, $perm), 'cpgroupid') : array();
	}
}

?>