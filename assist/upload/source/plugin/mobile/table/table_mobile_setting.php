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
 *      $Id: table_mobile_setting.php 31700 2012-09-24 03:46:59Z zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_mobile_setting extends discuz_table {

	public function __construct() {
		$this->_table = 'mobile_setting';
		$this->_pk = 'skey';

		parent::__construct();
	}

	public function fetch($skey) {
		return DB::result_first('SELECT svalue FROM %t WHERE skey=%s', array($this->_table, $skey));
	}

	public function fetch_all($skeyarr) {
		if(!empty($skeyarr)) {
			return array();
		}
		$return = array();
		$query = DB::query('SELECT * FROM %t WHERE '.DB::field($this->_pk, $skeyarr), array($this->_table));
		while($svalue = DB::fetch($query)) {
			$return[$svalue['skey']] = $svalue['svalue'];
		}
		return $return;
	}

}