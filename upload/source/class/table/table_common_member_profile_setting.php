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
 *      $Id: table_common_member_profile_setting.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_member_profile_setting extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_member_profile_setting';
		$this->_pk    = 'fieldid';

		parent::__construct();
	}

	public function range($start = 0, $limit = 0) {
		return DB::fetch_all('SELECT * FROM '.DB::table($this->_table).' ORDER BY available DESC, displayorder'.DB::limit($start, $limit), null, $this->_pk);
	}
	public function fetch_all_by_available_unchangeable($available, $unchangeable) {
		return DB::fetch_all('SELECT * FROM %t WHERE available=%d AND unchangeable=%d ORDER BY displayorder', array($this->_table, $available, $unchangeable), $this->_pk);
	}

	public function fetch_all_by_available($available) {
		return DB::fetch_all('SELECT * FROM %t WHERE available=%d ORDER BY displayorder', array($this->_table, $available), $this->_pk);
	}

	public function fetch_all_by_available_formtype($available, $formtype) {
		return DB::fetch_all('SELECT * FROM %t WHERE available=%d AND formtype=%s', array($this->_table, $available, $formtype), $this->_pk);
	}

	public function fetch_all_by_available_required($available, $required) {
		return DB::fetch_all('SELECT * FROM %t WHERE available=%d AND required=%d', array($this->_table, $available, $required), $this->_pk);
	}

	public function fetch_all_by_available_showinregister($available, $showinregister) {
		return DB::fetch_all('SELECT * FROM %t WHERE available=%d AND showinregister=%d', array($this->_table, $available, $showinregister), $this->_pk);
	}
	public function fetch_all_by_available_showinthread($available, $showinthread) {
		return DB::fetch_all('SELECT * FROM %t WHERE available=%d AND showinthread=%d', array($this->_table, $available, $showinthread), $this->_pk);
	}

	public function clear_showinthread() {
		DB::update($this->_table, array('showinthread' => 0));
	}
}

?>