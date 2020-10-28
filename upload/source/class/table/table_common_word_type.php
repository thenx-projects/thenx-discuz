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
 *      $Id: table_common_word_type.php 27671 2012-02-09 06:56:51Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_word_type extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_word_type';
		$this->_pk    = 'id';

		parent::__construct();
	}
	public function fetch_by_typename($typename) {
		$data = array();
		if(!empty($typename)) {
			$data = DB::fetch_first('SELECT * FROM %t WHERE typename=%s', array($this->_table, $typename), $this->_pk);
		}
		return $data;
	}
	public function fetch_all() {
		return DB::fetch_all('SELECT * FROM %t', array($this->_table), $this->_pk);
	}

}

?>